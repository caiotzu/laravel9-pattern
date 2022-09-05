<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\User;
use App\Models\AdminSetting;

class RevendaUserService {
  public function listAllRevendaUsers(): Collection {
    return User::with('role')->get();
  }

  public function listAllAdminUsersWithPagination(): LengthAwarePaginator {
    $settings = AdminSetting::where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;
    return User::with('adminRole')->paginate($recordPerPage);
  }

  public function getRevendaUserById(Int $id): User {
    return User::findOrFail($id);
  }

  public function createAdminUser(Array $dto): User {
    $password = random_int(100000, 999999);
    $passwordHash = bcrypt($password);

    $dto['password'] = $passwordHash;

    return User::create($dto);
  }

  public function updateAdminUser(Int $id, Array $dto): User {
    $dto['active'] = isset($dto['active']) ? true : false;

    $user = User::findOrFail($id);
    $user->update($dto);
    return $user;
  }
}

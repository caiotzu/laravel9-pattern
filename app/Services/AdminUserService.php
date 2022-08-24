<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\AdminUser;

class AdminUserService {
  public function listAllAdminUsers(): Collection {
    return AdminUser::with('adminRole')->get();
  }

  public function listAllAdminUsersWithPagination(): LengthAwarePaginator {
    return AdminUser::with('adminRole')->paginate(10);
  }

  public function getAdminUserById(Int $id): AdminUser {
    return AdminUser::findOrFail($id);
  }

  public function createAdminUser(Array $dto): AdminUser {
    $password = random_int(100000, 999999);
    $passwordHash = bcrypt($password);

    $dto['password'] = $passwordHash;

    return AdminUser::create($dto);
  }

  public function updateAdminUser(Int $id, Array $dto): AdminUser {
    $dto['active'] = isset($dto['active']) ? true : false;

    $user = AdminUser::findOrFail($id);
    $user->update($dto);
    return $user;
  }
}

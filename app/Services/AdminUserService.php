<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\AdminUser;
use App\Models\AdminSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminUserService {
  public function listAllAdminUsers(): Collection {
    return AdminUser::with('adminRole')->get();
  }

  public function listAllAdminUsersWithPagination(): LengthAwarePaginator {
    $settings = AdminSetting::where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;
    return AdminUser::with('adminRole')->paginate($recordPerPage);
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

  public function updateAdminUserProfile(Array $dto) {
    $user = AdminUser::findOrFail(Auth::guard('admin')->user()->id);

    if(isset($dto['avatar'])) {
      if(Storage::exists($user->avatar))
        Storage::delete($user->avatar);

      $path = $dto['avatar']->store('admin/users');
      $dto['avatar'] = $path;

      auth()->guard('admin')->user()->avatar = $path;
    }

    $user->update($dto);
    return $user;
  }
}

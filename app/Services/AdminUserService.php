<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

use App\Models\AdminUser;

class AdminUserService {
  public function listAllAdminUsers() {
    return AdminUser::get();
  }

  public function createAdminUser(Array $dto): AdminUser {
    $password = random_int(100000, 999999);
    $passwordHash = bcrypt($password);

    $dto['password'] = $passwordHash;

    return AdminUser::create($dto);
  }
}

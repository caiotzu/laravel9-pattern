<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\AdminUser;

class AdminUserProfileService {
  public function updateAdminUserProfile(Array $dto) {
    $user = AdminUser::findOrFail(Auth::guard('admin')->user()->id);

    if(isset($dto['avatar'])) {
      if(Storage::exists($user->avatar))
        Storage::delete($user->avatar);

      $path = $dto['avatar']->store('admin/users');
      $dto['avatar'] = $path;
    }

    if($dto['password'] != '' && $dto['password'] != null) {
      $passwordHash = bcrypt($dto['password']);
      $dto['password'] = $passwordHash;
    } else {
      unset($dto['password']);
      unset($dto['password_confirmation']);
    }

    $user->update($dto);
    return $user;
  }
}

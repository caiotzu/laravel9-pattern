<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\User;

class RevendaUserProfileService {
  public function updateRevendaUserProfile(Array $dto) {
    $user = User::findOrFail(Auth::guard('web')->user()->id);

    if(isset($dto['avatar'])) {
      if(!is_null($user->avatar) && Storage::exists($user->avatar))
        Storage::delete($user->avatar);

      $path = $dto['avatar']->store('revenda/users');
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

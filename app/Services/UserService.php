<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\User;
use App\Models\AdminSetting;

class UserService {
  public function listAllUsers(): Collection {
    return User::with('role.company')
    ->whereHas('role.company', function ($query) {
      $companyId = Auth::guard('web')->user()->role->company->id;
      return $query->where('id', $companyId);
    })
    ->get();
  }

  public function listAllUsersWithPagination(): LengthAwarePaginator {
    $settings = AdminSetting::where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;

    return User::with('role.company')
    ->whereHas('role.company', function ($query) {
      $companyId = Auth::guard('web')->user()->role->company->id;
      return $query->where('id', $companyId);
    })
    ->paginate($recordPerPage);
  }

  public function getUserById(Int $id): User {
    return User::findOrFail($id);
  }

  public function createUser(Array $dto): User {
    $password = random_int(100000, 999999);
    $passwordHash = bcrypt($password);

    $dto['password'] = $passwordHash;

    return User::create($dto);
  }

  public function updateUser(Int $id, Array $dto): User {
    $dto['active'] = isset($dto['active']) ? true : false;

    $user = User::findOrFail($id);
    $user->update($dto);
    return $user;
  }

  public function updateUserProfile(String $path, Array $dto) {
    $user = User::findOrFail(Auth::guard('web')->user()->id);

    if(isset($dto['avatar'])) {
      if(!is_null($user->avatar) && Storage::exists($user->avatar))
        Storage::delete($user->avatar);

      $pathAvatar = $dto['avatar']->store($path);
      $dto['avatar'] = $pathAvatar;
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

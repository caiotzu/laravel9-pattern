<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
  public function role() {
    return $this->belongsTo(Role::class, 'role_id', 'id');
  }

  public function userAccessCompanies() {
    return $this->hasMany(UserAccessCompany::class, 'user_id', 'id');
  }

  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  protected $appends = ['photo'];

  public function getPhotoUrlAttribute() {
    if ($this->foto !== null) {
      return url('media/user/' . $this->id . '/' . $this->foto);
    } else {
      return url('media-example/no-image.png');
    }
  }
}

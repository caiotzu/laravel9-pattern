<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRolePermission extends Model {

  public function role() {
    return $this->belongsTo(AdminRole::class, 'role_id', 'id');
  }

  public function permission() {
    return $this->belongsTo(AdminPermission::class, 'permission_id', 'id');
  }
}

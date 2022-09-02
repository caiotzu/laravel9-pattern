<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyGroupSetting extends Model {
  public function Profile() {
    return $this->belongsTo(Profile::class, 'profile_id', 'id');
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Packs extends Model {
  use HasFactory;
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'label',
    'words',
    'user_id',
    ];

  public function user() {
    return $this->belongsTo(User::class);
  }
}

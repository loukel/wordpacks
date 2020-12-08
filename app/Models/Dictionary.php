<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Dictionary extends Model
{
  use HasFactory;
  protected $collection = 'dictionary';
  protected $hidden = ['_id'];
}

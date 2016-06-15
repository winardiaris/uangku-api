<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
  protected $fillable = [
            'users_id', 'value', 'token','token_image','date','desc','status','type',
          ];
  protected $hidden = [
    'users_id',
  ];
}

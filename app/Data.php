<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
  protected $fillable = [
            'users_id', 'value', 'bill','date','desc','status','type',
          ];
  protected $hidden = [
    'users_id',
  ];
}

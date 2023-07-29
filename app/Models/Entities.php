<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entities extends Model
{
    protected $table = 'entities';

    protected $fillable = [
        'id','id_user','name','description','phone','email','latitude','length','image','status'
    ];

}


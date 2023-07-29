<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
    protected $table = 'quotes';

    protected $fillable = [
        'id','id_entity','name','phone','ws','email','identification','date','service','note','status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'id','id_entity','name','description','price','status'
    ];

    public function entities()
    {
    	return $this->belongsTo('App\Models\Services', 'id_entity');
    }
}

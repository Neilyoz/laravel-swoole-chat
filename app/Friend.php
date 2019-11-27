<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    //

    protected $fillable = [
        'owner_id', 'relation_id'
    ];
}

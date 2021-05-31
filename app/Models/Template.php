<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class template extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [ 
        'message', 
        'block_status',
    ];

    protected $dates = [ 'deleted_at' ];

 
}

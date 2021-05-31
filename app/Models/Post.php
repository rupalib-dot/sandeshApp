<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'approval_status',
         'person_name',
         'surname',
        'description',
        'template_id',
        'swd',
        'swdperson',
        'relation',
        'pocontact',
        'lname',
        'institute',
        'number',
        'age',
        'date_of_death',
        'flowers',
        'address',
        'lat',
        'long',
        'person_pic',
        'death_certificate',
        'is_draft',
        'flower_type'
    ];

    protected $dates = [ 'deleted_at' ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

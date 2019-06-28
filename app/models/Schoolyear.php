<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schoolyear extends Model
{
    protected $table = 'schoolyear';
    public $timestamps = false;
    protected $fillable = [
        'year'
    ];

    /*--------------------GRADENET METHODS------------------------*/

}
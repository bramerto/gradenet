<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student_Class extends Model
{
    protected $table = 'class';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'year'
    ];

    /*--------------------GRADENET METHODS------------------------*/

}
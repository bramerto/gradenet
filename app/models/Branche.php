<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branche extends Model
{
    protected $table = 'branche';
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];

    /*--------------------GRADENET METHODS------------------------*/

}
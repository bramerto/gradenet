<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'education';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'brancheId'
    ];

    /*--------------------GRADENET METHODS------------------------*/

}
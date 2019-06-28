<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    protected $table = 'dossier';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'schoolyearId',
        'link'
    ];

    /*--------------------GRADENET METHODS------------------------*/

}
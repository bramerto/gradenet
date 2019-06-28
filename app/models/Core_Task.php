<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Core_Task extends Model
{
    protected $table = 'core_task';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'dossierId'
    ];

    /*--------------------GRADENET METHODS------------------------*/

}
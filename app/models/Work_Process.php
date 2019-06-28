<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work_Process extends Model
{
    protected $table = 'work_process';
    public $timestamps = false;

    protected $fillable = [
        'task',
        'description',
        'core_taskId'
    ];

    /*--------------------GRADENET METHODS------------------------*/

    public static function getAllWorkProcessesForProject($projectWorkProcesses)
    {
        $workprocesses =  new Work_Process();

        foreach ($projectWorkProcesses as $projectWorkProcess) {

            $workprocesses->where('id', '!=', $projectWorkProcess->id);
        }

        $workprocesses = $workprocesses->get();

        $workprocessesArray = [];

        foreach($workprocesses as $workprocess) {

            $workprocessesArray += [
                $workprocess->id => $workprocess->task . ' - ' . $workprocess->description
            ];
        }

        return $workprocessesArray;

        //TODO: if project has all workprocceses return zero
    }
}
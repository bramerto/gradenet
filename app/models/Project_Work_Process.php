<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project_Work_Process extends Model
{
    protected $table = 'project_work_process';
    public $timestamps = false;
    protected $fillable = [
        'projectId',
        'work_processId'
    ];

    /*--------------------GRADENET METHODS------------------------*/

    public static function getWorkProcessessForProject($projectId)
    {
        return Project_Work_Process::join('work_process', 'project_work_process.work_processId', '=', 'work_process.id')
            ->join('core_task', 'work_process.core_taskId', '=', 'core_task.id')
            ->where('project_work_process.projectId', $projectId)
            ->select('project_work_process.id AS projectWorkProcessId',
                    'work_process.id AS id', 'work_process.task AS workProcessTask', 'work_process.description AS workProcessDescription',
                    'core_task.description AS core_taskDescription')
            ->get();
    }
}
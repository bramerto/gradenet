<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Project extends Model
{
    protected $table = 'user_project';
    public $timestamps = false;
    protected $fillable = [
        'userId',
        'projectId',
        'blockId',
    ];

    /*--------------------GRADENET METHODS------------------------*/

    public static function workProcessPerUser()
    {
        return User_Project::join('user_project_work_process', 'user_project.id', '=', 'user_project_work_process.user_projectId')
            ->join('project_work_process', 'user_project_work_process.project_work_processId', '=', 'project_work_process.id')
            ->join('work_process', 'project_work_process.work_processId', '=', 'work_process.id')
            ->join('core_task', 'work_process.core_taskId', '=', 'core_task.id')
            ->select('user_project.userId AS userId', 'user_project_work_process.score AS score',
                'work_process.task as task', 'work_process.description AS description',
                'core_task.description AS core_task');
    }

    public static function getUserProjectId($projectId, $studentId)
    {
        return User_Project::where('userId', $studentId)
            ->where('projectId', $projectId)
            ->select('id')
            ->first()->id;
    }
}
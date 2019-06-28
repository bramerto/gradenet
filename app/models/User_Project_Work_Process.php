<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User_Project_Work_Process extends Model
{
    protected $table = 'user_project_work_process';
    public $timestamps = false;

    protected $fillable = [
        'user_projectId',
        'project_work_processId'
    ];

    /*--------------------GRADENET METHODS------------------------*/

    public static function getGrades($id) //gets all students for student overview
    {

        return User_Project_Work_Process::join('user_project', 'user_project_work_process.user_projectId', '=','user_project.id')
            ->join('user', 'user_project.userId', '=', 'user.id')
            ->join('project_work_process', 'user_project_work_process.project_work_processId', '=', 'project_work_process.id')
            ->join('work_process','project_work_process.work_processId','=','work_process.id')
            ->select(DB::raw('sum(user_project_work_process.score)/5 AS score'))//,'work_process.id AS workProcess')
            ->where('user.id', $id)
            ->groupby('work_process.id')
            ->get();
    }

    public static function setGrades($userid,$grades,$projectid)
    {
        $temp1 = User_Project::select('user_project.id AS upId')
            ->where('user_project.userId',$userid)
            ->where('user_project.projectId',$projectid)->get();

        $upid = $temp1[0]->upId;
        foreach ($grades as $grade){
            $temp2 = Project_Work_Process::select('project_work_process.id')
                ->join('project','project.id','=','project_work_process.projectId')
                ->where('project_work_process.work_processId',$grade['id'])
                ->where('project.id',$projectid)
                ->get();
            //test of record al bestaad
            $check = User_Project_Work_Process::select('*')
                ->where('user_projectId',$upid)
                ->where('project_work_processId',$temp2[0]->id)
                ->get();

            if ($check == null) {
                User_Project_Work_Process::insertGetId(
                    array('score' => $grade['grade'], 'user_projectId' => $upid, 'project_work_processId' => $temp2[0]->id)
                );
            } else {
                User_Project_Work_Process::where('user_projectId',$upid)
                    ->where('project_work_processId',$temp2[0]->id)
                    ->update(['score' => $grade['grade'], 'user_projectId' => $upid, 'project_work_processId' => $temp2[0]->id]);
            }
        }
    }

    public static function getProjectScoresForStudent($userId, $projectId)
    {
        return User_Project_Work_Process::join('user_project', 'user_project.id', '=', 'user_project_work_process.user_projectId')
            ->join('project_work_process', 'project_work_process.id', '=', 'user_project_work_process.project_work_processId')
            ->join('work_process', 'work_process.id', '=', 'project_work_process.work_processId')
            ->select('user_project_work_process.score AS score', 'work_process.*')
            ->where('user_project.userId', $userId)
            ->where('user_project.projectId', $projectId)
            ->get();
    }
}
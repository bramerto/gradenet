<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'description',
        'active'
    ];

    /*--------------------GRADENET METHODS------------------------*/

    public static function getStudentProjectsWithProgress($id) //get all student projects that are close to deadline
    {
        $projects = Project::join('user_project', 'project.id', '=', 'user_project.projectId')
            ->join('block', 'user_project.blockId', '=', 'block.id')
            ->where('user_project.userId', $id)
            ->where('project.done', 0)
            ->select('project.id', 'project.name', 'block.period AS period', 'block.date_end AS deadline')
            ->orderBy('block.date_end', 'asc')
            ->take(4)
            ->get();

        foreach($projects as $project) {

            $scores = User_Project_Work_Process::getProjectScoresForStudent($id, $project->id);

            $scorecount = count($scores);

            $project->progress = 0;

            foreach($scores as $score) {
                if($score->score != 'O') {
                    $project->progress += intval(100 / $scorecount);
                }
            }
        }

        return $projects;
    }

    public static function getUpcomingProjects()
    {
        return Project::join('user_project', 'project.id', '=', 'user_project.projectId')
            ->join('block', 'user_project.blockId', '=', 'block.id')
            ->select('project.id', 'project.name', 'block.period', 'block.date_start')
            ->where('project.done', 0)
            ->orderBy('date_start', 'asc')
            ->take(5)
            ->get();
    }

    public static function getAllProjects() //get all projects for the teacher
    {
        return Project::select('project.id','project.name', 'project.done');
    }

    public static function allProjectsForStudent($id)
    {
        return Project::join('user_project', 'project.id', '=', 'user_project.projectId')
            ->join('block', 'user_project.blockId', '=', 'block.id')
            ->join('schoolyear', 'block.schoolyearId', '=', 'schoolyear.id')
            ->select('project.id', 'project.name', 'project.description', 'project.done',
                'user_project.userId AS userId',
                'block.period AS projectPeriod', 'block.date_start AS projectStart', 'block.date_end AS projectDeadline')
            ->where('userId', $id);
    }

    public static function getProjectInfo($projectId)
    {
        return Project::select('project.id AS id', 'project.name', 'project.description')
            ->where('project.id', $projectId)
            ->first();
    }
}
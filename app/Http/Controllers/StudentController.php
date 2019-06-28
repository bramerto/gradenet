<?php
namespace App\Http\Controllers;
use App\Models\User_Project_Work_Process;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use App\Models\Project_Work_Process;

class StudentController extends BaseController
{
        protected static $navigationItems = [
            '/student'                  => 'Gradenet',  //header
            '/student/'                 => 'Dashboard',
            'student/profile'           => 'Jouw Profiel', //nav items
            'student/projectoverview'   => 'Jouw Projecten',
//            'student/settings'          => 'Instellingen',
        ];

    public function Index()
    {
        $studentId = Auth::user()->id;
        $projects = Project::getStudentProjectsWithProgress($studentId);
        //$grades = User_Project_Work_Process::getGrades(Auth::user()->id);

        return View::make('student.index', array('navigationItems' => StudentController::$navigationItems,
            'current_projects' => $projects));
    }

    public function Profile()
    {
        $studentId = Auth::id();

        $student = new User();
        $student = $student->getStudentProfile($studentId);

        return View::make('student.profile', array('navigationItems' => StudentController::$navigationItems,
            'student' => $student));
    }

    public function Projects()
    {
        $studentId = Auth::id();

        $projects = Project::allProjectsForStudent($studentId)->get();

        return View::make('student.project.overview', array('navigationItems' => StudentController::$navigationItems,
            'projects' => $projects));
    }

    public function getProject($id)
    {
        $studentId = Auth::id();
        $studentsForProject = new User();

        $project = Project::getProjectInfo($id);
        $studentsForProject = $studentsForProject->getUsersForProject($id, false);
        $studentScores = User_Project_Work_Process::getProjectScoresForStudent($studentId, $id);
        $projectworkprocesses = Project_Work_Process::getWorkProcessessForProject($id);


        return View::make('student.project.page', array('navigationItems' => StudentController::$navigationItems,
            'project' => $project, 'projectStudents' => $studentsForProject,
            'projectWorkProcesses' => $projectworkprocesses, 'studentScores' => $studentScores));
    }

//    public function Results()
//    {
//        $id = Auth::id();
//
//        return View::make('student.results', array('navigationItems' => StudentController::$navigationItems,));
//    }

    public function Settings()
    {
        $studentId = Auth::id();

        return View::make('student.settings', array('navigationItems' => StudentController::$navigationItems,));
    }
}
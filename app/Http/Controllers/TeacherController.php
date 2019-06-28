<?php
namespace App\Http\Controllers;

use App\Models\Schoolyear;
use Illuminate\Database\QueryException;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Project;
use App\Models\Block;
use App\Models\Project_Work_Process;
use App\Models\Work_Process;
use App\Models\User_Project_Work_Process;
use App\Models\User_Project;

class TeacherController extends BaseController
{
        protected static $navigationItems = [
            '/teacher'                  => 'Gradenet',  //nav header
            '/teacher/'                 => 'Dashboard',
            'teacher/profile'           => 'Uw Profiel', //nav items
            'teacher/projectoverview'   => 'Projectenoverzicht',
            'teacher/studentoverview'   => 'Studenten overzicht',
            'teacher/controlpanel'      => 'Beheerpaneel',
//            'teacher/settings'          => 'Instellingen',
        ];

        private static $projectrules = [
            'name'        => 'required',
            'description' => '',
        ];

        private static $newblockrules = [
            'period'     => 'required|digits_between:1,100',
            'date_start' => 'required|date',
            'date_end'   => 'required|date',
            'schoolyear' => 'required|numeric',
        ];

        private static $editblockrules = [
            'id'             => 'required|numeric',
            'editPeriod'     => 'required|digits_between:1,100',
            'editDate_start' => 'required|date',
            'editDate_end'   => 'required|date',
            'editSchoolyear' => 'required|numeric',
        ];

        private static $messages = [
            'required'             => 'Dit veld moet ingevuld worden',
            'date'                 => 'Datum moet correct worden ingevuld (ex: 2017-02-24)',
            'digits_between:1,100' => 'Moet een nummer zijn tussen 1 en 100',
            'numeric'              => 'Moet een nummer zijn'
        ];

    public function Index()
    {
        $upcoming_projects = Project::getUpcomingProjects();

        return View::make('teacher.index', array('navigationItems' => TeacherController::$navigationItems,
            'projects' => $upcoming_projects));
    }

    public function Profile()
    {
        $id = Auth::id();

        $teacher = new User();
        $teacher = $teacher->getUserProfile($id);

        return View::make('teacher.profile', array('navigationItems' => TeacherController::$navigationItems,
            'teacher' => $teacher));
    }

    public function Projects()
    {
        $id = Auth::id();

        $projects = Project::getAllProjects()->orderBy('project.id', 'asc')->get();

        return View::make('teacher.project.overview', array('navigationItems' => TeacherController::$navigationItems,
            'projects' => $projects));
    }

    public function GetProject($id)
    {
        $project = Project::getProjectInfo($id);

        $studentsForProject = User::getUsersForProject($id);
        $selectStudents = User::getSelectUsersForProject($studentsForProject);

        $projectworkprocesses = Project_Work_Process::getWorkProcessessForProject($id);
        $selectWorkProcesses = Work_Process::getAllWorkProcessesForProject($projectworkprocesses);

        $blocks = Block::getAllBlocksInArray();

        return View::make('teacher.project.page', array('navigationItems' => TeacherController::$navigationItems,
            'project' => $project, 'students' => $studentsForProject, 'workprocessess' => $projectworkprocesses,
            'blocks' => $blocks, 'selectWorkProcesses' => $selectWorkProcesses, 'selectStudents' => $selectStudents));
    }

    public function StudentOverview() //returns student overview
    {
        $id = Auth::id();

        $students = User::getAllStudents()->get();

        return View::make('teacher.student.overview', array('navigationItems' => TeacherController::$navigationItems,
            'students' => $students));
    }

    public function ControlPanel()
    {
        return View::make('teacher.controlpanel.index', array('navigationItems' => TeacherController::$navigationItems));
    }

    public function Settings()
    {
        $id = Auth::id();

        return View::make('teacher.settings', array('navigationItems' => TeacherController::$navigationItems));
    }

    public function getStudent($id)
    {
        $student = new User();
        $student = $student->getStudentProfile($id);
        $studentProjects = Project::allProjectsForStudent($id)->get();

        return View::make('teacher.student.page', array('navigationItems' => TeacherController::$navigationItems,
                    'student' => $student, 'projects' => $studentProjects));
    }

    public function ScoreProject($id)
    {
        $studentsForProject = User::getUsersForProject($id);

        return View::make('teacher.score.overview', array('navigationItems' => TeacherController::$navigationItems,
            'students' => $studentsForProject, 'projectId' => $id));
    }

    public function ControlBlocks()
    {
        $allBlocks = Block::join('schoolyear', 'block.schoolyearId', '=', 'schoolyear.id')
                    ->select('block.*', 'schoolyear.id AS schoolyearId', 'schoolyear.year AS schoolyear')
                    ->get();

        $schoolYears = Schoolyear::select('id', 'year')->get();
        $schoolyearSelect = [];

        foreach ($schoolYears as $schoolYear) {
            $schoolyearSelect += [
                $schoolYear->id => $schoolYear->year
            ];
        }

        return View::make('teacher.controlpanel.blocks', array('navigationItems' => TeacherController::$navigationItems,
        'blocks' => $allBlocks, 'schoolyears' => $schoolyearSelect));
    }

    public function addNewBlock()
    {
        $validator = Validator::make(Input::all(), TeacherController::$newblockrules, TeacherController::$messages);

        if ($validator->fails()) {
            return Redirect::to('teacher/controlpanel/blocks')->withErrors($validator)->withInput();
        }

        try {
            Block::create([
                    'period'       => Input::get('period'),
                    'date_start'   => Input::get('date_start'),
                    'date_end'     => Input::get('date_end'),
                    'schoolyearId' => Input::get('schoolyear')
                ]
            );

        } catch (QueryException $e) {
            return Redirect::to('teacher/controlpanel/blocks')->withErrors('Er is iets misgegaan'); //TODO: needs to catch this in view
        }

        return Redirect::to('teacher/controlpanel/blocks')->with('add_period', 'success');
    }

    public function editBlock()
    {

        $validator = Validator::make(Input::all(), TeacherController::$editblockrules, TeacherController::$messages);

        if ($validator->fails()) {
            return Redirect::to('teacher/controlpanel/blocks')->withErrors($validator)->withInput();
        }

        try {
            Block::where('block.id', Input::get('id'))
                ->update(array(
                        'period'       => Input::get('editPeriod'),
                        'date_start'   => Input::get('editDate_start'),
                        'date_end'     => Input::get('editDate_end'),
                        'schoolyearId' => Input::get('editSchoolyear'))
                );

        } catch(QueryException $e) {
            return Redirect::to('teacher/controlpanel/blocks')->withErrors('Er is iets misgegaan'); //TODO: needs to catch this in view
        }

        return Redirect::to('teacher/controlpanel/blocks')->with('edit_period', 'success');
    }

    public function ScoreStudentForProject($projectId, $studentId)
    {
        $existingProjectScores = User_Project_Work_Process::getProjectScoresForStudent($studentId, $projectId);
        $allProjectWorkProcesses = Project_Work_Process::getWorkProcessessForProject($projectId);

        if (count($existingProjectScores)) {

            return View::make('teacher.score.student', array('navigationItems' => TeacherController::$navigationItems,
                'existingProjectScores' => $existingProjectScores,
                'allProjectWorkProcesses'=> $allProjectWorkProcesses
                ));

        } else {

            $allProjectWorkProcesses = Project_Work_Process::getWorkProcessessForProject($projectId);

            if(count($allProjectWorkProcesses)) {

                $user_projectId = User_Project::getUserProjectId($projectId, $studentId);

                foreach($allProjectWorkProcesses as $ProjectWorkProcess) {
                    User_Project_Work_Process::create([
                            'project_work_processId' => $ProjectWorkProcess->projectWorkProcessId,
                            'user_projectId' => $user_projectId
                        ]
                    );
                }

                $newscores = User_Project_Work_Process::getProjectScoresForStudent($studentId, $projectId);

                return View::make('teacher.score.student', array('navigationItems' => TeacherController::$navigationItems,
                    'scores' => $newscores,
                    'existingProjectScores' => $existingProjectScores,
                    'allProjectWorkProcesses'=> $allProjectWorkProcesses

                    ));

            } else {

                return Redirect::to('teacher/project/' . $projectId . '/score')->with('not_found', 'failed');
            }
        }
    }

    public function storeGrades(){
        $items = [];
        for($i=0;$i<13;$i++) {
            $data = Input::get('grade'.$i);
            if(strlen($data)==2){
                $temparr['id'] = $i;
                $temparr['grade']=$data;
                array_push($items,$temparr);
            }
        }
        $userid =  Input::get('id');//userID van de student
        $projectid = Input::get('projectid');//ID van

        User_Project_Work_Process::setGrades($userid,$items,$projectid);

        return Redirect::to('teacher/projectoverview');
    }


    public function addNewProject() //add a new project to database
    {
        $validator = Validator::make(Input::all(), TeacherController::$projectrules, TeacherController::$messages);

        if ($validator->fails()) {
            return Redirect::to('teacher/projectoverview')->withErrors($validator)->withInput();
        }

        try {
            Project::create([
                'name'        => Input::get('name'),
                'description' => Input::get('description')
                ]
            );

        } catch (QueryException $e) {
            return Redirect::to('teacher/projectoverview')->withErrors('Er is iets misgegaan'); //TODO: needs to catch this in view
        }

        return Redirect::to('teacher/projectoverview')->with('add_project', 'success');
    }


    public function editProject($id) //update project to database
    {
        $validator = Validator::make(Input::all(), TeacherController::$projectrules, TeacherController::$messages);

        if ($validator->fails()) {
            return Redirect::to('teacher/project/' . $id)->withErrors($validator);
        }

        try {
            Project::where('project.id', $id)
                        ->update(array(
                            'name'          => Input::get('name'),
                            'description'   => Input::get('description')
                        ));

        } catch (QueryException $e) {
            return Redirect::to('teacher/project/' . $id)->withErrors('Er is iets misgegaan'); //TODO: needs to catch this in view
        }

        return Redirect::to('teacher/project/' . $id)->with('edit_project', 'success');
    }
}
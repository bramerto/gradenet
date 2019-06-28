<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Project;
use App\Models\Project_Work_Process;
use App\Models\User_Project;
use Illuminate\Database\QueryException;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\User_Project_Work_Process;

class AjaxController extends BaseController
{
    function LoadCompetenceStar() {
        if(Auth::user()->roleId != 3){
            $id = Input::get('id');
        }else{
            $id = Auth::user()->id;
        }
        $grades = User_Project_Work_Process::getGrades($id);
        for($i=0;$i<9;$i++){
            if(!isset($grades[$i]->score)){
                $grades[$i] = (object)array( "score" => 0 );
            }
        }
        $response = array(
            'sdov'  => (int)$grades[0]->score,  /*  (S)telt (d)e (o)pdracht (v)ast           1*/
            'lbap'  => (int)$grades[1]->score,  /*  (L)evert (b)ijdrage (a)an (p)rojectplan  2*/
            'lbao'  => (int)$grades[2]->score,  /*  (L)evert (b)ijdrage (a)an (o)ntwerp      3*/
            'brv'   => (int)$grades[3]->score,  /*  (B)ereidt (r)ealisatie (v)oor            4*/
            'rep'   => (int)$grades[4]->score,  /*  (R)ealiseert (e)en (p)roduct             5*/
            'top'   => (int)$grades[5]->score,  /*  (T)est (o)ntwikkelde (p)roduct           6*/
            'op'    => (int)$grades[6]->score,  /*  (O)ptimaliseert (p)roduct                7*/
            'lpo'   => (int)$grades[7]->score,  /*  (L)evert (p)roduct (o)p                  8*/
            'ep'    => (int)$grades[8]->score, /*  (E)valueert (p)roject                    9*/
        );
        return Response::json($response);
    }

    public function deleteProject($id)
    {
        try {
            Project_Work_Process::where('project_work_process.projectId', $id)->delete();
            User_Project::where('user_project.projectId', $id)->delete();
            Project::where('project.id', $id)->delete();

        } catch (QueryException $e) {
            return Response::json('failed: ' . $e);
        }

        return Response::json('success');
    }

    public function addWorkProcessToProject($projectId)
    {
        $work_processId = Input::get('work_processId');

        try {
            Project_Work_Process::create([
                'projectId' => $projectId,
                'work_processId' => $work_processId
                ]
            );

        } catch (QueryException $e) {

            return Response::json('failed: ' . $e);
        }

        return Response::json('success');
    }

    public function addStudentToProject($projectId)
    {
        $studentId = Input::get('studentId');
        $blockId = Input::get('periodId');

        try {
           User_Project::create([
               'userId' => $studentId,
               'projectId' => $projectId,
               'blockId' => $blockId
               ]
           );

        } catch (QueryException $e) {

            return Response::json('failed: ' . $e);
        }

        return Response::json('success');
    }

    public function deleteBlock($id)
    {
        try {
            Block::where('id', $id)->delete();
            User_Project::where('blockId', $id)->update(array('blockId' => null));

        } catch (QueryException $e) {
            return Response::json('failed: ' . $e);
        }

        return Response::json('success');
    }
}
<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class AdminController extends BaseController{
    protected static $navigationItems = [
        '/student'                  => 'Gradenet',  //header
        'admin/profile'             => 'Jouw Profiel', //nav items
        'admin/users'               => 'Gebruikers beheren',
//        'admin/settings'            => 'Instellingen',
    ];

    private static $userAddRules = [
        'email' => 'required|email',
        'firstname' => 'required',
        'lastname' => 'required',
        'age' => 'required|numeric',
    ];

    private static $messages = [
        'required'             => 'Dit veld moet ingevuld worden',
        'email'                => 'Moet een correct email zijn',
        'numeric'              => 'Moet een nummer zijn'
    ];

    public function Index()
    {
        return View::make('admin.index', array('navigationItems' => AdminController::$navigationItems));
    }

    public function Users()
    {
        $users = new User();
        $users = $users->getAllusers()->get();

        return View::make('admin.overview', array('navigationItems' => AdminController::$navigationItems,
            'users' => $users));
    }

    public function Profile()
    {
        $id = Auth::id();

        $user = new User();
        $user = $user->getUserProfile($id);

        return View::make('admin.profile', array('navigationItems' => AdminController::$navigationItems, 'user' => $user));
    }

    public function Settings()
    {
        return View::make('admin.settings', array('navigationItems' => AdminController::$navigationItems));
    }

    public function AddUser(){

        $validator = Validator::make(Input::all(), AdminController::$userAddRules, AdminController::$messages);

        if ($validator->fails()) {
            return Redirect::to('admin/users')->withErrors($validator);
        }

        $input = [
            'email' => Input::get('email'),
            'password' => '$2a$06$AWjtyWCUQuFRaDDeZAiTEeHec0omGEpe20yH3amzSvHZcpsQATz9m',
            'firstname' => Input::get('firstname'),
            'lastname' => Input::get('lastname'),
//            'educationId',
            'classId' => 1,
            'birthdate' => date('Y-m-d H:i:s'),
            'roleId' => 3
        ];

        User::create($input);

        return $this->Users();
    }
}

?>
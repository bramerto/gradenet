<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class SessionsController extends BaseController
{
    public function create()
    {
        return View::make('sessions.create');
    }

    public function store()
    {
        if (Auth::attempt(Input::only('email', 'password')))
        {
            switch(Auth::user()->roleId){
                case 1:
                    return Redirect::to('/admin');
                    break;
                case 2:
                    return Redirect::to('/teacher');
                    break;
                case 3:
                    return Redirect::to('/student');
                    break;
            }

        } else {
            return 'false';
        }

    }

    public function destroy()
    {
        Auth::logout();

        return Redirect::route('sessions.create');

    }
}
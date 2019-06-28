<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use \Illuminate\Support\Facades;


class HomeController extends BaseController
{
	public function Index()
	{
		return View::make('home.index');
	}
}

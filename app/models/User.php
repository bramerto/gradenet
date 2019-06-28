<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $table = 'user';
	public $timestamps = true;
	protected $hidden = array('password', 'remember_token');
	protected $fillable = [
		'email',
		'password',
		'firstname',
		'lastname',
		'educationId',
		'classId',
		'birthdate',
		'roleId'
	];

	/*--------------------GRADENET METHODS------------------------*/

	public function isRole($roleName)
	{
		if ($this->role()->first()->name == $roleName) {
			return true;
		}

		return false;
	}

	public function getStudentProfile($studentId) //get profile info for student page
	{
		return $this->join('education', 'user.educationId', '=', 'education.id')
			->join('class', 'user.classId', '=', 'class.id')
			->select('user.id', 'user.email', 'user.firstname', 'user.lastname', 'user.age',
				'education.name AS educationName', 'class.name AS className', 'class.year')
			->where('user.id', $studentId)
			->first();
	}

	public function getUserProfile($userId) //get profile info for teacher page
	{
		return $this->select('user.id', 'user.email', 'user.firstname', 'user.lastname', 'user.age')
			->where('user.id', $userId)
			->first();
	}


	public static function getAllStudents()
	{
		return User::join('education', 'user.educationId', '=', 'education.id')
				->join('class', 'user.classId', '=', 'class.id')
				->join('role', 'user.roleId', '=', 'role.id')
				->select('user.id AS id', 'user.email AS email', 'user.firstname AS firstname', 'user.lastname AS lastname', 'user.age AS age',
					'education.name AS educationName',
					'class.name AS className', 'class.year',
					'role.name AS roleName')
				->where('role.id', 3);
	}

	public static function getAllusers() //gets all users for user overview
	{
		return User::join('education', 'user.educationId', '=', 'education.id')
			->join('class', 'user.classId', '=', 'class.id')
			->join('role', 'user.roleId', '=', 'role.id')
			->select('user.id AS id', 'user.email AS email', 'user.firstname AS firstname', 'user.lastname AS lastname', 'user.age AS age',
				'education.name AS educationName',
				'class.name AS className', 'class.year',
				'role.name AS roleName')
			;
	}

	public static function getUsersForProject($projectId, $withWorkProcesses = true)
	{
		$students = User::join('user_project', 'user.id', '=', 'user_project.userId')
			->join('block', 'user_project.blockId', '=', 'block.id')
			->join('class', 'user.classId', '=', 'class.id')
			->join('education', 'user.educationId', '=', 'education.id')
			->where('user_project.projectId', $projectId)
			->select('user.id AS id', 'user.email AS email', 'user.firstname AS firstname', 'user.lastname AS lastname',
				'block.date_start AS projectStart', 'block.date_end AS projectDeadline',
				'class.name AS className', 'class.year AS classYear',
				'education.name AS educationName')
			->get();

		if($withWorkProcesses) {

			foreach ($students as $student) {

				$student->workprocesses = User_Project::workProcessPerUser()
					->where('user_project.userId', $student->id)
					->where('user_project.projectId', $projectId)
					->get();
			}
		}

		return $students;
	}

	public static function getSelectUsersForProject($studentsForProject)
	{
		$selectStudentArray = [];

		$selectStudents = User::getAllStudents();

		foreach($studentsForProject as $studentForProject) {
			$selectStudents->where('user.id', '!=', $studentForProject->id);
		}

		$selectStudents = $selectStudents->get();

		foreach ($selectStudents as $selectStudent) {

			$selectStudentArray += [
				$selectStudent->id => $selectStudent->firstname . ' ' . $selectStudent->lastname . ' - ' . $selectStudent->educationName . ' - ' . $selectStudent->className
			];
		}

		return $selectStudentArray;
	}

	public function role()
	{
		return $this->belongsTo('App\Models\Role', 'roleId');
	}

	public function klas()
	{
		return $this->belongsTo('App\Models\Class', 'classId');
	}

	public function education()
	{
		return $this->belongsTo('App\Models\Education', 'educationId');
	}

	public function projects()
	{
		return $this->belongsToMany('App\Models\User_Project', 'userId');
	}
}

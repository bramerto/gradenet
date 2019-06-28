<?php

Route::resource('sessions', 'SessionsController');

//LOGIN PAGES
Route::get('/', array('as' => 'Home', 'uses' => 'HomeController@Index'));
Route::get('login', 'SessionsController@create');
Route::get('logout', 'SessionsController@destroy');

//TEACHER PAGES 'middleware' => 'Role:teacher',
Route::get('teacher',                                               array('as' => 'Teacher',               'middleware' => 'role:teacher', 'uses' => 'TeacherController@Index'));
Route::get('teacher/profile',                                       array('as' => 'Profile',               'middleware' => 'role:teacher', 'uses' => 'TeacherController@Profile'));
Route::get('teacher/projectoverview',                               array('as' => 'ProjectOverview',       'middleware' => 'role:teacher', 'uses' => 'TeacherController@Projects'));
Route::get('teacher/project/{id}',                                  array('as' => 'Project',               'middleware' => 'role:teacher', 'uses' => 'TeacherController@GetProject'));
Route::get('teacher/studentoverview',                               array('as' => 'StudentOverview',       'middleware' => 'role:teacher', 'uses' => 'TeacherController@StudentOverview'));
Route::get('teacher/controlpanel',                                  array('as' => 'ControlPanel',          'middleware' => 'role:teacher', 'uses' => 'TeacherController@ControlPanel'));
Route::get('teacher/controlpanel/blocks',                           array('as' => 'ControlBlock',          'middleware' => 'role:teacher', 'uses' => 'TeacherController@ControlBlocks'));
Route::get('teacher/settings',                                      array('as' => 'Settings',              'middleware' => 'role:teacher', 'uses' => 'TeacherController@Settings'));
Route::get('teacher/student/{id}',                                  array('as' => 'SeeStudent',            'middleware' => 'role:teacher', 'uses' => 'TeacherController@getStudent'));
Route::get('teacher/project/{id}/score',                            array('as' => 'ScoreProject',          'middleware' => 'role:teacher', 'uses' => 'TeacherController@ScoreProject'));
Route::get('teacher/project/{projectId}/score/student/{studentId}', array('as' => 'ScoreProjectByStudent', 'middleware' => 'role:teacher', 'uses' => 'TeacherController@ScoreStudentForProject'));
Route::post('teacher/sendgrades',                                   array('as' => 'sendgrades',            'middleware' => 'role:teacher', 'uses' => 'TeacherController@storeGrades'));


Route::post('teacher/projectoverview',         array('as' => 'addNewProject', 'middleware' => 'role:teacher', 'uses' => 'TeacherController@addNewProject'));
Route::post('teacher/project/{id}',            array('as' => 'editProject',   'middleware' => 'role:teacher', 'uses' => 'TeacherController@editProject'));
Route::post('teacher/controlpanel/blocks',     array('as' => 'addNewBlock',   'middleware' => 'role:teacher', 'uses' => 'TeacherController@addNewBlock'));
Route::post('teacher/controlpanel/block/edit', array('as' => 'editBlock',     'middleware' => 'role:teacher', 'uses' => 'TeacherController@editBlock'));

//ADMIN PAGES
Route::get('admin',          array('as' => 'Admin',             'middleware' => 'role:admin', 'uses' => 'AdminController@Index'));
Route::get('admin/users',    array('as' => 'AdminUserOverview', 'middleware' => 'role:admin', 'uses' => 'AdminController@Users'));
Route::get('admin/profile',  array('as' => 'AdminProfile',      'middleware' => 'role:admin', 'uses' => 'AdminController@Profile'));
Route::get('admin/settings', array('as' => 'AdminSettings',     'middleware' => 'role:admin', 'uses' => 'AdminController@Settings'));
Route::post('admin/users',   array('as' => 'AddUser',           'middleware' => 'role:admin', 'uses' => 'AdminController@AddUser'));

//STUDENT PAGES
Route::get('student',                 array('as' => 'Student',  'middleware' => 'role:student', 'uses' => 'StudentController@Index'));
Route::get('student/profile',         array('as' => 'Profile',  'middleware' => 'role:student', 'uses' => 'StudentController@Profile'));
Route::get('student/projectoverview', array('as' => 'Projects', 'middleware' => 'role:student', 'uses' => 'StudentController@Projects'));
Route::get('student/settings',        array('as' => 'Settings', 'middleware' => 'role:student', 'uses' => 'StudentController@Settings'));
Route::get('student/project/{id}',    array('as' => 'Project',  'middleware' => 'role:student', 'uses' => 'StudentController@getProject'));

//AJAX CALLS
Route::get('ajax/loadcompetencestar',                   array('uses' => 'AjaxController@LoadCompetenceStar'));

Route::post('teacher/project/delete/{id}',              array('as' => 'DeleteProject',  'middleware' => 'role:teacher', 'uses' => 'AjaxController@deleteProject'));
Route::post('teacher/project/{id}/addWorkProcess',      array('as' => 'addWorkProcess', 'middleware' => 'role:teacher', 'uses' => 'AjaxController@addWorkProcessToProject'));
Route::post('teacher/project/{id}/addStudentToProject', array('as' => 'addWorkStudent', 'middleware' => 'role:teacher', 'uses' => 'AjaxController@addStudentToProject'));
Route::post('teacher/block/delete/{id}',                array('as' => 'deleteBlock',    'middleware' => 'role:teacher', 'uses' => 'AjaxController@deleteBlock'));

<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::get('/', ['uses' => 'LoginController@index', 'as' => 'login']);
Route::post('/auth/login', ['uses' => 'LoginController@login', 'as' => 'auth.login']);
Route::get('/auth/logout', ['uses' => 'LoginController@logout', 'as' => 'auth.logout']);

Route::group(['middleware' => ['auth', 'role:teacher|student']], function () {
	Route::put('/auth/profile', ['uses' => 'LoginController@update', 'as' => 'auth.update']);
	Route::put('/auth/password', ['uses' => 'LoginController@passwordUpdate', 'as' => 'auth.updatepassword']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::put('/auth/image', ['uses' => 'LoginController@changeImage', 'as' => 'auth.image']);
});

Route::post('/password/email', ['uses' => 'Auth\PasswordController@postEmail', 'as' => 'email.store']);
Route::get('/password/reset/{token}', ['uses' => 'Auth\PasswordController@getReset', 'as' => 'reset.request']);
Route::post('/password/reset', ['uses' => 'Auth\PasswordController@postReset', 'as' => 'reset.store']);

Route::group(['prefix' => '/lms-admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'role:staff']], function () {
	Route::get('/', ['uses' => 'HomeController@index', 'as' => 'lms-admin.index'] );
	Route::get('/profile',['uses' => 'HomeController@profile', 'as' => 'lms-admin.profile']);
	
	Route::resource('/users', 'UserController', ['except' => 'show']);
	Route::patch('users/{users}/usermeta', ['uses' => 'UserController@updateMeta', 'as' => 'lms-admin.users.updatemeta']);
	Route::resource('/majors', 'MajorController', ['except' => 'show']);
	Route::resource('/subjects', 'SubjectController', ['except' => 'show']);
	Route::resource('/announcements', 'AnnouncementController', ['except' => 'show']);
	Route::resource('/classrooms', 'ClassroomController', ['except' => 'show']);
	Route::post('/classrooms/addmembers', ['uses' => 'ClassroomController@addMembers', 'as' => 'lms-admin.classrooms.addmembers']);
	Route::post('/classrooms/removemember', ['uses' => 'ClassroomController@removeMember', 'as' => 'lms-admin.classrooms.removemember']);
});

Route::group(['namespace' => 'User', 'middleware' => ['auth', 'role:teacher|student']], function () {
	Route::get('/home', ['uses' => 'HomeController@index', 'as' => 'home.index']);
	Route::get('/{username}/profile', ['uses' => 'HomeController@friend', 'as' => 'home.friend']);
	Route::get('/profile',['uses' => 'HomeController@profile', 'as' => 'home.profile']);
	Route::get('/password', ['uses' => 'HomeController@password', 'as' => 'home.password']);
	Route::get('/calendar', ['uses' => 'HomeController@calendar', 'as' => 'home.calendar']);
	Route::get('/all-announcements', ['uses' => 'AnnouncementController@index', 'as' => 'home.announcements']);
	Route::get('/all-online', ['uses' => 'HomeController@online', 'as' => 'home.onlines']);
	Route::get('/all-assignments', ['uses' => 'AssignmentController@assignments', 'as' => 'home.assignments']);

	Route::get('/classrooms/{classrooms}', ['uses' => 'ClassroomController@show', 'as' => 'classrooms.show']);
	Route::get('/classrooms/{classrooms}/edit', ['uses' => 'ClassroomController@show', 'as' => 'classrooms.user.edit']);
	Route::post('/classrooms/{classrooms}', ['uses' => 'ClassroomController@update', 'as' => 'classrooms.user.update']);
	Route::get('/classrooms/{classrooms}/courses', ['uses' => 'ClassroomController@courses', 'as' => 'classrooms.courses']);
	Route::get('/classrooms/{classrooms}/assignments', ['uses' => 'ClassroomController@assignments', 'as' => 'classrooms.assignments']);
	Route::get('/classrooms/{classrooms}/quizzes', ['uses' => 'ClassroomController@quizzes', 'as' => 'classrooms.quizzes']);
	Route::get('/classrooms/{classrooms}/members', ['uses' => 'ClassroomController@members', 'as' => 'classrooms.members']);

	Route::get('/classrooms/{classrooms}/discuss/{discuss}', ['uses' => 'ClassroomController@discussionDetail', 'as' => 'classrooms.discussiondetail']);
	Route::get('/classrooms/{classrooms}/assignments/{assignments}', ['uses' => 'ClassroomController@assignmentDetail', 'as' => 'classrooms.assignmentdetail']);
	Route::get('/classrooms/{classrooms}/courses/{courses}', ['uses' => 'ClassroomController@courseDetail', 'as' => 'classrooms.coursedetail']);
	Route::get('/classrooms/{classrooms}/modules/{modules}', ['uses' => 'ClassroomController@moduleDetail', 'as' => 'classrooms.moduledetail']);
	Route::get('/classrooms/{classrooms}/quizzes/{quizzes}', ['uses' => 'ClassroomController@quizDetail', 'as' => 'classrooms.quizdetail']);
	Route::get('/classrooms/{classrooms}/quizzes/{quizzes}/score', ['uses' => 'ClassroomController@score', 'as' => 'classrooms.score']);
	Route::get('/score-download/{classrooms}/{quizzes}', ['uses' => 'ClassroomController@downloadScore', 'as' => 'classrooms.downloadscore']);
	Route::get('/submission-download/{classrooms}/{assignment}', ['uses' => 'ClassroomController@downloadSubmission', 'as' => 'classrooms.downloadsubmission']);
	Route::get('/classrooms/download/{filename}', ['uses' => 'ClassroomController@download', 'as' => 'classrooms.download']);

	Route::resource('/discuss', 'DiscussionController', ['only' => ['store', 'destroy']]);
	Route::post('/submission', ['uses' => 'ClassroomController@attachSubmission', 'as' => 'submissions.store']);
	Route::delete('/submission', ['uses' => 'ClassroomController@detachSubmission', 'as' => 'submissions.destroy']);

});

Route::group(['namespace' => 'User', 'middleware' => ['auth', 'role:teacher']], function () {
	Route::resource('/assignments', 'AssignmentController', ['except' => 'show']);
	Route::post('/assignments/attach', ['uses' => 'AssignmentController@attachTo', 'as' => 'assignments.attach']);
	Route::post('/assignments/detach', ['uses' => 'AssignmentController@detachFrom', 'as' => 'assignments.detach']);
	
	Route::resource('/courses', 'CourseController', ['except' => 'show']);
	Route::post('/courses/attach', ['uses' => 'CourseController@attachTo', 'as' => 'courses.attach']);
	Route::post('/courses/detach', ['uses' => 'CourseController@detachFrom', 'as' => 'courses.detach']);

	Route::resource('/modules', 'ModuleController', ['except' => ['index', 'create', 'show']]);

	Route::resource('/quizzes', 'QuizController', ['except' => 'show']);
	Route::resource('/quizzes.mc', 'MultipleChoiceController', ['except' => ['index', 'show']]);
	Route::post('/quizzes/attach', ['uses' => 'QuizController@attachTo', 'as' => 'quizzes.attach']);
	Route::post('/quizzes/detach', ['uses' => 'QuizController@detachFrom', 'as' => 'quizzes.detach']);
});

Route::group(['prefix' => '/api', 'namespace' => 'API', 'middleware' => ['auth', 'role:teacher|student']], function () {
	Route::get('/assignments', 'AssignmentController@deadline');
	Route::post('/quizzes/start', 'QuizController@startQuiz');
	Route::post('/quizzes/submit', 'QuizController@submitQuiz');
	Route::post('/users/status', 'UserController@toggleStatus');
});
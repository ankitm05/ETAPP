<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@index')->name('home');
Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
Route::get('terms/', 'StaticController@term')->name('terms');
Route::get('about/', 'StaticController@about')->name('about');
Route::get('privacypolicy/', 'StaticController@privacy')->name('privacypolicy');

Route::group(['middleware'=>['auth:admin']], function () {

	Route::get('/dashboard', 'HomeController@index')->name('dashboard');
	Route::get('/user-management', 'UserController@index')->name('user-management');
	Route::get('/subadmin-management', 'HomeController@subadminlist')->name('subadmin-management');
	Route::get('/user-edit/{id}', 'UserController@userEdit')->name('user-edit');
	Route::post('/user-update/{id}', 'UserController@userUpdate')->name('user-update');
	Route::post('/admin-update/{id}', 'UserController@adminUpdate')->name('admin-update');

	Route::get('/user-status/{id}', 'UserController@userStatus')->name('user-status');
	Route::get('/subadmin-status/{id}', 'HomeController@subadminStatus')->name('subadmin-status');
	Route::get('/profile', 'HomeController@myprofile')->name('profile');

	//Event
	Route::get('/event-management', 'EventController@index')->name('event-management');
	Route::get('/create-event', 'EventController@create')->name('create-event');
	Route::post('/save-event', 'EventController@saveevent')->name('save-event');
	Route::get('/view-event/{eid}', 'EventController@viewevent')->name('view-event');
	Route::post('/update-event/{eid}', 'EventController@updateevent')->name('update-event');
	Route::get('/delete-event/{eid}', 'EventController@deleteevent')->name('delete-event');

	//subadmin events
	Route::get('/subadmin-event-management/{id}', 'EventController@subadmineventlist')->name('subadmin-event-management');
	Route::get('/subadmin-view-event/{eid}', 'EventController@subadminviewevent')->name('subadmin-view-event');

	Route::get('/features/{id}', 'EventController@feature')->name('features');
	Route::post('/savefeature/{id}', 'EventController@savefeature')->name('savefeature');

	Route::get('/content/{id}/{tabing?}', 'EventController@content')->name('content');

	Route::get('/organisers/{id}', 'EventController@organiser')->name('organisers');
	Route::post('/addabout/{id}', 'EventController@addabout')->name('addabout');

	Route::get('/speakers/{id}', 'EventController@speaker')->name('speakers');
	Route::post('/addspeaker/{id}', 'EventController@addspeaker')->name('addspeaker');

	Route::get('/exhibitors/{id}', 'EventController@exhibitor')->name('exhibitors');
	Route::post('/addexhibitor/{id}', 'EventController@addexhibitor')->name('addexhibitor');

	Route::get('/sponsers/{id}', 'EventController@sponser')->name('sponsers');
	Route::post('/addsponser/{id}', 'EventController@addsponser')->name('addsponser');

	Route::get('/ministeries/{id}', 'EventController@ministerie')->name('ministeries');
	Route::post('/addschedule/{id}', 'EventController@addschedule')->name('addschedule');

	Route::get('/floor-plan/{id}', 'EventController@floorplan')->name('floor-plan');
	Route::post('/savefloorplan/{id}', 'EventController@savefloorplan')->name('savefloorplan');

	Route::post('/event-status-change', 'EventController@eventstatuschange')->name('event-status-change');

	// Notification
	Route::get('/notifications/{id}', 'NotificationController@index')->name('notifications');
	// Social
	Route::get('/social/{id}', 'SocialController@index')->name('social');
	Route::get('/delete-post/{id}', 'SocialController@deletepost')->name('delete-post');
	// Comment
	Route::get('/comment/{pid}/{id}', 'SocialController@comment')->name('comment');
	Route::get('/delete-comment/{id}', 'SocialController@deletecomment')->name('delete-comment');

	// Poll
	Route::get('/polls/{id}', 'PollController@index')->name('polls');
	Route::post('/addpoll/{id}', 'PollController@addpoll')->name('addpoll');
	Route::get('/delete-poll/{id}', 'PollController@deletepoll')->name('delete-poll');

	// Static pages
	Route::get('/static-pages', 'StaticController@staticpages')->name('static-pages');
	Route::get('/view-static-page/{id}', 'StaticController@viewstaticpages')->name('view-static-page');
	Route::post('/update-static-page/{id}', 'StaticController@updatestaticpages')->name('update-static-page');

	Route::get('/joined/{id}', 'UserController@joinedusers')->name('joined');
	Route::post('/delete_feature', 'EventController@deletefeature')->name('delete_feature');
	Route::post('/delete_content', 'EventController@deletecontent')->name('delete_content');
	
	//subadmin joined users
	Route::get('/subadmin-joined-users/{id}', 'UserController@subadminjoinedusers')->name('subadmin-joined-users');


	Route::get('/reports/{id}', 'ReportController@index')->name('reports');
	Route::get('/delete-report/{id}/{pid}', 'ReportController@deletepost')->name('delete-report');
});

Auth::routes();
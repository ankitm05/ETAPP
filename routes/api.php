<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function () {
    Route::post('/email_verification_code','AuthController@emailotp');
    Route::post('/email_verification','AuthController@verifyemailotp');
    Route::post('/check_email','AuthController@checkemail');
    Route::post('/register','AuthController@register');
    Route::post('/login','AuthController@login');
    Route::post('/forgot_password','AuthController@forgotpassword');
    Route::post('/forgot_password_verify','AuthController@verifyforgotpassword');
    // Search Event
    Route::post('/search','EventController@searchevent');
    //Event
    Route::get('/events','EventController@index');
    Route::get('/event/{id}','EventController@eventfetch');    

    Route::group(['middleware'=>'auth:api'],function() {
        Route::get('/logout','AuthController@logout');
        //User
        Route::get('/profile_view','UserController@profile');
        Route::post('/profile_edit','UserController@editProfile');
        Route::post('/change_password','UserController@changepassword');
        Route::get('/notification_status_change','UserController@notifystatuschange');
        Route::get('/notification_status','UserController@notifystatus');

        // Search Event
        Route::post('/afterloginsearch','EventController@loginsearchevent');
        
        // Notification list
        Route::get('/notification_list/{id?}','EventController@notifications');

        // Join Event
        Route::get('/join/{id}','EventController@joinevent');
        // Joined Event code verify
        Route::post('/events_code_verify','EventController@joinedeventcode');
        // Joined Event
        Route::get('/joined_events','EventController@joinedevents');

        // Joined Event
        Route::get('/menus/{id}','EventController@menus');
        
        // Joined Event view
        Route::get('/event_view/{id}','EventController@joinedeventview');
        // Questionnare
        Route::get('/questionnares/{id}','EventController@questionList');
        // Questionnare save
        Route::post('/questionnare_save','EventController@saveQuestion');
        // side menu list
        Route::post('/sidemenuList','EventController@sidemenuList');
        // Floor Plan
        Route::get('/floorplans/{id}','EventController@floorplan');
        // Organiser, Ministerie, Sponser, Exhibitor, Speaker View
        Route::post('/details_view','EventController@detailview');
        // About Event
        Route::get('/about_event/{id}','EventController@aboutevent');
        // Joined People
        Route::get('/peoples/{id}','EventController@joinedpeoples');
        // Bookmark
        Route::post('/bookmark','EventController@bookmark');
        // Schedule List
        Route::get('/scheduleLists','EventController@schedulelist');
        // Event Search
        Route::post('/event_search','EventController@eventsearch');

        // Post
        Route::post('/save_post','PostController@postsave');
        // Favourite
        Route::post('/save_favourite','PostController@favouritesave');
        // Comment
        Route::get('/view_comment/{id}','PostController@commentview');
        Route::post('/save_comment','PostController@commentsave');
        // user details
        Route::post('/user_detail','PostController@userdetails');

        // Post report
        Route::post('/report_post','PostController@reportpost');
        
        // room ID
        Route::post('/joinroom','ChatController@index');
        // room chat History
        Route::post('/chathistory','ChatController@history');
        // room chat List
        Route::get('/chatlist','ChatController@lists');
    });
});
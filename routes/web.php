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

Route::get('/', function () {
    return view('welcome');
});

// account

Route::post('/sign_up', 'Account@SignUp');
Route::post('/Sign_in', 'Account@Login');
Route::post('/sign_out', 'Account@Logout');
Route::post('/del_msg', 'Account@DeleteMsg');
Route::post('/read_msg', 'Account@ReadMsg');
Route::patch('/updateprefs', 'Account@Updates');
Route::get('/prefs', 'Account@Prefs');
Route::get('/me', 'Account@Me');
Route::get('/info', 'Account@ProfileInfo');
Route::get('/karma', 'Account@Karma');
Route::get('/messages', 'Account@Messages');



// administration

Route::post('/del_ac', 'Administration@DeleteApexCom');
Route::post('/del_user', 'Administration@DeleteUser');
Route::post('/add_mod', 'Administration@AddModerator');



// ApexCom

Route::get('/about', 'ApexCom@About');
Route::post('/posts', 'ApexCom@Posts');
Route::post('/subscribe', 'ApexCom@Subscribe');
Route::post('/site_admin', 'ApexCom@Admin');



// links and comments

Route::post('/comment', 'Comment@Add');
Route::post('/DelComment', 'Comment@Delete');
Route::post('/Edit', 'Comment@EditText');
Route::post('/Hide', 'Comment@Hide');
Route::post('/unhide', 'Comment@Unhide');
Route::post('/moreComm', 'Comment@MoreChildren');
Route::post('/report', 'Comment@Report');
Route::post('/vote', 'Comment@Vote');
Route::post('/save', 'Comment@Save');
Route::post('/unsave', 'Comment@UnSave');



// general

Route::get('/search', 'General@Search');
Route::get('/trendings', 'General@Trendings');
Route::get('/hot_posts', 'General@HotPosts');



// moderation

Route::post('/remove', 'Moderation@Remove');
Route::post('/approve', 'Moderation@Approve');
Route::get('/review_reports', 'Moderation@ReviewReports');



// user

Route::post('/block_user', 'User@Block');
Route::post('/compose', 'User@Compose');
Route::get('/user_date', 'User@JoinDate');
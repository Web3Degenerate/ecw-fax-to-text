<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
// use App\Http\Controllers\ExampleController;

//&&& #DCT &&& - Added Note and Patient Controllers
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PatientController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Default route from Laravel
// Route::get('/', function () {
//     return view('welcome');
// });


// ******************************* USER ROUTES ******************************************* //

// Route::get('/', [ExampleController::class, 'homePage']);
// Route::get('/', [UserController::class, 'showCorrectHomepage']);
// (4:35) - Set named 'login' route to '/' for laravel's middleware('auth') redirect
Route::get('/', [UserController::class, 'showCorrectHomepage'])->name('login');

// Route::get('/about', [ExampleController::class, 'aboutPage']);



// &&& #DCT &&&  Remove the ->name('login') limitation for testing the /enroll route: ##################################################################################
// Route::get('/enroll', [UserController::class, 'showEnrollForm'])->name('login');
Route::get('/enroll', [UserController::class, 'showEnrollUserForm']);
Route::get('/enroll/patient', [UserController::class, 'showEnrollPatientForm']);

//Register user route: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207604#content
// Route::post('/register', [UserController::class, 'register'])->middleware('guest');
// &&& #DCT &&& - to start testing, allow anyone 'guest' or 'auth' to access the register user route:
Route::post('/register', [UserController::class, 'register']);



//Add login route: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207654#overview
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
//Added logout route: (1:50): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207658#overview
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Added manage avatar route (2:40): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34470392#overview
Route::get('/manage-avatar', [UserController::class, 'showAvatarForm']);


// ============================ FOLLOWER - FOLLOWING RELATED ROUTES ============================== //
                //look up user by username (brad/barksalot)
Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow'])->middleware('mustBeLoggedIn');
Route::post('/remove-follow/{user:username}', [FollowController::class, 'removeFollow'])->middleware('mustBeLoggedIn');




// ****************************** POST / NOTE ROUTES ********************************************//

// Route:: get('/create-post', [PostController::class, 'showCreateForm']);
//(~3:30) Protected route with simple Middleware! => https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400816#overview
        // Route:: get('/create-post', [PostController::class, 'showCreateForm'])->middleware('auth');
        // Route:: post('/create-post', [PostController::class, 'storeNewPost'])->middleware('auth');
//(13:25) Now try replacing 'middleware('auth')' with our custom 'middleware(mustBeLoggedIn)': https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400816#overview
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('mustBeLoggedIn');

//Other middleware combo of 'guest' with name of 'home'

// (4:50): Set up get route on successful post submission: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351480#overview
// Route::get('/post/{pizza}', [PostController::class, 'viewSinglePost']);
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);

// (12:20): Set up Delete Route: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426438#overview
// Route::delete('/post/{post}', [PostController::class, 'delete']);

//(1:40) - Set up Owner Only restriction via middleware: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426442#overview
Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');


//(6:40) - EDIT POST - add GET view route && PUT edit routes: 
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, 'actuallyUpdate'])->middleware('can:update,post');





// ****************************** PROFILE RELATED ROUTES ********************************************//

Route::get('/profile/{pizza:username}', [UserController::class, 'profile']);

// (7:25) - Set up routes for 'following' and 'follwer' tabs: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview
Route::get('/profile/{user:username}/followers', [UserController::class, 'profileFollowers']);
Route::get('/profile/{user:username}/following', [UserController::class, 'profileFollowing']);


// **************************** GATE *************************************//

// (1:15): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426458#overview
Route::get('/admins-controller-only', function(){
    //Set normal controller and functions here.
    if (Gate::allows('visitAdminPages')) {
        //restricted content here.
        return 'Function Way To Enforce: Only admins should be able to see this page';
    }
    return 'Function Way To Enforce: You can not view this page.';

});

// (6:40) Protect gate with middleware instead of function above: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426458#overview
Route::get('/admins-only', function(){
    return 'Middleware Way to Enforce: Only admins should be able to see this page.';
})->middleware('can:visitAdminPages');


// &&& #DCT &&& - Manual check for new faxes
Route::post('/manually-get-fax-update', [NoteController::class, 'manuallyGetFaxUpdate']);

// &&& #DCT &&& - Manually create a new PATIENT in the patient table
Route::post('/register-new-online-digitial-em-patient', [PatientController::class, 'manuallyRegisterNewPatient']);

// &&& #DCT &&& - view patient Dashboard
// Route::get('/profile/{pizza:username}', [UserController::class, 'profile']);
// Route::get('/hub/{patient:mrn}', [PatientController::class, 'viewPatient']);
Route::get('/hub/{id}', [PatientController::class, 'viewPatient']);

// &&& #DCT &&& - #ToDo - Add edit page and route: 
Route::get('/edit-patient/{patient:mrn}', [PatientController::class, 'editPatient']);


// ****************************** PATIENT HUB RELATED ROUTES (BORROWED FROM "PROFILE RELATED ROUTES" ********************************************//

// START WITH JUST THE 'Profile' page for patient which we are calling 'hub'
Route::get('/profile/{patient:mrn}', [PatientController::class, 'getHub']); //old UserController@profile()hub

// (7:25) - Set up routes for 'following' and 'follwer' tabs: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview
Route::get('/hub/{patient:mrn}/billing', [UserController::class, 'getHubBilling']);
Route::get('/hub/{patient:mrn}/edit', [UserController::class, 'getHubEdit']);


// **************************** FAX RELATED ROUTES ********************************************* //

// Copy of rxminter/srfax index.php
Route::get('/fax-inbox-list', [NoteController::class, 'checkFaxInbox']);

Route::get('/fax-inbox', [NoteController::class, 'showFaxInbox']);


Route::get('/view-single-fax/{faxid}', [NoteController::class, 'retrieveSingleFax']);

Route::get('/manually-enter-single-fax-form/{faxid}', [NoteController::class, 'retrieveFaxFormForManualEntry']);

Route::post('/create-note-from-single-fax-form', [NoteController::class, 'createNoteFromManualFaxForm']);
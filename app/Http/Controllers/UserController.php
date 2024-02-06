<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{

//Added (16:20) - Show homepage for logged in user: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207654#overview
    public function showCorrectHomepage(){
        //Check if current user is logged in with globally available 'auth()'
        // auth()->check() //true or false if logged in
        if (auth()->check()) {
            $hardCodedMessage = '';

            $users = User::all();
            $patients = Patient::all();
            return view('homepage-feed', ['guestMessage' => $hardCodedMessage, 'users' => $users, 'patients' => $patients]);
            // return 'you are logged in'; 
        } else {
            // return view('homepage');
            $ourName = 'Guest';
            $animals = ['Meowsalot', 'Barksalot', 'Purrsloud'];
            $hardCodedMessage = '';
            return view('homepage', ['allAnimals' => $animals, 'name' => $ourName, 'catname' => 'Meowsalot', 'guestMessage' => $hardCodedMessage]);
        }
    }

// &&& #DCT &&& #############################################################################################################
    public function showEnrollUserForm(){
        //Logged in user can register another user:
            if (auth()->check()) {
                $hardCodedMessage = '';
                return view('homepage-enroll', ['guestMessage' => $hardCodedMessage]);
            } else {
        // redirect back to GUEST homepage: (let guest create the first user)
                $hardCodedMessage = 'Go ahead and register as a guest.';
                return view('homepage-enroll', ['guestMessage' => $hardCodedMessage]);
                return view('homepage-enroll')->with('failure', 'Go ahead and register as guest...');
                return redirect('/')->with('failure', 'You do not have the permissions to create a patient account.');

            }  
    }

//Added Enroll user route for logged in user admin panel short cut (2/5/2024)
    public function showEnrollPatientForm(){
               //Logged in user can register another user:
               if (auth()->check()) {
                // $hardCodedMessage = '';
                // return view('homepage-enroll', ['guestMessage' => $hardCodedMessage]);
                return view('homepage-enroll-patient');
            } else {
        // redirect back to GUEST homepage: (let guest create the first user)
                // $hardCodedMessage = 'Go ahead and register as a guest.';
                // return view('homepage-enroll', ['guestMessage' => $hardCodedMessage]);
                // return view('homepage-enroll')->with('failure', 'Go ahead and register as guest...');
                return redirect('/')->with('failure', 'You do not have the permissions to create a patient account.');

            }  
    }

//Added logout function: (2:05): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207658#overview
    public function logout(){
        //kill session with auth()->logout()
        auth()->logout();
        // return 'You are now logged out';
        //Add redirect() at (8:20). Add with() (~10:50)
        return redirect('/')->with('success', 'You have successfully logged out.');
    }


//Added login function: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207654#overview
    public function login(Request $request){
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        //Attempt to login
        if (auth()->attempt(['username' => $incomingFields['loginusername'],
        'password' => $incomingFields['loginpassword']])) {
            //(9:30):
            $request->session()->regenerate();
            // return 'Congrats!!';
            // Added redirect() on login at (9:00): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207658#overview
            // return redirect('/');
            //chain on with() to the redirect object at (10:10)
            return redirect('/')->with('success', 'You have successfully logged in.');
        } else {
            // return 'Sorry';
            //Added redirect with error message (14:20): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207658#overview
            return redirect('/')->with('failure', 'Log in attempt failed. Please try again.');
        }
    }


    // public function register(Request $request){
    //     $incomingFields = $request->validate([
    //         // 'username' => 'required', //updated to array in https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#content
    //         'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
    //         'email' => ['required', 'email', Rule::unique('users', 'email')],
    //         'password' => ['required', 'min:8', 'confirmed'],
    //     ]);

    //     // (7:30) - encrypt password before saving to DB: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview
    //     //look inside associative array
    //     $incomingFields['password'] = bcrypt($incomingFields['password']);
    //     // User::create($incomingFields); //creates new user in DB 
    //     $user = User::create($incomingFields); //creates new user && save to local variable 
        
    //     // (16:50): Log in newly registered user: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207658#overview
    //     auth()->login($user); //sends along cookie session so user logged in
        
    //     // return 'Connection to UserController success';
    //     // (16:15) - return redirect to '/' with success message: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207658#overview
    //     return redirect('/')->with('success', 'Thank you for creating an account');
    // }

// &&& #DCT &&& register function:
    public function register(Request $request){
        $incomingFields = $request->validate([
            // 'username' => 'required', //updated to array in https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#content
            //&&& #DCT NEW FIELDS &&&
            'name' => ['required'],
            'isAdmin' => ['required'],
            'dob' => ['required'],
            'referring_provider' => ['required', Rule::in([1, 2, 3, 999])], // Add Rule::in rule for the 'provider' field
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed'],
            // 'mrn' => ['required', Rule::unique('users', 'mrn')],
            // 'provider' => ['required'],
        ]);

        // $incomingFields['password'] = bcrypt($incomingFields['password']);

        // (7:30) - encrypt password before saving to DB: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview
        //look inside associative array

//JUST GO F'ING OLD SCHOOL
        $user = new User;

        $user->name = $request->input('name'); 
        $user->isAdmin = $request->input('isAdmin'); 
        $user->dob = $request->input('dob'); 
        $user->referring_provider = $request->input('referring_provider'); 
        $user->username = $request->input('username'); 
        $user->email = $request->input('email'); 
            $getPassword = $request->input('password');
        $user->password = bcrypt($getPassword);

        $user->save();   


                    // $incomingFields['name'] = $request->input('name');
                    // $incomingFields['isAdmin'] = $request->input('isAdmin');
                    // $incomingFields['dob'] = $request->input('dob');
                    // $incomingFields['referring_provider'] = $request->input('referring_provider');
        
        // $incomingFields['password'] = bcrypt($incomingFields['password']);

        // User::create($incomingFields); //creates new user in DB 
// $user = User::create($incomingFields); //creates new user && save to local variable 
        
        // (16:50): Log in newly registered user: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207658#overview
//&&& #DCT &&& - skip logging in newly created user:
// auth()->login($user); //sends along cookie session so user logged in
        
        // return 'Connection to UserController success';
        // (16:15) - return redirect to '/' with success message: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207658#overview

//&&& #DCT &&& - redirect back to the register/enroll page after creating a new patient user:
// return redirect('/')->with('success', 'Thank you for creating an account');
        $displayPatientName = $user->name;
        $displayPatientMRN = $user->username;
        $hardCodedMessage = 'You may enroll another patient with the form below.';

        
// Success message worked, hardCodedMessage did not ($guestMessage):
        // return back()->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.', ['guestMessage' => $hardCodedMessage]);
        return back()->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.');
    
        //Success message failed, hardCodedMessage worked:        
        return view('homepage-enroll', ['guestMessage' => $hardCodedMessage])->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.');
//Type Error: "http://symfony/Component/HttpFoundation/RedirectResponse::__construct():%20Argument%20#2%20($status)%20must%20be%20of%20type%20int,%20array%20given,"        
        return redirect('/enroll', ['guestMessage' => $hardCodedMessage])->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.');
    }


// *************************** PROFILE RELATED FUNCTIONS **************************************//

// (3:45) - Set up private function to handle duplicate code in tab functions: 
// BECAUSE I AM KEEPING profile(User $pizza) TYPE HINTING, ONLY APPLY TO profile Followers and Following:
    private function getSharedData($user) {
        $currentlyFollowing = 0; //false by default (guests)
        
        if (auth()->check()) {  //if user logged in
            $currentlyFollowing = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
        }

        //(~4:00): Use Laravel Class or Facade called 'View' which has a static method of 'share'
//MUST IMPORT 'View'
            // We can 'share' a variable and it will be available in our blade template:
            // View::share('label', 'variable or array of variables to share')
        View::share('sharedData', 
        [
            'currentlyFollowing' => $currentlyFollowing,
            'username' => $user->username,
            // 'posts' => $pizza->posts()->latest()->get(),
            'postCount' => $user->posts()->count(),
            //(V43. (14:15)) - Add follower and following count: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503228#notes
            'followerCount' => $user->followers()->count(),
            'followingCount' => $user->followingTheseUsers()->count()
        ]);
    }

// *** ~(2:40) - Set up view for individual patient view: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400818#overview
    // GET INSTANCE OF USER with TYPE HINTING = User <{name-used-in-routes}>

    public function profile(User $pizza){
        //(1:20) - Added Follow boolean: 
            $currentlyFollowing = 0; //false by default (guests)
            
//KEPT THE $pizza TYPE HINTING: (so $pizza->id instead of $user->id)
            if (auth()->check()) {  //if user logged in
// FORMAT IS TWO SUB ARRAYS ==> 'Follow::where([ [], [] ])'
                $currentlyFollowing = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $pizza->id]])->count();
                // ['followeduser', '=', $user->id])->count(); //count either 0 or 1 
                // ['followeduser', '=', $pizza->id])->count(); //count either 0 or 1 
            }
            
                //instance of the User model with type hinting
                //** $pizza is now a fully built out instance of the User model */
                
                //(8:55) - Spell out relationship b/t User and Post from view of User: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400818#overview
                // DEFINE User.php Model relationship.
                
                // $thePosts = $pizza->posts()->get();
                // return $thePosts;
                // return view('profile-posts', ['username' => $pizza->username]);

                // (12:35) - Return on one line: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400818#overview
            
                // (~min 7-9ish) Updated the return array used in fn getSharedData manually because we wanted to preserve the pizza type hinting example: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503226#notes
        View::share('sharedData', 
        [
            'currentlyFollowing' => $currentlyFollowing,
            // 'username' => $user->username,
            'username' => $pizza->username,
            // 'posts' => $pizza->posts()->latest()->get(),
            // 'postCount' => $user->posts()->count()
            'postCount' => $pizza->posts()->count(),

            //(V43. (14:15)) - Add follower and following count: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503228#notes
            'followerCount' => $pizza->followers()->count(),
            'followingCount' => $pizza->followingTheseUsers()->count()
        ]);
        
        return view('profile-posts', 
        [
                //(3:20) - Added currentlyFollowing to the view array. Missing his avatar value in this function: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34476624#overview
                // (~min 7-9) cleaned up with $sharedData: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503226#notes
                // 'currentlyFollowing' => $currentlyFollowing,
                // 'username' => $pizza->username,
                // 'postCount' => $pizza->posts()->count(),
            'posts' => $pizza->posts()->latest()->get()
        ]);
    }


// STOPPED USING pizza Type Hinting and went back to 'user' for the profile Following and profile Followers Tabs
    public function profileFollowing(User $user){
            // $currentlyFollowing = 0; //false by default (guests)        
            // if (auth()->check()) {  //if user logged in
            //     $currentlyFollowing = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
            // }     
            
        $this->getSharedData($user);    

        return view('profile-following', 
        [
            // 'currentlyFollowing' => $currentlyFollowing,
            // 'username' => $user->username,
            // 'postCount' => $user->posts()->count(),

            //(V43. (12:30) - Updated with new User - Follow table relationship in User.php: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503228#notes
            // 'posts' => $user->posts()->latest()->get()
            'following' => $user->followingTheseUsers()->latest()->get()
        ]);
    }


// STOPPED USING pizza Type Hinting and went back to 'user' for the profile Following and profile Followers Tabs
    public function profileFollowers(User $user){
        // $currentlyFollowing = 0; //false by default (guests)   
        // if (auth()->check()) {  //if user logged in
        //     $currentlyFollowing = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
        // }  
        
        $this->getSharedData($user);

        //debugging, view full json on route: (V43. 5:50)
        // return $user->followers()->latest()->get();

        return view('profile-followers', 
        [
            // 'currentlyFollowing' => $currentlyFollowing,
            // 'username' => $user->username,
            // 'postCount' => $user->posts()->count(),
        // (Video 43: 5:20) use new relationship in User.php: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503228#notes
            // 'posts' => $user->posts()->latest()->get()
            'followers' => $user->followers()->latest()->get()
        ]);
    }
 






// (3:15) - Added form to edit avatar: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34470392#overview
    //COME BACK AND FINISH AVATAR SECTION ATP:

    public function showAvatarForm(){
        return view('avatar-form');
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Patient;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\Follow;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;


use DB; 
use Carbon\Carbon; 

class PatientController extends Controller
{
    

// post request to /register-new-online-digitial-em-patient/
    public function manuallyRegisterNewPatient(Request $request){
        // $currentDate = Carbon::now();
        // $currentDayForSearch = $currentDate->toDateTimeString();     
        // $past_date_to_search_from = Carbon::parse($currentDayForSearch)->modify('-5 day')->format('Y-m-d');

        //JUST GO F'ING OLD SCHOOL
        $patient = new Patient;

        $patient->name = $request->input('name'); 
        $patient->mrn = $request->input('mrn'); 
        // $patient->dob = $request->input('dob'); 
        $patient->referring_provider = $request->input('referring_provider'); 


                $currentDateInEST = Carbon::now('America/New_York');
                // $formattedDate = $currentDateInEST->format('Y-m-d H:i:s');
                $formattedDate = $currentDateInEST->format('Y-m-d');
        $patient->billing_index_start_date = $formattedDate; 
                    // Create a DateTime object from the formatted Current Day in EST
                    // $dateTime_start_number = new DateTime($formattedDate);
                    $dateTime_start_number = Carbon::createFromFormat('Y-m-d', $formattedDate);
                 
                    // Get the day of the year
                    $dayOfYear_start_number = $dateTime_start_number->format('z') + 1;
        $patient->billing_index_start_number = $dayOfYear_start_number;

                // Get a date that is 7 days in the future
                $futureDate = $currentDateInEST->addDays(7);
                // Format the future date as a string
                // $formattedFutureDate = $futureDate->format('Y-m-d H:i:s');
                $formattedFutureDate = $futureDate->format('Y-m-d');

        $patient->billing_index_end_date = $formattedFutureDate; 
                // Create a DateTime object from the the formatted day, 7 days in the future EST
                // $dateTime_end_number = new DateTime($formattedFutureDate);
                $dateTime_end_number = Carbon::createFromFormat('Y-m-d', $formattedFutureDate);
                // Get the day of the year
                $dayOfYear_end_number = $dateTime_end_number->format('z') + 1;
        $patient->billing_index_end_number = $dayOfYear_end_number;        

        // $patient->unique_days = '0'; // query notes table within date range.
        // $patient->status = 0; // 0 is active, 1 is inactive

        $patient->save();   


        $displayPatientName = $patient->name;
        $displayPatientMRN = $patient->mrn;

        
// Success message worked, hardCodedMessage did not ($guestMessage):
        // return back()->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.', ['guestMessage' => $hardCodedMessage]);
        return back()->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program (in patients table).');
    }


//Just like UserController@profile(User $pizza)in the get('/profile/{pizza:username}' route
// THE VARIABLE '$pizza' or '$mrn' IS the entire patient (or user) OBJECT. So to get mrn in this case, it's $mrn->mrn:
    public function viewPatient(Patient $mrn){
        $getPatient = Patient::where('mrn', $mrn->mrn)->firstOrFail();
        return view('profile-patient', ['patient' => $getPatient]);
    }


    // *** ~(2:40) - Set up view for individual patient view: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400818#overview
    // GET INSTANCE OF USER with TYPE HINTING = User <{name-used-in-routes}>

    public function getHub(Patient $mrn){
        if (auth()->check()) {
            // $getPatient = Patient::where('mrn', '$mrn->mrn')->firstOrFail();  
            $getPatient = Patient::where('mrn', $mrn->mrn)->firstOrFail();       
        }
        return view('profile-patient', ['patient' => $getPatient ]);
                
    }










    public function disenrollPatient(Patient $mrn){
        $updatePatient = Patient::where('mrn', $mrn->mrn)->firstOrFail();
        $updatePatient->status = 1; // 1 is inactive. 0 is active (default)
        $updatePatient->save();

    }


} //end of class

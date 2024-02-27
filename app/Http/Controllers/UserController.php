<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use App\Models\Patient;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

use DB; 
use Carbon\Carbon; 
use App\Models\Invoice;

class UserController extends Controller
{



    public function calculateBillingCode($cumulativeClinicTime){
        if($cumulativeClinicTime >= 5 && $cumulativeClinicTime < 11){
            return '99421';
        } elseif($cumulativeClinicTime >= 11 && $cumulativeClinicTime < 21){
            return '99422';
        } elseif($cumulativeClinicTime >= 21){
            return '99423';
        } else {
            return 'N/A';
        }
    }



    private function updatePendingInvoices($pendingInvoices){
            //Inside foreqach loop
            foreach($pendingInvoices as $pending_invoice){
                                
                        
                // Get start date from the Invoice DB:
                $pending_invoice_start_date = $pending_invoice->seven_days_from_date_only;

                // Convert to Carbon instance
                $startInvoiceDateTime = Carbon::parse($pending_invoice_start_date)->startOfDay()->addSecond();

                // Calculate end date (7 days in the future)
                $endInvoiceDateTime = Carbon::parse($pending_invoice_start_date)->addDays(7)->endOfDay();

                // Check if invoice_end_date is less than the current date in EST.
                $currentDateEST = Carbon::now('America/New_York');

                // Now you have startInvoiceDateTime, endInvoiceDateTime, and currentDateEST as dateTime values
                $pending_invoice_start_date_TIME = $startInvoiceDateTime->toDateTimeString(); // 00:00:01 on date in $pending_invoice_start_date
                $pending_invoice_end_date_TIME = $endInvoiceDateTime->toDateTimeString();     // 23:59:59 on date in $pending_invoice_end_date 
                $currentDateEST_date_TIME = $currentDateEST->toDateTimeString();


    //*** IF PENDING INVOICE IS NOW CLOSED *************************************************************************/
            if ($pending_invoice_end_date_TIME < $currentDateEST_date_TIME) {

                        $get_pending_invoice_notes = Note::where('billing_number', $pending_invoice->id)
                        ->get();
                        $past_invoice_clinic_time = $get_pending_invoice_notes->sum('clinic_time');

                            // $get_last_invoice_note_date = Note::where('billing_number', $pending_invoice->id)->last();
                            // $get_last_invoice_note_date = Note::where('billing_number', $pending_invoice->id)
                            // ->orderBy('id', 'asc')
                            // ->latest('id')
                            // ->first();

                            $get_last_invoice_note_date = Note::where('billing_number', $pending_invoice->id)
                            ->orderBy('date_time_as_string', 'desc')
                            ->first();


        //GET NEW NOTES: Use date_time_as_string and change $pending_invoice_end_date to date time at 11:59 PM (23:59:59)
                        $get_new_invoice_notes = Note::where('patient_id', $pending_invoice->patient_id)
                        ->whereIn('billing_status_string', ['pending', 'check', 'billing_pending'])
                        ->whereBetween('date_time_as_string', [$get_last_invoice_note_date->date_time_as_string, $pending_invoice_end_date_TIME]) 
                        ->get();

        // Foreach loop to update each note in $get_new_invoice_notes
                    $new_invoice_clinic_time = $get_new_invoice_notes->sum('clinic_time');

        // Add up old time + new time:
                    $updated_invoice_clinic_time = $past_invoice_clinic_time + $new_invoice_clinic_time;

    //UPDATE the Pending Invoice before closing it out:                        
                    $pending_invoice->cumulative_clinic_time = $updated_invoice_clinic_time;
                    $pending_invoice->billing_code = $this->calculateBillingCode($updated_invoice_clinic_time);

                    $pending_invoice->status = 1; //inactive since end_date_TIME is less than currentDate_TIME
                    if($updated_invoice_clinic_time > 4){
                        $pending_invoice->billing_group_number = 'billing_completed';
                    }else{
                        $pending_invoice->billing_group_number = 'billing_failed';
                    }

                $pending_invoice->save();

    //UPDATE the new notes which were a part of this now CLOSED Invoice:
                foreach($get_new_invoice_notes as $new_note){
                    $new_note->billing_status = 1; 
                    $new_note->billing_number = $pending_invoice->id;
                        if($updated_invoice_clinic_time > 4){
                            $new_note->billing_status_string = 'billing_completed';
                        }else{
                            $new_note->billing_status_string = 'billing_failed';
                        }
                    $new_note->save();
                }

    //*** IF PENDING INVOICE IS STILL OPEN *************************************************************************/
            } else {

                        //             // $pending_invoice->
                        //                     // $patient = $note->patient;  // We already have $findPatient object available to us:
                        //                     // $clinicTime instead of $note->clinic_time

                        //             // $sevenDaysAgo = now()->subDays(7)->startOfDay();

                        // //Get last note with pending invoice id
                        // $get_pending_invoice_notes = Note::where('billing_number', $pending_invoice->id)
                        // ->get();


                        // //Pass Array to where clause: https://stackoverflow.com/questions/19325312/how-to-create-multiple-where-clause-query-using-laravel-eloquent
                        // $matchThese = ['patient_id' => $pending_invoice->patient_id, 'billing_number' => $sevenDaysAgo];

                        // $checkOtherInvoices = Invoice::where($matchThese)->get();
                        //         // get first then sum?? see: https://laracasts.com/discuss/channels/eloquent/laravel-how-to-calculate-sum-of-column-values-using-eloquent
                        //         // $checkOtherInvoices = Invoice::where($matchThese)->sum('clinic_time');
                        // $checkExistingTotal = $checkOtherInvoices->sum('clinic_time');
                        // $cumulativeClinicTime = $clinicTime + $checkExistingTotal;

                        // $invoices = Invoice::updateOrCreate(
                        //     [
                        //         'patient_id' => $findPatient->id,
                        //         'seven_days_from_date_only' => $sevenDaysAgo,
                        //     ],
                        //     [
                        //         'cumulative_clinic_time' => Invoice::where('patient_id', $findPatient->id)
                        //             ->where('created_at', '>=', $sevenDaysAgo)
                        //             ->sum('clinic_time') + $clinicTime,
                        //         'billing_code' => calculateBillingCode($cumulativeClinicTime), // Implement this function
                        //     ]
                        // );


                        $get_pending_invoice_notes = Note::where('billing_number', $pending_invoice->id)
                        ->get();
                        $past_invoice_clinic_time = $get_pending_invoice_notes->sum('clinic_time');

                            // $get_last_invoice_note_date = Note::where('billing_number', $pending_invoice->id)->last();
                            // $get_last_invoice_note_date = Note::where('billing_number', $pending_invoice->id)
                            // ->orderBy('id', 'asc')
                            // ->latest('id')
                            // ->first();

                            $get_last_invoice_note_date = Note::where('billing_number', $pending_invoice->id)
                            ->orderBy('date_time_as_string', 'desc')
                            ->first();


        //GET NEW NOTES: Use date_time_as_string and change $pending_invoice_end_date to date time at 11:59 PM (23:59:59)
                        $get_new_invoice_notes = Note::where('patient_id', $pending_invoice->patient_id)
                        ->whereIn('billing_status_string', ['pending', 'check', 'billing_pending'])
                        ->whereBetween('date_time_as_string', [$get_last_invoice_note_date->date_time_as_string, $pending_invoice_end_date_TIME]) 
                        ->get();

        // Foreach loop to update each note in $get_new_invoice_notes
                    $new_invoice_clinic_time = $get_new_invoice_notes->sum('clinic_time');

        // Add up old time + new time:
                    $updated_invoice_clinic_time = $past_invoice_clinic_time + $new_invoice_clinic_time;

    //UPDATE the Pending Invoice THAT IS STILL OPEN:                         
                    $pending_invoice->cumulative_clinic_time = $updated_invoice_clinic_time;
                    $pending_invoice->billing_code = $this->calculateBillingCode($updated_invoice_clinic_time);

                    $pending_invoice->status = 0; //inactive since end_date_TIME is less than currentDate_TIME

                    $pending_invoice->billing_group_number = 'billing_pending';
                    // if($updated_invoice_clinic_time > 4){
                    //     $pending_invoice->billing_group_number = 'billing_completed';
                    // }else{
                    //     $pending_invoice->billing_group_number = 'billing_failed'
                    // }

                $pending_invoice->save();

    //UPDATE the new notes which were a part of this CURRENTLY OPEN Invoice:
                foreach($get_new_invoice_notes as $new_note){
                    $new_note->billing_status = 0; 
                    $new_note->billing_number = $pending_invoice->id;

                    $new_note->billing_status_string = 'billing_pending';
                        // if($updated_invoice_clinic_time > 4){
                        //     $new_note->billing_status_string = 'billing_completed';
                        // }else{
                        //     $new_note->billing_status_string = 'billing_failed';
                        // }

                    $new_note->save();
                }                                        


            } //end of else clause for update pending invoices period being OPEN '0'


        }
    }


//***************************************************************************************************************************** */

    private function checkForInvoices($patient){

            $oldestPendingNote = Note::where('patient_id', $patient->id)
            ->whereIn('billing_status_string', ['pending', 'check']) // 'in-billing'
            ->where('billing_status', 0) // Check that billing_status is equal to 0
            ->orderBy('date_only', 'asc')
            ->first();

            if ($oldestPendingNote) {

                
                // Set start date:
                $note_start_date = $oldestPendingNote->date_only;
            
                // Calculate end date (7 days in the future)
                $note_end_date = Carbon::parse($note_start_date)->addDays(7)->toDateString();

            // Check if note_end_date is less than the current date in EST.
                $currentDateEST = Carbon::now('America/New_York')->toDateString();
                if ($note_end_date < $currentDateEST) {
                    // The invoice group is in the past and both the Note and Invoice may be marked as completed. 
                    // $invoice_period_status = 'complete';
                    // $invoice_period_status = 'inactive';
                    $invoice_period_status = 1; //change billing_status from default 0 to 1
                } else {
                    // The invoice group is current, and at least the Invoice should be marked as pending? 
                    // $invoice_period_status = 'pending';
                    // $invoice_period_status = 'active';
                    $invoice_period_status = 0; //keep open/active and keep billing_status as default 0
                }

            //Get all notes in the invoice period:
                $notes_in_billing_period = Note::where('patient_id', $patient->id)
                    ->whereBetween('date_only', [$note_start_date, $note_end_date])
                    ->get();

                $check_clinic_time = $notes_in_billing_period->sum('clinic_time');
            
// UPDATE 2/21/2024 - $oldestPendingNote will always be without a billing_number value in function checkForInvoice()
                // Get the invoice_billing_number for this group by checking if oldest pending note has an billing_number, else create new #
                // if(!$oldestPendingNote->billing_number){
                if ($oldestPendingNote->billing_number !== null) {
                    $invoice_billing_number = $oldestPendingNote->billing_number;
                    $update_or_create_invoice = Invoice::find($invoice_billing_number); 
                }else{
                    $update_or_create_invoice = new Invoice;
                    $invoice_billing_number = $update_or_create_invoice->id;
                }
                                                        
        // $updateOldestPendingNote_billing_number = Note::find($oldestPendingNote->id);
        // $updateOldestPendingNote_billing_number->billing_number = $update_or_create_invoice->id;
        // $updateOldestPendingNote_billing_number->save();


                // Get the invoice_billing_number for this group by checking if oldest pending note has an billing_number, else create new #

                if($check_clinic_time > 4){

        // Update or Create Invoice ************************************************//
                // update or create the note in the Invoices table:
                    $update_or_create_invoice->patient_id = $patient->id;
                    $update_or_create_invoice->cumulative_clinic_time = $check_clinic_time;

        //*********probably get rid of seven days? Just set to note_end_date off oldestPendingNote ***************//
                    $update_or_create_invoice->seven_days_from_date_only = $note_start_date; //changed from note_end_date

        //*********probably get rid of seven days? Just set to note_end_date off oldestPendingNote ***************//


                // Invoice Status fields 'status' and 'billing_group_number'
                    // treat invoice->status as boolean even though originally set up as string:
                    $update_or_create_invoice->status = $invoice_period_status; // 0 active or 1 inactive (outside current date EST)

                if($invoice_period_status == 0){
                    // Probably change name of 'billing_group_number' like notes->billing_status_string
                    $update_or_create_invoice->billing_group_number = 'billing_pending';
                }else{
                    $update_or_create_invoice->billing_group_number = 'billing_completed';
                }

                //might change to calling outside private function: 
                    $update_or_create_invoice->billing_code = $this->calculateBillingCode($check_clinic_time); //get billing code

                    $update_or_create_invoice->save();
        // Update or Create Invoice ************************************************//

        // Update each note(s) **********************************************//
                    foreach($notes_in_billing_period as $updateNote){

                        //already have found our collection in the initial $notes_in_billing_period query
                        // $updateNote = Note::find($note->id);

                        // Add billing_number to note
                        $updateNote->billing_number = $invoice_billing_number;

                    // Add period_complete or period_ending to Note and Invoice
                        // $updateNote->billing_status_string = $invoice_period_status;
                        $updateNote->billing_status = $invoice_period_status; //Note billing_stauts either 'active/open' 0 or 'inactive/closed' 1
                        
                        if($invoice_period_status == 0){
                            $updateNote->billing_status_string = 'billing_pending';
                        }
                            $updateNote->billing_status_string = 'billing_completed';

                        $updateNote->save();

                    }
                

                }else{ //LESS THAN 4 MINS

        // **** LESS THAN 4 MINS -> NOT ENOUGHT TIME: 
                    if($invoice_period_status === 1 ){

        // LESS than 5 mins - PERIOD CLOSED - INVOICE UPDATE
                        // less than 4 minutes and 7 day window is closed, so mark as not billable: 
                        $update_or_create_invoice->status = $invoice_period_status; // 1 - closed/inactive
                        $update_or_create_invoice->billing_group_number = 'billing_failed'; //CHECK INVOICE FIELD NAME
                        $update_or_create_invoice->patient_id = $patient->id;
                        $update_or_create_invoice->cumulative_clinic_time = $check_clinic_time;

                    
                        $update_or_create_invoice->seven_days_from_date_only = $note_start_date; //changed from note_end_date
                        $update_or_create_invoice->billing_code = $this->calculateBillingCode($check_clinic_time); //returns 'N/A'
                        $update_or_create_invoice->save();


        // LESS than 5 mins - PERIOD CLOSED - Update each note(s) **********************************************//
                        foreach($notes_in_billing_period as $updateFailedNote){   
                            //Already have found note in initial query:
                            // $updateNote = Note::find($note->id);
                            // Add billing_number to note
                            // $updateFailedNote->billing_number = $invoice_billing_number;
                            $updateFailedNote->billing_number = $update_or_create_invoice->id;

                        // Add period_complete or period_ending to Note and Invoice
                            $updateFailedNote->billing_status = $invoice_period_status; //Note billing_stauts is 'inactive/closed' 1
                            $updateFailedNote->billing_status_string = 'billing_failed';
                            $updateFailedNote->save();
                        }
                    }else{
        // LESS than 5 mins - PERIOD STILL OPEN - INVOICE UPDATE

                        // Less than 4 minutes but 7 day window is still open: 

                        $update_or_create_invoice->status = $invoice_period_status; // 0 - open/active
                        $update_or_create_invoice->billing_group_number = 'billing_pending'; //CHECK INVOICE FIELD NAME
                        $update_or_create_invoice->patient_id = $patient->id;
                        $update_or_create_invoice->cumulative_clinic_time = $check_clinic_time;
                
                        $update_or_create_invoice->seven_days_from_date_only = $note_start_date; //changed from note_end_date
                            // Don't skip calling the billing_code function... (??)
                        $update_or_create_invoice->billing_code = $this->calculateBillingCode($check_clinic_time); //returns 'N/A'
                        $update_or_create_invoice->save();

        // LESS than 5 mins - PERIOD STILL OPEN - NOTE(s) UPDATE
                        foreach($notes_in_billing_period as $incompleteNote){   
                            // Already found note in initial query
                            // $incompleteNote = Note::find($note->id);
                            // Add billing_number to note
                            // $incompleteNote->billing_number = $invoice_billing_number;
                            $incompleteNote->billing_number = $update_or_create_invoice->id;
                        // Add period_complete or period_ending to Note and Invoice
                            $incompleteNote->billing_status = $invoice_period_status; //Note billing_stauts is 'active/open' 0
                            $incompleteNote->billing_status_string = 'billing_pending'; //check if this will conflict with note creation status string??
                            $incompleteNote->save();
                        }

                    }
                }

            } // outter check to see if patient has $oldestPendingNote
        //Do I need the else clause? 
            // else {
            //     // Handle the case where no note is found
            //     $note_start_date = null;
            //     $note_end_date = null;
            // }
    }


//****************************************************************************************************************************** */


//Added (16:20) - Show homepage for logged in user: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207654#overview
    public function showCorrectHomepage(){
        //Check if current user is logged in with globally available 'auth()'
        // auth()->check() //true or false if logged in
        if (auth()->check()) {
            $hardCodedMessage = '';

            $users = User::all();
            // $patients = Patient::all();
            $patients = Patient::where('status',0)->get(); //get all active patients
            

            // *** FIRST TEST TO SUM ALL PENDING NOTES AND UPDATE FIELD ON USER => clinic_time_counter **********//
                            // foreach($patients as $patient){        
                                //     // $getPendingPtNotes = Note::where('patient_id', $patient->id)
                                //     // ->whereIn('billing_status_string', ['pending', 'check'])
                                //     // ->get();
                                
                                //     $getPendingPtNotes = Note::where('patient_id', $patient->id)
                                //     ->whereIn('billing_status_string', ['pending', 'check'])
                                //     ->where('billing_status', 0) // Check that billing_status is equal to 0
                                //     ->get();
                                
                                //     $getPendingTime = $getPendingPtNotes->sum('clinic_time');
                                //     // if($getPendingTime){
                                    
                                    //         $updatePatientTime = Patient::find($patient->id);
                                    //         $updatePatientTime->clinic_time_counter = $getPendingTime;
                                    //         $updatePatientTime->save();
                                    //     // }
                                    // }
            // *** FIRST TEST TO SUM ALL PENDING NOTES AND UPDATE FIELD ON USER => clinic_time_counter **********//
                                       
                    // Thu 2/8/2023 Update all patient Invoices from last 'pending' or 'check' note:
                    // foreach($patients as $patient){
                    // } //end of pt foreach loop


//******************************************************************************************************************************* */

// Separate function: ****************************************************************************
        // $pendingInvoices = Invoice::where('billing_status', 'billing_pending')->get();
        // $pendingInvoices = Invoice::where('billing_group_number', 'billing_pending')->get();

        foreach($patients as $patient){

            $pendingInvoices = Invoice::where('patient_id', $patient->id)
            ->whereIn('billing_status_string', ['billing_pending'])
            // ->whereBetween('date_time_as_string', [$get_last_invoice_note_date->date_time_as_string, $pending_invoice_end_date_TIME]) 
            ->get();


            if($pendingInvoices !== null) {
                $this->updatePendingInvoices($pendingInvoices);
            }else{
                $this->checkForInvoices($patient);
            }

        }



// UPDATE PENDING INVOICES END******************************************************************

            $invoices = Invoice::all();

            return view('homepage-feed', ['guestMessage' => $hardCodedMessage, 'users' => $users, 'patients' => $patients, 'invoices' => $invoices]);
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

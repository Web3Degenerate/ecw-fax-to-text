<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Invoice;

use DB; 
use Carbon\Carbon; 

class NoteController extends Controller
{
    
    
    
//See #DCT NurseController @ storeNurseNote
    public function storeNurseNote(Request $request){
        //Create Note
        $note = new Note;
        $note->patient_name = $request->input('patient_name'); 
        $note->mrn = $request->input('user_mrn'); 
        $note->user_id = $request->input('user_id'); 
        $note->note_date = $request->input('note_date');
        
        
        
        //1/6/21 update - SOLUTION! $datetime_from = (new Carbon($thestime))->subMinutes(45)->format('Y-m-d H:i');
        // FROM: https://stackoverflow.com/questions/11688829/php-use-strtotime-to-subtract-minutes-from-a-date-time-variable
        // $note->time_in = $request->input('time_in');
        // https://stackoverflow.com/questions/17717911/how-to-subtract-minutes/17718000#:~:text=php%20%24date%20%3D%20new%20DateTime(,i%3As')%3B%3F%3E&text=To%20subtract%2015%20minutes%20you,number%20of%20minutes%20you%20want.
        // ****
        // Fixed AM/PM issue with upper case 'H' to convert to 24 hour: https://www.php.net/manual/en/datetime.format.php
            
            $time_out_calc = Carbon::parse($request->input('time_out'))->format('H:i:s');
            $clinc_time_manual = $request->input('clinic_time'); 
            $time_in_calc = (new Carbon($time_out_calc))->subMinutes($clinc_time_manual)->format('H:i:s');
        }

        



// __  __                         _    ____      _ _   _____       ____  ____  _____               _    ____ ___ 
// |  \/  | __ _ _ __  _   _  __ _| |  / ___|__ _| | | |_   _|__   / ___||  _ \|  ___|_ ___  __    / \  |  _ \_ _|
// | |\/| |/ _` | '_ \| | | |/ _` | | | |   / _` | | |   | |/ _ \  \___ \| |_) | |_ / _` \ \/ /   / _ \ | |_) | | 
// | |  | | (_| | | | | |_| | (_| | | | |__| (_| | | |   | | (_) |  ___) |  _ <|  _| (_| |>  <   / ___ \|  __/| | 
// |_|  |_|\__,_|_| |_|\__,_|\__,_|_|  \____\__,_|_|_|   |_|\___/  |____/|_| \_\_|  \__,_/_/\_\ /_/   \_\_|  |___|




    public function getFaxInbox(){
            // Dynamically set $sEndDate to current day (in EST) and set $sStartDate will be 14 prior to $sEndDate. 
            // date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time
        
            // // Get the current date in 'YYYYMMDD' format
            //     $currentDate = (new DateTime())->format('Ymd');
            //     $sEndDate = $currentDate;
            
            // // Go back 14 days from the current date
            //     $startDateObj = (new DateTime())->modify('-14 day');
            //     $sStartDate = $startDateObj->format('Ymd');

            // Get the current date in 'YYYYMMDD' format
                // $currentDate = Carbon::now()->format('Ymd');

                $currentDate = Carbon::now('America/New_York')->format('Ymd');
                // $sEndDate = $currentDate;
//For testing, set sEndDate to hardcoded 2/3/2023
        $sEndDate = '20240203';
                    // Go back X days from the current date: 1/23/2024 => 2/6/2024 (14 days)
                        // $startDateObj = Carbon::now()->subDays(14);
                        // $sStartDate = $startDateObj->format('Ymd');
        $sStartDate = '20240123';

                // $sEndDate = '20220206';
                // $sStartDate = '20220205';
            
              $postVariables = array(
                'action'           => 'Get_Fax_Inbox',
                'access_id'        => "309406",
                'access_pwd'       => "TCDM3d1cal1!",
                'sPeriod'    => 'RANGE',
                'sStartDate' => $sStartDate,
                'sEndDate' => $sEndDate
               );
        
        
               $curlDefaults = array(
                CURLOPT_POST           => 1,
                CURLOPT_HEADER         => 0,
                CURLOPT_URL            => 'https://secure.srfax.com/SRF_SecWebSvc.php',
                CURLOPT_FRESH_CONNECT  => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE   => 1,
                CURLOPT_TIMEOUT        => 60,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_POSTFIELDS     => http_build_query($postVariables),
            );
            
            $ch = curl_init();
            curl_setopt_array($ch, $curlDefaults);
            $result = curl_exec($ch);
                 
                if (curl_errno($ch)) {
                    // echo 'Error – ' . curl_error($ch);
                        // $log_for_get_fax_inbox = 'Error – ' . curl_error($ch);
                        // exit;
                    return 'Error – ' . curl_error($ch);
                }
                else {
                //  echo $result;
                 return $result;
                    // $log_for_get_fax_inbox = 'Success! 1 or more faxes found.';

                            // $response = file_get_contents($result);
                            // $result_get_fax_inbox = json_decode($response, true);
                
                            // // Pull out the array results
                            // if ($result_get_fax_inbox && isset($result_get_fax_inbox['Result'])) {
                            //     $faxData = $result_get_fax_inbox['Result'];
                            //     return $faxData;
                            // } else {
                            //     $faxData = '';
                            //     return $faxData;
                            // }
                   
                }

                curl_close($ch);
    }



    private function retrieveFax($sFaxDetailsID){

        $postVariables = array(
            'action'           => 'Retrieve_Fax',
            'access_id'        => "309406",
            'access_pwd'       => "TCDM3d1cal1!",
            'sFaxDetailsID'    => $sFaxDetailsID,
            'sDirection'       => 'IN',
            'sResponseFormat'  => 'JSON',
            'sFaxFormat'       => 'PDF'
        );

        $curlDefaults = array(
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => 0,
            CURLOPT_URL            => 'https://secure.srfax.com/SRF_SecWebSvc.php',
            CURLOPT_FRESH_CONNECT  => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE   => 1,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_POSTFIELDS     => http_build_query($postVariables),
        );

        $ch = curl_init();
        curl_setopt_array($ch, $curlDefaults);
        $result_retrieve_fax = curl_exec($ch);

            if (curl_errno($ch)) {
                // $log_for_retrieve_fax_result = 'Fax sFaxDetailsID ' . $sFaxDetailsID . ' Error Message:  ' . curl_error($ch);
                // echo json_encode(["error" => "Error – " . curl_error($ch)]);
                // echo 'Error – ' . curl_error($ch);
                return 'Error – ' . curl_error($ch);

            } else {  
                // $log_for_retrieve_fax_result = 'Fax sFaxDetailsID ' . $sFaxDetailsID . ' retrieved! Fax notes added to DB.';
                // echo $result_retrieve_fax;
                return $result_retrieve_fax;

            }
            curl_close($ch);

    }



 // check fax inbox: GET ROUTE  
 // show all faxes in date range without saving them as notes (original version)
    public function checkFaxInbox() {
        $check_srfax_inbox = $this->getFaxInbox();
        return view('fax-inbox-list', ['faxDataContents' => $check_srfax_inbox]);
    }

// show all notes which are partially created from the faxes received (2/4/2024 version)
    public function showFaxInbox() {

        $check_srfax_inbox = $this->getFaxInbox();
        //         $response = file_get_contents($check_srfax_inbox);
                $result_get_fax_inbox = json_decode($check_srfax_inbox, true);
        
        //    // Pull out the array results
                    if ($result_get_fax_inbox && isset($result_get_fax_inbox['Result'])) {
                        $faxData = $result_get_fax_inbox['Result'];
                    // **** GOOD UP TO $faxData ************************************************************* //

                            foreach ($faxData as $fax) {
                    
                                // Extract sFaxDetailsID from FileName
                                    $fileNameParts = explode('|', $fax['FileName']);
                                $sFaxDetailsID = isset($fileNameParts[1]) ? $fileNameParts[1] : '';
                                $sFaxFileName = isset($fileNameParts[0]) ? $fileNameParts[0] : '';
                                
                                // Pull the Date Fax was Sent??
                                        // echo urlencode($fax['Date']);
                                        // echo 'Date: ' . $fax['Date'];
                                $date_fax_sent = $fax['Date'];       
                                $fax_status = $fax['ReceiveStatus'];
                                $checkForNote = Note::where('fax_details_id', $sFaxDetailsID)->first();

                                    if(!$checkForNote){
                                        $note = new Note;
                                        $note->patient_id = 1; //Enter id of Catchall User
                                            // Set the timezone to Eastern Standard Time
                                            // $currentDate = Carbon::now('America/New_York')->format('Ymd');
                                            // $set_default_expiration_date = $currentDate->addDays(7);
                                            $set_default_expiration_date = Carbon::now('America/New_York')->addDays(7)->format('Ymd');
                                        
                                        $note->billing_expiration_date = $set_default_expiration_date;
                                        $note->patient_name = 'Patient Inbox';
                                        $note->pt_mrn = '911';

                                        $note->fax_file_name = $sFaxFileName;
                                        $note->fax_details_id = $sFaxDetailsID;
                                        $note->fax_status = $fax_status;
                                    
                                        $note->date_time_fax_received = Carbon::parse($date_fax_sent);
                                        
                                        $note->save();
                                    }
                            }

                            // return view('fax-inbox')->with('success', 'Faxes Updated.');
                            $notes = Note::all();
                            $hardCodedMessage = 'Success! New faxes have been updated';
                            $displayBox = "alert alert-success text-center";
                            return view('fax-inbox', ['faxMessage' => $hardCodedMessage, 'notes' => $notes, 'displayBox' => $displayBox]);
                    } else {
                        // $faxData = '';
                        $notes = Note::all();
                        $hardCodedMessage = 'No new faxes have been received';
                        $displayBox = "alert alert-danger text-center";
                        return view('fax-inbox', ['faxMessage' => $hardCodedMessage, 'notes' => $notes, 'displayBox' => $displayBox]);
                    }

            // return view('fax-inbox', ['faxData' => $faxData]);
            // return view('fax-inbox', ['faxDataContents' => $check_srfax_inbox]);

    } 


    public function retrieveSingleFax($faxid){
        $sFaxDetailsID = $faxid;
  
        $check_retrieve_fax = $this->retrieveFax($sFaxDetailsID);
        // return view('fax-view-single', ['pdfDataUrl' => $check_retrieve_fax]);
                                                
        // $retrieveFaxResponse = file_get_contents($check_retrieve_fax); // don't need file_get_contents in laravel
        $decodedResult = json_decode($check_retrieve_fax, true);
        $pdfData = $decodedResult['Result'];

        $dataUrlPdfData = 'data:application/pdf;base64,' . $pdfData;

        // $pdfDataUrl = json_encode($dataUrlPdfData); json_encode in the view's JS?? (1/29/24)

        return view('fax-view-single', ['dataUrlPdfData' => $dataUrlPdfData, 'pdfData' => $pdfData, 
                    'faxDetailsId' => $sFaxDetailsID]);
    }

    public function retrieveFaxFormForManualEntry($faxid){
        $sFaxDetailsID = $faxid;
  
        $check_retrieve_fax = $this->retrieveFax($sFaxDetailsID);
        // return view('fax-view-single', ['pdfDataUrl' => $check_retrieve_fax]);
                                                
        // $retrieveFaxResponse = file_get_contents($check_retrieve_fax); // don't need file_get_contents in laravel
        $decodedResult = json_decode($check_retrieve_fax, true);
        $pdfData = $decodedResult['Result'];

        $dataUrlPdfData = 'data:application/pdf;base64,' . $pdfData;

        // $pdfDataUrl = json_encode($dataUrlPdfData); json_encode in the view's JS?? (1/29/24)

        return view('fax-enter-single-form', ['dataUrlPdfData' => $dataUrlPdfData, 'pdfData' => $pdfData,
                    'faxDetailsId' => $sFaxDetailsID]);
    }




// ************ UPDATE OR CREATE NOTE FROM MANUAL FAX FORM ******************************************//
    
    public function createNoteFromManualFaxForm(Request $request){

        // $getPatient = Patient::find($request->input('mrn'));
        $get_pt_mrn = $request->input('mrn');
            $get_pt_name = $request->input('patient_name');
            $get_pt_dob = $request->input('dob');
            $get_pt_referring_provider = $request->input('referring_provider');


         //firstOrCreate vs (v10.20) new createOrfirst: https://laravel-news.com/firstorcreate-vs-createorfirst
        // FROM StackOverFlow: https://stackoverflow.com/questions/25178464/first-or-create
        $findPatient = Patient::firstOrCreate([
            'mrn' => $get_pt_mrn
        ], [
            'name' => $get_pt_name,
            'dob' => $get_pt_dob,
            'referring_provider' => $get_pt_referring_provider
        ]);
// Get dateTime stamp: 

        $get_standardized_date_time_string = $request->input('note_date_time_string_standardized');
//Instead of using firstOrFail(), which will throw an exception if no note is found, you should use first() and then check if the result is not null. This way, you can handle the case where no note is found more gracefully.
        // $checkForNote = Note::where('date_time_as_string', $get_standardized_date_time_string)->firstOrFail();
        
        
        
        // Consolidate $checkForNote and Note's patient_id equalks current patient id into one if statement:
            // if($checkForNote){
                //     if($checkForNote->patient_id == $findPatient->id){
                    //         return back()->with('failure', 'Note on ' . $get_standardized_date_time_string . ' for patient ' . $get_pt_name . ' ( ' . $get_pt_mrn . ') has already been entered in your practice\'s Online Digital E-M program.');
                    //     }
                    // }

// 2/5/2024 - Temporarily turn off the check based on action taken dateTime stamp:
// $checkForNote = Note::where('date_time_as_string', $get_standardized_date_time_string)->first();
// if ($checkForNote && $checkForNote->patient_id == $findPatient->id) {
//     return back()->with('failure', 'Note on ' . $get_standardized_date_time_string . ' for patient ' . $get_pt_name . ' (' . $get_pt_mrn . ') has already been entered in your practice\'s Online Digital E-M program.');
// }


        // if(!$checkForNote){
            // $note = new Note;
            $fax_details_id = $request->input('fax_details_id');

            $note = Note::where('fax_details_id', $fax_details_id)->first();

            if($note){
                $note = $note;
            }else{
                $note = new Note;
            }

            $note->patient_id = $findPatient->id;

            $note->patient_name = $get_pt_name; 
            $note->pt_mrn = $get_pt_mrn; 

            $note->patient_dob = $get_pt_dob; 

// $note->dob_formatted = $request->input('dob_formatted');
//run migration: $table->date('patient_dob_formatted')->nullable();

            $note->note_provider = $request->input('referring_provider'); 

            $note->date_time_as_string = $request->input('note_date_time_string_standardized');
//pure dateTime: Try using the ISO field first (1/31/2024):
    // $note->date_time = $request->input('note_date_time_formatted')
// dateTime as ISO (Try this first for the pure dateTime on 1/31/2024)
    // $note->date_time_iso = $request->input('note_date_time_iso');

    $dateTimeOfNote = $request->input('note_date_time_iso');
    $clinicTime = $request->input('clinic_time');

        //Store the time spent in minutes: 
        $note->clinic_time = $clinicTime;   // example 2

// Modified dateTime and time fields: Example: 01/31/2024 08:19 PM
        $carbonDateTime = Carbon::parse($dateTimeOfNote);

        $note->date_time = $carbonDateTime; // stores "01/31/2024 08:19 PM"

        $note->time_out = $carbonDateTime->format('H:i:s'); // stores "08:19 PM as 20:19:00"
    
        // Format date_only
        $current_note_date_on_timestamp = $carbonDateTime->toDateString();
        $note->date_only = $current_note_date_on_timestamp;

        // Add 7 days to the date_only field
        $billingExpirationDate = $carbonDateTime->copy()->addDays(7)->format('Ymd');

        // Save the billing_expiration_date field
        $note->billing_expiration_date = $billingExpirationDate; // 7 days from current note_date


        // date_default_timezone_set('America/New_York');
        // $currentEstDate = Carbon::now()->format('Ymd');
        // $currentEstString = Carbon::now('America/New_York')->format('Ymd');
        // $currentEstDate = Carbon::parse($currentEstString);

//*************** TODO: convert date as string to date object so you can compare it: *********************************************** //
// $currentDate = Carbon::now('America/New_York')->format('Ymd');
// $currentEstDate = $currentDate;
        
// In this corrected code, I used copy() to create a copy of the $currentEstDate before subtracting 7 days to ensure that the original $currentEstDate remains unchanged for the comparison. 
// Also, I replaced >= with isAfter for the comparison.        
        // $seven_days_ago_check = $currentEstDate->subDays(7);
        // $seven_days_ago_check = $currentEstDate->copy()->subDays(7);
        // ERROR: Call to a member function copy() on string
            // $seven_days_ago_check = $currentEstDate->subDays(7)->format('Ymd');


// You're on the right track, but there's a small mistake in your code. subDays(7) returns a new Carbon instance representing the date 7 days ago, so you don't need to perform the date comparison using >=. 
// Instead, you should use isAfter to check if the note's date is after the calculated date.
        // if ($currentEstDate->isAfter($seven_days_ago_check)) {
// if ($billingExpirationDate->isAfter($currentEstDate)) {   
//     $note->billing_status = 0; // actively within current 7 day period
// }else{
//     $note->billing_status = 1; // inactive - more than 7 days from current period.
// }
//*************** TODO: convert date as string to date object so you can compare it: *********************************************** //

    // $current_note_date = $carbonDateTime->format('Ymd');
    
    // $patient_em_date = $findPatient->em_date;
    // if($patient_em_date){
    //     $seven_days_after_patient_em_date = $patient_em_date->addDays(7);
    //     if ($current_note_date > $seven_days_after_patient_em_date) {   // if ($billingExpirationDate->isAfter($currentEstDate)) {     
    //         $note->billing_status_string = 'pending; // pending - note outside of 7 day window from last em visit
    //     }else{
    //         $note->billing_status_string = 'invalid'; // inactive - note within 7 days of last em visit
    //     }
    // }



        $note->review_status = 1; //migration on 2/4/2024 as another boolean value, 0 needs review, 1 review complete.

//ChatGPT code review, merge subMinutes and format into one line
        // $modifiedDateTime = $carbonDateTime->subMinutes($clinicTime); // creates 01/31/2024 08:17 PM
            // Format our modifiedDateTime into 'h:i:s A' format
        // $note->time_in = $modifiedDateTime->format('h:i:s A'); // saves as "08:17 PM"
        // $note->time_in = $carbonDateTime->subMinutes($clinicTime)->format('h:i:s A'); // saves as "08:17 PM"
        $note->time_in = $carbonDateTime->subMinutes($clinicTime)->format('H:i:s'); // saves as "20:17:00"


        // $note->note_body = $request->input('note_body');
        // $note->fax_image_link = $request->input('fax_image_link');
        // $note->fax_details_id = $request->input('fax_details_id');
        
        $note->save();   
        //******************* END OF CREATE NOTE  *************************** */           


        //****************** START OF UpdateOrCreate an Invoice object ********* */

    //ChatGPT recommended setting up separate function: 
    function calculateBillingCode($cumulativeClinicTime){
        if($cumulativeClinicTime >= 5 && $cumulativeClinicTime < 11){
            return '99421';
        } elseif($cumulativeClinicTime >= 11 && $cumulativeClinicTime < 21){
            return '99422';
        } elseif($cumulativeClinicTime >= 21){
            return '99423';
        } else {
            return 'Online Digital E/M Billing Requirements Not Met';
        }
    }

        // $patient = $note->patient;  // We already have $findPatient object available to us:
        // $clinicTime instead of $note->clinic_time

        $sevenDaysAgo = now()->subDays(7)->startOfDay();

        //Pass Array to where clause: https://stackoverflow.com/questions/19325312/how-to-create-multiple-where-clause-query-using-laravel-eloquent
        $matchThese = ['patient_id' => $findPatient->id, 'seven_days_from_date_only' => $sevenDaysAgo];
        $checkOtherInvoices = Invoice::where($matchThese)->get();
        // get first then sum?? see: https://laracasts.com/discuss/channels/eloquent/laravel-how-to-calculate-sum-of-column-values-using-eloquent
        // $checkOtherInvoices = Invoice::where($matchThese)->sum('clinic_time');
        $checkExistingTotal = $checkOtherInvoices->sum('clinic_time');
        $cumulativeClinicTime = $clinicTime + $checkExistingTotal;

        $invoices = Invoice::updateOrCreate(
            [
                'patient_id' => $findPatient->id,
                'seven_days_from_date_only' => $sevenDaysAgo,
            ],
            [
                'cumulative_clinic_time' => Invoice::where('patient_id', $findPatient->id)
                    ->where('created_at', '>=', $sevenDaysAgo)
                    ->sum('clinic_time') + $clinicTime,
                'billing_code' => calculateBillingCode($cumulativeClinicTime), // Implement this function
            ]
        );




    // ******************** END of UpdateOrCreate Invoice Object => finally return back() to the view: **********//
        // return back()->with('success', 'Note on ' . $get_standardized_date_time_string . ' for patient ' . $get_pt_name . ' ( ' . $get_pt_mrn . ') was added to your practice\'s Online Digital E-M program.');
        return redirect('/fax-inbox')->with('success', 'Note on ' . $get_standardized_date_time_string . ' for patient ' . $get_pt_name . ' ( ' . $get_pt_mrn . ') was added to your practice\'s Online Digital E-M program.');

    // }


    } //end of manual save note entry (createNoteFromManualFaxForm)


// ***************************************** manuallyGetFaxUpdate() combined function test ********************* //

    public function manuallyGetFaxUpdate(Request $request){

        $check_srfax_inbox = $this->getFaxInbox();
                $response = file_get_contents($check_srfax_inbox);
                $result_get_fax_inbox = json_decode($response, true);
        
           // Pull out the array results
                    if ($result_get_fax_inbox && isset($result_get_fax_inbox['Result'])) {
                        $faxData = $result_get_fax_inbox['Result'];
            // **** GOOD UP TO $faxData ************************************************************* //

                            foreach ($faxData as $fax) {
                    
                                // Extract sFaxDetailsID from FileName
                                    $fileNameParts = explode('|', $fax['FileName']);
        $sFaxDetailsID = isset($fileNameParts[1]) ? $fileNameParts[1] : '';
                                $sFaxFileName = isset($fileNameParts[0]) ? $fileNameParts[0] : '';
                                
                                // Pull the Date Fax was Sent??
                                        // echo urlencode($fax['Date']);
                                        // echo 'Date: ' . $fax['Date'];
                                $date_fax_sent = $fax['Date'];       
                                $fax_status = $fax['ReceiveStatus'];
        
                                
    //** With SRFax $sFaxDetailsID, we can now call the SRFax 'Retrieve_Fax' action: */
                                //pass $sFaxDetailsID to details.php
        
                                        // if (empty($sFaxDetailsID)) {
                                        //     $log_for_retrieve_fax_attempt = 'Error: sFaxDetailsID is missing.';
                                        //     // echo json_encode(["error" => "sFaxDetailsID is missing."]);
                                        //     exit;
                                        // }
        
                                        // $log_for_retrieve_fax_attempt = 'sFaxDetailsID ' . $sFaxDetailsID . ' exists. Processing Retrieve_Fax action.';
        
                                       
        $check_retrieve_fax = $this->retrieveFax($sFaxDetailsID);
                                             
        
                                                $retrieveFaxResponse = file_get_contents($check_retrieve_fax);
                                                $decodedResult = json_decode($retrieveFaxResponse, true);
                                                $pdfData = $decodedResult['Result'];
            
                                                $dataUrlPdfData = 'data:application/pdf;base64,' . $pdfData;
            
                                                $pdfDataUrl = json_encode($dataUrlPdfData);
                                                              

// ************************************* Extract string values from $pdfDataUrl ***************
                                                $mrn_matches = [];
                                                $pt_name_matches = [];
                                                $pt_dob_matches =[];

                                                if (preg_match('/Account No:\s*(\d{5,6})/i', $pdfDataUrl, $mrn_matches)) {
                                                    $get_pt_mrn = $mrn_matches[1];                                     
                                                }else{
                                                    $get_pt_mrn = '911';
                                                }


                                                if (preg_match('/Patient Name:\s*([^,]*,[^,]*)/', $pdfDataUrl, $pt_name_matches)) {
                                                    $get_pt_name = $pt_name_matches[1];                                    
                                                }else{
                                                    $get_pt_name = '911';
                                                }

         
                                                if (preg_match('/DOB:\s*(\d{2}\/\d{2}\/\d{4})/', $pdfDataUrl, $pt_dob_matches)) {
                                                    $get_pt_dob = $pt_dob_matches[1];                                    
                                                }else{
                                                    $get_pt_dob = '';
                                                }

                        // Referring_Provider:
                        $pt_referring_provider_matches = [];
                        $get_pt_referring_provider = '';

                        // Perform the regular expression match
                        if (preg_match('/Action Taken\s+([^\d]+)\s+\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2} [APMapm]+ >\d+ minutes/', $pdfDataUrl, $pt_referring_provider_matches)) {
                            $get_pt_referring_provider = trim($pt_referring_provider_matches[1]);
                        }else{
                            $get_pt_referring_provider = 'Dent Provider';
                        }

        //firstOrCreate vs (v10.20) new createOrfirst: https://laravel-news.com/firstorcreate-vs-createorfirst
        // FROM StackOverFlow: https://stackoverflow.com/questions/25178464/first-or-create
                                                $findPatient = Patient::firstOrCreate([
                                                    'mrn' => $get_pt_mrn
                                                ], [
                                                    'name' => $get_pt_name,
                                                    'dob' => $get_pt_dob,
                                                    'referring_provider' => $get_pt_referring_provider
                                                ]);
        // Get dateTime stamp: 
                        $pt_date_time_string_matches = [];
                        $get_date_time_string = '';

                        // dateTime Stamp String regular expression match
                        if (preg_match('/Action Taken [^0-9]+ (\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2} [APMapm]+) >\d+ minutes/', $pdfDataUrl, $pt_date_time_string_matches)) {
                            $get_date_time_string = trim($matches[1]);
                        }else{
                            $get_date_time_string = 'Note dateTime stamp Not Found';
                        }

                                            

                                                $saveObj = Note::updateOrCreate(
                                                    // ['data_id'=>$bpList['DataID']
                                                    ['note_date_time'=>$bpList['DataID']
                                                ],
                                                [
                                                    'user_id' => $userID,
                                                    'bpl' => $bpList['BPL'],
                                                    'data_id' => $bpList['DataID'],
                                                    'data_source' => $bpList['DataSource'],
                                                    'hp' => $bpList['HP'],
                                                    'hr' => $bpList['HR'],
                                                    'is_arr' => $bpList['IsArr'],
                                                    'lp' => $bpList['LP'],
                                                    'last_change_time' => date("Y-m-d H:i:s", $bpList['LastChangeTime']),
                                                    'lat' => $bpList['Lat'],
                                                    'lon' => $bpList['Lon'],
                                                    'measurement_date' => date("Y-m-d H:i:s", $bpList['MDate']),
                                                    'note' => $bpList['Note'],
                                                    'time_zone' => $bpList['TimeZone'],
                                                    'measurement_time' => $bpList['measurement_time'],
                                                ]);




                                        } //End of foreach loop hopefully; replaces => //end of else clause for successfully retrieving fax via 'Retrieve_Fax'
        
                                
                            } //End of IF checking isset($result_get_fax_inbox['Result']);  replaces=> //end of 'Get_Fax_Inbox' action foreach loop
                    // } //end of 'Get_Fax_Inbox' $decoded_result isset check


                    return redirect('/')->with('success', 'Manual Check for New Faxes Completed.');
                } //End of function manuallyGetFaxUpdate;  replaces=> //End of curl_exec else statment
        

// ******************* FORMAT FOR ChatGPT code review *************************



    } //end of NoteController class; replaces => //end of manuallyGetFaxUpdate() // R 1/25/2024
        





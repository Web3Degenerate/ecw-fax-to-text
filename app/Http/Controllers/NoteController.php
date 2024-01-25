<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use DB; 
use Carbon\Carbon; 

class NoteController extends Controller
{
    
    public function manuallyGetFaxUpdate(Request $request){

        return redirect('/')->with('success', 'Manual Check for New Faxes Completed.');
    }


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

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Patient;
use App\Models\Note;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

use DB; 
use Carbon\Carbon; 
use App\Models\Invoice;

use App\Models\Name;
use App\Models\Provider;
use App\Models\Clinic;


class ClinicController extends Controller
{
    

        public function showAddProviderForm(){
            //Logged in user can register another user:
            if (auth()->check()) {
                $hardCodedMessage = '';
                return view('provider-add-new', ['guestMessage' => $hardCodedMessage]);

            } else {
        // redirect back to GUEST homepage: (let guest create the first user)
                // $hardCodedMessage = 'Go ahead and register as a guest.';
                // return view('homepage-enroll', ['guestMessage' => $hardCodedMessage]);
                // return view('homepage-enroll')->with('failure', 'Go ahead and register as guest...');
                $hardCodedMessage = 'Go ahead and add a provider as a guest. Don\'t tell anyone!';
                return view('provider-add-new', ['guestMessage' => $hardCodedMessage]);
                // return redirect('/')->with('failure', 'You do not have the permissions to add a new provider.');
            }  

            
        }





} //end of clinic class

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Follow;

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

    public function getPreviousInvoices(){
        //add new table here.
        return back();
    }
    

        public function showAddClinicForm(){
            //Logged in user can register another user:
            if (auth()->check()) {
                $hardCodedMessage = '';
                return view('clinic-add-new', ['guestMessage' => $hardCodedMessage]);

            } else {
        // redirect back to GUEST homepage: (let guest create the first user)
                // $hardCodedMessage = 'Go ahead and register as a guest.';
                // return view('homepage-enroll', ['guestMessage' => $hardCodedMessage]);
                // return view('homepage-enroll')->with('failure', 'Go ahead and register as guest...');
                $hardCodedMessage = 'Go ahead and add a provider as a guest. Don\'t tell anyone!';
                return view('clinic-add-new', ['guestMessage' => $hardCodedMessage]);
                // return redirect('/')->with('failure', 'You do not have the permissions to add a new provider.');
            }  

            
        }


        // ['clinic_name', 'clinic_type', 'clinic_email', 'clinic_fax'];

        public function registerNewClinic(Request $request){
            $incomingFields = $request->validate([
                // 'username' => 'required', //updated to array in https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#content
                //&&& #DCT NEW FIELDS &&&
                'clinic_name' => ['required'],
                // 'clinic_name' => ['required', Rule::in([1, 2, 3])], // Add Rule::in rule for the 'provider' field
                'clinic_type' => ['required']
            ]);
    

            $clinic = new Clinic;
    
            $clinic->clinic_name = $request->input('clinic_name'); 
            $clinic->clinic_type = $request->input('clinic_type'); 
            $clinic->clinic_email = $request->input('clinic_phone'); //phone
            $clinic->clinic_fax = $request->input('clinic_fax'); 

            $clinic->save();   
    
    

            $displayClinicName = $clinic->clinic_name;
            $displayBuildingName = $clinic->clinic_type;
            $hardCodedMessage = 'Clinic ' . $displayClinicName . ' in building:' . $displayBuildingName . ' has been added as an eligible provider in the Online Digital E-M program.';

            $users = User::all();
            // $patients = Patient::all();
            $patients = Patient::where('status',0)->get(); //get all active patients           
            $invoices = Invoice::all();
            return view('homepage-feed', ['guestMessage' => $hardCodedMessage, 'users' => $users, 'patients' => $patients, 'invoices' => $invoices]);
    
            // return redirect('/')->with('success', 'Clinic ' . $displayClinicName . ' in building:' . $displayPatientMRN . ' has been added as an eligible provider in the Online Digital E-M program.');
    // Success message worked, hardCodedMessage did not ($guestMessage):
    //         // return back()->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.', ['guestMessage' => $hardCodedMessage]);
    //         return back()->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.');
        
    //         //Success message failed, hardCodedMessage worked:        
            // return view('homepage-feed', ['guestMessage' => $hardCodedMessage])->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.');
    // //Type Error: "http://symfony/Component/HttpFoundation/RedirectResponse::__construct():%20Argument%20#2%20($status)%20must%20be%20of%20type%20int,%20array%20given,"        
    //         return redirect('/enroll', ['guestMessage' => $hardCodedMessage])->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.');
        }



// *********************************** PROVIDERS ****************************************************************************************** //




public function showAddProviderForm(){
    //Logged in user can register another user:
    if (auth()->check()) {
        $hardCodedMessage = 'NOTE: You must select a clinic for this new provider';
        $clinics = Clinic::all();
        return view('provider-add-new', ['guestMessage' => $hardCodedMessage, 'clinics' => $clinics]);

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



public function registerNewProvider(Request $request){

    // Fetch the clinics from your data source
    $clinics = Clinic::all();

    // Create an array of valid clinic IDs
    $validClinicIds = $clinics->pluck('id')->toArray();


    $incomingFields = $request->validate([
        // 'username' => 'required', //updated to array in https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#content
        //&&& #DCT NEW FIELDS &&&
        'provider_name' => ['required'],
        'clinic_id' => ['required', Rule::in($validClinicIds)] // Add Rule::in rule for the 'provider' field
    ]);


    $provider = new Provider;

    $provider->clinic_id = $request->input('clinic_id'); 
    $provider->provider_name = $request->input('provider_name'); 
    $provider->provider_type = $request->input('provider_type'); 
    $provider->provider_email = $request->input('provider_email');
    $provider->provider_fax = $request->input('provider_fax'); 

    $provider->save();   



    $displayProviderName = $request->input('provider_name');

    $clinicID = $request->input('clinic_id');
    $getClinicName = Clinic::find($clinicID);
    if($getClinicName){
        $displayClinicName = $getClinicName->clinic_name;
    }else{
        $displayClinicName = '';
    }

    $hardCodedMessage = 'Provider ' . $displayProviderName . ' has been added as an eligible provider in your Online Digital E-M program as part of the clinic for ' . $displayClinicName . '.';

    $users = User::all();
    // $patients = Patient::all();
    $patients = Patient::where('status',0)->get(); //get all active patients           
    $invoices = Invoice::all();
    return view('homepage-feed', ['guestMessage' => $hardCodedMessage, 'users' => $users, 'patients' => $patients, 'invoices' => $invoices]);

    // return redirect('/')->with('success', 'Clinic ' . $displayClinicName . ' in building:' . $displayPatientMRN . ' has been added as an eligible provider in the Online Digital E-M program.');
// Success message worked, hardCodedMessage did not ($guestMessage):
//         // return back()->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.', ['guestMessage' => $hardCodedMessage]);
//         return back()->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.');

//         //Success message failed, hardCodedMessage worked:        
    // return view('homepage-feed', ['guestMessage' => $hardCodedMessage])->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.');
// //Type Error: "http://symfony/Component/HttpFoundation/RedirectResponse::__construct():%20Argument%20#2%20($status)%20must%20be%20of%20type%20int,%20array%20given,"        
//         return redirect('/enroll', ['guestMessage' => $hardCodedMessage])->with('success', 'Patient ' . $displayPatientName . ' (' . $displayPatientMRN . ') has been enrolled in the Online Digital E-M program.');
}



// *********************************** NAMES ****************************************************************************************** //



    public function showAddNameForm(){
        //Logged in user can register another user:
        if (auth()->check()) {
            $hardCodedMessage = 'NOTE: Enter a known version of the provider\'s name.';
            $providers = Provider::all();
            return view('provider-name-add-new', ['guestMessage' => $hardCodedMessage, 'providers' => $providers]);

        } else {
    // redirect back to GUEST homepage: (let guest create the first user)
            // $hardCodedMessage = 'Go ahead and register as a guest.';
            // return view('homepage-enroll', ['guestMessage' => $hardCodedMessage]);
            // return view('homepage-enroll')->with('failure', 'Go ahead and register as guest...');
            // $hardCodedMessage = 'You do not have permission to add a provider name.';
            // return view('/homepage-feed', ['guestMessage' => $hardCodedMessage]); //return view('/') => View [.] not found.
            return redirect('/')->with('failure', 'You do not have the permissions to add a new provider.');
        }  
    }



    public function registerNewName(Request $request){


            // Fetch the clinics from your data source
            $providers = Provider::all();

            // Create an array of valid clinic IDs
            $validProviderIds = $providers->pluck('id')->toArray();


            $incomingFields = $request->validate([
                // 'username' => 'required', //updated to array in https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#content
                //&&& #DCT NEW FIELDS &&&
                'provider_id' => ['required', Rule::in($validProviderIds)], // Add Rule::in rule for the 'provider' field
                'provider_name' => ['required']
            ]);


            $getProvider = Provider::find($request->input('provider_id'));
            $getProviderClinic = Clinic::find($getProvider->clinic_id);

//ADD CHECK FOR STRING provider_name MATCH/DUPLICATE
            $name = new Name;

            $name->provider_id = $request->input('provider_id'); 
            $name->provider_name = $request->input('provider_name'); 
            $name->clinic_id = $getProviderClinic->id; 

            $name->save();   


            //flash message variables:
            $displayProviderName = $getProvider->provider_name;
            $displaySpelling = $request->input('provider_name');



            $hardCodedMessage = 'Success! ' . $displaySpelling . ' has been added for Provider ' . $displayProviderName . ' in the clinic of ' . $getProviderClinic->clinic_name . '.';

            $users = User::all();
            // $patients = Patient::all();
            $patients = Patient::where('status',0)->get(); //get all active patients           
            $invoices = Invoice::all();
            return view('homepage-feed', ['guestMessage' => $hardCodedMessage, 'users' => $users, 'patients' => $patients, 'invoices' => $invoices]);

    }




} //end of clinic class

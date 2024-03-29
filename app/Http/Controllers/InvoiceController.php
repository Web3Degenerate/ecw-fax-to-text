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

class InvoiceController extends Controller
{
    

    public function updatePatientList(){

        $findPatients = Patient::all(); 

        return back();
    }

    private function calculateBillingCode($cumulativeClinicTime){
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



// Pacific Update *********************************************************

    public function showSingleInvoice($id){
        $locatedInvoice = Invoice::find($id);
        $patientId = $locatedInvoice->patient_id;
        $patient = Patient::find($patientId);
        $locatedInvoiceNotes = Note::where('billing_number',$locatedInvoice->id)->get();

        $invoices = $patient->invoices()->get();

        return view('invoice-single', ['locatedInvoice' => $locatedInvoice, 'notes' => $locatedInvoiceNotes, 
        'patient' => $patient, 'invoices' => $invoices]);

    }

}

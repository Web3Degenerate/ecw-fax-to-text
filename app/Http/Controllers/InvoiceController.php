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

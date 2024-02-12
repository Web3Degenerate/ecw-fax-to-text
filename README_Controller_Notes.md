## Laravel Controller Notes

1. Return collection, sorted by certain column in ASC/DESC order.
    - Example: _See NoteController@showFaxInbox_ where we are returning the "fax" notes, sorted by `date_time_fax_received`.
        - `$notes = Note::orderBy('date_time_fax_received', 'desc')->get();`

**ORDER BY ONLY**

```php
// NoteController@showFaxInbox
$notes = Note::orderBy('date_time_fax_received', 'desc')->get();
```

**GET BY X field, THEN ORDER BY**

```php
// PatientController@viewPatient
$getAllPtNotes = Note::where('patient_id', $id)
    ->orderBy('date_time', 'desc')
    ->get();

```

---

### whereIn()

2. Query Database (1) **where** $id and (2) a second field multiple values with an **array** with **whereIn**

```php
// PatientController@viewPatient
// Get all notes for a particular patient where the 'billing_status_string' is either set to 'pending' or 'check'
$getPendingPtNotes = Note::where('patient_id', $id)
    ->whereIn('billing_status_string', ['pending', 'check'])
    ->get();


```

---

3. Using Array to find Notes with desired patient_id and 7 day window:

```php

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

```

---

4. Just staging GPT question

```php

    //other code aobve here in function which stores the Note object from a Post request submission
    $patient_id = $request->input('patient_id_input');


    $note = new Note;
    $patient_em_date_input = $request->input('em_date_iso');



    if($patient_em_date_input !== '0911-09-11' && $patient_em_date_input !== null){
        $patient_em_date = $patient_em_date_input;
    }else{
        $patient_em_date = $findPatient->em_date; //get last em_date on file or return null.
    }


    if ($patient_em_date) {
        // Convert the patient_em_date string to a Carbon instance
        $seven_days_after_patient_em_date = Carbon::parse($patient_em_date)->addDays(6);

        // Get current note date
            $get_note_date_timerz = $request->input('note_date_time_iso');
            $format_note_date_timerz = Carbon::parse($get_note_date_timerz);
            $compare_note_date_onlyz = $format_note_date_timerz->format('Y-m-d');

        // Compare the Carbon instances
        if ($compare_note_date_onlyz > $seven_days_after_patient_em_date->format('Y-m-d')) {
            $note->billing_status_string = 'pending';

                    // Here is my attempt to update the 'billing_index' date field with the Note date ('$compare_note_date_onlyz') if null
                    $patient = Patient::find($patient_id);
                    // If there is not currently a date entered in the 'billing_index' date field on the Patients Table
                    if(!$patient->billing_index){
                        $patient->billing_index = $compare_note_date_onlyz;
                        $patient->save();
                    }

        } else {
            $note->billing_status_string = 'invalid';
        }
    } else {
        $note->billing_status_string = 'check';
    }

    $note->save();

```

**GPT Response**

```php

// ... (your existing code)

// Here, after saving the Note
$note->save();

// Update the billing_index on the Patients table if it's null
$patient = Patient::find($patient_id);

if (!$patient->billing_index) {
    $patient->billing_index = $compare_note_date_onlyz;
    $patient->save();
}
```

**GPT Response to check existing $patient->billing_index to current note date in $compare_note_date_onlyz**

```php

// ... (your existing code)

// Update the billing_index on the Patients table if it's null
$patient = Patient::find($patient_id);

if ($patient) {
    // If there is not currently a date entered in the 'billing_index' date field on the Patients Table
    if (!$patient->billing_index) {
        $patient->billing_index = $compare_note_date_onlyz;
        $patient->save();
    } else {
        // Compare the current Note date with the billing_index
        $seven_days_after_billing_index = Carbon::parse($patient->billing_index)->addDays(6);

        if ($compare_note_date_onlyz > $seven_days_after_billing_index->format('Y-m-d')) {
            // If the Note date is more than 7 days in the future from billing_index, update billing_index
            $patient->billing_index = $compare_note_date_onlyz;
            $patient->save();
        }
        // If the Note date is within 7 days or in the past, do nothing
    }
}


```

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

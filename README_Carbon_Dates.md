1. Get current date in EST:

```php
    date_default_timezone_set('America/New_York');
    $currentEstDate = Carbon::now()->format('Ymd');

```

2. Set date forward or backwards a certain number of days. For example, check 7 days from current EST Date:

```php
// *** CHECK IF CURRENT EST DATE IS WITHIN 7 DAYS OF NOTE DATE:
        // date_default_timezone_set('America/New_York');
        $currentEstDate = Carbon::now('America/New_York')->format('Ymd');

        $seven_days_ago_check = $currentEstDate->subDays(7);

// You're on the right track, but there's a small mistake in your code. subDays(7) returns a new Carbon instance representing the date 7 days ago, so you don't need to perform the date comparison using >=.
// Instead, you should use isAfter to check if the note's date is after the calculated date.
        if ($currentEstDate->isAfter($seven_days_ago_check)) {
            $note->billing_status = 0; // actively within current 7 day period
        }else{
            $note->billing_status = 1; // inactive - more than 7 days from current period.
        }

```

---

3. Use Carbon Parse to ensure date / time formats will be saved as desired:

```php

    $dateTimeOfNote = $request->input('note_date_time_iso');
// Modified dateTime and time fields: Example: 01/31/2024 08:19 PM
        $carbonDateTime = Carbon::parse($dateTimeOfNote);

        $note->date_time = $carbonDateTime; // stores "01/31/2024 08:19 PM"

        $note->time_out = $carbonDateTime->format('h:i:s A'); // stores "08:19 PM"

```

---

4. See [NotesController@createNoteFromManualFaxForm](https://github.com/Web3Degenerate/ecw-fax-to-text/blob/master/app/Http/Controllers/NoteController.php) for a good example of working with dates.

```php

// dateTime as ISO (Try this first for the pure dateTime on 1/31/2024)
    // $note->date_time_iso = $request->input('note_date_time_iso');

    $dateTimeOfNote = $request->input('note_date_time_iso');
    $clinicTime = $request->input('clinic_time');

        //Store the time spent in minutes:
        $note->clinic_time = $clinicTime;   // example 2

// Modified dateTime and time fields: Example: 01/31/2024 08:19 PM
        $carbonDateTime = Carbon::parse($dateTimeOfNote);

        $note->date_time = $carbonDateTime; // stores "01/31/2024 08:19 PM"

        $note->time_out = $carbonDateTime->format('h:i:s A'); // stores "08:19 PM"

        // Format date_only
        $current_note_date_on_timestamp = $carbonDateTime->toDateString();
        $note->date_only = $current_note_date_on_timestamp;

        // Add 7 days to the date_only field
        $billingExpirationDate = $carbonDateOnly->addDays(7);

        // Save the billing_expiration_date field
        $note->billing_expiration_date = $billingExpirationDate; // 7 days from current note_date


        date_default_timezone_set('America/New_York');
        $currentEstDate = Carbon::now()->format('Ymd');

        $seven_days_ago_check = $currentEstDate->subDays(7);

// You're on the right track, but there's a small mistake in your code. subDays(7) returns a new Carbon instance representing the date 7 days ago, so you don't need to perform the date comparison using >=.
// Instead, you should use isAfter to check if the note's date is after the calculated date.
        if ($currentEstDate->isAfter($seven_days_ago_check)) {
            $note->billing_status = 0; // actively within current 7 day period
        }else{
            $note->billing_status = 1; // inactive - more than 7 days from current period.
        }


//ChatGPT code review, merge subMinutes and format into one line
        // $modifiedDateTime = $carbonDateTime->subMinutes($clinicTime); // creates 01/31/2024 08:17 PM
            // Format our modifiedDateTime into 'h:i:s A' format
        // $note->time_in = $modifiedDateTime->format('h:i:s A'); // saves as "08:17 PM"
        $note->time_in = $carbonDateTime->subMinutes($clinicTime)->format('h:i:s A'); // saves as "08:17 PM"

        $note->note_body = $request->input('note_body');
        $note->fax_image_link = $request->input('fax_image_link');
        $note->fax_details_id = $request->input('fax_details_id');
```

5. On front end, display the current date in php:

```php
                  <?php
                    //(1/24/2024) - Dynamically set sEndDate to current day (in EST) and set sStartDate will be 2 days back.
                      date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time

                    // Get the current date in 'YYYYMMDD' format
                        $getCurrentEstDate = (new DateTime())->format('D M jS, Y');
                        $displayCurrentEstDate = $getCurrentEstDate;
                  ?>
```

---

6. In Laravel View, we can format dates by using Carbon in the Laravel directive.
    - dateTime example: `{{ \Carbon\Carbon::parse($note->date_time)->format('m/d/Y g:i A') }}` like `01/21/2024 4:38 PM`
    - date example: `Last EM Visit:  {{ \Carbon\Carbon::parse($patient->em_date ?? 'Not set')->format('l, F jS, Y') }}` like `Sunday, January 21st, 2024`

```php
// Format date YYYY-MM-DD in the format Weekday, Month, Day(th/st) and Year.
<strong> On {{ \Carbon\Carbon::parse($note->date_time)->format('m/d/Y g:i A') }} ({{ $note->note_provider }})</strong> spent a total of {{ $note->clinic_time }} total minutes.

// Format dateTime as MM/DD/YYYY H:MM AM/PM:
    // I guess you can't optionally set the parse param like '$patient->em_date ?? 'Not Set''
    // Last EM Visit:  {{ \Carbon\Carbon::parse($patient->em_date ?? 'Not set')->format('l, F jS, Y') }}
    Last EM Visit:  {{ \Carbon\Carbon::parse($patient->em_date)->format('l, F jS, Y') }}

```

7. You can also use Carbon to subtract the the number of days between two dates:
    - `This note was entered {{ Carbon\Carbon::parse($note->date_time)->diffInDays($patient->em_date) }} days from the last EM vist. `

```php
This note was entered {{ Carbon\Carbon::parse($note->date_time)->diffInDays($patient->em_date) }} days from the last EM vist.

```

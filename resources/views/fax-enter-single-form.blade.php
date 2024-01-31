 <x-faxlayout>


    {{-- *************************************************** SLOT BEGINS HERE ************************************* --}}
        <div class="container py-md-5 container--narrow">
    
            <div class="text-center">
              {{-- <h2>Hello <strong>{{ ucwords(auth()->user()->username) }}</strong>, your feed is empty.</h2> --}}
              <h2><strong>Manually Entry Form:</strong> For Single Fax:</h2>
              {{-- <p class="lead text-muted">If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p> --}}
              <p class="lead text-muted">Review and submit the note with the relevant E-M details.</p>
            
            </div>
      
      
      
            
      {{-- <div class="row"> --}}
      
          <hr>
        <div class="profile-slot-content">
            <div class="list-group">
      
                      
                <div class="list-group-item list-group-item-action">
                    <h5>Extracted Text From Fax</h5>
                        {{-- <img class="avatar-tiny" src="https://0.gravatar.com/avatar/0d08988056acc135805ec1f5901f88ad19dd96c81966c088548f9335f11a56de?size=256" /> --}}
                        {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} or {{ $post->created_at->format('n/j/Y') }} --}}
                        {{-- <strong>{{ $pdfDataUrl }} </strong> --}}


                        <form action="/login" method="POST" class="mb-0 pt-2 pt-md-0" id="registration-form">
                            @csrf

    {{-- PATIENT NAME --}}
                            <div class="form-group">
                              <label for="patient_name" class="text-muted mb-1"><small>Patient</small></label>
                              {{-- autocomplete="off" --}}
                              <input value="{{old('patient_name')}}" name="patient_name" id="patient-name" class="form-control" type="text"  />
                            {{-- (11:50) Added error message: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
                              @error('patient_name')
                                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                              @enderror
                          </div>

    {{-- MRN --}}
                        <div class="form-group">
                            <label for="mrn" class="text-muted mb-1"><small>MRN</small></label>
                            <input value="{{old('mrn')}}" name="mrn" id="account-number" class="form-control" type="text" autocomplete="off" />
                            @error('mrn')
                              <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                            @enderror
                        </div>

    {{-- DOB string --}}
                        <div class="form-group">
                            <label for="dob" class="text-muted mb-1"><small>DOB</small></label>
                            <input value="{{old('dob')}}" name="dob" id="patient-dob" class="form-control" type="text" autocomplete="off" />
                            @error('dob')
                            <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                            @enderror
                        </div>

    {{-- Provider --}}
                        <div class="form-group">
                            <label for="provider" class="text-muted mb-1"><small>Patient Provider:</small></label>
                            <input value="{{old('provider')}}" name="provider" id="patient-provider" class="form-control" type="text" autocomplete="off" />
                            @error('provider')
                            <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                            @enderror
                        </div>

                        

    {{-- Clinic Time --}}
                        <div class="form-group">
                            <label for="clinic_time" class="text-muted mb-1"><small>Total Minutes Spent:</small></label>
                            <input value="{{old('clinic_time')}}" name="clinic_time" id="patient-clinic-time" class="form-control" type="number" autocomplete="off" />
                            @error('clinic_time')
                            <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                            @enderror
                        </div>


    {{-- Date Time String --}}
                        <div class="form-group">
                            <label for="note_date_time_string" class="text-muted mb-1"><small>Date Time String</small></label>
                            <input value="{{old('note_date_time_string')}}" name="note_date_time_string" id="patient-dateTime-stamp-string" class="form-control" type="text" autocomplete="off" />
                            @error('note_date_time_string')
                              <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                            @enderror
                        </div>

    {{-- Date Time Formatted as dateTime Object --}}
                        <div class="form-group">
                            <label for="note_date_time_formatted" class="text-muted mb-1"><small>Date Time Formatted</small></label>
                            {{-- <input value="{{old('note_date_time_formatted')}}" name="note_date_time_formatted" id="patient-dateTime-stamp-formatted" class="form-control" type="text" autocomplete="off" /> --}}
                            <input value="{{old('note_date_time_formatted')}}" name="note_date_time_formatted" id="patient-dateTime-stamp-formatted" class="form-control" type="text" autocomplete="off" />
                            @error('note_date_time_formatted')
                              <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                            @enderror
                        </div>

    {{-- Date Time Formatted as datetime-local (iso) WITHOUT time zone --}}
                        <div class="form-group">
                            <label for="note_date_time_iso" class="text-muted mb-1"><small>Date Time Iso Format:</small></label>
                            {{-- <input value="{{old('note_date_time_formatted')}}" name="note_date_time_formatted" id="patient-dateTime-stamp-formatted" class="form-control" type="text" autocomplete="off" /> --}}
                            <input value="{{old('note_date_time_iso')}}" name="note_date_time_iso" id="patient-dateTime-stamp-iso" class="form-control" type="datetime-local" autocomplete="off" />
                            @error('note_date_time_iso')
                            <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                            @enderror
                        </div>

                        
                            <button type="submit" class="py-3 mt-4 btn btn-lg btn-success btn-block">Create Note</button>
                  </form>





                        {{-- <p id="patient-name">Patient: <i>Loading...</i></p> --}}
                        {{-- <p id="patient-dob">DOB: <i>Loading...</i></p> --}}
                        {{-- <p id="account-number">MRN Number: <i>Loading...</i></p> --}}
                        
                        {{-- <p id="patient-provider">Provider: <i>Loading...</i></p> --}}
                        {{-- <p id="patient-dateTime-stamp">Note Date and Time: <i>Loading...</i></p> --}}
                        {{-- <p id="patient-clinic-time">Clinic Time Spent: <i>Loading...</i></p> --}}
    
                </div>
            </div>
    {{-- START OF details.php --}}
    
    
        <!--<div id="text-layer"></div>-->
    
    <!--<div id="notes-results"><i>Searching For Qualifying Provider Notes</i></div>-->
    
        <div id="notes-container">
            <!--<h5 id="notes-status"></h5>-->
            <ul id="notes-results"><i>Searching For Qualifying Provider Notes</i></ul>
        </div>
    
    <br>
    <br>
    <hr>
    <h2>All Text From the Fax:</h2>
        <div id="pdf-container" class="list-group-item list-group-item-action">
            <ul id="fax-results"></ul>
        </div>
    
    {{-- *********************************** START PDF.JS SCRIPT HERE ************************************  --}}
     
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
          <script>
            $('[data-toggle="tooltip"]').tooltip()
          </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>
        {{-- <script src="{{ asset('js/pdfjs/pdf.js') }}"></script> --}}
         <script>
        
                const pdfDataUrl = <?php echo json_encode($dataUrlPdfData); ?>;
                // const pdfDataUrl = document.getElementById('pdf-url').innerHTML;
                // const textLayerDiv = document.getElementById('text-layer');
                
                const patientFullName = document.getElementById('patient-name');
                // patientFullName.innerHTML = `Patient: ${patientName}`;
                
                const patientDob = document.getElementById('patient-dob');
                // patientDob.innerHTML = `DOB: ${dob}`;
                                    
                    
                const patientMrn = document.getElementById('account-number');
                // patientMrn.innerHTML = `MRN Number: ${accountNumber}`;
                
                const patientProvider = document.getElementById('patient-provider');
                // const phpPatientProvider = <?php //echo strval($get_date_time_string); ?>;
                // const phpPatientProvider = "Bates, Vernice";
                // patientProvider.innerHTML = `Provider: ${phpPatientProvider}`;
                
                
                // const patientDateTimeStamp = document.getElementById('patient-dateTime-stamp');
                const patientDateTimeStamp = document.getElementById('patient-dateTime-stamp-string');
                const patientDateTimeStampFormatted = document.getElementById('patient-dateTime-stamp-formatted');
                const patientDateTimeStampIso = document.getElementById('patient-dateTime-stamp-iso');
                
                const patientClinicTime = document.getElementById('patient-clinic-time');
                
                
                
                
                // const patientMatchesDiv = document.getElementById('patient-matches');
                const patientMatchesDiv = document.getElementById('notes-container');
                
                // const notesStatusHeader = document.getElementById('notes-status');
                const notesStatusHeader = document.getElementById('notes-results');
        
                pdfjsLib.getDocument({ data: atob(pdfDataUrl.split(',')[1]) })
                    .promise.then(pdf => {
                        for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                            pdf.getPage(pageNumber).then(page => {
                                page.getTextContent().then(textContent => {
                                    var text = '';
                                    textContent.items.forEach(item => {
                                        text += item.str + ' ';
                                    });
                                    console.log(' Page ', + pageNumber + ': ' + text);
                                    
                                    //Display Full Text By Page: 
                                    //https://teamtreehouse.com/community/ulcreateelement-is-not-a-function-error
                                    const ul = document.getElementById('fax-results');
                                    const li = document.createElement('li');
                                    li.textContent = `Page , ${pageNumber}: ${text}`;
                                    ul.appendChild(li);//add item to the list
        
                            // Extract Account Number using JavaScript
                                    const match = text.match(/Account No:\s*(\d{5,6})/i);
                                    const accountNumber = match ? match[1] : 'Not Found';
                                    // patientMrn.innerHTML = `MRN Number: ${accountNumber}`;
                                    patientMrn.value = `${accountNumber}`;

          
                                
                                    // Display or use the extracted Account Number as needed
                                    console.log('Account Number:', accountNumber);
                                    
                        // Patient Name and DOB:   
                                // Extract Patient Name and DOB using JavaScript
                                    const patientNameMatch = text.match(/Patient Name:\s*([^,]*,[^,]*)/);
                                    // const patientProviderMatch = text.match(/Action Taken:(?:.*?\n)?\s*([^0-9]+?)\s*\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2}\s[APMapm]{2}>/);                           
                                    const patientName = patientNameMatch ? patientNameMatch[1] : 'Not Found';
                                    // patientFullName.innerHTML = `Patient: ${patientName}`;
                                    patientFullName.value = `${patientName}`;
                                    
                        // DOB            
                                    const dobMatch = text.match(/DOB:\s*(\d{2}\/\d{2}\/\d{4})/);
                                    const dob = dobMatch ? dobMatch[1] : 'Not Found';
                                    // patientDob.innerHTML = `DOB: ${dob}`;
                                    patientDob.value = `${dob}`;
                           
                        // Referring Provider: 
                                    const patientProviderPattern = /Action Taken[^]*?(\b[A-Z][a-z]+,\s[A-Z][a-z]+\b)[^]*?\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2}\s[APMapm]{2}>/;
        
                                    const patientProviderMatch = text.match(patientProviderPattern);
                                    const displayPatientProvider = patientProviderMatch ? patientProviderMatch[1].trim() : 'Error: Provider Not Found!';
                                    // patientProvider.innerHTML = `Provider: ${displayPatientProvider}`;
                                    patientProvider.value = `${displayPatientProvider}`;

                                    console.log("Patient Provider: ", displayPatientProvider);
                                
                          
                        // dateTime stamp (patientDateTimeStamp)
                                    // const dateTimeStampPattern = /Action Taken [^]*?(\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2} [APMapm]{2})\s?>/;
                        // Modified dateTime (no space)
                                    const dateTimeStampPattern = /Action Taken [^]*?(\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2} [APMapm]{2})\s?>/;
                        
                                    const dateTimeStampMatch = text.match(dateTimeStampPattern);

                                    const displayPatientDateTimeStamp = dateTimeStampMatch ? dateTimeStampMatch[1] : 'Error: DateTime Stamp Not Found';
                                    // patientDateTimeStamp.innerHTML = `Note Created At: ${displayPatientDateTimeStamp}`;
                                    patientDateTimeStamp.value = `${displayPatientDateTimeStamp}`;
                                    
                                        console.log('Patient DateTime Stamp:', displayPatientDateTimeStamp);                         
                                
                                 
                                    
// *********************** 1/31/24

                        const dateTimeStampPatternInput = /Action Taken [^]*?(\d{2}\/\d{2}\/\d{4})(?:\s?(\d{2}:\d{2}:\d{2} [APMapm]{2}))?\s?>/;
                        const dateTimeStampMatchInput = text.match(dateTimeStampPatternInput);

                        if (dateTimeStampMatchInput) {
                        const datePart = dateTimeStampMatchInput[1];
                        const timePart = dateTimeStampMatchInput[2] || '00:00:00 AM'; // Default time if not provided
                        const dateTimeStringInput = `${datePart} ${timePart}`;
                        
                        const dateTimeObjectInput = new Date(dateTimeStringInput);
                        // const dateTimeObjectInput = new Date(dateTimeString + ' GMT-0500'); // Eastern Standard Time offset

                        // Check if the conversion was successful
                        if (!isNaN(dateTimeObjectInput.getTime())) {
                            // Now `dateTimeObjectInput` contains the Date object

                            patientDateTimeStampFormatted.value = `${dateTimeObjectInput}`;
                            console.log('Date Object (System Time):', dateTimeObjectInput);

// Pacific Standard Time offset: UTC-8
// Eastern Standard Time offset: UTC-5
// const estOffset = 3 * 60 * 60 * 1000; // 3 hours difference
// const dateTimeObjectEST = new Date(dateTimeObjectInput.getTime() + estOffset);
// console.log('Date Object (EST Time):', dateTimeObjectEST.toString());
// patientDateTimeStampFormatted.value = `${dateTimeObjectEST}`;

// ISO STRING ATTEMPT:
                //ISO STRING OFFSET - HARD CODED (8 hours PST)
                            // Convert to ISO format (without time zone) for dateTime-local type:
                            // Subtract 8 hours
                            // dateTimeObjectInput.setHours(dateTimeObjectInput.getHours() - 8);
                            // const isoString = dateTimeObjectInput.toISOString().slice(0, 16);

                //ISO STRING OFFSET - DYNAMICALLY GENERATED FROM MACHINE TIME ZONE
                            // Dynamically subtract the correct hours: Get the timezone offset in minutes
                            const timezoneOffsetInMinutes = dateTimeObjectInput.getTimezoneOffset();
                            console.log('timezoneOffsetInMinutes is ', timezoneOffsetInMinutes)

                            // Subtract the timezone offset in minutes
                            const adjustedDateTime = new Date(dateTimeObjectInput.getTime() - timezoneOffsetInMinutes * 60 * 1000);
                            const isoString = adjustedDateTime.toISOString().slice(0, 16);

                            console.log('Formatted for datetime-local input (dynamically):', isoString);

                            
                            patientDateTimeStampIso.value = `${isoString}`;

                        } else {
                            console.error('Invalid DateTime String:', dateTimeStringInput);
                            patientDateTimeStampFormatted.value = `Invalid DateTime String: ${dateTimeStringInput}`;
                        }
                        } else {
                        console.error('DateTime Stamp Not Found');
                        patientDateTimeStampFormatted.value = `Error: DateTime Stamp Not Found.`;
                        }





// **************************** 1/31/24 end         


        // Clinic time (patientClinicTime)
                                //second response which was working:
                                    // const clinicTimePattern = />(\d+)\s*minutes\s*Date: \d{2}\/\d{2}\/\d{4}/;
                                // Combined first and second response using regex pattern to extract the clinic time
                                    // const clinicTimePattern = /Action Taken [^]*?>(\d+)\s*minutes\s*Date: \d{2}\/\d{2}\/\d{4}/;
                                // Updated regex pattern to extract the clinic time
                                    // const clinicTimePattern = /Action Taken [^]*?>(\d+)\s*minutes(?:[^]*?Date: \d{2}\/\d{2}\/\d{4}|[^]*?$)/;                            
                            // Clinic Time without minutes: These two failed:
                                    // const clinicTimePattern = /Action Taken [^]*?(\d+)\s*(?:minutes)?\s*(\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2} [APMapm]{2})\s?>/;
                                    // const clinicTimePattern = /Action Taken [^]*?>\s*(\d+)\s*(?:minutes)?\s*(\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2} [APMapm]{2})[^]*?Date: \d{2}\/\d{2}\/\d{4}/;
                                    
                            // Clinic Time without minutes and skip Action Taken: 
                                    // const clinicTimePattern = /(?:\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2} [APMapm]{2}>)(\d+)\s*(?:minutes)?[^]*?Date: \d{2}\/\d{2}\/\d{4}/;
                            // Clinic Time without minutes, skip Action taken dateTime stamp no space:
                                    // const clinicTimePattern = /(?:\d{2}\/\d{2}\/\d{4}(?:\s?\d{2}:\d{2}:\d{2} [APMapm]{2})?)>(\d+)\s*(?:minutes)?[^]*?Date: \d{2}\/\d{2}\/\d{4}/;
                            // Clinic Time without minutes, skip Action taken, skip dateTime stamp START AM> or PM>
                                    // const clinicTimePattern = /(?:AM|am|PM|pm)>(\d+)\s*(?:minutes)?[^]*?Date: \d{2}\/\d{2}\/\d{4}/;        
                            // Clinic Time (updated 1/30/24 - 4pm) to start at AM/PM> and allow text/space before and after numer: 
                                    const clinicTimePattern = /(?:AM|am|PM|pm)>[^]*?(\d+)\s*(?:minutes)?[^]*?Date: \d{2}\/\d{2}\/\d{4}/;
    
                                    const clinicTimeMatch = text.match(clinicTimePattern);
                                    const displayPatientClinicTime = clinicTimeMatch ? parseInt(clinicTimeMatch[1], 10) : 'Error: Clinic Time Not Found';

                                    // patientClinicTime.innerHTML = `Total Minutes Spent: ${displayPatientClinicTime}`;
                                    patientClinicTime.value = `${displayPatientClinicTime}`;
                                    
                                    console.log('Patient Clinic Time:', displayPatientClinicTime);
                                    
        
                                // Display or use the extracted information as needed
                                    console.log('Patient Name:', patientName);
                                    console.log('DOB:', dob);
        
                                    
                                    // Extract all occurrences of the specified pattern
                                    // const pattern = /([A-Za-z,]+)\s(\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>)/g; //stops at first name
                                    // const pattern = /(\S+,\s*[A-Za-z\s,]+)\s(\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>)/g; //Grabs last name, ignores falty time stamp
                    
                    //"Working" for time stamps:                
                                    // const pattern = /(?:\S+,\s*[A-Za-z\s,]+)?\s?(\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>)/g; //Attempts to grab last name and falty time stamps.
                    
                    
            //Attempting to get timestamps and minutes in one swoop: 
                                    // const pattern = /(?:\S+,\s*[A-Za-z\s,]+)?\s?(\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>)(.*?)(?=(?:\S+,\s*[A-Za-z\s,]+)?\s?\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>|$)/gs;
                    //Go back to this one above, but don't match until after first occurrence of 'Action Taken:'
                                    // const pattern = /(?:(?!Action Taken).*?\n)?(?:\S+,\s*[A-Za-z\s,]+)?\s?(\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>)(.*?)(?=(?:\S+,\s*[A-Za-z\s,]+)?\s?\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>|$)/gs;
                    //Remove requirement 'Action Taken:' (with colon). Also accept date-time with no space:
                                    const pattern = /(?:(?!Action Taken:).*?\n)?(?:\S+,\s*[A-Za-z\s,]+)?\s?(\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2}\s[APMapm]{2}>)(.*?)(?=(?:\S+,\s*[A-Za-z\s,]+)?\s?\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2}\s[APMapm]{2}>|$)/gs;
                    
                    // Go back to this base but cut on 2nd double score; 
                                    // const pattern = /(?:\S+,\s*[A-Za-z\s,]+)?\s?(\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>)(.*?)(?=(?:\S+,\s*[A-Za-z\s,]+)?\s?\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>|$)(?=(?:(?:(?!\s{0,3}>|$|__).)*__){2})/gs;
        
                     
                    //Attempting to remove unwanted words (negative regex)
                                    //const pattern = /(?:\S+,\s*[A-Za-z\s,]+)?\s?(\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>)(.*?)(?=(?:\S+,\s*[A-Za-z\s,]+)?\s?\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>|$)(?!(Date: \d{2}\/\d{2}\/\d{4}|Time: \d{2}:\d{2} [APMapm]{2}|From: [A-Za-z\s,]+|Created: \d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}|Sent: \d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}|Message:.*?Addressed To:|Action Taken:))/gs;
                       
                    //3 space yolo try
                                    // const pattern = /(?:\S+,\s*[A-Za-z\s,]+)?\s?(\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>)(.*?)(?=(?:\S+,\s*[A-Za-z\s,]+)?\s?\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\s[APMapm]{2}>|$)(?!(Date: \d{2}\/\d{2}\/\d{4}|Time: \d{2}:\d{2} [APMapm]{2}|From: [A-Za-z\s,]+|Created: \d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}|Sent: \d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}|Message:.*?Addressed To:|Action Taken:))(.*?)(?=\s{0,3}>|$)/gs;
                                    
                                    const matches = [...text.matchAll(pattern)];
                                    
                                    // Display or use the extracted matches as needed
                                    console.log('Matches:', matches);
                
                                    // Display the extracted matches on the page
                                    const NotesUl = document.createElement('ul');
                                    // const NotesUl = document.getElementById('notes-results');
                                    matches.forEach(match => {
                                        const li = document.createElement('li');
                                        li.textContent = match[0];
                                        NotesUl.appendChild(li);
                                    });
                                    patientMatchesDiv.appendChild(NotesUl);    
                                    notesStatusHeader.innerHTML = "<h3>Extracted Provider Note Results</h3>";
            
            
                                });
                            });
                        }
                    });
            </script>
    
    {{-- *********************************** DISPLAY PDF IMAGE BELOW ************************************* --}}
        <br>
        <br>
        <hr>
        <h2>PDF Image of the Fax Received:</h2>
        
    
        <p>End of page</p>
    
    
    <?php
        if ($pdfData) {
          // Display the embedded PDF
            echo '<iframe title="PDF Viewer" width="100%" height="500px" src="data:application/pdf;base64,'.$pdfData.'" /></div></div><p>end of page</p></x-faxlayout>';
            // echo '</div></div></x-faxlayout>';
      } else {
            echo '<h3>Error fetching fax image. Please try again.</3>';
      }
    ?>
    
    
    
    
    {{-- CLOSING TWO LAYOUT DIVS  --}}
        </div>
    </div>
    {{-- CLOSING TWO LAYOUT DIVS  --}}
    
    {{-- *************************************************** SLOT ENDS HERE ************************************* --}}
    
    
    </x-faxlayout>
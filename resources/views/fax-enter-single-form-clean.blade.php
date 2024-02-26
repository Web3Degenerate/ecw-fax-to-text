<x-faxlayout>


{{-- *************************************************** SLOT BEGINS HERE ************************************* --}}
    <div class="container py-md-5 container--narrow">

        <div class="text-center">
          {{-- <h2>Hello <strong>{{ ucwords(auth()->user()->username) }}</strong>, your feed is empty.</h2> --}}
          <h2><strong>Manually Entry Form:</strong> For Single Fax:</h2>
          {{-- <p class="lead text-muted">If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p> --}}
          <p class="lead text-muted">Review and submit the note with the relevant E-M details.</p>
        
        </div>
  
  
  <?php 

        if($pdfData){
            $fax_image_link = 'data:application/pdf;base64,'. $pdfData .'';
        }else{
            $fax_image_link = 'n/a';
        }
  ?>
        
  {{-- <div class="row"> --}}
  
      <hr>
    <div class="profile-slot-content">
        <div class="list-group">
  
                  
            <div class="list-group-item list-group-item-action">
                <h5>Extracted Text From Fax</h5>
                    {{-- <img class="avatar-tiny" src="https://0.gravatar.com/avatar/0d08988056acc135805ec1f5901f88ad19dd96c81966c088548f9335f11a56de?size=256" /> --}}
                    {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} or {{ $post->created_at->format('n/j/Y') }} --}}
                    {{-- <strong>{{ $pdfDataUrl }} </strong> --}}


                    <form action="/create-note-from-single-fax-form" method="POST" class="mb-0 pt-2 pt-md-0" id="registration-form">
                        @csrf

{{-- Hidden Input Fields --}}

                    <input type="text" id="fax_image_link" name="fax_image_link" value="<?php echo $fax_image_link; ?>">
                    <input type='text' id='fax-details-id' name="fax_details_id" value="<?php echo $faxDetailsId;?>">

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

{{-- DOB string --}}
                    <div class="form-group">
                        <label for="dob_formatted" class="text-muted mb-1"><small>DOB Formatted</small></label>
                        <input value="{{old('dob_formatted')}}" name="dob_formatted" id="patient-dob-formatted" class="form-control" type="date" autocomplete="off" />
                        @error('dob_formatted')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                    </div>

                    

{{-- Provider --}}
                    <div class="form-group">
                        <label for="referring_provider" class="text-muted mb-1"><small>Patient Provider From Time Stamp:</small></label>
                        <input value="{{old('referring_provider')}}" name="referring_provider" id="patient-provider" class="form-control" type="text" autocomplete="off" />
                        @error('referring_provider')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                    </div>

                    
{{-- Provider From Template --}}
                    <div class="form-group">
                        <label for="referring_provider_from_template" class="text-muted mb-1"><small>Patient Provider From Template:</small></label>
                        <input value="{{old('referring_provider_from_template')}}" name="referring_provider_from_template" id="patient-provider-from-template" class="form-control" type="text" autocomplete="off" />
                        @error('referring_provider_from_template')
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

{{-- Date Time String --}}
                    <div class="form-group">
                        <label for="note_date_time_string_standardized" class="text-muted mb-1"><small>Date Time String (Standardized)</small></label>
                        <input value="{{old('note_date_time_string_standardized')}}" name="note_date_time_string_standardized" id="patient-dateTime-stamp-string-standardized" class="form-control" type="text" autocomplete="off" />
                        @error('note_date_time_string_standardized')
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


{{-- Date Time Formatted as datetime-local (iso) WITHOUT time zone --}}
            <div class="form-group">
                <label for="em_date_iso" class="text-muted mb-1"><small>Date of Last E-M Visit:</small></label>
                {{-- <input value="{{old('note_date_time_formatted')}}" name="note_date_time_formatted" id="patient-dateTime-stamp-formatted" class="form-control" type="text" autocomplete="off" /> --}}
                <input value="{{old('em_date_iso')}}" name="em_date_iso" id="patient-em-date-iso" class="form-control" type="date" autocomplete="off" />
                @error('em_date_iso')
                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                @enderror
            </div>

{{-- Date Format of New Template DOS date from template (2/25/2024) --}}
            <div class="form-group">
                <label for="dos_date_from_template" class="text-muted mb-1"><small>E-M DOS Date:</small></label>
                <input value="{{old('dos_date_from_template')}}" name="dos_date_from_template" id="dos_date_from_template" class="form-control" type="date" autocomplete="off" />
                @error('dos_date_from_template')
                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                @enderror
            </div>


                    <div class="form-group">
                        <label for="note_body" class="text-muted mb-1"><small>Note Text:</small></label>
                        <textarea id="note-body" name="note_body" rows="4" class="form-control">
                            
                        </textarea>
                        @error('note_body')
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
            
            const patientDobString = document.getElementById('patient-dob');
            // patientDobString.innerHTML = `DOB: ${dob}`;

            const patientDobFormatted = document.getElementById('patient-dob-formatted');
                                
                
            const patientMrn = document.getElementById('account-number');
            // patientMrn.innerHTML = `MRN Number: ${accountNumber}`;
            
            const patientProvider = document.getElementById('patient-provider');
            const patientProviderFromTemplate = document.getElementById('patient-provider-from-template');
            // const phpPatientProvider = <?php //echo strval($get_date_time_string); ?>;
            // const phpPatientProvider = "Bates, Vernice";
            // patientProvider.innerHTML = `Provider: ${phpPatientProvider}`;
            
            
            // const patientDateTimeStamp = document.getElementById('patient-dateTime-stamp');
            const patientDateTimeStamp = document.getElementById('patient-dateTime-stamp-string');
            const patientDateTimeStampStandardized = document.getElementById('patient-dateTime-stamp-string-standardized');
            const patientDateTimeStampFormatted = document.getElementById('patient-dateTime-stamp-formatted');

            const patientDateTimeStampIso = document.getElementById('patient-dateTime-stamp-iso');
            const patientEmDateIso = document.getElementById('patient-em-date-iso');

            const patientDosDateFromTemplate = document.getElementById('dos_date_from_template');

            
            const patientClinicTime = document.getElementById('patient-clinic-time');
            
            
            
            
            // const patientMatchesDiv = document.getElementById('patient-matches');
            const patientMatchesDiv = document.getElementById('notes-container');
            const noteBodyMatchesDiv = document.getElementById('note-body');
            
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
                                console.log('original dob es', dob)
                                // patientDobString.innerHTML = `DOB: ${dob}`;
                                patientDobString.value = `${dob}`;
                                console.log('final dob es', patientDobString.value)

                    // DOB formatted:
                                // Split the DOB string into an array [MM, DD, YYYY]
                                // const dobArray = dob != 'Not Found' ? dob.split('/') : '01/01/1011';
                                if(dobMatch){
                                    const dobArray = dob.split('/');

                                // Create a new Date object with the parts of the DOB
// Try feeding the date input with a string in the format of YYYY-MM-DD for the dob as date in the DB:
// const dobDateObject = new Date(`${dobArray[2]}-${dobArray[0]}-${dobArray[1]}`);
                                    const dobDateObject = `${dobArray[2]}-${dobArray[0]}-${dobArray[1]}`;
                                    patientDobFormatted.value = `${dobDateObject}`;
                                    console.log("patientDobFormatted is ", dobDateObject)
                                }else{
                                    patientDobFormatted.value = '0911-09-11';
                                }


// ********** Referring Provider From Time Stamp: ********************************************************************************************************************** //
                                const patientProviderPattern = /Action Taken[^]*?(\b[A-Z][a-z]+,\s[A-Z][a-z]+\b)[^]*?\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2}\s[APMapm]{2}>/;
    
                                const patientProviderMatch = text.match(patientProviderPattern);
                                const displayPatientProvider = patientProviderMatch ? patientProviderMatch[1].trim() : 'Error: Provider Not Found!';
                                // patientProvider.innerHTML = `Provider: ${displayPatientProvider}`;
                                patientProvider.value = `${displayPatientProvider}`;

                                console.log("Patient Provider: ", displayPatientProvider);


// ********** Referring Provider From TEMPLATE: ********************************************************************************************************************** //
// patientProviderFromTemplate
                                const patientProviderFromTemplatePattern = /Provider:\s*([^>]*?)\s*\d{1,2}\/\d{1,2}\/\d{2,4}/g;
                                                                        //   /Provider:\s*([^>]*?)\s*\d{1,2}\/\d{1,2}\/\d{2,4}/g;
                                // const patientProviderFromTemplateMatch = text.match(patientProviderFromTemplatePattern);
                                // const patientProviderFromTemplateMatch = [...text.match(patientProviderFromTemplatePattern)];

                                    let matchFromTemplate;
                                    let lastMatchFromTemplate;

                                    while ((matchFromTemplate = patientProviderFromTemplatePattern.exec(text)) !== null) {
                                        lastMatchFromTemplate = matchFromTemplate;
                                    }

                                    if (lastMatchFromTemplate) {
                                        const providerNameFromTemplate = lastMatchFromTemplate[1].trim();
                                        patientProviderFromTemplate.value = `${providerNameFromTemplate}`;
                                        console.log("Provider Name From Template: ", providerNameFromTemplate);
                                    } else {
                                        patientProviderFromTemplate.value = "Provider Name Not Found In Template";
                                        console.log("Provider Name From Template Not Found.");
                                    }






                                    // if (patientProviderFromTemplateMatch.length > 0) {
                                    //     const lastMatch = patientProviderFromTemplateMatch[patientProviderFromTemplateMatch.length - 1];
                                    //     const providerNameFromTemplate = lastMatch[1].trim();
                                    //     patientProviderFromTemplate.value = `${providerNameFromTemplate}`;
                                    //     console.log("Provider Name From Template: ", providerNameFromTemplate);
                                    // } else {
                                    //     patientProviderFromTemplate.value = "Provider Name Not Found In Template";
                                    //     console.log("Provider Name From Template Not Found.");
                                    // }


                                // const displayProviderFromTemplate = patientProviderFromTemplateMatch ? patientProviderFromTemplateMatch[1].trim() : 'Error: Provider From Template Not Found!';
                                // // patientProvider.innerHTML = `Provider: ${displayProviderFromTemplate}`;
                                // patientProviderFromTemplate.value = `${displayProviderFromTemplate}`;

                                // console.log("Patient Provider FROM TEMPLATE: ", displayProviderFromTemplate);


                            
// ********* DATE TIME STAMP AS STRING ************************************************************************************************************* //

    // **** DATE TIME STAMP AS RAW STRING (with or without space) **** //

                    // dateTime stamp (patientDateTimeStamp)
                                // const dateTimeStampPattern = /Action Taken [^]*?(\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2} [APMapm]{2})\s?>/;
                    // Modified dateTime (no space)
                                const dateTimeStampPattern = /Action Taken [^]*?(\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2} [APMapm]{2})\s?>/;
                    
                                const dateTimeStampMatch = text.match(dateTimeStampPattern);

                                const displayPatientDateTimeStamp = dateTimeStampMatch ? dateTimeStampMatch[1] : 'Error: DateTime Stamp Not Found';
                                // patientDateTimeStamp.innerHTML = `Note Created At: ${displayPatientDateTimeStamp}`;
                                patientDateTimeStamp.value = `${displayPatientDateTimeStamp}`;
                                
                                    console.log('Patient DateTime Stamp (core) "displayPatientDateTimeStamp" ==> ', displayPatientDateTimeStamp);                         
    // **** DATE TIME STAMP STANDARDIZED - (always with space) **** //
        //raw version: displayPatientDateTimeStamp

                //                 if(dateTimeStampMatch){
                //                     // Regular expression to match date and time parts
                //                     const dateTimeStampStandardizedPattern = /(\d{2}\/\d{2}\/\d{4})(?:\s?(\d{2}:\d{2}:\d{2} [APMapm]{2}))?/;

                //                     // Match the date and time parts
                //                     const dateTimeStampStandardizedMatch = displayPatientDateTimeStamp.match(dateTimeStampStandardizedPattern);

                // // ******* INNER STANDARDIZE STRING DATE TIME IF STATEMENT ************************ //
                //                     if (dateTimeStampStandardizedMatch) {
                //                         // If there is no space between date and time, add a space
                //                         if (!dateTimeStampStandardizedMatch[2] || dateTimeStampStandardizedMatch[2].length === 0) {
                //                             const formattedDateTimeStamp = `${dateTimeStampStandardizedMatch[1]} ${dateTimeStampStandardizedMatch[2] || ''}`.trim();
                //                             console.log('Formatted DateTime Stamp:', formattedDateTimeStamp);
                //                             patientDateTimeStampStandardized.value = `${formattedDateTimeStamp}`;
                //                         } else {
                //                             console.log('ALREADY CORRECT DateTime Stamp as is:', displayPatientDateTimeStamp);
                //                             patientDateTimeStampStandardized.value = `${displayPatientDateTimeStamp}`;
                //                         }
                //                         } else {
                //                         console.log('Invalid DateTime Stamp Format');
                //                         patientDateTimeStampStandardized.value = `Error: DateTime Stamp Not Found. Error-Code-407b`;
                //                         }
                                    
                //                 }




                // ******************** ChatGPT model: 
                function ensureSpaceInDateTimeFormat(dateTimeString) {
                    const pattern = /^(\d{2}\/\d{2}\/\d{4})(\s?\d{2}:\d{2}:\d{2} [APMapm]{2})$/;

                    const match = dateTimeString.match(pattern);

                    if (match) {
                        const [_, datePart, timePart] = match; // Extract matched groups

                        // If there is no space between date and time, add a space
                        const correctedDateTimeString = `${datePart}${timePart ? ' ' + timePart : ''}`;

                        return correctedDateTimeString;
                    }

                    return null; // Return null for an invalid format
                }

                const standarizedPatientDateTimeStamp = ensureSpaceInDateTimeFormat(displayPatientDateTimeStamp);
                patientDateTimeStampStandardized.value = `${standarizedPatientDateTimeStamp}`;

                                
// *********************** 1/31/24: dateTime stamp Modifications ************************************************************************************//

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

// ********* LAST WORKING clinicTimePattern on Thu Feb 1 2024, before adjusting possible ending on 'Provider.'                         
        // Clinic Time (updated 1/30/24 - 4pm) to start at AM/PM> and allow text/space before and after numer: 
                                // const clinicTimePattern = /(?:AM|am|PM|pm)>[^]*?(\d+)\s*(?:minutes)?[^]*?Date: \d{2}\/\d{2}\/\d{4}/;

// POSSIBLE CHANGE TO CLINIC TIME REGEX => Stop searching when it finds EITHER 'Date: MM/DD/YYYY' or 'Provider.'
                                const clinicTimePattern = /(?:AM|am|PM|pm)>[^]*?(\d+)\s*(?:minutes)?[^]*?(?:Date: \d{2}\/\d{2}\/\d{4}|Provider\.)/;
                                
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
                


                // *********** PATIENT LAST EM VISIT **************************88
                    // 1 - Copy clinic_time pattern. Look for date. 

                        // const emDatePattern = /(?:AM|am|PM|pm)>[^]*?(?:(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})|(?:\(as "MVI-DD-YYYY" \)\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})))[^]*?(?:Date: (\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4}))/;
                    //2. Hard stop when reaches 'Date:' or 'Provider'
                        // const emDatePattern = /(?:AM|am|PM|pm)>[^]*?(?:(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})|(?:\(as "MVI-DD-YYYY" \)\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})))(?:(?!Date:|Provider).)*?(?:Date: (\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4}))/;
                        // const emDatePattern = /(?:Last E-M-DOS: \(as "MVI-DD-YYYY" \) (\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?end of time entry\. Please do not write after this line\. > II /;
                        // const emDatePattern = /(?:Date Mnutes Acquired: \(as "MVVDD\/YYYY" \) (\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;
                        // const emDatePattern = /(?:Last E-M-DOS: (\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;

                        // const emDatePattern = /(?:Last E-M-DOS: \(as "?MVI-DD-YYYY"?\s*\)\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;
                        
                    //Last working version 2/25/24 - 9:50pm
                        // const emDatePattern = /(?:Last E-M-DOS: \(as "?MVI-DD-YYYY"?\s*\)=?>?\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;

                        // const emDatePattern = /(?:Date of Last Pati?ent E-M\s* :? \(as "?MVI-DD-YYYY"?\s*\)=?>?\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;
                        // const emDatePattern = /(?:Last E-M-Visit:? \(as "?MVI-DD-YYYY"?\s*\)=?>?\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;
                        const emDatePattern = /(?:Last E-M-Visit:? \(as "?MVI-DD-YYYY"?\s*\)=?>?\s*(\d{1,2}[-\/\\\.i]\d{1,2}[-\/\\\.i]\d{2,4})).*?>/;


                        console.log('#emDatePattern Raw: ',emDatePattern)

                        //2. Hard stop "specifically" to Date:
                        // const emDatePattern = /(?:AM|am|PM|pm)>[^]*?(?:(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})|(?:\(as "MVI-DD-YYYY" \)\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})))\s*[^]*?(?:Date:)/;

                        // const emDatePattern = /(?:AM|am|PM|pm)>[^]*?(?:(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})|(?:\(as "MVI-DD-YYYY" \)\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})))\s*[^]*?(?=\/Date:)/;
                        // const emDatePattern = /(?:AM|am|PM|pm)>[^]*?(?:(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})|(?:\(as "MVI-DD-YYYY" \)\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4}))).*\/Date:/;
                        // const emDatePattern = /(?:AM|am|PM|pm)>[^]*? (?:(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})))(?:Date:|Provider\.)/;
                        //                       /(?:AM|am|PM|pm)>[^]*? (\d+)\s*(?:minutes)?[^]*?(?:Date: \d{2}\/\d{2}\/\d{4}|Provider\.)/

                        // const emDatePattern = /(?:AM|am|PM|pm)>[^]*?(?:\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})(?:(?!Date:|Provider).)*/;
                        // const emDatePattern = /(?:AM|am|PM|pm)>[^]*?(?:\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})(?:(?!Date:|Provider)[^])*?(?:Date: (\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4}))/;


                        const emDateMatch = text.match(emDatePattern);
                        console.log("emDateMatch #match returned: ", emDateMatch)

                        // const displayEmDate = emDateMatch ? emDateMatch[1] || emDateMatch[2] || emDateMatch[3] : '';
//***** TRIM TEST FOR EM DATE **************************************************************************************//


//***** EM DATE Version 3.0 (Active 2/7/2024) **************************************************************************************//
                            


                    if (emDateMatch) {
                        // Trim at 'Date:' or 'Provider'
                        const trimmedMatchEm = emDateMatch[0].split(/Date:|Provider/)[0].trim();
                        console.log("Trimmed match: ", trimmedMatchEm);

                        // Regular expression to match 'MM/DD/YYYY' or 'MM-DD-YYYY'
                        // Adds in backslash and dot:
                        // const datePatternEm = /(\d{1,2}[-\/\\\.]\d{1,2}[-\/\\\.]\d{2,4})/;

                        // const datePatternEm = /(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})/;
                        const datePatternEm = /(\d{1,2}[-\/\\\.i]\d{1,2}[-\/\\\.i]\d{2,4})/;
                        

                        const matchDateEm = trimmedMatchEm.match(datePatternEm);

                            if (matchDateEm) {
                                // const displayEmDate = matchDateEm[1];
                                let displayEmDate = matchDateEm[1];
                                console.log("displayEmDate searching #trimmedMatchEm returned: ", displayEmDate);

                                displayEmDate = displayEmDate.replace(/[i.\\]/g, '/');

                                const dateObjectEm = new Date(displayEmDate); // Parse the date string
                                const formattedDateEm = dateObjectEm.toISOString().split('T')[0]; // Convert to ISO format and extract the date part

                                patientEmDateIso.value = formattedDateEm;
                            } else {
                                // console.error('Error: Date Not Found');
                                    fakeDate = '0911-09-11';
                                    const dateObjectEmFake = new Date(fakeDate); // Parse the date string
                                    const formattedDateEmFake = dateObjectEmFake.toISOString().split('T')[0]; // Convert to ISO format and extract the date part

                                    patientEmDateIso.value = formattedDateEmFake;
                                    // patientEmDateIso.vaue = '0911-09-11';
                                    console.error('Error: Patient Last EM Visit Not Found. formattedDateEmFake used instead: ', formattedDateEmFake);
                            } 
                } else {
                    console.error('Error: No #emDateMatch match found on outter if check: ', emDateMatch);
                }

// DOS Date From Template (2/25/2024) **********************************************************************

                // const emDatePattern = /(?:Last E-M-DOS: \(as "MVI-DD-YYYY" \)\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;
                // const dosDatePattern = /(?:Date Mnutes Completed: \(as "MVVDD\/YYYY" \)\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;
                // const dosDatePattern = /(?:Date Mnutes Completed: \(as "MVVDD\/YYYY" \)=>\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;
                // const dosDatePattern = /(?:Date Mnutes Completed: \(as "MVI-DD-YYYY"\s*\)=>\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;

            //last working version 2/25/24 - 9:50pm
                // const dosDatePattern = /(?:Date Mnutes Completed: \(as "?MVI-DD-YYYY"?\s*\)=?>?\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;
                // Date Mnutes Completed:
                const dosDatePattern = /(?:Date Mnutes Completed: \(as "?MVI-DD-YYYY"?\s*\)=?>?\s*(\d{1,2}[-\/\\\.i]\d{1,2}[-\/\\\.i]\d{2,4})).*?>/;


                // const dosDatePattern = /(?:Date Mnutes Completed: \(as "MVVDDNYYr \)=>\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;

                // const dosDatePattern = /(?:Date Mnutes Acquired: \(as "MVI-DD-YYYY" \)\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})).*?>/;

                console.log('#dosDatePattern is', dosDatePattern);

                const dosDateMatch = text.match(dosDatePattern);
                console.log("dosDateMatch #match returned: ", dosDateMatch);
                // console.log("dosDateMatch[0] returns, ",dosDateMatch[0]);

                

                // patientDosDateFromTemplate
                if (dosDateMatch) {
                        // Trim at 'Date:' or 'Provider'
                        // const trimmedMatchEm = emDateMatch[0].split(/Date:|Provider/)[0].trim();
                        // const trimmedMatchDosDate = dosDateMatch[0].split(/ /)[0].trim();
                        const trimmedMatchDosDate = dosDateMatch[0].split(/Date:|Provider/)[0].trim();

                        // const trimmedMatchDosDate = dosDateMatch[1];

                        console.log("Trimmed match: ", trimmedMatchDosDate);

                        // Regular expression to match 'MM/DD/YYYY' or 'MM-DD-YYYY'
                        // const datePatternEm = /(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})/;                           
                        // const datePatternDosDate = /(\d{1,2}[-\/i]\d{1,2}[-\/i]\d{2,4})/;
                        const datePatternDosDate = /(\d{1,2}[-\/\\\.i]\d{1,2}[-\/\\\.i]\d{2,4})/;

                        const matchDateDosDate = trimmedMatchDosDate.match(datePatternDosDate);

                            if (matchDateDosDate) {
                                // const displayDosDate = matchDateDosDate[1];
                                let displayDosDate = matchDateDosDate[1];

                                    // // Replace 'i' with '/'
                                    // displayDosDate = displayDosDate.replace(/i/g, '/');
                                    // Replace 'i', '.' or '\' with '/'
                                    displayDosDate = displayDosDate.replace(/[i.\\]/g, '/');
                                    
                                console.log("displayDosDate searching #trimmedMatchDosDate returned: ", displayDosDate);

                                const dateObjectDosDate = new Date(displayDosDate); // Parse the date string
                                const formattedDateDosDate = dateObjectDosDate.toISOString().split('T')[0]; // Convert to ISO format and extract the date part
                                console.log("formattedDateDosDate is: ", formattedDateDosDate)

                                patientDosDateFromTemplate.value = formattedDateDosDate;
                            } else {
                                // console.error('Error: Date Not Found');
                                    fakeDate = '0911-09-11';
                                    const dateObjectEmFake = new Date(fakeDate); // Parse the date string
                                    const formattedDateEmFake = dateObjectEmFake.toISOString().split('T')[0]; // Convert to ISO format and extract the date part

                                    patientEmDapatientDosDateFromTemplateteIso.value = formattedDateEmFake;
                                    // patientEmDateIso.vaue = '0911-09-11';
                                    console.error('Error: Patient Last EM Visit Not Found. formattedDateEmFake used instead: ', formattedDateEmFake);
                            } 
                } else {
                    console.error('Error: No #dosDateMatch match found on outter if check: ', dosDateMatch);
                }






// END OF DOS Date From Template (2/25/2024) **********************************************************************


// version 2 **********************************************************************
                        //         const displayEmDate = emDateMatch[1] || emDateMatch[2] || emDateMatch[3];

                        //             if (displayEmDate) {
                        //                 console.log("displayEmDate match returned: ", displayEmDate);
                        //                 const dateObjectEm = new Date(displayEmDate); // Parse the date string
                        //                 const formattedDateEm = dateObjectEm.toISOString().split('T')[0]; // Convert to ISO format and extract the date part

                        //                 patientEmDateIso.value = formattedDateEm;
                        //             } else {
                        //                 // console.error('Error: Date Not Found');
                        //                 fakeDate = '0911-09-11';
                        //                 const dateObjectEmFake = new Date(fakeDate); // Parse the date string
                        //                 const formattedDateEmFake = dateObjectEmFake.toISOString().split('T')[0]; // Convert to ISO format and extract the date part

                        //                 patientEmDateIso.value = formattedDateEmFake;
                        //                 // patientEmDateIso.vaue = '0911-09-11';
                        //                 console.error('Error: Date Not Found');
                        //             }
                        // } else {
                        //     console.error('Error: No #emDateMatch match found on outter if check: ', emDateMatch);
                        // }




//***** EM DATE Version 2.0: Gets trimmedMatch but doesn't use it **************************************************************************************//

                        // if (emDateMatch) {
                        //     // Trim at 'Date:' or 'Provider'
                        //     const trimmedMatch = emDateMatch[0].split(/Date:|Provider/)[0].trim();
                        //     console.log("Trimmed match: ", trimmedMatch);

                        //     const displayEmDate = emDateMatch[1] || emDateMatch[2] || emDateMatch[3];

                        //     if (displayEmDate) {
                        //         console.log("displayEmDate match returned: ", displayEmDate);
                        //         const dateObjectEm = new Date(displayEmDate); // Parse the date string
                        //         const formattedDateEm = dateObjectEm.toISOString().split('T')[0]; // Convert to ISO format and extract the date part

                        //         patientEmDateIso.value = formattedDateEm;
                        //     } else {
                        //         // console.error('Error: Date Not Found');
                        //         fakeDate = '0911-09-11';
                        //         const dateObjectEmFake = new Date(fakeDate); // Parse the date string
                        //         const formattedDateEmFake = dateObjectEmFake.toISOString().split('T')[0]; // Convert to ISO format and extract the date part

                        //         patientEmDateIso.value = formattedDateEmFake;
                        //         // patientEmDateIso.vaue = '0911-09-11';
                        //         console.error('Error: Date Not Found');
                        //     }
                        // } else {
                        //     console.error('Error: No #emDateMatch match found on outter if check: ', emDateMatch);
                        // }


//***** EM DATE Version 1.0 **************************************************************************************//

                        // if (displayEmDate) {
                        //     console.log("displayEmDate match returned: ", displayEmDate)
                        //     const dateObjectEm = new Date(displayEmDate); // Parse the date string
                        //     const formattedDateEm = dateObjectEm.toISOString().split('T')[0]; // Convert to ISO format and extract the date part

                        //     patientEmDateIso.value = formattedDateEm;
                        // } else {
                        //     fakeDate = '0911-09-11';
                        //     const dateObjectEmFake = new Date(fakeDate); // Parse the date string
                        //     const formattedDateEmFake = dateObjectEmFake.toISOString().split('T')[0]; // Convert to ISO format and extract the date part

                        //     patientEmDateIso.value = formattedDateEmFake;
                        //     // patientEmDateIso.vaue = '0911-09-11';
                        //     console.error('Error: Date Not Found');
                        // }
                        
                        // // patientEmDateIso.value = `${displayEmDate}`;
                        //   console.log('EM Date:', displayEmDate);

//***** END OF EM DATE MATCHING  **************************************************************************************//

                
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

                                // matches.forEach(match => {
                                //     noteBodyMatchesDiv.value(match);
                                // });

                                // Set the textarea value to the matched text
                                noteBodyMatchesDiv.value = matches.map(match => match[0]).join('\n');
                                
        
        
                            });
                        });
                    }
                });
        </script>

{{-- *********************************** DISPLAY PDF IMAGE BELOW ************************************* --}}
    <br>
    <br>
    <hr>
    <!-- <h2>PDF Image of the Fax Received:</h2> -->
    
<?php
  //   if ($pdfData) {
  //       $display_fax_image_link = 'data:application/pdf;base64,'. $pdfData .'';
  //     // Display the embedded PDF
  //       // echo '<iframe title="PDF Viewer" width="100%" height="500px" src="data:application/pdf;base64,'.$pdfData.'" /></div></div><p>end of page</p></x-faxlayout>';
  //       // echo '<iframe title="PDF Viewer" width="100%" height="500px" src="'.$display_fax_image_link.'" /></div></div><p>end of page</p></x-faxlayout>';
  //       echo '<iframe title="PDF Viewer" width="100%" height="1000px" src="'.$display_fax_image_link.'"></iframe>';

        
  //       // echo '</div></div></x-faxlayout>';
  // } else {
  //       echo '<h3>Error fetching fax image. Please try again.</3>';
  // }
?>


{{-- CLOSING TWO LAYOUT DIVS  --}}
    </div>
</div>
{{-- CLOSING TWO LAYOUT DIVS  --}}

{{-- *************************************************** SLOT ENDS HERE ************************************* --}}


<?php
        if ($pdfData) {
            $display_fax_image_link = 'data:application/pdf;base64,'. $pdfData .'';
          // Display the embedded PDF
            // echo '<iframe title="PDF Viewer" width="100%" height="500px" src="data:application/pdf;base64,'.$pdfData.'" /></div></div><p>end of page</p></x-faxlayout>';

            // echo '<iframe title="PDF Viewer" width="100%" height="500px" src="'.$display_fax_image_link.'" /></div></div><p>end of page</p></x-faxlayout>';
            echo '<h2 style="text-align:center">PDF Image of the Fax Received:</h2>';
            echo '<iframe title="PDF Viewer" width="1500px" height="1000px" src="'.$display_fax_image_link.'" /></div></div><p>end of page</p></x-faxlayout>';
            
            // echo '</div></div></x-faxlayout>';
      } else {
            echo '<h3>Error fetching fax image. Please try again.</3>';
      }
    ?>

</x-faxlayout>



// [
// 0: "PM>7 mins Date: 01/26/2024 Time: 11:27 PM Provider: Bates, Vernice   01/26/2024 Note generatedbyeClinicalWorks EVR/PMSoftware (vvweveClinicalWorks.corn)  To: TCD Medical PLLC, Subject: Progress Notes, Fax#: (716)303-7012,   SendDate:",
// 1: "01/26/2024",
// 2: null
// ]


//**** EXAMPLE OF NO EM-DATE FROM:  http://127.0.0.1:8000/manually-enter-single-fax-form/1245045912  *********************//

// [
//     0: "PM>7 mins Date: 01/26/2024 Time: 11:27 PM Provider: Bates, Vernice   01/26/2024 Note generatedbyeClinicalWorks EVR/PMSoftware (vvweveClinicalWorks.corn)  To: TCD Medical PLLC, Subject: Progress Notes, Fax#: (716)303-7012,   SendDate: 01/26/2024",
//     1: "01/26/2024",
//     2: null,
//     3: "01/26/2024"
// ]

// [
//     [0]: "Bates, Vernice Telephone Encounter Answered by   Bates, Vemice Action Taken   Bates, Vernice 01/26/202411:26:13 PM>7 mins Date: 01/26/2024 Time: 11:27 PM Provider: Bates, Vernice   01/26/2024 Note generatedbyeClinicalWorks EVR/PMSoftware (vvweveClinicalWorks.corn)  To: TCD Medical PLLC, Subject: Progress Notes, Fax#: (716)303-7012,   SendDate: 01/26/2024 11:27:26 AM,   page In [-ulg2.4.1.17in] ",
//     [1]: "01/26/202411:26:13 PM>",
//     [2]: "7 mins Date: 01/26/2024 Time: 11:27 PM Provider: Bates, Vernice   01/26/2024 Note generatedbyeClinicalWorks EVR/PMSoftware (vvweveClinicalWorks.corn)  To: TCD Medical PLLC, Subject: Progress Notes, Fax#: (716)303-7012,   SendDate: 01/26/2024 11:27:26 AM,   page In [-ulg2.4.1.17in] "
// ]


//**** EXAMPLE OF EM-DATE INCLUDED FROM: http://127.0.0.1:8000/manually-enter-single-fax-form/1250113784   *********************//

// [
//     "AM>Enter sour time and the date of last E-Mvist in the lines below: >Total Mnutes   16 >Last E-M-DOS: (as \"MVI-DD-YYYY\" )   1/21/2024 >end of time entry. Please do not write after this line. > II Date: 02/07/2024",
//     null,
//     "1/21/2024",
//     "02/07/2024"
// ]

// [
//     [0]: "Bates, Vernice Telephone Encounter Answered by   Bates, Vemice Action Taken   Bates, Vernice 02/07/2024 01:53:20 AM>Enter sour time and the date of last E-Mvist in the lines below: >Total Mnutes   16 >Last E-M-DOS: (as \"MVI-DD-YYYY\" )   1/21/2024 >end of time entry. Please do not write after this line. > II Date: 02/07/2024 Time: 01:45 AM Provider: Bates, Vernice   02/07/2024 Note generatedbyeClinicalWorks EVR/PMSoftware (vvweveClinicalWorks.corn) To: TCD Medical PLLC, Subject: Progress Notes, Fax#: (716)303-7012,   SendDate: 02/07/202401:54:11 AM,   page In [-ulg2.4.1.17in] ",
//     [1]: "02/07/2024 01:53:20 AM>",
//     [2]: "Enter sour time and the date of last E-Mvist in the lines below: >Total Mnutes   16 >Last E-M-DOS: (as \"MVI-DD-YYYY\" )   1/21/2024 >end of time entry. Please do not write after this line. > II Date: 02/07/2024 Time: 01:45 AM Provider: Bates, Vernice   02/07/2024 Note generatedbyeClinicalWorks EVR/PMSoftware (vvweveClinicalWorks.corn) To: TCD Medical PLLC, Subject: Progress Notes, Fax#: (716)303-7012,   SendDate: 02/07/202401:54:11 AM,   page In [-ulg2.4.1.17in] "
// ]


{{-- Starts [(11:50)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34130780#content) --}}

{{-- Add both header and footer, slot for main content --}}

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Digital Online R-M</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="main.css" /> --}}
    <link rel="stylesheet" href="/main.css" />

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script> --}}
    <script src="{{ asset('js/pdfjs/pdf.js') }}"></script>
    
    <?php
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: access");
        // header("Access-Control-Allow-Methods: POST, GET");
        // header("Content-Type: application/json, charset=UTF-8, text/plain, application/octet-stream");
        // header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    ?>
  </head>
  <body>
    <header class="header-bar mb-3">
      <div class="container d-flex flex-column flex-md-row align-items-center p-3">
        <h4 class="my-0 mr-md-auto font-weight-normal">
            <a href="/" class="text-white">
              <img title="My Profile" data-toggle="tooltip" data-placement="bottom" style="width: 50px; height: 50px; border-radius: 16px" src="/images/DentCareTeam-Sidebar-Logo-Zoom.jpg" />
              Digital Online R-M
            </a>
        </h4>
        {{-- (12:55): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207654#overview --}}
        
        @auth
            <div class="flex-row my-3 my-md-0">
              <a href="#" class="text-white mr-2 header-search-icon" title="Search" data-toggle="tooltip" data-placement="bottom"><i class="fas fa-search"></i></a>

  {{-- Removed Chat icon:  --}}
              {{-- <span class="text-white mr-2 header-chat-icon" title="Chat" data-toggle="tooltip" data-placement="bottom"><i class="fas fa-comment"></i></span> --}}
             
              <a href="/profile/{{ auth()->user()->username }}" class="mr-2"><img title="My Profile" data-toggle="tooltip" data-placement="bottom" style="width: 32px; height: 32px; border-radius: 16px" src="/images/DentCareTeam-Sidebar-Logo-Zoom.jpg" /></a>
              
              <a class="btn btn-sm btn-success mr-2" href="/create-post">Create Post</a>
              <form action="/logout" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-secondary">Sign Out</button>
              </form>
            </div>
        @else 
            <form action="/login" method="POST" class="mb-0 pt-2 pt-md-0">
              @csrf
              <div class="row align-items-center">
                <div class="col-md mr-0 pr-md-0 mb-3 mb-md-0">
                  <input name="loginusername" class="form-control form-control-sm input-dark" type="text" placeholder="Username" autocomplete="off" />
                </div>
                <div class="col-md mr-0 pr-md-0 mb-3 mb-md-0">
                  <input name="loginpassword" class="form-control form-control-sm input-dark" type="password" placeholder="Password" />
                </div>
                <div class="col-md-auto">
                  <button class="btn btn-primary btn-sm">Sign In</button>
                </div>
              </div>
            </form>
        @endauth

        
      </div>
    </header>
    <!-- header ends here -->

    {{-- (11:45) - Added success message: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207658#overview  --}}
{{-- check if current session data has a message with 'success' using session() helper function --}}
    @if (session()->has('success'))
      <div class="container container--narrow">
        <div class="alert alert-success text-center">
          {{ session('success') }}
        </div>
      </div>
    @endif
{{-- (15:05) - Check for failure message --}}
    @if (session()->has('failure'))
    <div class="container container--narrow">
      <div class="alert alert-danger text-center">
        {{ session('failure') }}
      </div>
    </div>
  @endif


    {{$slot}}


      <!-- footer begins -->
      <footer class="border-top text-center small text-muted py-3">
        <p class="m-0">Copyright &copy; {{ date('Y') }} <a href="/" class="text-muted">Dent Care Team</a>. All rights reserved.</p>
      </footer>
  
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      <script>
        $('[data-toggle="tooltip"]').tooltip()
      </script>
      <script>
        console.log("hello");
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>
     <script>
    
            const pdfDataUrlView = <?php echo json_encode($pdfDataUrl); ?>;
            // const pdfDataUrlView = document.getElementById('pdf-url').innerHTML;
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
            
            
            const patientDateTimeStamp = document.getElementById('patient-dateTime-stamp');
    
            
            const patientClinicTime = document.getElementById('patient-clinic-time');
            
            
            
            
            // const patientMatchesDiv = document.getElementById('patient-matches');
            const patientMatchesDiv = document.getElementById('notes-container');
            
            // const notesStatusHeader = document.getElementById('notes-status');
            const notesStatusHeader = document.getElementById('notes-results');
    
            pdfjsLib.getDocument({ data: atob(pdfDataUrlView.split(',')[1]) })
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
                                patientMrn.innerHTML = `MRN Number: ${accountNumber}`;
      
                            
                                // Display or use the extracted Account Number as needed
                                console.log('Account Number:', accountNumber);
                                
                    // Patient Name and DOB:   
                            // Extract Patient Name and DOB using JavaScript
                                const patientNameMatch = text.match(/Patient Name:\s*([^,]*,[^,]*)/);
                                const dobMatch = text.match(/DOB:\s*(\d{2}\/\d{2}\/\d{4})/);
                                // const patientProviderMatch = text.match(/Action Taken:(?:.*?\n)?\s*([^0-9]+?)\s*\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2}\s[APMapm]{2}>/);
                                
                                const patientName = patientNameMatch ? patientNameMatch[1] : 'Not Found';
                                patientFullName.innerHTML = `Patient: ${patientName}`;
                                
                                
                                const dob = dobMatch ? dobMatch[1] : 'Not Found';
                                patientDob.innerHTML = `DOB: ${dob}`;
                       
                    // Referring Provider: 
                                const patientProviderPattern = /Action Taken[^]*?(\b[A-Z][a-z]+,\s[A-Z][a-z]+\b)[^]*?\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2}\s[APMapm]{2}>/;
    
                                const patientProviderMatch = text.match(patientProviderPattern);
                                const displayPatientProvider = patientProviderMatch ? patientProviderMatch[1].trim() : 'Error: Provider Not Found!';
                                patientProvider.innerHTML = `Provider: ${displayPatientProvider}`;
                                console.log("Patient Provider: ", displayPatientProvider);
                            
                      
                    // dateTime stamp (patientDateTimeStamp)
                                // const dateTimeStampPattern = /Action Taken [^]*?(\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2} [APMapm]{2})\s?>/;
                    // Modified dateTime (no space)
                                const dateTimeStampPattern = /Action Taken [^]*?(\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2} [APMapm]{2})\s?>/;
                    
                                const dateTimeStampMatch = text.match(dateTimeStampPattern);
                                const displayPatientDateTimeStamp = dateTimeStampMatch ? dateTimeStampMatch[1] : 'Error: DateTime Stamp Not Found';
                                patientDateTimeStamp.innerHTML = `Note Created At: ${displayPatientDateTimeStamp}`;
                                console.log('Patient DateTime Stamp:', displayPatientDateTimeStamp);                         
                            
                                
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
                                const clinicTimePattern = /(?:\d{2}\/\d{2}\/\d{4}\s?\d{2}:\d{2}:\d{2} [APMapm]{2}>)(\d+)\s*(?:minutes)?[^]*?Date: \d{2}\/\d{2}\/\d{4}/;
                                
                                const clinicTimeMatch = text.match(clinicTimePattern);
                                const displayPatientClinicTime = clinicTimeMatch ? parseInt(clinicTimeMatch[1], 10) : 'Error: Clinic Time Not Found';
                                patientClinicTime.innerHTML = `Total Minutes Spent: ${displayPatientClinicTime}`;
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
    </body>
  </html>
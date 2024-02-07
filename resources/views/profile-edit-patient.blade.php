{{-- Created (17:40): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207654#overview --}}

<x-layout>

    {{-- <div class="container py-md-5 container--narrow">
        <div class="text-center">
          <h2>Hello <strong>{{ ucwords(auth()->user()->username) }}</strong>, your feed is empty.</h2>
          <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p>
        </div>
    </div> --}}

    <div class="container py-md-5 container--narrow">

      <div class="text-center">
        {{-- <h2>Hello <strong>{{ ucwords(auth()->user()->username) }}</strong>, your feed is empty.</h2> --}}
        <h2><strong>Enrollment:</strong> Add A New Patient</h2>
        {{-- <p class="lead text-muted">If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p> --}}
        <p class="lead text-muted">Enter the fields below to enroll a new patient into the Online Digital E-M services for your practice.</p>
      
      </div>



      
      <div class="row">
{{-- LEFT 1 of 3 slot with three 'class="col-sm"' 
        CHANGED to 1/3 left (col-md-4) and 2/3 right (col-md-8)
--}}
  
              
          
                  <?php
                    //(1/24/2024) - Dynamically set sEndDate to current day (in EST) and set sStartDate will be 2 days back. 
                      date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time

                    // Get the current date in 'YYYYMMDD' format
                        $getCurrentEstDate = (new DateTime())->format('D M jS, Y');
                        $displayCurrentEstDate = $getCurrentEstDate;
                  ?>

        

{{-- Right (3 of 3) third dividier --}}
        <div class="col-md-12">
                    {{-- <div class="border p-3"> USING 'p-3' adding padding? merged our forms --}}
                    <div class="border border-success p-2">
                                                      <!-- register-new-online-digitial-em-patient -->
                      <form method="POST" action="{{ url('/edit-online-digitial-em-patient') }}">
                            {{ csrf_field() }}
                            
                            <input type="hidden" id="patient_id" name="patient_id" value="{{ $patient->id }}">
                            
                            <h4 class="text-center">Update Records for patient {{ $patient->name }}</h4> 
                            
                        <div class="form-group row p-1 text-center">
                                <div class="col-xs-4 p-2">
                                  <label for="set-pt-name" class="text-muted mb-1"><small>Edit Patient Name</small></label>
                                  <input name="name" id="set-pt-name" class="form-control" type="text" value="{{ $patient->name }}" autocomplete="off" />                           
                                </div>
                           
                              <div class="col-xs-2 p-2">
                                  <label for="set-pt-mrn" class="text-muted mb-1"><small>Edit Pt MRN</small></label>
                                  <input name="mrn" id="set-pt-mrn" class="form-control" type="text" value="{{ $patient->mrn }}" />                           
                              </div>


                              <div class="col-xs-4 p-2">
                                  <label for="set-referring_provider" class="text-muted mb-1"><small>Edit Referring Provider</small></label>
                                  <input name="referring_provider" id="set-referring_provider" class="form-control" type="text" value="{{ $patient->referring_provider }}" autocomplete="off" />                           
                              </div>

                              <div class="col-xs-4 p-2">
                                <label for="em_date" class="text-muted mb-1"><small>Update Last EM Vist</small></label>
                                <input name="em_date" id="em_date" class="form-control" type="date" value="{{ $patient->em_date }}" autocomplete="off" />                           
                            </div>
                        </div>

                            {{-- <div class="form-group row ">
                            </div> --}}

                            {{-- <input type="hidden" id="custId" name="custId" value="3487"> --}}
                          <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-success" >Save Changes</button>
                          </div>
                      </form>
                </div>
                              <a href="{{ url('/hub'.$patient->id) }}" class="btn btn-sm btn-warning">Cancel. Go Back.</a>
        </div>
      </div>
<hr>

  </div>


</x-layout>


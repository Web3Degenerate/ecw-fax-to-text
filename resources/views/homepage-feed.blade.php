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
        <h2><strong>Admin Dashboard</strong> Patient List</h2>
        {{-- <p class="lead text-muted">If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p> --}}
        <p class="lead text-muted">Here is the time collected for Online Digital E-M services from your practice. Click on a patient to view their E-M history and manage their account.</p>
      
      </div>



      
      <div class="row">
{{-- LEFT 1 of 3 slot with three 'class="col-sm"' 
        CHANGED to 1/3 left (col-md-4) and 2/3 right (col-md-8)
--}}
        <div class="col-md-4">
              
          
                  <?php
                    //(1/24/2024) - Dynamically set sEndDate to current day (in EST) and set sStartDate will be 2 days back. 
                      date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time

                    // Get the current date in 'YYYYMMDD' format
                        $getCurrentEstDate = (new DateTime())->format('D M jS, Y');
                        $displayCurrentEstDate = $getCurrentEstDate;
                  ?>

                  {{-- <div class="border p-3">  --}}
                  <div class="border border-warning p-2">
                            <form method="POST" action="{{ url('/manually-get-fax-update') }}">
                                  {{ csrf_field() }}
                                  
                                  
                                  
                                  <h4 class="text-center">Check For New Faxes</h4> 
                                  
                                  <div class="form-group">
                                    <label for="set-end-date" class="text-muted mb-1"><small>Days From {{ $displayCurrentEstDate }}</small></label>
                                    <input value="{{old('sEndDate')}}" name="sEndDate" id="set-end-date" class="form-control" type="text" placeholder="Enter number of days" autocomplete="off" />
                                    
                                  </div>

                                  {{-- <input type="hidden" id="custId" name="custId" value="3487"> --}}
                                <div class="text-center">
                                  <button type="submit" class="btn btn-sm btn-warning" >Manually Check For New Faxes</button>
                                </div>
                            </form>
                  </div>
        </div>{{-- End of left third dividier --}}
        

{{-- Right (3 of 3) third dividier --}}
        <div class="col-md-8">
                    {{-- <div class="border p-3"> USING 'p-3' adding padding? merged our forms --}}
                    <div class="border border-success p-2">
                      <form method="POST" action="{{ url('/register-new-online-digitial-em-patient') }}">
                            {{ csrf_field() }}
                            
                            
                            
                            <h4 class="text-center">Manually Add A New Pt</h4> 
                            
                        <div class="form-group row p-1 text-center">
                                <div class="col-xs-4 p-2">
                                  <label for="set-pt-name" class="text-muted mb-1"><small>Enter Patient Name</small></label>
                                  <input value="{{old('name')}}" name="name" id="set-pt-name" class="form-control" type="text" placeholder="Last Name, First Name" autocomplete="off" />                           
                                </div>
                           
                              <div class="col-xs-2 p-2">
                                  <label for="set-pt-mrn" class="text-muted mb-1"><small>Enter Pt MRN</small></label>
                                  <input value="{{old('mrn')}}" name="mrn" id="set-pt-mrn" class="form-control" type="text" placeholder="'000000'" autocomplete="off" />                           
                              </div>


                              <div class="col-xs-4 p-2">
                                  <label for="set-referring_provider" class="text-muted mb-1"><small>Pt Referring Provider</small></label>
                                  <input value="{{old('referring_provider')}}" name="referring_provider" id="set-referring_provider" class="form-control" type="text" placeholder="Last Name, First" autocomplete="off" />                           
                              </div>
                        </div>

                            {{-- <div class="form-group row ">
                            </div> --}}

                            {{-- <input type="hidden" id="custId" name="custId" value="3487"> --}}
                          <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-success" >Manually Add New Patient</button>
                          </div>
                      </form>
                </div>

        </div>
      </div>
<hr>
    <div class="profile-slot-content">
          <div class="list-group">
            @foreach($patients as $patient)
                @if($patient->status == 0)
                    <a href="/profile/{{ $patient->mrn }}" class="list-group-item list-group-item-action">
                        <img class="avatar-tiny" src="https://0.gravatar.com/avatar/0d08988056acc135805ec1f5901f88ad19dd96c81966c088548f9335f11a56de?size=256" />
                        {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} or {{ $post->created_at->format('n/j/Y') }} --}}
                        <strong>{{ $patient->name }} ({{ $patient->mrn }})</strong> has XX total minutes. 
                    </a>
                @endif
            @endforeach
            {{-- <p>Hi from nested component x-profile</p> --}}
          </div>
    </div>
  </div>
</x-layout>


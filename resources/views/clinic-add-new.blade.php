{{-- &&& #DCT &&& --}}

<x-layout>

  <!-- &&& #DCT &&& - guest hardcoded message -->
  @if ($guestMessage)
      <div class="container container--narrow">
        <div class="alert alert-danger text-center">
          {{ $guestMessage }}
        </div>
      </div>

    @endif

  <div class="container py-md-5">

    
    <h1 class="display-5">Add A New <strong>Clinic</strong> From Your Practice</h1>
    {{-- <p class="lead text-muted">Log in to manage your patients&rsquo; &ldquo;Digital Online E-M&rdquo; encounters as they are sent from your EHR/EMR.</p>         --}}
    <p class="lead text-muted">Add another Clinic into Dent&rsquo;s Digital Online E-M Program.</p>
    
    <div class="row align-items-center">
      
      {{-- LEFT COLUMN --}}
          <div class="col-lg-7 py-3 py-md-5">
      

            {{-- <form action="" method="POST" id="registration-form"> --}}


              <form method="POST" action="{{ url('/save/new/clinic') }}">
                {{ csrf_field() }}
              {{-- @csrf --}}

                    <div class="form-group">
                        <label for="clinic_name" class="text-muted mb-1"><small>Enter The Clinic Name</small></label>
                        <input value="{{old('clinic_name')}}" name="clinic_name" id="name-register" class="form-control" type="text" placeholder="Enter Clinic Name" autocomplete="off" />
                      {{-- (11:50) Added error message: htnametps://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
                        @error('clinic_name')
                          <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                    </div>



                    <div class="form-group">
                      <label for="clinic_type" class="text-muted mb-1"><small>Facility:</small></label>
                      <input value="{{old('clinic_type')}}" name="clinic_type" id="name-register" class="form-control" type="text" placeholder="Enter Clinic Facility" autocomplete="off" />
                    {{-- (11:50) Added error message: htnametps://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
                      @error('clinic_type')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                      @enderror
                  </div>

          </div>
  {{-- END OF LEFT COLUMN --}}

  {{-- RIGHT COLUMN --}}
          <div class="col-lg-5 pl-lg-5 pb-3 py-lg-5">


            <div class="form-group">
              <label for="clinic_phone" class="text-muted mb-1"><small>(<i>Optional</i>) Clinic Phone:</small></label>
              <input value="{{old('clinic_phone')}}" name="clinic_phone" id="name-register" class="form-control" type="text" placeholder="Enter Clinic Phone Number" autocomplete="off" />
              {{-- <input type="text" id="phone" name="phone" pattern="\d{3}-\d{3}-\d{4}" title="Please enter a valid phone number (XXX-XXX-XXXX)" required> --}}
            {{-- (11:50) Added error message: htnametps://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
              @error('clinic_phone')
                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
              @enderror
          </div>


          <div class="form-group">
            <label for="clinic_fax" class="text-muted mb-1"><small>(<i>Optional</i>) Clinic Fax:</small></label>
            <input value="{{old('clinic_fax')}}" name="clinic_fax" id="name-register" class="form-control" type="text" placeholder="Enter Clinic Fax Number" autocomplete="off" />
          {{-- (11:50) Added error message: htnametps://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
            @error('clinic_fax')
              <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
            @enderror
        </div>



                        
                      </div> {{-- End of right column --}}
                      
        <button type="submit" class="py-3 mt-4 btn btn-lg btn-success btn-block">Add Clinic</button>
      </form>
          
          
        </div>{{-- End of 2nd Outter Row div 'row align-items-center' --}}
        

  </div>   {{-- End of parent container 'container py-md-5' --}}



</x-layout>
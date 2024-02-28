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

  
  {{-- <form action="/save/clinic/details" method="POST" id="registration-form"> --}}
            {{-- @csrf --}}
    <form method="POST" action="{{ url('/save/new/provider') }}">
        {{ csrf_field() }}
        {{-- @csrf --}}
            
                
                <div class="form-group">
                    <label for="clinic_id" class="text-muted mb-1"><small>Provider's Clinic</small></label>
                    {{-- <input value="{{old('provider')}}" name="provider" id="provider-register" class="form-control" type="date" placeholder="Enter Patient's Provider" autocomplete="off" /> --}}
                    
                    <select name="clinic_id" id="clinic_id-register" class="form-control">

                        <option value="0" {{ old('clinic_id') == 0 ? 'selected' : '' }}>Select The Provider's Clinic</option>

                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}" {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>{{ $clinic->clinic_name }}</option>
                    @endforeach

                    </select>
                    @error('clinic_id')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                    @enderror
                </div>
                



                <div class="form-group">
                    <label for="provider_name" class="text-muted mb-1"><small>Name of Provider</small></label>
                    <input value="{{old('provider_name')}}" name="provider_name" id="name-register" class="form-control" type="text" placeholder="Enter Provider's Name" autocomplete="off" />
                  {{-- (11:50) Added error message: htnametps://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
                    @error('provider_name')
                      <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                    @enderror
                </div>
  
  
  
                <div class="form-group">
                  <label for="provider_type" class="text-muted mb-1"><small>Qualifying Credentials of Provider</small></label>
                  <input value="{{old('provider_type')}}" name="provider_type" id="name-register" class="form-control" type="text" placeholder="Enter Provider Credentials" autocomplete="off" />
                {{-- (11:50) Added error message: htnametps://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
                  @error('provider_type')
                    <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                  @enderror
              </div>
  
  
  

  
  
  
  
  
  
            </div>
    {{-- END OF LEFT COLUMN --}}
  
    {{-- RIGHT COLUMN --}}
            <div class="col-lg-5 pl-lg-5 pb-3 py-lg-5">
  
  
              <div class="form-group">
                <label for="provider_email" class="text-muted mb-1"><small>(<i>Optional</i>) Provider E-mail:</small></label>
                <input value="{{old('provider_email')}}" name="provider_email" id="name-register" class="form-control" type="text" placeholder="Enter Provider's E-mail" autocomplete="off" />
              {{-- (11:50) Added error message: htnametps://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
                @error('provider_email')
                  <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                @enderror
            </div>
  
  
            <div class="form-group">
              <label for="provider_fax" class="text-muted mb-1"><small>(<i>Optional</i>) Provider Fax:</small></label>
              <input value="{{old('provider_fax')}}" name="provider_fax" id="name-register" class="form-control" type="text" placeholder="Enter Provider's Fax" autocomplete="off" />
            {{-- (11:50) Added error message: htnametps://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
              @error('provider_fax')
                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
              @enderror
          </div>
  
        
                        </div> {{-- End of right column --}}
                        
          <button type="submit" class="py-3 mt-4 btn btn-lg btn-success btn-block">Add Provider</button>
        </form>
            
            
          </div>{{-- End of 2nd Outter Row div 'row align-items-center' --}}
          
  
    </div>   {{-- End of parent container 'container py-md-5' --}}
  
  
  
  </x-layout>
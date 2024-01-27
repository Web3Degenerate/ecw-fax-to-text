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

    
    <h1 class="display-5">Enroll A New Patient</h1>
    {{-- <p class="lead text-muted">Log in to manage your patients&rsquo; &ldquo;Digital Online E-M&rdquo; encounters as they are sent from your EHR/EMR.</p>         --}}
    <p class="lead text-muted">Enter the form to enroll a new patient into Dent&rsquo;s Digital Online E-M Program.</p>
    
    <div class="row align-items-center">
      
      {{-- LEFT COLUMN --}}
          <div class="col-lg-7 py-3 py-md-5">
      

            <form action="/register" method="POST" id="registration-form">
              @csrf
                        
                            <div class="form-group">
                                    <label for="name-register" class="text-muted mb-1"><small>Name</small></label>
                                    <input value="{{old('name')}}" name="name" id="name-register" class="form-control" type="text" placeholder="Enter Patient's Name" autocomplete="off" />
                                  {{-- (11:50) Added error message: htnametps://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
                                    @error('name')
                                      <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                                    @enderror
                            </div>
          
                            {{-- <div class="form-group">
                                  <label for="mrn-register" class="text-muted mb-1"><small>MRN</small></label>
                                  <input value="{{old('mrn')}}" name="mrn" id="mrn-register" class="form-control" type="text" placeholder="Enter Patient's MRN" autocomplete="off" />
                                  @error('mrn')
                                    <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                                  @enderror
                            </div> --}}
          
                            <div class="form-group">
                                  <label for="isAdmin-register" class="text-muted mb-1"><small>Select User Type</small></label>
                                  {{-- <input value="{{old('provider')}}" name="provider" id="provider-register" class="form-control" type="date" placeholder="Enter Patient's Provider" autocomplete="off" /> --}}
                                  
                                  <select name="isAdmin" id="isAdmin-register" class="form-control">
                                    <option value="0" {{ old('isAdmin') == 0 ? 'selected' : '' }}>Enroll As Patient</option>
                                    <option value="1" {{ old('isAdmin') == 1 ? 'selected' : '' }}>Register As Admin User</option>
                                  </select>
                                  @error('isAdmin')
                                    <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                                  @enderror
                            </div>
          
                            <div class="form-group">
                                  <label for="dob-register" class="text-muted mb-1"><small>DOB</small></label>
                                  <input value="{{old('dob')}}" name="dob" id="dob-register" class="form-control" type="date" placeholder="Enter Patient's DOB" autocomplete="off" />
                                {{-- (11:50) Added error message: htnametps://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
                                  @error('dob')
                                    <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                                  @enderror
                            </div>
          
                            <div class="form-group">
                                  <label for="referring_provider-register" class="text-muted mb-1"><small>Provider</small></label>
                                  {{-- <input value="{{old('provider')}}" name="provider" id="provider-register" class="form-control" type="date" placeholder="Enter Patient's Provider" autocomplete="off" /> --}}
                                  
                                  <select name="referring_provider" id="referring_provider-register" class="form-control">
                                    <option value="0" {{ old('referring_provider') == 0 ? 'selected' : '' }}>Select A Provider</option>
                                    <option value="1" {{ old('referring_provider') == 1 ? 'selected' : '' }}>Vernice Bates, M.D.</option>
                                    <option value="2" {{ old('referring_provider') == 2 ? 'selected' : '' }}>Dr. Ajtai, M.D.</option>
                                    <option value="3" {{ old('referring_provider') == 3 ? 'selected' : '' }}>Dr. Mechtler, M.D.</option>
                                    <option value="999" {{ old('referring_provider') == 999 ? 'selected' : '' }}>Admin User</option>
                                  </select>
                                  @error('referring_provider')
                                    <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                                  @enderror
                            </div>


          </div>
  {{-- END OF LEFT COLUMN --}}

  {{-- RIGHT COLUMN --}}
          <div class="col-lg-5 pl-lg-5 pb-3 py-lg-5">

                        <div class="form-group">
                              <label for="username-register" class="text-muted mb-1"><small>MRN</small></label>
                              <input value="{{old('username')}}" name="username" id="username-register" class="form-control" type="text" placeholder="(this is just username)_Enter Patient&rsquo;s MRN" autocomplete="off" />
                            {{-- (11:50) Added error message: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
                              @error('username')
                                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                              @enderror
                        </div>

                        <div class="form-group">
                              <label for="email-register" class="text-muted mb-1"><small>Email</small></label>
                              <input value="{{old('email')}}" name="email" id="email-register" class="form-control" type="text" placeholder="you@example.com" autocomplete="off" />
                              @error('email')
                                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                              @enderror
                        </div>

                        <div class="form-group">
                              <label for="password-register" class="text-muted mb-1"><small>Password</small></label>
                              <input name="password" id="password-register" class="form-control" type="password" placeholder="Create a password" />
                              @error('password')
                                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                              @enderror
                        </div>

                        <div class="form-group">
                              <label for="password-register-confirm" class="text-muted mb-1"><small>Confirm Password</small></label>
                              {{-- <input name="password" id="password-register-confirm" class="form-control" type="password" placeholder="Confirm password" /> --}}
                              {{-- updated in (5:50): setup 'confirm' https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#content --}}
                              <input name="password_confirmation" id="password-register-confirm" class="form-control" type="password" placeholder="Confirm password" />
                              @error('password_confirmation')
                                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                              @enderror
                        </div>

                        
                      </div> {{-- End of right column --}}
                      
        <button type="submit" class="py-3 mt-4 btn btn-lg btn-success btn-block">Enroll Patient</button>
      </form>
          
          
        </div>{{-- End of 2nd Outter Row div 'row align-items-center' --}}
        

  </div>   {{-- End of parent container 'container py-md-5' --}}



</x-layout>
<x-layout>

    <div class="container py-md-5">
      <div class="row align-items-center">
  {{-- LEFT COLUMN --}}
            <div class="col-lg-7 py-3 py-md-5">
              <h1 class="display-5">Manage Patient Time</h1>
              <p class="lead text-muted">Log in to manage your patients&rsquo; &ldquo;Digital Online E-M&rdquo; encounters as they are sent from your EHR/EMR.</p>        
            </div>
  {{-- RIGHT COLUMN --}}
            <div class="col-lg-5 pl-lg-5 pb-3 py-lg-5">

  {{-- &&& #DCT &&& CONVERTED TO LOG IN ROUTE --}}
  {{-- <form action="/register" method="POST" id="registration-form"> --}}
                  <form action="/login" method="POST" class="mb-0 pt-2 pt-md-0" id="registration-form">
                            @csrf
                            <div class="form-group">
                              <label for="username-register" class="text-muted mb-1"><small>Username/Email</small></label>
                              <input value="{{old('loginusername')}}" name="loginusername" id="username-register" class="form-control" type="text" placeholder="Enter Your Username/Email" autocomplete="off" />
                            {{-- (11:50) Added error message: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
                              @error('loginusername')
                                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                              @enderror
                          </div>

                            <div class="form-group">
                              <label for="password-register" class="text-muted mb-1"><small>Password</small></label>
                              <input name="loginpassword" id="password-register" class="form-control" type="password" placeholder="Enter your password" />
                              @error('loginpassword')
                                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                              @enderror
                            </div>

                            <button type="submit" class="py-3 mt-4 btn btn-lg btn-success btn-block">Sign In</button>
                  </form>

            </div>

      </div>
    </div>


</x-layout>
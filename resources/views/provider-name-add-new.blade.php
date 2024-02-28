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
  
      
      <h1 class="display-5">Add A New <strong>Spelling</strong> For A Provider's Name</h1>
      {{-- <p class="lead text-muted">Log in to manage your patients&rsquo; &ldquo;Digital Online E-M&rdquo; encounters as they are sent from your EHR/EMR.</p>         --}}
      <p class="lead text-muted">Add another version of a Provider&rsquo;s name to match on the fax notes for the Online E-M Program.</p>
      
      <div class="row align-items-center">

      

        {{-- LEFT COLUMN --}}
            <div class="col-lg-7 py-3 py-md-5">

  
  {{-- <form action="/save/clinic/details" method="POST" id="registration-form"> --}}
            {{-- @csrf --}}
    <form method="POST" action="{{ url('/save/new/name') }}">
        {{ csrf_field() }}
        {{-- @csrf --}}
            
                
                <div class="form-group">
                    <label for="provider_id" class="text-muted mb-1"><small>Provider</small></label>
                    {{-- <input value="{{old('provider')}}" name="provider" id="provider-register" class="form-control" type="date" placeholder="Enter Patient's Provider" autocomplete="off" /> --}}
                    
                    <select name="provider_id" id="provider_id-register" class="form-control">

                        <option value="0" {{ old('provider_id') == 0 ? 'selected' : '' }}>Select A Provider</option>

                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>{{ $provider->provider_name }}</option>
                    @endforeach

                    </select>
                    @error('provider_id')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                    @enderror
                </div>
                



                <div class="form-group">
                    <label for="provider_name" class="text-muted mb-1"><small>Spelling for Provider's Name</small></label>
                    <input value="{{old('provider_name')}}" name="provider_name" id="name-register" class="form-control" type="text" placeholder="Enter Provider's Name" autocomplete="off" />
                  {{-- (11:50) Added error message: htnametps://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview --}}
                    @error('provider_name')
                      <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                    @enderror
                </div>
  

  
  
            </div>
    {{-- END OF LEFT COLUMN --}}
  
    {{-- RIGHT COLUMN --}}
            <div class="col-lg-5 pl-lg-5 pb-3 py-lg-5">
  
 
                {{-- No Right Column For Provider Name Spelling --}}
        
            </div> {{-- End of right column --}}
                        
          <button type="submit" class="py-3 mt-4 btn btn-lg btn-success btn-block">Add Provider</button>
        </form>
            
            
          </div>{{-- End of 2nd Outter Row div 'row align-items-center' --}}
          
  
    </div>   {{-- End of parent container 'container py-md-5' --}}
  
  
  
  </x-layout>
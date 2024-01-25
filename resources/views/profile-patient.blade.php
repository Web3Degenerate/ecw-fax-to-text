{{-- Created (1:46): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview --}}

{{-- THIS WAS IMPORTED FROM /views/profile-posts.blade.php 
  In Video #41 (~3:15): 
  https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview
  
-}}

{{-- Created (~3:00): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400818#overview --}}

<x-layout>

    <div class="container py-md-5 container--narrow">
        <h2>
          {{-- <img class="avatar-small" src="https://gravatar.com/avatar/b9408a09298632b5151200f3449434ef?s=128" /> {{ ucwords($sharedData['username']) }} --}}
          <img class="avatar-small" src="https://0.gravatar.com/avatar/0d08988056acc135805ec1f5901f88ad19dd96c81966c088548f9335f11a56de?size=256" /> {{ ucwords($patient->name) }}

           
{{-- (3:40) - Add (at)auth wrapper around form--}}
    @auth

    <a href="/hub/{{ $patient->mrn }}/edit-patient" class="btn btn-primary btn-sm">Edit Patient {{ $patient->name }}<i class="fas fa-user-plus"></i></a>
    @endauth
        </h2>hub
  
        <div class="profile-nav nav nav-tabs pt-2 mb-4">
          <a href="/hub/{{ $patient->mrn }}" class="profile-nav-link nav-item nav-link {{ Request::segment(3) == "" ? 'active' : '' }}">Activity Log For {{ $patient->name }} </a>
          <a href="/hub/{{ $patient->mrn }}/billing" class="profile-nav-link nav-item nav-link {{ Request::segment(3) == "billing" ? 'active' : '' }}">Patient Billing History</a>
          <a href="/hub/{{ $patient->mrn }}/edit-patient" class="profile-nav-link nav-item nav-link {{ Request::segment(3) == "edit-patient" ? 'active' : '' }}">Optional Tab 3</a>
        </div>


{{-- Added NEW SLOT in video 41 (~3:20): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview --}}
{{-- Later, we'll come back and add JavaScript to this to make a SPA --}}

        {{-- <div class="profile-slot-content">
            {{ $slot }}            
        </div> --}}


{{-- (5:40) Stripped out the code for User's own posts (when click on avatar) to `profile-posts.blade.php`: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview --}}

        
      </div>
</x-layout>
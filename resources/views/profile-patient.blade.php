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
          | ( {{ $patient->mrn }} )  |  Total Time: {{ $totalTime ?? 'No Time Yet'}}
           
{{-- (3:40) - Add (at)auth wrapper around form--}}
    @auth

    <a href="/hub/{{ $patient->mrn }}/edit-patient" class="btn btn-primary btn-sm">Edit Patient {{ $patient->name }}<i class="fas fa-user-plus"></i></a>
    @endauth
        </h2>
  
        <div class="profile-nav nav nav-tabs pt-2 mb-4">
          <a href="/hub/{{ $patient->id }}" class="profile-nav-link nav-item nav-link {{ Request::segment(3) == "" ? 'active' : '' }}">Activity Log For {{ $patient->name }} </a>
          <a href="/hub/{{ $patient->id }}/billing" class="profile-nav-link nav-item nav-link {{ Request::segment(3) == "billing" ? 'active' : '' }}">Patient Billing History</a>
          <a href="/hub/{{ $patient->id }}/edit-patient" class="profile-nav-link nav-item nav-link {{ Request::segment(3) == "edit-patient" ? 'active' : '' }}">Optional Tab 3</a>
        </div>


{{-- Added NEW SLOT in video 41 (~3:20): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview --}}
{{-- Later, we'll come back and add JavaScript to this to make a SPA --}}

        {{-- <div class="profile-slot-content">
            {{ $slot }}            
        </div> --}}


{{-- (5:40) Stripped out the code for User's own posts (when click on avatar) to `profile-posts.blade.php`: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview --}}

    <div class="profile-slot-content">
      <div class="list-group">
        @foreach($notes as $note)
            @if($note->billing_status_string == 'invalid')
                <a href="/hub/{{ $note->id }}" class="list-group-item list-group-item-action" style='background-color: red; color:white'>
            @elseif($note->billing_status_string == 'pending')
              <a href="/hub/{{ $note->id }}" class="list-group-item list-group-item-action" style="background:#33ff77">
            @else
                <a href="/hub/{{ $note->id }}" class="list-group-item list-group-item-action">
            @endif
                    <img class="avatar-tiny" src="https://0.gravatar.com/avatar/0d08988056acc135805ec1f5901f88ad19dd96c81966c088548f9335f11a56de?size=256" />
                    {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} or {{ $post->created_at->format('n/j/Y') }} --}}
                    <strong> On {{ $note->date_time }} ({{ $note->note_provider }})</strong> spent a total of {{ $note->clinic_time }} total minutes.
                    <br>
                    Last EM Visit: {{$patient->em_date ?? 'Not set'}} 

                    @if($patient->em_date) 
                    <br>
                    This note was entered {{ Carbon\Carbon::parse($note->date_time)->diffInDays($patient->em_date) }} days from the last EM vist. 
                    @endif
                    <br>
                    Note Status: {{ $note->billing_status_string }}
                </a>
            {{-- @endif --}}
        @endforeach
        {{-- <p>Hi from nested component x-profile</p> --}}
      </div>
    </div>
        



{{-- Closing Div and x-layout tag --}}
      </div>
</x-layout>
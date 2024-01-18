{{-- Created (1:46): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview --}}

{{-- THIS WAS IMPORTED FROM /views/profile-posts.blade.php 
  In Video #41 (~3:15): 
  https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview
  
-}}

{{-- Created (~3:00): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400818#overview --}}

<x-layout>

    <div class="container py-md-5 container--narrow">
        <h2>
          <img class="avatar-small" src="https://gravatar.com/avatar/b9408a09298632b5151200f3449434ef?s=128" /> {{ ucwords($username) }}
{{-- (3:40) - Add (at)auth wrapper around form--}}
      @auth
          {{-- SHOW FOLLOW BUTTON: NOT following AND not your OWN account: --}}
            @if(!$currentlyFollowing AND auth()->user()->id != $username)
                <form class="ml-2 d-inline" action="/create-follow/{{$username}}" method="POST">
                      {{-- FORGOT THE CSRF token ==> ERROR MESSAGE IS 419 Page Expired --}}
                      @csrf 
                      <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
                      <!-- <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button> -->
                </form>  
            @endif

  {{-- SHOW UNFOLLOW BUTTON: --}}
            @if($currentlyFollowing)
                <form class="ml-2 d-inline" action="/remove-follow/{{$username}}" method="POST">
                        {{-- FORGOT THE CSRF token ==> ERROR MESSAGE IS 419 Page Expired --}}
                        @csrf 
                        {{-- <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button> --}}
                        <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button>
                      </form>            
            @endif  

                {{-- (1:15) - Add check to manage avatar image: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34470392#overview --}}
                @if(auth()->user()->username == $username)
                <a href="/manage-avatar" class="btn btn-secondary btn-sm">Manage Avatar</a>
                @endif
    @endauth
        </h2>
  
        <div class="profile-nav nav nav-tabs pt-2 mb-4">
          <a href="#" class="profile-nav-link nav-item nav-link active">Posts: {{ $postCount }}</a>
          <a href="#" class="profile-nav-link nav-item nav-link">Followers: 3</a>
          <a href="#" class="profile-nav-link nav-item nav-link">Following: 2</a>
        </div>


{{-- Added NEW SLOT in video 41 (~3:20): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview --}}
        <div class="profile-slot-content">
            {{-- Later, we'll come back and add JavaScript to this to make a SPA --}}

            {{ $slot }}            
        </div>


{{-- (5:40) Stripped out the code for User's own posts (when click on avatar) to `profile-posts.blade.php`: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview --}}

        
      </div>
</x-layout>
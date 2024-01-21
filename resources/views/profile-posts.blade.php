{{-- OLD "profile-posts" template THIS WAS MOVED TO /Components/profile.blade.php 
  In Video #41 (~3:15): 
  https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview
  
-}}

{{-- (5:40): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview
    Added in ONLY the code for the default tab of User's OWN posts --}}
{{-- WRAPPED AROUND OUR NEW (2nd component layout) x tags --}}

{{-- <x-profile> PASS IN VALUES VIA "PROPS"--}}

  {{-- TO DO- ADD IN AVATAR WHEN SECTION COMPLETED: <x-profile :avatar="$avatar"> --}}
{{-- Props on 'profile-posts' stays the same because we used Type Hint of $pizza --}}

{{-- So these three Props can be replaced with $sharedData --}}
    {{-- <x-profile :username="$username" :currentlyFollowing="$currentlyFollowing" :postCount="$postCount"> --}}
      <x-profile :sharedData="$sharedData">

        <div class="list-group">
          @foreach($posts as $post)

              <a href="/post/{{ $post->id }}" class="list-group-item list-group-item-action">
                  <img class="avatar-tiny" src="https://gravatar.com/avatar/b9408a09298632b5151200f3449434ef?s=128" />
                  {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} --}}
                  <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('n/j/Y') }}

              </a>
          @endforeach
          {{-- <p>Hi from nested component x-profile</p> --}}
        </div>

</x-profile>
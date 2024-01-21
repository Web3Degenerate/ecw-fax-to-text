{{-- Created (~9:20): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview --}}

{{-- Copied template for default profile-posts tab (users own posts when clicking on avatar) --}}

  {{-- TO DO- ADD IN AVATAR WHEN SECTION COMPLETED: <x-profile :avatar="$avatar"> (and add to UserController getSharedData($user) private function) --}}
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
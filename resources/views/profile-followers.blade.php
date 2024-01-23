{{-- Created (~9:20): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview --}}

{{-- Copied template for default profile-posts tab (users own posts when clicking on avatar) --}}

  {{-- TO DO- ADD IN AVATAR WHEN SECTION COMPLETED: <x-profile :avatar="$avatar"> (and add to UserController getSharedData($user) private function) --}}
    {{-- So these three Props can be replaced with $sharedData --}}
    {{-- <x-profile :username="$username" :currentlyFollowing="$currentlyFollowing" :postCount="$postCount"> --}}
        <x-profile :sharedData="$sharedData">
  
          <div class="list-group">
            @foreach($followers as $follow)
  
                <a href="/profile/{{ $follow->userDoingTheFollowing->username }}" class="list-group-item list-group-item-action">
                    <img class="avatar-tiny" src="https://gravatar.com/avatar/b9408a09298632b5151200f3449434ef?s=128" />
    {{-- When add avatar, you can load followers avatar with this: --}}
                    {{-- <img class="avatar-tiny" src={{ $follow->userDoingTheFollowing->avatar }} /> --}}
                    {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} --}}
                    {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('n/j/Y') }} --}}
                    {{ $follow->userDoingTheFollowing->username }}
                </a>
            @endforeach
            {{-- <p>Hi from nested component x-profile</p> --}}
          </div>
  
  </x-profile>
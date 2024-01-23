{{-- Created (~9:30): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview --}}

  {{-- TO DO- ADD IN AVATAR WHEN SECTION COMPLETED: <x-profile :avatar="$avatar"> --}}
    {{-- <x-profile :username="$username" :currentlyFollowing="$currentlyFollowing"
    :postCount="$postCount"> --}}
    <x-profile :sharedData="$sharedData">
  
          <div class="list-group">
            @foreach($following as $follow)
  
                <a href="/profile/{{ $follow->userBeingFollowed->username }}" class="list-group-item list-group-item-action">
                    <img class="avatar-tiny" src="https://gravatar.com/avatar/b9408a09298632b5151200f3449434ef?s=128" />
    {{-- After setting up the avatar section you can use this:  --}}
                    {{-- <img class="avatar-tiny" src="{{ $follow->userBeingFollowed->avatar }}" /> --}}
                   
                    {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} --}}
                    {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('n/j/Y') }} --}}
                    {{ $follow->userBeingFollowed->username }}
                </a>
            @endforeach
            {{-- <p>Hi from nested component x-profile</p> --}}
          </div>
  
  </x-profile>
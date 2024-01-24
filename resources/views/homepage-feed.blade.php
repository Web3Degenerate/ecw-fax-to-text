{{-- Created (17:40): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207654#overview --}}

<x-layout>

    {{-- <div class="container py-md-5 container--narrow">
        <div class="text-center">
          <h2>Hello <strong>{{ ucwords(auth()->user()->username) }}</strong>, your feed is empty.</h2>
          <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p>
        </div>
    </div> --}}

    <div class="container py-md-5 container--narrow">

      <div class="text-center">
        {{-- <h2>Hello <strong>{{ ucwords(auth()->user()->username) }}</strong>, your feed is empty.</h2> --}}
        <h2><strong>Admin Dashboard</strong> Patient List</h2>
        {{-- <p class="lead text-muted">If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p> --}}
        <p class="lead text-muted">Here is the time collected for Online Digital E-M services from your practice. Click on a patient to view their E-M history and manage their account.</p>
      
      </div>


    <div class="profile-slot-content">
          <div class="list-group">
            @foreach($users as $user)
                @if($user->isAdmin == 0)
                    <a href="/profile/{{ $user->username }}" class="list-group-item list-group-item-action">
                        <img class="avatar-tiny" src="https://0.gravatar.com/avatar/0d08988056acc135805ec1f5901f88ad19dd96c81966c088548f9335f11a56de?size=256" />
                        {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} or {{ $post->created_at->format('n/j/Y') }} --}}
                        <strong>{{ $user->name }} ({{ $user->username }})</strong> has XX total minutes. 
                    </a>
                @endif
            @endforeach
            {{-- <p>Hi from nested component x-profile</p> --}}
          </div>
    </div>
  </div>
</x-layout>
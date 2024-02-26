{{-- Replicates the rxminter/srfax index.php --}}

{{-- Created (17:40): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207654#overview --}}

<x-layout>

    @if ($faxMessage)
      <div class="container container--narrow">
        <!-- <div class="alert alert-success text-center"> -->
        <div class="{{ $displayBox }}">     
          {{ $faxMessage }}
        </div>
      </div>
    @endif


    {{-- <div class="container py-md-5 container--narrow">
        <div class="text-center">
          <h2>Hello <strong>{{ ucwords(auth()->user()->username) }}</strong>, your feed is empty.</h2>
          <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p>
        </div>
    </div> --}}

    <div class="container py-md-5 container--narrow">

      <div class="text-center">
        {{-- <h2>Hello <strong>{{ ucwords(auth()->user()->username) }}</strong>, your feed is empty.</h2> --}}
        <h2><strong>Admin Dashboard:</strong> Fax Inbox</h2>

        {{-- <p class="lead text-muted">If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p> --}}
        <p class="lead text-muted">Here is the all incoming faxes Online Digital E-M services from your practice. Click on a fax to view their the E-M details.</p>
      
      </div>



      
{{-- <div class="row"> --}}

    <hr>
        <div class="profile-slot-content">
            <div class="list-group">

 
                @foreach($notes as $note)
             
                        <div class="list-group-item list-group-item-action">  
                            <ul>
                                <li>
                            @if($note->review_status == 0)
                                {{-- <a href="/manually-enter-single-fax-form/{{ $note->fax_details_id }}" class="list-group-item list-group-item-action btn btn-success btn-sm" style="background:#33ff77"> --}}
                                <a href="/manually-enter-clinic-time/{{ $note->fax_details_id }}" class="list-group-item list-group-item-action btn btn-success btn-sm" style="background:#33ff77">

                                    
                                            {{-- <img class="avatar-tiny" src="https://0.gravatar.com/avatar/0d08988056acc135805ec1f5901f88ad19dd96c81966c088548f9335f11a56de?size=256" /> --}}
                                            {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} or {{ $post->created_at->format('n/j/Y') }} --}}
                                    <strong>Manually Enter Fax Received On: {{ $note->date_time_fax_received }} </strong>
                                </a>
                            @endif
                            @if($note->review_status == 1)
                                {{-- <a href="/manually-enter-single-fax-form/{{ $note->fax_details_id }}" class="list-group-item list-group-item-action btn btn-success btn-sm" style="background:#b3c6ff"> --}}
                                <a href="/manually-enter-clinic-time/{{ $note->fax_details_id }}" class="list-group-item list-group-item-action btn btn-success btn-sm" style="background:#b3c6ff">

                                            {{-- <img class="avatar-tiny" src="https://0.gravatar.com/avatar/0d08988056acc135805ec1f5901f88ad19dd96c81966c088548f9335f11a56de?size=256" /> --}}
                                            {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} or {{ $post->created_at->format('n/j/Y') }} --}}
                                    <strong>Fax Received On: {{ $note->date_time_fax_received }} Entered for Patient {{ $note->patient_name }} </strong>
                                </a>
                            @endif
                                </li>
                                <li>Fax Details Id: {{ $note->fax_details_id }}</li>
                                <li>Fax File Name: {{ $note->fax_file_name }}</li>
                                <li>Fax Status: {{ $note->fax_status }}</li>
                                <li>
                                    <a href="/view-single-fax/{{ $note->fax_details_id }}" class="btn btn-warning btn-sm">
                                    View {{ $note->date_time_fax_received }} Fax Details 
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <hr>
                @endforeach

             
            </div>
        </div>

{{-- End of outter div row --}}
{{-- </div>  --}}



</x-layout>


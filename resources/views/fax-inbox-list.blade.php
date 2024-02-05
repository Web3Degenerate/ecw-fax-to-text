{{-- 2/4/2024 Copy of the original show all faxes without saving them as notes which Replicated the rxminter/srfax index.php --}}

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
        <h2><strong>Admin Dashboard:</strong> Fax Inbox</h2>
        {{-- <p class="lead text-muted">If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p> --}}
        <p class="lead text-muted">Here is the all incoming faxes Online Digital E-M services from your practice. Click on a fax to view their the E-M details.</p>
      
      </div>



      
{{-- <div class="row"> --}}

    <hr>
        <div class="profile-slot-content">
            <div class="list-group">

                <?php
                // $response = file_get_contents($faxData);
                $result_get_fax_inbox = json_decode($faxDataContents, true);
        
           // Pull out the array results
                    if ($result_get_fax_inbox && isset($result_get_fax_inbox['Result'])) {
                        $faxData = $result_get_fax_inbox['Result'];
                    } else{
                        $faxData = '';
                    }
                ?>

                @foreach($faxData as $fax)
                    <?php
                        //     // Extract sFaxDetailsID from FileName
                            $fileNameParts = explode('|', $fax['FileName']);
                        $sFaxDetailsID = isset($fileNameParts[1]) ? $fileNameParts[1] : '';
                        $sFaxFileName = isset($fileNameParts[0]) ? $fileNameParts[0] : '';
                        
                        // Pull the Date Fax was Sent??
                                // echo urlencode($fax['Date']);
                                // echo 'Date: ' . $fax['Date'];
                        $date_fax_sent = $fax['Date'];       
                        $fax_status = $fax['ReceiveStatus'];
                    ?>
                        <div class="list-group-item list-group-item-action">  
                            <ul>
                                <li>
                                <a href="/manually-enter-single-fax-form/{{ $sFaxDetailsID }}" class="list-group-item list-group-item-action btn btn-success btn-sm" style="background:#33ff77">
                                    {{-- <img class="avatar-tiny" src="https://0.gravatar.com/avatar/0d08988056acc135805ec1f5901f88ad19dd96c81966c088548f9335f11a56de?size=256" /> --}}
                                    {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} or {{ $post->created_at->format('n/j/Y') }} --}}
                                    <strong>Manually Enter Fax On: {{ $date_fax_sent }} </strong>
                                </a>
                                </li>
                                <li>Fax Details Id: {{ $sFaxDetailsID }}</li>
                                <li>Fax File Name: {{ $sFaxFileName }}</li>
                                <li>Fax Status: {{ $fax_status }}</li>
                                <li>
                                    <a href="/view-single-fax/{{ $sFaxDetailsID }}" class="btn btn-warning btn-sm">
                                    View {{ $date_fax_sent }} Fax Details 
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


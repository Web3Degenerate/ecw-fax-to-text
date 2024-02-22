{{-- Created (17:40): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207654#overview --}}

<x-layout>

    {{-- <div class="container py-md-5 container--narrow">
        <div class="text-center">
          <h2>Hello <strong>{{ ucwords(auth()->user()->username) }}</strong>, your feed is empty.</h2>
          <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p>
        </div>
    </div> --}}

    <?php
        //(1/24/2024) - Dynamically set sEndDate to current day (in EST) and set sStartDate will be 2 days back. 
          date_default_timezone_set('America/New_York'); // Set the timezone to Eastern Time

        // Get the current date in 'YYYYMMDD' format
            $getCurrentEstDate = (new DateTime())->format('D M jS, Y');
            $displayCurrentEstDate = $getCurrentEstDate;
      ?>

    <div class="container py-md-5 container--narrow">

        <div class="text-center">
            {{-- <h2>Hello <strong>{{ ucwords(auth()->user()->username) }}</strong>, your feed is empty.</h2> --}}
            <h2><strong>Admin Dashboard</strong> Patient List on {{ $displayCurrentEstDate }} </h2>
            {{-- <p class="lead text-muted">If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p> --}}
            <p class="lead text-muted">Here is the time collected for Online Digital E-M services from your practice. Click on a patient to view their E-M history and manage their account.</p>
        </div>
    
      {{-- <div class="row"> --}}


      <hr>
          <div class="profile-slot-content">
                <div class="list-group">
                    @foreach($patients as $patient)
                        @if($patient->status == 0)
                          @if($patient->id != 1)
                              <a href="/hub/{{ $patient->id }}" class="list-group-item list-group-item-action">
                                  <img class="avatar-tiny" src="https://0.gravatar.com/avatar/0d08988056acc135805ec1f5901f88ad19dd96c81966c088548f9335f11a56de?size=256" />
                                  {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} or {{ $post->created_at->format('n/j/Y') }} --}}
                                  <strong>{{ $patient->name }} ({{ $patient->mrn }})</strong> has {{ $patient->clinic_time_counter ?? '0' }} total minutes. (last EM Visit: {{$patient->em_date ?? 'Not set'}})
                              </a>
                          @endif
                        @endif
                    @endforeach               
                </div>            
          </div>


          <h5>Invoice Section</h5>

      <ul>
        @foreach($invoices as $invoice)
            <li><strong>Invoice for Patient {{ $invoice->patient_id }} which began on ({{ $invoice->seven_days_from_date_only }})</strong> had billing code:  {{ $invoice->billing_code ?? 'Missed' }} for a total 
              of {{ $invoice->cumulative_clinic_time }} minutes. (Invoice Status: {{$invoice->status ?? 'Missed'}} and billing_group_number is: {{ $invoice->billing_group_number ?? 'Missed'}}).</li>
        @endforeach
      </ul>


          <hr>


          <!-- <div class="profile-slot-content"> -->
                <div class="list-group">
                    @foreach($invoices as $invoice)
                        <!-- @if($invoice->status == 0) -->
                          <!-- @if($invoice->id != 1) -->
                              <a href="/hub/{{ $invoice->id }}" class="list-group-item list-group-item-action">
                                  <img class="avatar-tiny" src="https://0.gravatar.com/avatar/0d08988056acc135805ec1f5901f88ad19dd96c81966c088548f9335f11a56de?size=256" />
                                  {{-- <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('m/d/Y') }} or {{ $post->created_at->format('n/j/Y') }} --}}
                                  <strong>Invoice for Patient {{ $invoice->patient_id }} which began on ({{ $invoice->seven_days_from_date_only }})</strong> had billing code:  {{ $invoice->billing_code ?? 'Missed' }} for a total 
                                  of {{ $invoice->cumulative_clinic_time }} minutes. (Invoice Status: {{$invoice->status ?? 'Missed'}} and billing_group_number is: {{ $invoice->billing_group_number ?? 'Missed'}}).
                              </a>
                          <!-- @endif -->
                        <!-- @endif -->
                    @endforeach               
                </div>            
          <!-- </div> -->



 {{-- Closing div for outter parent row div --}}
  {{-- </div>  --}}
</div>

</x-layout>


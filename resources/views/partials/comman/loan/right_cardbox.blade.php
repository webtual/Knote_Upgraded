<div class="card-box text-center">
   <div class="text-left mt-0">
       
      @if($application)
        @if(isset($is_consent) && $is_consent)
        
        @else
            <h3 class="font-22 mb-0">Application Ref No.</h3>
            <h3 class="mb-4"><span class="text-success"> {{ $application->application_number }}</span></h3>
        @endif
      @endif
      
      {{--
      @if($application)
         @if($application->review_notes->count() > 0)
            <h5 class="mb-3 mt-0 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Review Updates</h5>
            @php
               $max_height = ($application->review_notes->count() < 4) ? ($application->review_notes->count() * 100) : '400';
            @endphp
            <div class="slimscroll mb-0" style="max-height: {{ $max_height }}px;"> 
               @forelse($application->review_notes as $key => $review)
                  <div class="post-user-comment-box px-2 pt-1 pb-0 mb-0 {{ ($key == 0) ? 'mt-0' : '' }}">
                     <div class="media">
                        <div class="media-body p-1">
                           <div class="d-flex justify-content-between"><h5 class="mt-0"> {{ $review->user->name }}</h5> <small class="text-muted">{{ $review->time_ago() }}</small></div>
                           {!! strip_tags(htmlspecialchars_decode($review->note)) !!}
                           <br>
                        </div>
                     </div>
                  </div>
               @empty

               @endforelse
            </div>
         <hr>
         @endif
         
         @if($application->assessor_review_notes->count() > 0)
            <h5 class="mb-3 mt-0 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Assessor Updates</h5>
            @php
            $max_heights = ($application->assessor_review_notes->count() < 3) ? ($application->assessor_review_notes->count() * 100) : '400';
            @endphp
           <div class="slimscroll mb-3 mt-1" style="max-height: {{ $max_heights }}px !important;">
              <div class="assessor-data-note"></div> 
              @forelse($application->assessor_review_notes as $keys => $reviews)
                  <div class="post-user-comment-box px-2 pb-0 pt-1 mb-0 {{ ($keys == 0) ? 'mt-0' : '' }}">
                     <div class="media">
                        <div class="media-body p-1">
                            <div class="d-flex justify-content-between"><h5 class="mt-0"> {{ $reviews->user->name }}</h5> <small class="text-muted">{{ $reviews->time_ago() }}</small></div>
                           {!! strip_tags(htmlspecialchars_decode($reviews->assessor_note)) !!}
                           <div class="text-right">
                            @if(sizeof($reviews->assessor_docs) != 0)
                                @foreach($reviews->assessor_docs as $document)
                                    @php
                                        $assessor_file_path = $document->assessor_file;
                                    @endphp
                                    @if(isset($assessor_file_path))
                                        <a class="text-success" title="Download Document" href="{{ asset('storage/'.$assessor_file_path) }}" download><i class="mdi mdi-download mr-1 fs-22"></i></a>
                                    @endif
                                @endforeach
                            @endif
                            </div>
                        </div>
                     </div>
                  </div>
              @empty
              @endforelse
           </div>
         <hr>
         @endif
      @endif
      --}}
      
      {{--
      <h3 class="font-22">Why choose Knote for your business loan?</h3>
      <p class="text-muted font-15 mb-3">
         Low interest, high support. Our loan experts are available and keen to help you with your application.
      </p>
      <h3 class="font-25 mt-1">Features</h3>
      <p class="text-dark mb-1 mt-3 font-15"><strong>No ongoing fees</strong></p>
      <p class="text-dark mb-1 font-15"><strong>Local support ready to help</strong></p>
      <p class="text-dark mb-1 font-15"><strong>Discounts for loyalty</strong></p>
      <p class="text-dark mb-1 font-15"><strong>Flexible and convenient</strong></p>
      <p class="text-dark mb-1 font-15"><strong>Highly competitive home loan rates</strong></p>
      <p class="text-dark mb-2 mt-2 font-15">Any questions ? <a href="{{ url('faq') }}" class="text-dark " target="blank">See our FAQs </a></p>
      --}}
      
      
       <div class="what-do-need">
          <h4><strong>How Knote can help?</strong></h4>
          <ul class="what-we-need-apply">
             <li><i class="fa fa-check" aria-hidden="true"></i> Property Loan</li>
             <li><i class="fa fa-check" aria-hidden="true"></i> Business Cash flow Loan</li>
             <li><i class="fa fa-check" aria-hidden="true"></i> Commercial / Business Loan</li>
             <li><i class="fa fa-check" aria-hidden="true"></i> Cryptocurrency Loan</li>
          </ul>
       </div>
       <div class="have-questions mt-4">
          <!--<h4><strong>Have questions?<br>-->
          <!--   We have answers.</strong> -->
          <!--</h4>-->
          
          <h4><strong>We are happy to answer questions</strong></h4>
          <p>Our friendly customer service team are waiting to help you.</p>
          <ul class="mt-4">
             <li>
             	<a href="tel://1300056683"><i class="fa fa-phone fa-flip-horizontal" aria-hidden="true"></i>Call us on 1300 056 683</a><br>
                <span>Mon - Fri, 9:00am till 5:30pm</span> 
             </li>
             <li>
             	<a href="mailto:hello@knote.com.au"><i class="fa fa-envelope" aria-hidden="true"></i>Email hello@knote.com.au</a>
             </li>
          </ul>
       </div>
      
      
      
      

      {{--
      <hr>
      <p class="mt-2"> <i class="fa fa-envelope margin-right-10" aria-hidden="true"></i> <strong><a href="mailto:hello@knote.com.au"> hello@knote.com.au</a></strong> </p>
      <p> <i class="fa fa-phone margin-right-10" aria-hidden="true"></i> <strong><a href="tel:+1300 056 683"> 1300 056 683</a></strong> </p>
      --}}
      
   </div>
</div>
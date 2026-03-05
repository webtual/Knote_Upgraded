<div class="card-box text-center">
   <div class="text-left mt-0">

      @if($application)
         @if(isset($is_consent) && $is_consent)

         @else
            <h3 class="font-22 mb-0">Application Ref No.</h3>
            <h3 class="mb-4"><span class="text-success"> {{ $application->application_number }}</span></h3>
         @endif
      @endif

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
               <a href="tel://1300056683"><i class="fa fa-phone fa-flip-horizontal" aria-hidden="true"></i>Call us on
                  1300 056 683</a><br>
               <span>Mon - Fri, 9:00am till 5:30pm</span>
            </li>
            <li>
               <a href="mailto:hello@knote.com.au"><i class="fa fa-envelope" aria-hidden="true"></i>Email
                  hello@knote.com.au</a>
            </li>
         </ul>
      </div>





      {{--
      <hr>
      <p class="mt-2"> <i class="fa fa-envelope margin-right-10" aria-hidden="true"></i> <strong><a
               href="mailto:hello@knote.com.au"> hello@knote.com.au</a></strong> </p>
      <p> <i class="fa fa-phone margin-right-10" aria-hidden="true"></i> <strong><a href="tel:+1300 056 683"> 1300 056
               683</a></strong> </p>
      --}}

   </div>
</div>
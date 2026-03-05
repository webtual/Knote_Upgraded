
<section id="business-proposals" class="pt-4">
   <div class="container">
      <div class="section-header">
         <h2><a class="sec-title-block" href="{{ url('business-proposals') }}">Business Proposals</a></h2>
         <p>Find an investment opportunity that's right for you.</p>
      </div>
      <div id="bp-owl" class="owl-carousel owl-theme">
         @php
         $business_proposals = App\BusinessProposal::whereis_approved(1)->limit(6)->orderBy('id', 'Desc')->get();
         @endphp
         @if(!empty($business_proposals))

            @foreach($business_proposals as $bs)

            <div class="item box wow">
               @include('partials.block.business_proposal', ['bs' => $bs])
            </div>

            @endforeach
         @endif
      </div>

      <div class="row">
         <div class="col-md-12 mb-5 text-right read-txt">
            <a class="" href="{{ url('business-proposals') }}">VIEW MORE <i class="fa fa-long-arrow-right"></i></a>
         </div>
      </div>

   </div>
</section>

<section id="resources" class="pt-4">
   <div class="container">
   <div class="section-header">
      <h2><a class="sec-title-block" href="{{ url('resource') }}">Resources</a></h2>
   </div>
   <div id="resources-owl" class="owl-carousel owl-theme">
      @php
         $resources = App\Resource::whereis_approved(1)->limit(6)->orderBy('id', 'Desc')->get();
      @endphp
      @if(!empty($resources))

         @foreach($resources as $resource)

            <div class="item box wow">
                @include('partials.block.resource', ['resource' => $resource])
            </div>

         @endforeach

      @endif
   </div>

   <div class="row">
      <div class="col-md-12 text-right read-txt mb-5">
         <a class="" href="{{ url('resource') }}">VIEW MORE <i class="fa fa-long-arrow-right"></i></a>
      </div>
   </div>

</section>

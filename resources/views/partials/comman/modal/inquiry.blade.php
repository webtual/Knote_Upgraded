<div class="modal fade ask-question" id="ask_a_question" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Get Started Now</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="{{ url('inquiry/create') }}" method="post" role="form" class="inquiry-form" onsubmit="return false;">
               <div class="form-group">
                  <input type="text" class="form-control" name="name" id="name" placeholder="Your Name*" />
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <input type="text" name="contact" class="form-control numbers-only" id="" placeholder="Your Contact*" />
                  </div>
                  <div class="form-group col-md-6">
                     <input type="email" class="form-control" name="email" id="email" placeholder="Your Email*" />
                  </div>
               </div>
               <div class="form-group">
                  <select class="form-control" name="purpose_of_visit">
                        <option value="">Purpose of visit*</option>
                        @foreach(config('constants.purpose_of_visits') as $key => $ps)
                        <option value="{{ $key }}">{{ $ps }}</option>
                        @endforeach
                  </select>
               </div>

               <div class="form-group d-none" id="message-box">
                  <textarea class="form-control" name="message" placeholder="Your Message*" rows="5"></textarea>
               </div>
               <input type="hidden" name="page_url" value="{{ url()->current() }}">
               <div class="text-right">
                  <button type="submit" class="btn btn-primary mr-2" id="submit-ask-inquiry">Submit</button>
                  {{-- <button type="cancel" class="btn btn-default">Cancel</button> --}}
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
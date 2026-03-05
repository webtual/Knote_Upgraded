
<!--==========================
   Contact Section
   ============================-->
<section id="contact" class="wow fadeInUp">
   <div class="container">
      <div class="section-header">
         {{-- <h2>Contact Us</h2> --}}
         <div class="row">
            <div class="col-md-6">
               <h2>Contact Us</h2>
            </div>    
            <div class="col-md-6">
               <div class="mt-3">For any loan related queries, please fill in the form and our executives will get back to you soon.
               </div>
            </div>
         </div>

      </div>
   </div>
   <div class="container">
      <div class="row">
         <div class="col-md-6">
            <div class="row contact-info">
               <div class="col-md-12">
                  <div class="contact-address">
                     <div class="icon">
                        <i class="ion-ios-location-outline"></i>
                     </div>
                     <div class="text-sec">
                        <h3>Address</h3>
                        <address><a href="https://www.google.com/maps/search/PO+Box+6493,+Point+Cook+VIC+3030/@-37.9053521,144.719196,13z/data=!3m1!4b1?hl=en-US" target="blank"> PO Box 6493, Point Cook VIC 3030</a></address>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="contact-phone">
                     <div class="icon">
                        <i class="ion-ios-telephone-outline"></i>
                     </div>
                     <div class="text-sec">
                        <h3>Phone Number</h3>
                        <p><a href="tel:+1300 056 683">1300 056 683</a></p>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="contact-email">
                     <div class="icon">
                        <i class="ion-ios-email-outline"></i>
                     </div>
                     <div class="text-sec" >
                        <h3>Email</h3>
                        <p><a href="mailto:hello@knote.com.au">hello@knote.com.au</a></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="form">
               <div id="sendmessage">Your message has been sent. Thank you!</div>
               <div id="errormessage"></div>
               {{-- <p>For any loan related queries, please fill in the form and our executives will get back to you soon.</p> --}}
               <form action="{{ route('contact.post') }}" method="post" role="form" class="co-form" onsubmit="return false;">
                 @csrf
                  <div class="form-group">
                     <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" />
                     <div class="validation"></div>
                  </div>
                  <div class="form-row">
                     <div class="form-group col-2 col-lg-2 col-xl-1">
                        <input type="text" name="countrycode" value="+61" readonly="readonly" class="form-control" id="countrycode" placeholder="+61" />
                     </div>
                     <div class="form-group col-10 col-lg-10 col-xl-11">
                        <input type="text" name="contact" class="form-control" id="" placeholder="Your Contact" />
                     </div>
                     <div class="form-group col-lg-12 col-xl-12">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                        <div class="validation"></div>
                     </div>
                  </div>
                  <div class="form-group">
                     <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                     <div class="validation"></div>
                  </div>
                  <div class="text-center">
                     <button type="submit" id="submit-contact"> <i class="fa fa-spinner fa-spin fa-fw d-none"></i> Send Message</button>
                  </div>
               </form>
            </div>
         </div>
         {{-- 
         <div class="col-md-6">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3149.0241300993266!2d144.73417701532074!3d-37.883118379739955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad688f338f26a21%3A0xa689766ace3c0121!2sAustralia%20Post%20Point%20Cook%20Franchise!5e0!3m2!1sen!2sin!4v1572863608062!5m2!1sen!2sin" width="100%" height="312" frameborder="0" style="border:0" allowfullscreen></iframe>
         </div>
         --}}
      </div>
   </div>
</section>
<!-- #contact -->
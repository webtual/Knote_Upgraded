<!--==========================
   Services Section
   ============================-->
<section id="services">
   <div class="container">
      <div class="section-header">
         <h2>Services</h2>
         <div class="service-block">
            <p>Knote is a fast-growing fintech lending platform. We fund ambitions and enable businesses to grow by connecting them with investors seeking a better return on their money.</p>
         </div>
      </div>
      <div class="row service-block">
         <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="box wow fadeInLeft">
               <div class="icon"><i class="fa fa-puzzle-piece"></i></div>
               <h4 class="title"><a href="javascript:;"  data-label="Investor" class="pre-questions" data-type="5">Investor</a></h4>
               <div class="description">
                  <p>You are Investor/Entrepreneur or want to be one.</p>
                  <p>Register/Login to see opportunities available</p>
               </div>
               <div class="row ser-bottom">
                  <div class="col-7">
                     <div class="how-it-part" onclick="openService('knote-investor')">How it works ?</div>
                  </div>
                  <div class="col-5">
                     <div class="btn-part"><a href="javascript:;" data-type="5" class="btn btn-primary loan-btn pre-questions" data-label="Investor" >Join us</a></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="box wow fadeInCenter">
               <div class="icon"><i class="fa fa-file-text font-40"></i></div>
               <h4 class="title"><a href="javascript:;" data-label="Entrepreneurs" class="pre-questions" data-type="4" >Entrepreneurs</a></h4>
               <div class="description">
                  <p>A existing/new business Idea need Investment.</p>
                  <p>Register/Send us the proposal</p>
               </div>
               <div class="row ser-bottom">
                  <div class="col-7">
                     <div class="how-it-part" onclick="openService('knote-entrepreneurs')">How it works ?</div>
                  </div>
                  <div class="col-5">
                     <div class="btn-part"><a href="javascript:;" data-label="Entrepreneurs" data-type="4" class="btn btn-primary loan-btn pre-questions" >Join us</a></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="box wow fadeInRight" data-wow-delay="0.2s">
               <div class="icon"><i class="fa fa-briefcase"></i></div>
               <!--<h4 class="title"><a href="{{ url('register/loan-applicant') }}">Loans</a></h4>-->
               <h4 class="title"><a href="{{ url('loans') }}">Loans</a></h4>
               <div class="description">
                  <p>New/Old Businesss Need Small medium</p>
                  <p>Apply for Loan below</p>
               </div>
               <div class="row ser-bottom">
                  <div class="col-7">
                     <div class="how-it-part" onclick="openService('knote-loan')">How it works ?</div>
                  </div>
                  <div class="col-5">
                     <div class="btn-part"><a href="{{ url('loans') }}" class="btn btn-primary loan-btn">Apply Now</a></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <form action="{{ route('my.preferences.store') }}" method="post" class="pre-form" onsubmit="return false;" data-redirect-url="{{ route('dashboard') }}">
            @php
            $roles_question = App\PreferenceQuestion::get_question_roles();
            @endphp
            @if(!empty($roles_question))
               @foreach($roles_question as $key => $role_single)
                  @php
                  $investor_question = App\PreferenceQuestion::get_question_by_role($role_single->role_id);
                  @endphp
                     @if(!empty($investor_question))
                     <div class="d-none wizard-section animated fadeInDown" id="question-block-{{ $role_single->role_id }}">
                        <div class="form-row">
                           <div class="col-lg-8 col-xl-9 question-block">
                              @foreach($investor_question as $sr => $value)
                              <div class="animated fadeInDown qu-answer-block {{ ($loop->first) ? '' : 'd-none' }}" data-key="{{ $sr+1 }}">
                                 <div class="questions"><strong>{{($sr+1).'. '.$value->title }}</strong></div>
                                 <div class="answers-fields">
                                    @if($value->type == 'selection')   
                                    <div class="form-group">
                                       <select class="form-control" id="" required="required" name="{{ $value->id }}">
                                          <option value="">Select..</option>
                                          @if(!empty($value->question_answers))
                                          @foreach($value->question_answers as $op => $option)
                                          <option value="{{ $option->answer_text }}">{{ $option->answer_text }}</option>
                                          @endforeach
                                          @endif
                                       </select>
                                    </div>
                                    @elseif($value->type == 'input')
                                    <div class="form-group">
                                       <input type="text" name="{{ $value->id }}" class="form-control" id="" placeholder="{{ $value->title }}" required="required" />
                                    </div>
                                    @elseif($value->type == 'radio')
                                    @if(!empty($value->question_answers))
                                    <div class="form-group ml-1">
                                       @foreach($value->question_answers as $op => $option)
                                       <div class="radio radio-info form-check-inline">
                                          <input type="radio" id="" value="{{ $option->answer_text }}" name="{{ $value->id }}" {{ ($op == 0) ? 'checked="checked"' : '' }}>
                                          <label for="inlineRadio1">{{ $option->answer_text }} </label>
                                       </div>
                                       @endforeach
                                    </div>
                                    @endif
                                    @endif
                                 </div>
                              </div>
                              @endforeach
                              <div class="qu-answer-block d-none" data-key="{{ $sr+2 }}">
                                 <div class="questions"><strong>There are a number of ways you can get in contact with knote.</strong></div>
                                 <div class="answers-fields">
                                    <div class="form-group">
                                       <input type="text" class="form-control" name="fullname" id="" placeholder="Fullname"  />
                                    </div>
                                    <div class="form-group">
                                       <input type="email" class="form-control" name="email" id="" placeholder="Email Address"  />
                                    </div>
                                    <div class="form-row">
                                       <div class="form-group col-2 col-lg-2 col-xl-1">
                                          <input type="text" class="form-control" name="countrycode" id="country-code" value="+61" readonly="readonly" placeholder="+61">
                                       </div>

                                       <div class="form-group col-10 col-lg-10 col-xl-11">
                                          <input type="text" class="form-control" name="phone" id="" placeholder="Phone "  />
                                       </div>
                                    </div>
                                    {{-- 
                                    <div class="form-group">
                                       <input type="password" class="form-control" name="password" id="" placeholder="Password"  />
                                    </div>
                                    <div class="form-group">
                                       <input type="password" class="form-control" name="confirm_password" id="" placeholder="Confirm Password"  />
                                    </div> --}}
                                 </div>
                              </div>
                              <input type="hidden" name="page_url" value="{{ url()->current() }}" />
                              <input type="hidden" name="purpose_of_visit" value="0"  />
                              <input type="hidden" name="role_id" value="{{ $role_single->role_id }}"  />
                           </div>
                           <div class="col-12 col-lg-4 col-xl-3 text-right">
                              <div class="btn-next-previous">
                                    <span class="d-none previous arrow-icon previous-btn" id=""><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                                    <span class="next arrow-icon next-btn pull-right" id=""><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                              </div>
                           </div>
                        </div>
                        <div class="row qxt text-left">
                           <div class="col-lg-12 mt-lg-4">
                              <a href="{{ url('/') }}"><i class="fa fa-long-arrow-left"></i> BACK</a>
                           </div>      
                        </div>
                     </div>
                     
                     @endif
               @endforeach
            @endif
         </form>
         
         
      <div class="thank-you d-none animated fadeInDown" id="inquiry-thank-you">
		  <div class="your-call-back">
			  <h5>Your call-back request has been submmited.</h5>
			  <p>Our customer service team will be in touch as soon as possible To discuss your application. We’re open Mon – Fri, 8:00 AM until 7:00 PM AEST. </p>
		  </div>
		   <h5>When we call, we’ll be able to help you with:</h5>
		<ul>
		  <li>Any questions you have about Moula</li>
		  <li>What you’ll need to complete your application</li>
		  <li>Next steps to continue</li>
		</ul>
	  <p>We look forward to discussing your funding needs with you.</p>
	  </div>
	  
      
   </div>
</section>
<!-- #services -->
<section id="service-description-part">
   <div class="container">
      <div id="main-section-service-description" style="display: none;">
         <div class="close_btn">
            <a style="cursor:pointer; font-size: 32px;" onclick="return closeServiceSection()"><i class="fa fa-window-close"></i></a>
         </div>
         <div class="service_nav_btn">
            <div id="btn-knote-investor" class="ser-btn"><a style="cursor:pointer;" onclick="openService('knote-investor')">Investor</a></div>
            <div id="btn-knote-entrepreneurs" class="ser-btn"><a style="cursor:pointer;" onclick="openService('knote-entrepreneurs')">Entrepreneurs</a></div>
            <div id="btn-knote-loan" class="ser-btn"><a style="cursor:pointer;" onclick="openService('knote-loan')">Loan</a></div>
         </div>
         <div id="knote-investor" class="service-description" style="">
            <div class="row">
               <div class="col-lg-6 service-img">
                  <img src="{{ asset('user/img/service/investor.jpg')}}" alt="" />
               </div>
               <div class="col-lg-6 service-txt">
                  <div class="service-title">
                     <i class="fa fa-puzzle-piece"></i> 
                     <h2>KNote Investor</h2>
                  </div>
                  <div class="service-text">
                     <ul>
                        <li>
                           <div class="title">
                              <strong>1</strong>
                              <h3><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Set an investing goal</h3>
                           </div>
                           <div class="text">
                              <p>Before you even think to start investing, you should set some goals.</p>
                           </div>
                        </li>
                        <li>
                           <div class="title">
                              <strong>2</strong>
                              <h3><i class="fa fa-money" aria-hidden="true"></i> Open a brokerage account</h3>
                           </div>
                           <div class="text">
                              <p>An online brokerage account is going to be where you’ll do your trading and investing — and there are a LOT to choose from.</p>
                           </div>
                        </li>
                        <li>
                           <div class="title">
                              <strong>3</strong>
                              <h3><i class="fa fa-line-chart" aria-hidden="true"></i> Buy your first stock</h3>
                           </div>
                           <div class="text">
                              <p>The simplest way to narrow down the universe of stock options is to think of companies you like and use.</p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div id="knote-entrepreneurs" class="service-description" style="display: none;">
            <div class="row">
               <div class="col-lg-6 service-img">
                  <img src="{{ asset('user/img/service/entrepreneurs.jpg') }}" alt="" />
               </div>
               <div class="col-lg-6 service-txt">
                  <div class="service-title">
                     <i class="fa fa-file-text font-40"></i> 
                     <h2>KNote Entrepreneurs</h2>
                  </div>
                  <div class="service-text">
                     <ul>
                        <li>
                           <div class="title">
                              <strong>1</strong>
                              <h3><i class="fa fa-lightbulb-o" aria-hidden="true"></i> Thinking about Starting</h3>
                           </div>
                           <div class="text">
                              <p>The start-up phase is thinking, making plans, developing the right motivation to start and develop the aptitude to be an entrepreneur.</p>
                           </div>
                        </li>
                        <li>
                           <div class="title">
                              <strong>2</strong>
                              <h3><i class="fa fa-thumbs-up" aria-hidden="true"></i> Doing a Startup</h3>
                           </div>
                           <div class="text">
                              <p>The doing phase is the hardest, it’s the one all the famous entrepreneurs don’t talk about, it’s the part where you spend 18 hours a day, 7 days a week making this business inch forward to some form of success.</p>
                           </div>
                        </li>
                        <li>
                           <div class="title">
                              <strong>3</strong>
                              <h3><i class="fa fa-tree" aria-hidden="true"></i> Growing a Startup</h3>
                           </div>
                           <div class="text">
                              <p>The final stage is growth, personal growth, business growth, network growth and sales growth. This stage is normally post 36 months and it’s the point where the business model and relationships with suppliers is well established. </p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div id="knote-loan" class="service-description" style="display: none;">
            <div class="row">
               <div class="col-lg-6 service-img">
                  <img src="{{ asset('user/img/service/loan.jpg') }}" alt="" />
               </div>
               <div class="col-lg-6 service-txt">
                  <div class="service-title">
                     <i class="fa fa-briefcase"></i> 
                     <h2>Knote Loans</h2>
                  </div>
                  <div class="service-text">
                     <ul>
                        <li>
                           <div class="title">
                              <strong>1</strong>
                              <h3><i class="fa fa-laptop" aria-hidden="true"></i> Apply online</h3>
                           </div>
                           <div class="text">
                              <p>Take a few minutes to apply and receive a decision in principle within 24 hours</p>
                           </div>
                        </li>
                        <li>
                           <div class="title">
                              <strong>2</strong>
                              <h3><i class="fa fa-thumbs-up" aria-hidden="true"></i> Get approved</h3>
                           </div>
                           <div class="text">
                              <p>We'll review your application and get in touch with a decision in principal, often within 24 business hours.</p>
                           </div>
                        </li>
                        <li>
                           <div class="title">
                              <strong>3</strong>
                              <h3><i class="fa fa-money" aria-hidden="true"></i> Receive funding</h3>
                           </div>
                           <div class="text">
                              <p>After signing your financing agreement, your funding will be sent within hours</p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
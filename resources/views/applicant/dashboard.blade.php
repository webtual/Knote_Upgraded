@extends('layouts.user')
@section('title', 'Knote - Dashboard')
@section('content')


   <main id="main">
      <section id="services" class="pt-5">
         <div class="container">
            <div class="row">
               <div class="col-md-9">
                  <div class="section-header">
                     <h2>Dashboard</h2>
                  </div>

                  <div class="row border-bottom pb-2 mb-5">
                     @if(auth()->user()->applications()->count() != 0)

                        @foreach(auth()->user()->applications as $key => $application)
                           <div class="col-md-4">
                              <div class="box">
                                 <div class="d-flex mb-3">
                                    <div class="align-self-center mr-auto">
                                       <a href="{{ url('loan/edit/' . Crypt::encrypt($application->id)) }}">
                                          <strong>{{ $application->application_number }}</strong>
                                       </a>
                                    </div>
                                    <div class="align-self-center text-right knote-color">
                                       <span class="price"><strong>{{ $application->loan_request_amount() }}</strong></span>
                                    </div>
                                 </div>
                                 <div class="d-flex mt-3">
                                    <div class="align-self-center mr-auto status">
                                       <span>{{ $application->current_status->status }}</span>
                                    </div>
                                    <div class="align-self-center text-right">
                                       <span
                                          class="post-date text-muted">{{ display_date_format($application->created_at) }}</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        @endforeach

                     @endif

                  </div>
                  <div class="price-calculator" id="loan-calculator">
                     <div class="section-header">
                        <h2>Calculate your business loan repayments</h2>
                     </div>
                     <div class="row box">
                        <div class="col-md-6">
                           <form>
                              <div class="form-group">
                                 <label><strong>I would like to borrow</strong></label>
                                 <div class="input-group"> <span class="input-group-addon">$</span>
                                    <input id="loan_calc_amount" name="amount" class="form-control" value="20000"
                                       im-insert="true">
                                 </div>
                                 <div class="help-block text-muted">MIN $5,000 - MAX $500,000</div>
                              </div>
                              <div class="form-group">
                                 <label><strong>How long do you want the loan for?</strong></label>
                                 <div class="input-group input-group input-group-text-only col-md-6 col-xl-5 pl-0">
                                    <input id="loan_calc_term" name="amount" class="form-control" value="6"
                                       im-insert="true">
                                    <span class="input-group-addon"><strong>months</strong></span>
                                 </div>
                                 <div class="help-block text-muted">MIN $5,000 - MAX $500,000</div>
                              </div>
                              <div class="form-group">
                                 <label><strong>Your fortnightly interest rate</strong></label>
                                 <input type="hidden" id="loan_calc_interest" name="interest" value="1.5">
                                 <div class="row">
                                    <div class="col-4 col-md-3 mb-2">
                                       <button class="btn btn-primary btn-sm btn-block pt-2 pb-2"
                                          data-interest-rate="0.61"> <strong>0.61%</strong> </button>
                                    </div>
                                    <div class="col-4 col-md-3 mb-2">
                                       <button class="btn btn-primary btn-sm btn-block pt-2 pb-2"
                                          data-interest-rate="0.75"> <strong>0.75%</strong> </button>
                                    </div>
                                    <div class="col-4 col-md-3 mb-2">
                                       <button class="btn btn-primary btn-sm btn-block pt-2 pb-2" data-interest-rate="1">
                                          <strong>1%</strong> </button>
                                    </div>
                                    <div class="col-4 col-md-3 mb-2">
                                       <button class="btn btn-primary btn-sm btn-block pt-2 pb-2"
                                          data-interest-rate="1.25"> <strong>1.25%</strong> </button>
                                    </div>
                                    <div class="col-4 col-md-3 mb-2">
                                       <button class="btn btn-primary btn-sm btn-block pt-2 pb-2" data-interest-rate="1.5">
                                          <strong>1.5%</strong> </button>
                                    </div>
                                    <div class="col-4 col-md-3 mb-2">
                                       <button class="btn btn-primary btn-sm btn-block pt-2 pb-2"
                                          data-interest-rate="1.75"> <strong>1.75%</strong> </button>
                                    </div>
                                    <div class="col-4 col-md-3 mb-2">
                                       <button class="btn btn-primary btn-sm btn-block pt-2 pb-2" data-interest-rate="2">
                                          <strong>2%</strong> </button>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                        <div class="col-md-6">
                           <div class="total-repayment text-light text-center p-4 ml-0 ml-md-5">
                              <svg width="100px" height="100px" id="Layer_1" data-name="Layer 1"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 97.77 97.77">
                                 <defs>
                                    <style>
                                       .cls-1 {
                                          fill: #fff;
                                       }
                                    </style>
                                 </defs>
                                 <title>calculator</title>
                                 <path class="cls-1"
                                    d="M43.72,32.91H35.29V24.48a1.69,1.69,0,0,0-3.38,0v8.43H23.48a1.69,1.69,0,0,0,0,3.38h8.43v8.43a1.69,1.69,0,0,0,3.38,0V36.29h8.43a1.69,1.69,0,0,0,0-3.38Zm0,0"
                                    transform="translate(-8.31 -9.31)" />
                                 <path class="cls-1"
                                    d="M90.91,32.91H70.69a1.69,1.69,0,0,0,0,3.38H90.91a1.69,1.69,0,0,0,0-3.38Zm0,0"
                                    transform="translate(-8.31 -9.31)" />
                                 <path class="cls-1"
                                    d="M58.89,9.31H8.31v97.77h97.77V9.31Zm-47.2,3.38H55.51V56.51H11.69Zm0,91V59.89H55.51v43.83Zm91,0H58.89V59.89h43.83ZM58.89,56.51V12.69h43.83V56.51Zm0,0"
                                    transform="translate(-8.31 -9.31)" />
                                 <path class="cls-1"
                                    d="M70.69,88.55H90.91a1.69,1.69,0,0,0,0-3.38H70.69a1.69,1.69,0,0,0,0,3.38Zm0,0"
                                    transform="translate(-8.31 -9.31)" />
                                 <path class="cls-1"
                                    d="M70.69,78.43H90.91a1.69,1.69,0,1,0,0-3.37H70.69a1.69,1.69,0,1,0,0,3.37Zm0,0"
                                    transform="translate(-8.31 -9.31)" />
                                 <path class="cls-1"
                                    d="M43.22,72.18a1.7,1.7,0,0,0-2.38,0L33.6,79.42l-7.24-7.24a1.7,1.7,0,0,0-2.38,0,1.68,1.68,0,0,0,0,2.38l7.23,7.24L24,89a1.68,1.68,0,0,0,1.19,2.87,1.66,1.66,0,0,0,1.19-.49l7.24-7.23,7.24,7.23A1.68,1.68,0,0,0,43.22,89L36,81.8l7.23-7.24a1.68,1.68,0,0,0,0-2.38Zm0,0"
                                    transform="translate(-8.31 -9.31)" />
                              </svg>
                              <div class="mt-2">Total repayment <i class="fa fa-info-circle fa-1x ml-1"
                                    aria-hidden="true"></i></div>
                              <h2 class="mt-0">$22,606</h2>
                              <span class="label">Including total interest of: <span
                                    class="total-interest">$2,206</span></span> <i class="fa fa-info-circle fa-1x ml-1"
                                 aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></i>
                              <button type="submit" class="btn btn-light w-100 py-3 mt-2 knote-color" id="submit-contact">
                                 <i class="fa fa-spinner fa-spin fa-fw d-none"></i><strong>Get repayment
                                    schedule</strong></button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="section-header">
                     <a href="{{ url('loan/create') }}" class="btn btn-primary btn-lg border-0 mt-0 w-100 rounded">New Loan
                        Application</a>
                  </div>
                  <div class="guide-line">
                     <h5><strong>Guidelines</strong></h5>

                     <div class="border-bottom mb-3 pb-2">
                        <div class="d-inline-flex">
                           <i class="fa fa-file-pdf-o" aria-hidden="true
                                       "></i>
                           <div class="">
                              <h6 class="mb-0"> <strong>Document one</strong> </h6>
                              <time class="text-muted">30-01-2020</time>
                           </div>
                        </div>
                     </div>
                     <div class="border-bottom mb-3 pb-2">
                        <div class="d-inline-flex">
                           <i class="fa fa-file-pdf-o" aria-hidden="true
                                       "></i>
                           <div class="">
                              <h6 class="mb-0"> <strong>Document two </strong> </h6>
                              <time class="text-muted">30-01-2020</time>
                           </div>
                        </div>
                     </div>
                     <!--<div class="border-bottom mb-3 pb-2">-->
                     <!--   <div class="d-inline-flex">-->
                     <!--      <i class="fa fa-file-pdf-o" aria-hidden="true-->
                     <!--         "></i>-->
                     <!--      <div class="">-->
                     <!--         <h6 class="mb-0"> <strong>Document three</strong> </h6>-->
                     <!--         <time class="text-muted">30-01-2020</time>-->
                     <!--      </div>-->
                     <!--   </div>-->
                     <!--</div>-->
                     <!--<div class="border-bottom mb-3 pb-2">-->
                     <!--   <div class="d-inline-flex">-->
                     <!--      <i class="fa fa-file-pdf-o" aria-hidden="true-->
                     <!--         "></i>-->
                     <!--      <div class="">-->
                     <!--         <h6 class="mb-0"> <strong>Document three</strong> </h6>-->
                     <!--         <time class="text-muted">30-01-2020</time>-->
                     <!--      </div>-->
                     <!--   </div>-->
                     <!--</div>-->
                     <!--<div class="border-bottom mb-3 pb-2">-->
                     <!--   <div class="d-inline-flex">-->
                     <!--      <i class="fa fa-file-pdf-o" aria-hidden="true-->
                     <!--         "></i>-->
                     <!--      <div class="">-->
                     <!--         <h6 class="mb-0"> <strong>Document three</strong> </h6>-->
                     <!--         <time class="text-muted">30-01-2020</time>-->
                     <!--      </div>-->
                     <!--   </div>-->
                     <!--</div>-->
                     <!--<div class="border-bottom mb-3 pb-2">-->
                     <!--   <div class="d-inline-flex">-->
                     <!--      <i class="fa fa-file-pdf-o" aria-hidden="true-->
                     <!--         "></i>-->
                     <!--      <div class="">-->
                     <!--         <h6 class="mb-0"> <strong>Document three</strong> </h6>-->
                     <!--         <time class="text-muted">30-01-2020</time>-->
                     <!--      </div>-->
                     <!--   </div>-->
                     <!--</div>-->

                  </div>
               </div>
            </div>
         </div>
      </section>



   </main>


@endsection
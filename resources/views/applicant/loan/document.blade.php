@extends('layouts._comman')
@section('title', 'Create New Loan Application - Knote')
@section('styles')
   @if(request()->is('loan*'))
      <link href="{{ cached_asset('comman/css/loan-application.css') }}" rel="stylesheet">
      <link href="{{ asset('comman/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
      {{--
      <link href="{{ asset('comman/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" /> --}}
   @endif

@endsection
@section('content')

   <div class="content">
      <!-- Start Content-->
      <div class="container-fluid document-page">
         <div class="row mt-4">
            <div class="col-lg-5 col-xl-3 cu-applisidebar cleft">
               <div class="card-box color-knote">
                  <h3 class="text-white text-uppercase">Start application</h3>
                  <div class="tab-content">
                     @include('partials.comman.loan.leftsidebar')
                  </div>
               </div>

            </div>
            <div class="col-md-7 col-xl-6">
               <div class="card-box">
                  <h3>Document</h3>
                  <div class="tab-content pt-0">
                     <div class="tab-pane active" id="settings">
                        <form action="{{ url()->current() }}" id="loan-application-four" name="loan-application-four"
                           method="post" onsubmit="return false;">

                           @php
                              $document_types = config('constants.document_types');
                              if ($application->apply_for == 1) {
                                 unset($document_types['3']);
                              }
                           @endphp

                           @foreach($document_types as $key => $value)
                              <div class="row mt-{{ ($key == 0) ? 0 : 3 }}">
                                 <div class="col-12">
                                    <div class="card">
                                       <div class="card-body border">
                                          <h4 class="header-title">{{ $value }}
                                             {!! ($value == "Proof of Identity") ? '<span class="text-danger">*</span>' : '' !!}
                                          </h4>
                                          <div class="input-group">
                                             <div class="custom-file">
                                                <input type="file" class="custom-file-input upload-documents" id="{{ $key }}"
                                                   multiple="multiple" accept="application/pdf, image/*"
                                                   data-pdf-placeholder="{{ asset('storage/document/pdf-placeholder.png') }}">
                                                <label class="custom-file-label" for="">Choose file</label>
                                             </div>
                                          </div>

                                          @if($value == "Proof of Identity")
                                             <div class="mt-2">
                                                <p class="mb-0"><b>Example:</b></p>
                                                <p class="mb-0"><b>Must one of them:</b> Driving licence ,Passport</p>
                                                <p class="mb-0"><b>Supporting:</b> Medicare and any Gov Card</p>
                                             </div>
                                          @endif

                                       </div>
                                    </div>
                                 </div>
                              </div>


                              <div class="row gallery" id="position-{{ $key }}">
                                 @if(!empty($application->get_documents_by_type($key)))
                                    @foreach($application->get_documents_by_type($key) as $document)
                                       <div class="col-3 fetch-documents">
                                          <div class="item">
                                             <input type="hidden" name="image[]" value="{{ $document->file }}">
                                             <input type="hidden" name="document_type[]" value="{{ $document->type }}">
                                             @php
                                                $ext = pathinfo(asset('storage/' . $document->file), PATHINFO_EXTENSION);
                                               @endphp
                                             @if($ext == 'pdf')
                                                <a href="{{ asset('storage/' . $document->file) }}" target="blank">
                                                   <img class="rounded" src="{{ asset('storage/document/pdf-placeholder.png') }}">
                                                </a>
                                             @else
                                                <img class="rounded" src="{{ asset('storage/' . $document->file) }}">
                                             @endif
                                             <p class="hard-remove-document-image text-left font-20" data-id="{{ $document->id }}"
                                                data-url="{{ url('loan/create/document/delete') }}"
                                                data-application-id="{{ $document->application_id }}">
                                                <i class="mdi mdi-delete-outline"></i>
                                             </p>
                                          </div>
                                       </div>
                                    @endforeach
                                 @endif
                              </div>

                           @endforeach
                           <input type="hidden" name="application_id" value="{{ $application->id }}">

                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Add Exit Strategy and Brief Notes ( What’s the loan for , give us a
                                       little background of requirement and proposal)<span
                                          class="text-danger">*</span></label>
                                    <textarea name="brief_notes" class="form-control" id="brief_notes"
                                       placeholder="Add Exit Strategy and Brief Notes">{{ ($application) ? $application->brief_notes : '' }}</textarea>
                                 </div>
                              </div>
                           </div>

                           @if($enc_id == "")
                              <div class="text-center">
                                 <a href="{{ route('loan.create.finance') }}"
                                    class="btn btn-light waves-effect waves-light mt-2"><i class="fe-arrow-left"></i>&nbsp;
                                    Previous
                                 </a>
                                 <button type="submit" data-url="{{ url()->current() }}"
                                    data-redirect="{{ url('loan/create/review') }}" id="pr-four"
                                    class="btn btn-success waves-effect waves-light mt-2 ml-2">Next<span
                                       class="btn-label-right"><i class="fe-arrow-right"></i></span></button>
                              </div>
                           @else
                              <div class="text-center">
                                 <a href="{{ url('loan/edit/finance/' . $enc_id) }}"
                                    class="btn btn-light waves-effect waves-light mt-2"><i class="fe-arrow-left"></i>&nbsp;
                                    Previous
                                 </a>
                                 <button type="submit" data-url="{{ url('loan/create/document') }}"
                                    data-redirect="{{ url('loan/edit/review/' . $enc_id) }}" id="pr-four"
                                    class="btn btn-success waves-effect waves-light mt-2 ml-2">Next<span
                                       class="btn-label-right"><i class="fe-arrow-right"></i></span></button>
                              </div>
                           @endif

                        </form>
                     </div>
                     <!-- end settings content-->
                  </div>
                  <!-- end tab-content -->
               </div>
            </div>
            <div class="col-md-7 col-xl-3 cu-applisidebar cright">
               @include('partials.comman.loan.right_cardbox', ['application' => $application])
            </div>
         </div>
      </div>
      <!-- container -->
   </div>

@endsection
@section('scripts')
   @if(request()->is('loan*'))
      <script src="{{ asset('comman/js/pages/ion.rangeSlider.min.js') }}"></script>



   @endif
@endsection
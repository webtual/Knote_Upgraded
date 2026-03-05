<div class="modal fade edit_document_model" id="edit_document_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="gocover_modal" style="background: url({{ asset('loader.gif') }}) center center no-repeat scroll rgba(45, 45, 45, 0.5); display: none;"></div>
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @php
                $application_id = $application->id;
            @endphp
            <div class="modal-body loan-form-page">
                <form action="{{ route('loan.details.update.document') }}" name="form_document_edit" id="form_document_edit" method="post" onsubmit="return false;" enctype="multipart/form-data">
                    
                    <input type="hidden" id="user_id" name="user_id" value="{{$application->user_id}}">
                    <input type="hidden" name="application_id" value="{{ ($application) ? $application->id : '' }}">
                    <input type="hidden" name="apply_for" value="{{ ($application) ? $application->apply_for : '1' }}">
                    
                    <div class="row document-page">
                            @php
                            $document_types = config('constants.document_types');
                                if($application->apply_for == 1){
                                    unset($document_types['3']);
                                }
                            @endphp
                            
                            <div class="col-lg-12">
                                @foreach($document_types as $key => $value)
                                    <div class="row mt-{{ ($key == 0) ? 0 : 3 }}">
                                       <div class="col-12">
                                          <div class="card">
                                             <div class="card-body border">
                                                <h4 class="header-title">{{ $value }} {!! ($value == "Proof of Identity") ? '<span class="text-danger">*</span>' : '' !!}</h4>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-documents" id="{{ $key }}" multiple="multiple" accept="application/pdf, image/*" data-pdf-placeholder="{{ asset('storage/document/pdf-placeholder.png') }}">
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
        
                              
                                    <div class="row gallery loanapplication" id="position-{{ $key }}">
                                        @if(!empty($application->get_documents_by_type($key)))
                                          @foreach($application->get_documents_by_type($key) as $document)
                                            <div class="position-relative col-3 fetch-documents">
                                              <div class="item">
                                                  <input type="hidden" name="image[]" value="{{ $document->file }}"
                                                  >
                                                  <input type="hidden" name="document_type[]" value="{{ $document->type }}">
                                                  @php
                                                  $ext = pathinfo(asset('storage/'.$document->file), PATHINFO_EXTENSION);
                                                  @endphp
                                                  @if($ext == 'pdf')
                                                  <a href="{{ asset('storage/'.$document->file) }}" target="blank">
                                                    <img class="rounded" src="{{ asset('storage/document/pdf-placeholder.png') }}">
                                                  </a>
                                                  @else
                                                  <img class="rounded" src="{{ asset('storage/'.$document->file) }}">
                                                  @endif
                                                  <p class="hard-remove-document-image-new text-left font-20" data-id="{{ $document->id }}" data-url="{{ url('admin/loan/details/document/delete') }}" data-application-id="{{ $document->application_id }}" >
                                                    <i class="mdi mdi-delete-outline"></i>
                                                  </p>
                                              </div>
                                            </div>
                                          @endforeach
                                        @endif
                                    </div>
                                 
                                @endforeach
                            </div>                            
                        </div>
                        
                    <div class="text-right">
                        <button type="submit" class="btn btn-success mr-2" id="form_document_edit_btn">Update</button>
                        <button type="button" class="btn btn-info mr-2" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
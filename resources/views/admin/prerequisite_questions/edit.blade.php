@extends('layouts._comman')
@section('title', 'Prerequisite Questions - Knote')
@section('styles')
@endsection
@section('content')
<div class="content">
<!-- Start Content-->
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <div class="page-title-box">
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item active">Prerequisite Question</li>
               </ol>
            </div>
            <h4 class="page-title">Edit Prerequisite Question</h4>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-lg-8">
         <form action="{{ url()->current() }}" id="prerequisite-question-form" name="prerequisite-question-form" method="post" onsubmit="return false;" enctype="multipart/form-data">
            <div class="card-box">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="">Role<span class="text-danger">*</span></label>
                        <select class="custom-select selectpicker " name="role">
                           <option value="">Select..</option>
                           @foreach($roles as $key => $role)
                           <option value="{{ $role->id }}" {{ ($question->role_id == $role->id) ? 'selected' : '' }}>{{ $role->role_name }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="">Question Title<span class="text-danger">*</span></label>
                        <input type="text" id="" name="question_title" value="{{ $question->title }}" class="form-control" placeholder="Question Title">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="">Field Type<span class="text-danger">*</span></label>
                        <select class="custom-select selectpicker " name="field_type">
                           <option value="">Select..</option>
                           @foreach(config('constants.field_types') as $key => $field_type)
                           <option value="{{ $field_type }}" {{ ($question->type == $field_type) ? 'selected' : '' }}>{{ ucfirst($field_type) }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>

               <div class="row {{ ($question->question_answers->count() == 0) ? 'd-none' : '' }}">
                  <div class="col-md-12">

                     <fieldset id="input-box">
                        @if($question->question_answers->count() != 0)
                           @foreach($question->question_answers as $key => $qs)
                              <div class="row">
                                 <div class="col-10">
                                    <div class="input-field form-group mb-3">
                                       <input type="text" name="answer_text[]" class="form-control" placeholder="Answer Text" value="{{ $qs->answer_text }}">
                                    </div>
                                 </div>
                                 <div class="col">
                                    <div class="text-left">
                                       <button class="remove btn btn-xs btn-danger mt-1"><i class="mdi mdi-minus"></i></button>
                                       <button class="add_more btn btn-xs btn-info mt-1 ml-1 {{ ($loop->last) ? '' : 'd-none' }}"><i class="mdi mdi-plus"></i></button>
                                    </div>
                                 </div>
                              </div>
                           @endforeach
                        @endif
                     </fieldset>
                     
                  </div>
               </div>
               
               <hr>
               <button class="btn btn-primary mt-3" type="submit" id="prerequisite-question-update">Submit</button>
               <button type="reset" class="btn btn-secondary mt-3 ml-2">Cancel</button>
            </div>
         </form>
         <!-- end card-box -->
      </div>
      <div class="col-lg-4">
         <div class="card-box">
            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Guidlines</h5>
            <div class="card slimscroll" style="max-height: 450px !important;">
               
            </div>
         </div>
      </div>
   </div>
   <!-- container -->
</div>


@endsection
@section('scripts')
<script type="text/javascript">
   $('select[name="field_type"]').change(function(){
      var field_type = $(this).val();
      if(field_type != 'input'){
         $(this).closest(".row").next().removeClass('d-none');  
      }else{
         $(this).closest(".row").next().addClass('d-none');
      }
   });
  
   
   $("form").on("click",".add_more", function(){
      var clone_div = $('#input-box').children('.row:first').html();
      $('#input-box').append('<div class="row">'+clone_div+'</div>');
      $('.remove').removeClass('d-none');
      $('.add_more').addClass('d-none').last().removeClass('d-none');
      $('#input-box').children('.row:last').find('input').val('');
      return false; 
   });

   $('#input-box').on('click', '.remove', function() {
      $(this).closest('.row').remove();
      $('.add_more').addClass('d-none').last().removeClass('d-none');
      var count_total_div = $('#input-box').find('.row').length;
      if(count_total_div == 1){
         $('.remove').first().addClass('d-none');
      }
      return false; 
   });

   $('#prerequisite-question-update').click(function(){
      var url = $('#prerequisite-question-form').attr('action');
      $.ajax ({
          type: 'PUT',
          url: url,
          async: false,
          data: $('#prerequisite-question-form').serialize(),
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success : function(response) {
            toaserMessage(response.status, response.message);
          },
          error: function (reject) {
              if( reject.status === 422 ) {
                  var errors = $.parseJSON(reject.responseText);
                  var errors = errors['errors'];
                  toaserMessage(422, Object.values(errors)[0]);
              }
          }
      }); 
   });
</script>
@endsection
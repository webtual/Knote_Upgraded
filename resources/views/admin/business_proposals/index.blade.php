@extends('layouts._comman')
@section('title', 'Business Proposals - Knote')
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
                     <li class="breadcrumb-item active">Business Proposals</li>
                  </ol>
               </div>
               <h4 class="page-title">Business Proposals ({{ App\BusinessProposal::count() }})</h4>
            </div>
         </div>
      </div>
      @include('partials.comman.alert.message')
      <div class="row">
         <div class="col-lg-12">
            <div class="search-result-box m-t-30 card-box">
               <div class="row">
                  <div class="col-md-8 offset-md-2">
                     <div class="pt-3 pb-4">
                        <form>
                           <div class="form-row align-items-center">
                              <div class="col-3">
                                 <label class="sr-only" for="inlineFormInput">Business Categories</label>
                                 <select class="form-control" name="category">
                                    <option value="">Business Categories</option>
                                    @foreach($business_types as $key => $bs)
                                    <option value="{{ $bs->id }}">{{ $bs->business_type }}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="col-7">
                                 <label class="sr-only" for="inlineFormInputGroup">Keyword</label>
                                 <input type="text" name="keyword" class="form-control" value="" placeholder="Keyword">
                              </div>
                              <button type="button" class="btn waves-effect waves-light btn-blue" id="filter-business-proposal-admin"><i class="fa fa-search mr-1"></i> Search</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12">
            <ul class="nav nav-tabs nav-bordered float-right">
               <li class="nav-item">
                  <a href="#grid-view" data-view="grid-view" data-toggle="tab" aria-expanded="false" class="nav-link active">
                  <i class="mdi mdi-grid"></i>
                  </a>
               </li>
               <li class="nav-item">
                  <a href="#list-view" data-view="list-view" data-toggle="tab" aria-expanded="true" class="nav-link">
                  <i class="fe-align-left"></i>
                  </a>
               </li>
            </ul>
         </div>
      </div>
      <div class="tab-content bs-list">
         <div class="tab-pane active" id="grid-view">
            <div class="row" id="my-list">
               @if(!empty($business_proposals))
               @foreach($business_proposals as $bs)
               <div class="col-xl-4 ad-id" id="{{ $bs->id }}">
                  @include('partials.comman.block.business_proposal', ['bs' => $bs])
               </div>
               @endforeach
               @endif
            </div>
         </div>
         <div class="tab-pane " id="list-view">
            <div class="row" id="my-list">
               @if(!empty($business_proposals))
               @foreach($business_proposals as $bs)
               <div class="col-xl-12 ad-id" id="{{ $bs->id }}">
                  @include('partials.comman.block.business_proposal_list', ['bs' => $bs])
               </div>
               @endforeach
               @endif
            </div>
         </div>
         <div class="row mb-5 d-none" id="my-loadmore">
            <div class="col-md-12">
               <div class="text-center">
                  <a href="javascript:;" id="admin-bs-loadmore" data-url="{{ url()->current() }}" class="text-success font-18 "><i class="mdi mdi-spin mdi-loading mr-1 my-loader d-none"></i> LoadMore </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
<script  type="text/javascript">
  $(".bs-list").on("click",".update-status-bs", function(){
    var url = $(this).attr('data-url');
    var text = $(this).text();
    $(this).closest('.btn-group').find('button').html(text+' <i class="mdi mdi-chevron-down"></i>');

    $.ajax ({
       type: 'GET',
       url: url,
       async: false,
       data: '',
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



   $('#filter-business-proposal-admin').click(function(){
      filter_business_proposal_admin();
   });
   
   $('#admin-bs-loadmore').click(function(){
      var active_list = $('ul.nav').find('a.active').attr('href');
      var id = $(active_list).find('.ad-id:last').attr('id');
      filter_business_proposal_admin(id, active_list);
   });
   
   function filter_business_proposal_admin(id=""){
      var active_list = $('ul.nav').find('a.active').attr('href');
       var category = $('select[name="category"]').val();
       var keyword = $('input[name="keyword"]').val();
       var url = $('#admin-loadmore').attr('data-url');
       $.ajax ({
           type: 'POST',
           url: url,
           async: false,
           data: {category:category, keyword:keyword, id:id, active_list:active_list},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success : function(response) {
               if(response.status == 201){
                   if(id == ""){
                       $(active_list).find('#my-list').empty();
                       $(active_list).find('#my-list').append(response.data).hide().fadeIn(700);
                   }else{
                        if(active_list == '#list-view'){
                           $(response.data).insertAfter(".col-xl-12:last").hide().fadeIn(700);
                        }else{
                           $(response.data).insertAfter(".col-xl-4:last").hide().fadeIn(700);    
                        }
                   }
               }else{
                   toaserMessage(response.status, response.message);
               }
           },
           error: function (reject) {
               if( reject.status === 422 ) {
                   var errors = $.parseJSON(reject.responseText);
                   var errors = errors['errors'];
                   toaserMessage(422, Object.values(errors)[0]);
               }
           }
       }); 
   }
   
</script>
@endsection
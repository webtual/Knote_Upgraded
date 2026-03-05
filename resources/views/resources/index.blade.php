@extends('layouts._comman')
@section('title', 'Resources - Knote')
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
                     <li class="breadcrumb-item active">Resources</li>
                  </ol>
               </div>
               <h4 class="page-title">Resources</h4>
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
                                 <label class="sr-only" for="inlineFormInput">Resource Categories</label>
                                 <select class="form-control" name="category">
                                    <option value="">Resource Categories</option>
                                    @foreach($business_types as $key => $bs)
                                    <option value="{{ $bs->id }}">{{ $bs->business_type }}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="col-7">
                                 <label class="sr-only" for="inlineFormInputGroup">Keyword</label>
                                 <input type="text" name="keyword" class="form-control" value="" placeholder="Keyword">
                              </div>
                              <button type="button" class="btn waves-effect waves-light btn-blue" id="filter-resource"><i class="fa fa-search mr-1"></i> Search</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      

      <div class="tab-content resource-list">
         <div class="tab-pane active" id="all">
            <div class="row" id="my-list">
               @if(!empty($resources))
                  @foreach($resources as $resource)
                  <div class="col-xl-4" id="{{ $resource->id }}">
                     @include('partials.comman.block.resource', ['resource' => $resource])
                  </div>
                  @endforeach
               @endif 
            </div>

            @if($resources->count() >= 9)
            <div class="row mb-5 d-none" id="my-loadmore">
               <div class="col-md-12">
                  <div class="text-center">
                     <a href="javascript:;" id="resource-loadmore" data-url="{{ url()->current() }}"  class="text-success font-18 "><i class="mdi mdi-spin mdi-loading mr-1 my-loader d-none"></i> LoadMore </a>
                  </div>
               </div>
            </div>
            @endif


         </div>
      </div>

   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
@endsection
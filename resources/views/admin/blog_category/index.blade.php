@extends('layouts._comman')
@section('title', 'Blog Categories - Knote')
@section('styles')
<!-- Footable css -->
<link href="{{ asset('comman/libs/footable/footable.core.min.css') }}" rel="stylesheet" type="text/css" />
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
                     <li class="breadcrumb-item active">Blog Categories</li>
                  </ol>
               </div>
               <h4 class="page-title">Blog Categories </h4>
            </div>
         </div>
      </div>

      @include('partials.comman.alert.message')
      
      <div class="row">
          <div class="col-12">
              <div class="card-box">
                 
                  <div class="mb-2">
                      <div class="row">
                          <div class="col-10 text-sm-center form-inline">
                              
                              <div class="form-group">
                                  <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                              </div>
                          </div>
                          <div class="col-2 text-right ">
                            <strong>Count : <span id="record-count"> {{ $blog_categories->count() }}</span></strong>
                         </div>
                      </div>
                  </div>
                  
                  <div class="table-responsive">
                      <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                          <thead>
                          <tr>
                              <th width="6%" data-sort-ignore="true">SrNo</th>
                              <th data-toggle="true">Category</th>
                              <th data-toggle="true" width="10%">CreatedAt</th>
                              <th width="8%" data-sort-ignore="true">Action</th>
                              
                          </tr>
                          </thead>
                          <tbody>

                          @foreach($blog_categories as $key => $value)
                          <tr>
                              <td>{{ $key + 1 }}</td>
                              <td>{{ $value->name }}</td>
                              <td>{{ display_date_format($value->created_at) }}</td>
                              <td>

                                <form action="{{url('admin/blog-category/'.$value->id)}}" class="cu-inline-block" method="POST">
                                  {{ method_field('DELETE') }}
                                  {{ csrf_field() }}
                                 
                                </form>
                                <a href="{{ url('admin/blog-category/'.$value->slug().'/edit') }}" class="action-icon " title="Edit" > <i class="fe-edit"></i></a>
                                <a href="javascript:;" title="Delete" class="action-icon del-confirm" > <i class="mdi mdi-delete"></i></a>
                               

                              </td>
                          </tr>
                          @endforeach
                          
                          </tbody>
                          <tfoot>
                          <tr class="active">
                              <td colspan="7">
                                  <div class="text-right">
                                      <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                  </div>
                              </td>
                          </tr>
                          </tfoot>
                      </table>
                  </div> 
              </div> 
          </div> 
      </div>
      
   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')

<!-- Footable js -->
<script src="{{ asset('comman/libs/footable/footable.all.min.js') }}"></script>

<!-- Init js -->
<script src="{{ asset('comman/js/pages/foo-tables.init.js') }}"></script>

@endsection
@extends('layouts._comman')
@section('title', 'Contact Inquiry - Knote')
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
                     <li class="breadcrumb-item active">Contact Inquiry</li>
                  </ol>
               </div>
               <h4 class="page-title">Contact Inquiry </h4>
            </div>
         </div>
      </div>

      @include('partials.comman.alert.message')
      
      <div class="row">
          <div class="col-12">
              <div class="card-box">
                  {{-- <h4 class="header-title">Filtering</h4>
                  <p class="sub-header">
                      include filtering in your FooTable.
                  </p> --}}

                  <div class="mb-2">
                      <div class="row">
                          <div class="col-10 text-sm-center form-inline">
                              <div class="form-group mr-2" style="display: none !important;">
                                  <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                      <option value="">Show all</option>
                                      <option value="active">Active</option>
                                      <option value="disabled">Disabled</option>
                                      <option value="suspended">Suspended</option>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                              </div>
                          </div>
                          <div class="col-2 text-right ">
                            <strong>Count : <span id="record-count"> {{ $contacts->count() }}</span></strong>
                         </div>
                      </div>
                  </div>
                  
                  <div class="table-responsive">
                      <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                          <thead>
                          <tr>
                              <th data-sort-ignore="true">SrNo</th>
                              <th data-toggle="true">Name</th>
                              <th data-toggle="true">Email</th>
                              <th data-toggle="true">Phone</th>
                              <th >Message</th>
                              <th data-toggle="true">CreatedAt</th>
                              <th data-sort-ignore="true">Action</th>
                              
                          </tr>
                          </thead>
                          <tbody>

                          @foreach($contacts as $key => $value)
                          <tr>
                              <td>{{ $key + 1 }}</td>
                              <td>{{ $value->name }}</td>
                              <td>{{ $value->email }}</td>
                              <td>{{ $value->contact }}</td>
                              <td>{{ $value->message }}</td>
                              <td>{{ display_date_format($value->created_at) }}</td>
                              <td>
                                <form action="{{url('admin/contact-inquiry/'.$value->id)}}" class="cu-inline-block" method="POST">
                                  {{ method_field('DELETE') }}
                                  {{ csrf_field() }}
                                  <a href="javascript:;" title="Delete" class="action-icon del-confirm" > <i class="mdi mdi-delete"></i></a>
                                </form>
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
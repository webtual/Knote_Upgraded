@extends('layouts._comman')
@section('title', 'Categories - Knote')
@section('styles')
   <!-- Footable css -->
   <link href="{{ asset('comman/libs/footable/footable.core.min.css') }}" rel="stylesheet" type="text/css" />
   <link href="{{ asset('comman/libs/custombox/custombox.min.css') }}" rel="stylesheet" type="text/css" />
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
                        <li class="breadcrumb-item active">Categories</li>
                     </ol>
                  </div>
                  <h4 class="page-title">Categories </h4>
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
                           <div class="form-group mr-2">
                              <select id="demo-foo-filter-status" class="custom-select custom-select-sm cu-foo-count">
                                 <option value="" data-count={{ $business_types->count() }}>Show all</option>
                              </select>
                           </div>
                           <div class="form-group">
                              <input id="demo-foo-search" type="text" placeholder="Search"
                                 class="form-control form-control-sm" autocomplete="on">
                           </div>
                        </div>
                        <div class="col-2 text-right ">
                           <strong>Count : <span id="record-count"> {{ $business_types->count() }}</span></strong>
                        </div>
                     </div>
                  </div>
                  <div class="table-responsive">
                     <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="10">
                        <thead>
                           <tr>
                              <th data-sort-ignore="true">SrNo</th>
                              <th data-toggle="true">Categories</th>
                              <th data-toggle="true">Type</th>
                              <th data-toggle="true">CreatedAt</th>
                              <th data-sort-ignore="true">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($business_types as $key => $value)
                              <tr>
                                 <td>{{ $key + 1 }}</td>
                                 <td>{{ $value->business_type }}</td>
                                 <td>---</td>
                                 <td>{{ display_date_format($value->created_at) }}</td>
                                 <td>
                                    <form action="{{url('admin/business-type/' . $value->id)}}" class="cu-inline-block"
                                       method="POST">
                                       {{ method_field('DELETE') }}
                                       {{ csrf_field() }}

                                       <a href="javascript:;" class="action-icon edit-business-types"
                                          data-id="{{ $value->id }}" data-name="{{ $value->business_type }}"
                                          data-type="{{ $value->type }}" title="Edit"> <i class="fe-edit"></i></a>
                                       <a href="javascript:;" title="Delete" class="action-icon del-confirm"> <i
                                             class="mdi mdi-delete"></i></a>
                                    </form>



                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                           <tr class="active">
                              <td colspan="5">
                                 <div class="text-right">
                                    <ul
                                       class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0">
                                    </ul>
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


   <div id="custom-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
      style="display: none;" aria-hidden="true">
      <div class="modal-dialog">
         <form action="{{ url('admin/business-type/create') }}" method="post" role="form" class="business-types-form"
            onsubmit="return false;" data-redirect-url="{{ url('admin/business-proposals/categories') }}">
            @csrf
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Categories</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                  <div class="card-box">
                     <div class="form-group mb-1">
                        <label for="">Name<span class="text-danger">*</span></label>
                        <input type="text" id="" name="name" value="" class="form-control" placeholder="Name">
                     </div>
                     @if(Route::currentRouteName() == 'bt.create')
                        <input type="hidden" id="type" name="type" value="1">
                     @elseif(Route::currentRouteName() == 'r.create')
                        <input type="hidden" id="type" name="type" value="2">
                     @else
                     @endif
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary waves-effect waves-light"
                     id="submit-business-type">Submit</button>
               </div>
            </div><!-- /.modal-content -->
         </form>
      </div><!-- /.modal-dialog -->
   </div>


@endsection
@section('scripts')
   <!-- Footable js -->
   <script src="{{ asset('comman/libs/footable/footable.all.min.js') }}"></script>
   <!-- Init js -->
   <script src="{{ asset('comman/js/pages/foo-tables.init.js') }}"></script>
   <!-- Modal-Effect -->
   <script src="{{ asset('comman/libs/custombox/custombox.min.js') }}"></script>
   <script type="text/javascript">
      var type = $("#demo-foo-filter-status").find(":selected").val();
      var count = $("#demo-foo-filter-status").find(":selected").attr('data-count');
      if ((type != "") || (type != undefined))
         $(window).on("load", function () {
            $('.footable').trigger('footable_filter', { filter: type });
         })
      $('#record-count').text(count);

      if ($('#type').length != 0) {
         $('#custom-modal').modal('show');
      }

      $('.edit-business-types').click(function () {
         var id = $(this).attr('data-id');
         var name = $(this).attr('data-name');
         var type = $(this).attr('data-type');

         $('input[name="name"]').val(name);
         if ($('#type').length != 0) {
            $('input[name="type"]').val(type);
            $('input[name="id"]').val(id);
         } else {
            $('.modal-body').append('<input type="hidden" id="type" name="type" value="' + type + '"><input type="hidden" name="id" value="' + id + '">');
         }

         $('#custom-modal').modal('show');

      });

   </script>
@endsection
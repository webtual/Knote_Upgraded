@extends('layouts._comman')
@section('title', 'Assistants - Knote')
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
                     <li class="breadcrumb-item active">Assistants</li>
                  </ol>
               </div>
               <h4 class="page-title">Assistants</h4>
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
                        <strong>Count : <span id="record-count"> {{ $users->count() }}</span></strong>
                     </div>

                  </div>
               </div>
               <div class="table-responsive">
                  <table id="demo-foo-filtering" class="table mb-0 table-bordered toggle-arrow-tiny" data-page-size="10" >
                     <thead>
                        <tr>
                           <th data-sort-ignore="true" width="5%">SrNo</th>
                           <th data-toggle="true">Name</th>
                           <th data-toggle="true" width="10%">Phone</th>
                           <th data-toggle="true" width="10%">Email Address</th>
                           <th data-hide="all"> Address </th>
                           <th data-toggle="true" width="10%">CreatedAt</th>
                           <th data-sort-ignore="true" width="8%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($users as $key => $user)
                        <tr>
                           <td>
                              {{ $key+1 }}
                           </td>
                           <td class="table-user">
                              <img src="{{ asset('storage/'.$user->avtar) }}" alt="table-user" class="mr-2 rounded-circle"> {{ $user->name }}
                           </td>
                           <td>
                              {{ $user->phone }}
                           </td>
                           <td>
                              {{ $user->email }}
                           </td>
                           <td>
                              {{ $user->address }}
                           </td>
                           <td>
                              {{ display_date_format($user->created_at) }}
                           </td>
                           <td>
                              <a href="{{ url('admin/user/delete/'.$user->id) }}" class="action-icon del-confirm" title="Delete" > <i class="fe-trash"></i></a>

                              <!--<a href="javascript:;" title="Change Password" class="action-icon "> <i class="mdi mdi-key-variant"></i></a>-->
                              
                              <a href="javascript:;" title="Edit" class="action-icon "> <i class="mdi mdi-square-edit-outline"></i></a>
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
@endsection
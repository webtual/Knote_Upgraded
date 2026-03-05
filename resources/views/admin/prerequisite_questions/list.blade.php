@extends('layouts._comman')
@section('title', 'Prerequisite Questions - Knote')
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
                     <li class="breadcrumb-item active">Prerequisite Question</li>
                  </ol>
               </div>
               <h4 class="page-title">Prerequisite Question</h4>
            </div>
         </div>
      </div>
      @include('partials.comman.alert.message')
      <div class="row">
         <div class="col-12">
            <div class="card-box ribbon-box">
              {{--  <div class="ribbon ribbon-secondary float-left"><i class="fe-users mr-1"></i> Users</div> --}}
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
                        <strong>Count : <span id="record-count"> {{ $questions->count() }}</span></strong>
                     </div>

                  </div>
               </div>
               <div class="table-responsive">
                  <table id="demo-foo-filtering" class="table mb-0 table-bordered toggle-arrow-tiny" data-page-size="10" >
                     <thead>
                        <tr>
                           <th data-sort-ignore="true" width="5%">SrNo</th>
                           <th data-toggle="true">Role</th>
                           <th data-toggle="true">Field Type</th>
                           <th data-toggle="true">Question Title</th>
                           <th data-hide="all"> Answer Text </th>
                           <th data-toggle="true" width="10%">CreatedAt</th>
                           <th data-sort-ignore="true" style="width: 82px;" width="5%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($questions as $key => $question)
                        <tr>
                           <td>
                              {{ $key+1 }}
                           </td>
                           <td>
                              {{ $question->role->role_name }}
                           </td>
                           <td>
                              {{ ucfirst($question->type) }}
                           </td>
                           <td>
                              {{ $question->title }}
                           </td>
                           <td>
                              @if($question->type != 'input')
                                 @php
                                 $count = ($question->question_answers->count());
                                 @endphp
                                 @foreach($question->question_answers as $key_q => $q)
                                    {{ $q->answer_text }}{{ ( ($key_q+1) == $count) ? '' : ', ' }}
                                 @endforeach
                              @endif
                           </td>
                           <td>
                              {{ display_date_format($question->created_at) }}
                           </td>
                           <td>
                               <form action="{{url('admin/questions/'.$question->id)}}" class="cu-inline-block" method="POST">
                                  {{ method_field('DELETE') }}
                                  {{ csrf_field() }}
                                  <a href="{{url('admin/question/edit/'.$question->id)}}" class="action-icon" title="Edit"> <i class="fe-edit"></i></a>
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
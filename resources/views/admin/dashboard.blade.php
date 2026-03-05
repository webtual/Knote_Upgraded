@extends('layouts._comman')
@section('title', 'Dashboard - Knote')
@section('styles')
   <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
   <style>
      .dataTables_wrapper .dataTables_paginate .paginate_button.current,
      .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
      .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
         background: #1abc9c !important;
         border-color: #1abc9c !important;
         color: #fff !important;
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button:active {
         box-shadow: none !important;
      }

      .bg-warning-tr {
         background: #FFFF8F !important;
         border-color: #FFFF8F !important;
         color: #000 !important;
      }

      .bg-danger-tr {
         background: #FF4141 !important;
         border-color: #FF4141 !important;
         color: #000 !important;
      }

      .bg-danger-tr td,
      .bg-warning-tr td {
         border-top: 4px solid #fff !important;
      }
   </style>
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
                        <li class="breadcrumb-item active">Dashboard</li>
                     </ol>
                  </div>
                  <h4 class="page-title">Dashboard</h4>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-4 col-xl-4">
               <a href="{{ url('admin/users') }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-6">
                           <div class="avatar-sm bg-success rounded">
                              <i class="fe-users avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $applicant_count }}</span></h3>
                              <p class="text-muted mb-1 text-truncate">Customers</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>

            <div class="col-md-4 col-xl-4">
               <a href="{{ url('admin/inquiries') }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-6">
                           <div class="avatar-sm bg-success rounded">
                              <i class="fe-mail avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $inquiry_count }}</span></h3>
                              <p class="text-muted mb-1 text-truncate">Inquiry</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>


            <div class="col-md-4 col-xl-4">
               <a href="{{ url('admin/loan-applications') }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-2">
                           <div class="avatar-sm bg-success rounded">
                              <i class="fe-box avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-10">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $application_count }}</span></h3>
                              <p class="text-muted mb-1 text-truncate">Current Loan Application</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>

            <div class="col-md-4 col-xl-4">
               <a href="{{ url('admin/declined-loan-applications') }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-2">
                           <div class="avatar-sm bg-success rounded">
                              <i class="fe-box avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-10">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span
                                    data-plugin="counterup">{{ $application_declined_count }}</span></h3>
                              <p class="text-muted mb-1 text-truncate">Declined Loan Application</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>

            <div class="col-md-4 col-xl-4">
               <a href="{{ url('admin/archived-loan-applications') }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-2">
                           <div class="avatar-sm bg-success rounded">
                              <i class="fe-box avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-10">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span
                                    data-plugin="counterup">{{ $application_archived_count }}</span></h3>
                              <p class="text-muted mb-1 text-truncate">Archived Loan Application</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>

            <div class="col-md-4 col-xl-4">
               <a href="{{ url('admin/settled-loan-applications') }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-2">
                           <div class="avatar-sm bg-success rounded">
                              <i class="fe-box avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-10">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span
                                    data-plugin="counterup">{{ $application_setteled_count }}</span></h3>
                              <p class="text-muted mb-1 text-truncate">Settled Loan Application</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>

            {{--
            <!-- end col -->
            <div class="col-md-6 col-xl-2">
               <a href="{{ url('admin/users').'?type=investor' }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-6">
                           <div class="avatar-sm bg-success rounded">
                              <i class="fe-users avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $investor_count }}</span></h3>
                              <p class="text-muted mb-1 text-truncate">Investor</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>
            <!-- end col -->
            <div class="col-md-6 col-xl-2">
               <a href="{{ url('admin/users').'?type=entrepreneur' }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-2">
                           <div class="avatar-sm bg-dark rounded">
                              <i class="fe-users avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-10">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $entrepreneur_count }}</span>
                              </h3>
                              <p class="text-muted mb-1 text-truncate">Entrepreneurs</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>
            <!-- end col -->
            <div class="col-md-6 col-xl-2">
               <a href="{{ url('admin/loan-applications') }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-2">
                           <div class="avatar-sm bg-blue rounded">
                              <i class="fe-edit avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-10">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $application_count }}</span></h3>
                              <p class="text-muted mb-1 text-truncate">Loan Application</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>
            <!-- end col -->
            <div class="col-md-6 col-xl-2">
               <a href="{{ url('admin/business-proposals') }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-2">
                           <div class="avatar-sm bg-success rounded">
                              <i class="fe-briefcase avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-10">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $business_proposal_count
                                    }}</span></h3>
                              <p class="text-muted mb-1 text-truncate">Business Proposal</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>
            <!-- end col -->
            <div class="col-md-6 col-xl-2">
               <a href="{{ url('admin/resources') }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-6">
                           <div class="avatar-sm bg-warning rounded">
                              <i class="fe-layers avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $resource_count }}</span></h3>
                              <p class="text-muted mb-1 text-truncate font-13"> Resources </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>
            <!-- end col -->
            <div class="col-md-6 col-xl-2">
               <a href="{{ url('admin/assistants') }}">
                  <div class="card-box p-2">
                     <div class="row">
                        <div class="col-6">
                           <div class="avatar-sm bg-success rounded">
                              <i class="fe-users avatar-title font-22 text-white"></i>
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="text-right">
                              <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $assistant_count }}</span></h3>
                              <p class="text-muted mb-1 text-truncate">Assistant</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <!-- end card-box-->
            </div>
            <!-- end col -->
            --}}
         </div>

         <div class="row">
            <div class="col-12">
               <div class="card-box">
                  <div class="mb-2 border border-1 p-2">
                     <div class="row">
                        <div class="col-12">
                           <div class="form-row mb-0 justify-content-start">
                              <div class="col-lg-3">
                                 <div class="form-group mt-0">
                                    <label for="search_application_number">Application Number</label>
                                    <input type="text" class="form-control" id="search_application_number"
                                       name="search_application_number" value="" placeholder="Application Number">
                                 </div>
                              </div>
                              <div class="col-lg-3">
                                 <div class="form-group mt-0">
                                    <label for="search_customer_number">Customer Number</label>
                                    <input type="text" class="form-control" id="search_customer_number"
                                       name="search_customer_number" value="" placeholder="Customer Number">
                                 </div>
                              </div>
                              <div class="col-lg-3">
                                 <div class="form-group mt-0">
                                    <label for="search_business_name">Business Name</label>
                                    <input type="text" class="form-control" id="search_business_name"
                                       name="search_business_name" value="" placeholder="Business Name">
                                 </div>
                              </div>
                              @php
                                 $apply_for = config('constants.apply_for');
                                @endphp
                              <div class="col-lg-3">
                                 <div class="form-group mt-0">
                                    <label for="search_apply_for">Apply For</label>
                                    <select id="search_apply_for" class="custom-select" name="search_apply_for">
                                       <option value="">Show all</option>
                                       @foreach($apply_for as $key => $vala)
                                          <option value="{{$key}}">{{$vala}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>

                              <div class="col-lg-3">
                                 <div class="form-group mt-0">
                                    <label for="search_status_id">Status</label>
                                    <select id="search_status_id" class="custom-select" name="search_status_id">
                                       <option value="">Show all</option>
                                       @foreach($application_status as $vals)
                                          <option value="{{$vals->id}}">{{$vals->status}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-3">
                                 <div class="form-group mt-0">
                                    <label for="search_daterange">Created Date</label>
                                    <input type="text" class="form-control" name="search_daterange" id="search_daterange"
                                       value="" placeholder="Created Date" />
                                 </div>
                              </div>
                              <div class="col-lg-3 text-left" style="margin-top: 28px;">
                                 <div class="form-group">
                                    <button type="button" class="btn btn-success btn-search-apply"
                                       id="btn-search-apply">Apply</button>
                                    <button type="button" class="btn btn-secondary btn-search-clear"
                                       id="btn-search-clear">Clear</button>
                                    <button type="button" class="btn btn-info" onclick="excel_download()">Export</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="table-responsive">
                     <table class="table datatables-basic internal-data-table staff-list">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th style="width:100px;">Application No</th>
                              <th style="width:100px;">Last Application</th>
                              <th style="width:100px;">Customer No</th>
                              <th style="width:80px;">Broker</th>
                              <th>Apply For</th>
                              <th>Business Information</th>
                              <th>Request Amount</th>
                              <th>Status</th>
                              <th>Created Date</th>
                              <th style="width: 50px;">View</th>
                           </tr>
                        </thead>
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
   <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

   <script type="text/javascript">

      $(function () {

         $('input[name="search_daterange"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
               cancelLabel: 'Clear'
            }
         });

         $('input[name="search_daterange"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
         });

         $('input[name="search_daterange"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
         });

      });
   </script>

   <script>
      $(function () {

         var column_name = "DT_RowIndex";

         var table = $('.internal-data-table').DataTable({
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
            processing: true,
            pageLength: 10,
            serverSide: true,
            searching: true,
            info: true,
            autoWidth: false,
            responsive: true,
            aoColumnDefs: [
               {
                  "bSearchable": true,
                  "bVisible": false,
                  "aTargets": [0]
               },
            ],
            "order": [[0, "desc"]],
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            ajax: {
               url: "{{ url('admin/loan-applications-ajax') }}",
               data: function (data) {
                  data.search_application_number = $('#search_application_number').val();
                  data.search_customer_number = $('#search_customer_number').val();
                  data.search_business_name = $('#search_business_name').val();
                  data.search_apply_for = $('#search_apply_for').val();
                  data.search_status_id = $('#search_status_id').val();
                  data.search_daterange = $('#search_daterange').val();
               }
            },
            columns: [
               { data: 'order_by_val', name: 'order_by_val' },
               { data: 'application_no', name: 'application_no' },
               { data: 'last_application', name: 'last_application' },
               { data: 'customer_no', name: 'customer_no' },
               { data: 'broker_info', name: 'broker_info' },
               { data: 'apply_for', name: 'apply_for' },
               { data: 'business_information', name: 'business_information' },
               { data: 'loan_request_amount', name: 'loan_request_amount' },
               { data: 'current_status', name: 'current_status' },
               { data: 'created_at', name: 'created_at' },
               { data: 'action', name: 'action' },
            ],
            rowCallback: function (row, data) {
               if (data.current_status_val === '') {
                  $(row).addClass('');
               } else {
                  $(row).addClass(data.current_status_val);
               }
            }
         });

         $('body').on('click', '.btn-search-clear', function () {
            $('#search_application_number').val('');
            $('#search_customer_number').val('');
            $('#search_apply_for').val('');
            $('#search_status_id').val('');
            $('#search_daterange').val('');
            table.draw();
         });

         $('body').on('click', '.btn-search-apply', function () {
            table.draw();
         });

      });
   </script>

   <script>
      function excel_download() {

         var search_application_number = $('#search_application_number').val();
         var search_customer_number = $('#search_customer_number').val();
         var search_business_name = $('#search_business_name').val();
         var search_apply_for = $('#search_apply_for').val();
         var search_status_id = $('#search_status_id').val();
         var search_daterange = $('#search_daterange').val();

         if (typeof search_application_number === 'undefined') { search_application_number = ""; } else { search_application_number = search_application_number; }
         if (typeof search_customer_number === 'undefined') { search_customer_number = ""; } else { search_customer_number = search_customer_number; }
         if (typeof search_business_name === 'undefined') { search_business_name = ""; } else { search_business_name = search_business_name; }
         if (typeof search_apply_for === 'undefined') { search_apply_for = ""; } else { search_apply_for = search_apply_for; }
         if (typeof search_status_id === 'undefined') { search_status_id = ""; } else { search_status_id = search_status_id; }
         if (typeof search_daterange === 'undefined') { search_daterange = ""; } else { search_daterange = search_daterange; }

         var permater = 'search_application_number=' + search_application_number + '&search_business_name=' + search_business_name + '&search_apply_for=' + search_apply_for + '&search_customer_number=' + search_customer_number + '&search_status_id=' + search_status_id + '&search_daterange=' + search_daterange;

         var csv_url = "{{ url('admin/current-loan-applications-export') }}?" + permater;

         window.location.href = csv_url;
      }
   </script>
@endsection
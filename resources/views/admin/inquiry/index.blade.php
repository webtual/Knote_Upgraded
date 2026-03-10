@extends('layouts._comman')
@section('title', 'Inquiry - Knote')
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

        .add_inquiry .error {
            color: red;
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
                            <!--<ol class="breadcrumb m-0">
                         <li class="breadcrumb-item active">Inquiry</li>
                      </ol>-->
                            <button type="button" class="btn btn-warning btn-add-newInquiry" id="btn-add-newInquiry">Add New
                                Inquiry</button>
                        </div>
                        <h4 class="page-title">Inquiry</h4>
                    </div>
                </div>
            </div>

            @include('partials.comman.alert.message')

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="mb-2 border border-1 p-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-row mb-0 justify-content-start">
                                        <div class="col-lg-3">
                                            <div class="form-group mt-0">
                                                <label for="search_name">Customer Name</label>
                                                <input type="text" class="form-control" id="search_name" name="search_name"
                                                    value="" placeholder="Customer Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group mt-0">
                                                <label for="search_contact">Customer Contact</label>
                                                <input type="text" class="form-control" id="search_contact"
                                                    name="search_contact" value="" placeholder="Customer Contact">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group mt-0">
                                                <label for="search_email">Customer Email</label>
                                                <input type="text" class="form-control" id="search_email"
                                                    name="search_email" value="" placeholder="Customer Email">
                                            </div>
                                        </div>
                                        @php
                                            $apply_for = config('constants.apply_for');
                                            use App\Models\User;
                                        @endphp
                                        <div class="col-lg-3">
                                            <div class="form-group mt-0">
                                                <label for="search_apply_for">Title</label>
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
                                                <label for="search_daterange">Created Date</label>
                                                <input type="text" class="form-control" name="search_daterange"
                                                    id="search_daterange" value="" placeholder="Created Date" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 text-left" style="margin-top: 28px;">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-success btn-search-apply"
                                                    id="btn-search-apply">Apply</button>
                                                <button type="button" class="btn btn-secondary btn-search-clear"
                                                    id="btn-search-clear">Clear</button>
                                                <button type="button" class="btn btn-info"
                                                    onclick="excel_download()">Export</button>
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
                                        <th>Customer No</th>
                                        <th>Title</th>
                                        <th>Know About Us</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th>Created Date</th>
                                        <th style="width: 40px;">Action</th>
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

    <div class="modal fade add_inquiry" id="add_inquiry" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add New Inquiry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/inquiries-add') }}" name="add_inquiry_form" id="add_inquiry_form"
                        method="post" role="form" class="add_inquiry_form" onsubmit="return false;">
                        @php
                            $apply_for = config('constants.apply_for');
                            $apply_for = collect($apply_for)->except([1]);
                        @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group input-pos-relative">
                                    <label for="">Are you applying for?<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="apply_for" id="apply_for">
                                        <option value="" selected>Select..</option>
                                        @foreach($apply_for as $key => $vala)
                                            <option value="{{$key}}">{{$vala}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group input-pos-relative">
                                    <label for="">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="fullname" class="form-control fullname" id="fullname"
                                        placeholder="Full Name" value="" maxlength="50" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group input-pos-relative">
                                    <label for="">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control email" id="email"
                                        placeholder="Email Address" value="" maxlength="50" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group input-pos-relative">
                                    <label for="">Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control phone-field phone" id="phone"
                                        placeholder="Phone" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group input-pos-relative">
                                    <label for="">How did you know about us?<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="know_about_us" id="know_about_us">
                                        <option value="" selected>Select..</option>
                                        @foreach (User::KNOW_ABOUT_US_VAL as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group input-pos-relative">
                                    <label for="know_about_us_others">Please Specify</label>
                                    <input type="text" name="know_about_us_others" class="form-control know_about_us_others"
                                        id="know_about_us_others" placeholder="Please Specify" value="" maxlength="100"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group input-pos-relative">
                                    <label for="">Message</label>
                                    <textarea name="message" class="form-control message" id="message" placeholder="Message"
                                        autocomplete="off"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success mr-2 submit-add-inquiry"
                                id="submit-add-inquiry">Save</button>
                            <button type="button" class="btn btn-info mr-2 close-notestag"
                                data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade edit_inquiry" id="edit_inquiry" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/inquiries-msg-update') }}" name="edit_inquiry_form" id="edit_inquiry_form"
                        method="post" role="form" class="edit_inquiry_form" onsubmit="return false;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group input-pos-relative">
                                    <label for="">Message</label>
                                    <textarea name="message_val" class="form-control message_val" id="message_val" rows="6"
                                        cols="60" placeholder="Message" autocomplete="off"></textarea>
                                    <input type="hidden" id="inquiry_id" name="inquiry_id" value="">
                                </div>
                            </div>

                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success mr-2 submit-edit-inquiry"
                                id="submit-edit-inquiry">Save</button>
                            <button type="button" class="btn btn-info mr-2 close-notestag"
                                data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
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
        $(document).ready(function () {
            $('#know_about_us').on('change', function () {
                if ($(this).val() == '8') {
                    $('#know_about_us_others').closest('.form-group').show();
                } else {
                    $('#know_about_us_others').closest('.form-group').hide();
                    $('#know_about_us_others').val(''); // Clear input if hidden
                }
            });

            // Trigger change on page load (e.g., for edit form)
            $('#know_about_us').trigger('change');
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
                    url: "{{ url('admin/inquiries/ajax') }}",
                    data: function (data) {
                        data.search_name = $('#search_name').val();
                        data.search_contact = $('#search_contact').val();
                        data.search_email = $('#search_email').val();
                        data.search_apply_for = $('#search_apply_for').val();
                        data.search_daterange = $('#search_daterange').val();
                    }
                },
                columns: [
                    { data: 'order_by_val', name: 'order_by_val' },
                    { data: 'customer_no', name: 'customer_no' },
                    { data: 'apply_for', name: 'apply_for' },
                    { data: 'know_about_us', name: 'know_about_us' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'contact_no', name: 'contact_no' },
                    { data: 'msg_val', name: 'msg_val' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' },
                ]
            });

            $('body').on('click', '.inquiry-edit', function () {
                var inquiry_id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('admin/get-inquiries-msg') }}",
                    async: false,
                    data: { inquiry_id: inquiry_id },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (response) {
                        $('#inquiry_id').val(inquiry_id);
                        $('#message_val').val(response.data.message);
                        $('#edit_inquiry').modal('show');
                    },
                    error: function (reject) {
                        if (reject.status === 422) {
                            var errors = $.parseJSON(reject.responseText);
                            errors = errors['errors'];
                            toaserMessage(422, Object.values(errors)[0]);
                        }
                    }
                });

            });

            $('body').on('click', '.submit-edit-inquiry', function () {

                var form = $("#edit_inquiry_form");

                form.validate({
                    ignore: ":hidden:not(:visible)",
                    rules: {
                        message_val: { required: true }
                    },
                    errorPlacement: function (error, element) {
                        error.insertAfter(element); // Adjust the placement if needed
                        console.log("Validation Error: ", error.text()); // Debugging
                    }
                });

                if (form.valid() === true) {
                    $.ajax({
                        url: form.attr('action'),
                        type: "POST",
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: form.serialize(),
                        success: function (data) {
                            if (data.status === 200) {
                                toastr.success(data.message);
                                $('#edit_inquiry').modal('hide');
                                table.draw();
                            }
                        },
                        beforeSend: function () {
                            // Add a loading spinner if needed
                        },
                        complete: function () {
                            // Remove the spinner if added
                            table.draw();
                        }
                    });
                }
            });

            $('body').on('click', '.submit-add-inquiry', function () {

                var form = $("#add_inquiry_form");

                form.validate({
                    ignore: ":hidden:not(:visible)",
                    rules: {
                        apply_for: { required: true },
                        fullname: { required: true },
                        phone: { required: true },
                        email: { required: true },
                        know_about_us: { required: true }
                    },
                    errorPlacement: function (error, element) {
                        error.insertAfter(element); // Adjust the placement if needed
                        console.log("Validation Error: ", error.text()); // Debugging
                    }
                });

                if (form.valid() === true) {
                    $.ajax({
                        url: form.attr('action'),
                        type: "POST",
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: form.serialize(),
                        success: function (data) {
                            if (data.status === 200) {
                                toastr.success(data.message);
                                $('#add_inquiry').modal('hide');
                                table.draw();
                            }
                        },
                        beforeSend: function () {
                            // Add a loading spinner if needed
                        },
                        complete: function () {
                            // Remove the spinner if added
                            table.draw();
                        }
                    });
                }
            });

            $('body').on('click', '.btn-add-newInquiry', function () {
                $('#apply_for').val('');
                $('#fullname').val('');
                $('#email').val('');
                $('#phone').val('');
                $('#message').val('');
                $('#add_inquiry').modal('show');
            });

            $('body').on('click', '.btn-search-clear', function () {
                $('#search_name').val('');
                $('#search_contact').val('');
                $('#search_email').val('');
                $('#search_apply_for').val('');
                $('#search_daterange').val('');
                table.draw();
            });

            $('body').on('click', '.btn-search-apply', function () {
                table.draw();
            });

            $("body").on("click", ".inquiry-delete", function () {

                var id = $(this).data('id');
                var url = $(this).attr('data-action');

                // Show a confirmation alert
                var confirmation = confirm("Are you sure you want to delete this inquiry?");

                if (confirmation) {
                    // If user confirms, proceed with the AJAX request
                    $.ajax({
                        type: 'POST',
                        url: url,
                        async: false,
                        data: { id: id },
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function (response) {
                            toaserMessage(response.status, response.message);
                            table.draw();
                        },
                        error: function (reject) {
                            if (reject.status === 422) {
                                var errors = $.parseJSON(reject.responseText);
                                errors = errors['errors'];
                                toaserMessage(422, Object.values(errors)[0]);
                            }
                            table.draw();
                        }
                    });
                } else {
                    // If user cancels, you can add logic here if needed (optional)
                    console.log('Deletion canceled');
                    table.draw();
                }
            });

        });
    </script>

    <script>
        function excel_download() {

            var search_name = $('#search_name').val();
            var search_contact = $('#search_contact').val();
            var search_email = $('#search_email').val();
            var search_apply_for = $('#search_apply_for').val();
            var search_daterange = $('#search_daterange').val();

            if (typeof search_name === 'undefined') { search_name = ""; } else { search_name = search_name; }
            if (typeof search_contact === 'undefined') { search_contact = ""; } else { search_contact = search_contact; }
            if (typeof search_email === 'undefined') { search_email = ""; } else { search_email = search_email; }
            if (typeof search_apply_for === 'undefined') { search_apply_for = ""; } else { search_apply_for = search_apply_for; }
            if (typeof search_daterange === 'undefined') { search_daterange = ""; } else { search_daterange = search_daterange; }

            var permater = 'search_name=' + search_name + '&search_contact=' + search_contact + '&search_apply_for=' + search_apply_for + '&search_email=' + search_email + '&search_daterange=' + search_daterange;

            var csv_url = "{{ url('admin/inquiries-export') }}?" + permater;

            window.location.href = csv_url;
        }
    </script>
@endsection
@extends('layouts._comman')
@section('title', 'Brokers - Knote')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,.dataTables_wrapper .dataTables_paginate .paginate_button:hover{
    background: #1abc9c !important;
    border-color: #1abc9c !important;
    color: #fff !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:active{
    box-shadow: none !important;
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
                  <a class="btn btn-warning" href="{{route('brokers.create')}}">Create</a>
               </div>
                <h4 class="page-title">
                   Brokers
                </h4>
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
                                        <label for="search_name">Name</label>
                                        <input type="text" class="form-control" id="search_name" name="search_name" value="" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mt-0">
                                        <label for="search_phone">Phone</label>
                                        <input type="text" class="form-control" id="search_phone" name="search_phone" value="" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mt-0">
                                        <label for="search_email">Email</label>
                                        <input type="text" class="form-control" id="search_email" name="search_email" value="" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mt-0">
                                        <label for="search_daterange">Created Date</label>
                                        <input type="text" class="form-control" name="search_daterange" id="search_daterange" value=""  placeholder="Created Date"/>
                                    </div>
                                </div>
                                <div class="col-lg-3 text-left" style="margin-top: 28px;">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success btn-search-apply" id="btn-search-apply">Apply</button>
                                        <button type="button" class="btn btn-secondary btn-search-clear" id="btn-search-clear">Clear</button>
                                        <button type="button" class="btn btn-info"  onclick="excel_download()">Export</button>
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
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Status</th>
								<th>Created Date</th>
								<th style="width: 82px;">Action</th>
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

<div class="modal fade edit_broker" id="edit_broker" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Broker Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/brokers/update') }}" name="edit_broker_form" id="edit_broker_form" method="post" role="form" class="edit_broker_form" onsubmit="return false;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group input-pos-relative">
                                <label for="">Full Name<span class="text-danger">*</span></label>
                                <input type="text" id="fullname" name="fullname" value="" class="form-control" placeholder="Full Name" autocomplete="off">
                                <input type="hidden" id="broker_id" name="broker_id" value="">
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group input-pos-relative">
                                <label for="">Email Address<span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" value="" class="form-control" placeholder="Email Address" autocomplete="off">
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group input-pos-relative">
                                <label for="">Phone<span class="text-danger">*</span></label>
                                <input type="text" id="phone" name="phone" value="" class="form-control phone-field" placeholder="Phone" autocomplete="off" readonly="">
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group input-pos-relative">
                                <label for="">Address</label>
                                <textarea id="address" name="address" class="form-control" placeholder="Address" autocomplete="off"></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group input-pos-relative">
                                <label for="">Status</label>
                                <select class="custom-select selectpicker " name="is_active" id="is_active">
                                    <option value="">Select Status</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Accepted</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success mr-2 submit-edit-broker" id="submit-edit-broker">Update</button>
                        <button type="button" class="btn btn-info mr-2 close-notestag" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade edit_reason" id="edit_reason" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Broker Registration Rejected Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/brokers/status/reject') }}" name="edit_reason_form" id="edit_reason_form" method="post" role="form" class="edit_reason_form" onsubmit="return false;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group input-pos-relative">
                                <label for="">Message</label>
                                <textarea name="rejected_reason" class="form-control rejected_reason" id="rejected_reason" rows="6" cols="60" placeholder="Message" autocomplete="off" ></textarea>
                                <input type="hidden" id="brok_id" name="brok_id" value="">
                            </div>
                        </div>
                        
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success mr-2 submit-edit-reason" id="submit-edit-reason">Save</button>
                        <button type="button" class="btn btn-info mr-2 close-notestag" data-dismiss="modal">Cancel</button>
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

$(function() {

    $('input[name="search_daterange"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="search_daterange"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('input[name="search_daterange"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

});

$(function () {
  
  var column_name = "DT_RowIndex";
  
  var table = $('.internal-data-table').DataTable({
    lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, 'All'] ],
    processing: true,
    pageLength: 10,
    serverSide: true,
    searching: true,
    info: true,
    autoWidth:false,
	responsive: true,
    aoColumnDefs: [
		{ 
			"bSearchable": true, 
			"bVisible": false, 
			"aTargets": [ 0 ]
		},
	],
	"order": [[ 0, "desc" ]],
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    ajax: {
        url:"{{ url('admin/brokers/ajax') }}",
        data: function(data){
            data.search_name = $('#search_name').val();
            data.search_email = $('#search_email').val();
            data.search_phone = $('#search_phone').val();
            data.search_daterange = $('#search_daterange').val();
        }
    },
    columns: [        
        {data: 'order_by_val', name: 'order_by_val'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'phone', name: 'phone'},
        {data: 'is_active', name: 'is_active'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action'},
      ]
    });
    
    $('body').on('click', '.broker-reject', function () {
        var brok_id = $(this).data('id');
        $('#brok_id').val(brok_id);
        $('#rejected_reason').val('');
        $('#edit_reason').modal('show');
    });
    
    $('body').on('click', '.submit-edit-reason', function () {
        
        var form = $("#edit_reason_form");
    
        form.validate({
            ignore: ":hidden:not(:visible)",
            rules: {
                rejected_reason: { required: true }
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
                        $('#edit_reason').modal('hide');
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
    
    $('body').on('click', '.broker-edit', function () {
        var broker_id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: "{{ url('admin/get-brokers') }}",
            async: false,
            data: {broker_id: broker_id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                $('#broker_id').val(broker_id);
                $('#fullname').val(response.data.name);
                $('#email').val(response.data.email);
                $('#phone').val(response.data.phone);
                $('#address').val(response.data.address);
                $('#is_active').val(response.data.is_active);
                $('#edit_broker').modal('show');
            },
            error: function (reject) {
                if(reject.status === 422) {
                    var errors = $.parseJSON(reject.responseText);
                    errors = errors['errors'];
                    toaserMessage(422, Object.values(errors)[0]);
                }
            }
        });
            
    });
    
    $('body').on('click', '.submit-edit-broker', function () {
        var form = $("#edit_broker_form");
    
        form.validate({
            ignore: ":hidden:not(:visible)",
            rules: {
                fullname: { required: true },
                email: { required: true, email: true },
                phone: { required: true }
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            }
        });
    
        if (form.valid()) {
            $.ajax({
                url: form.attr('action'),
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: form.serialize(),
                success: function (data) {
                    if (data.status === 200) {
                        toastr.success(data.message);
                        $('#edit_broker').modal('hide');
                        table.draw();
                    }
                },
                error: function (reject) {
                    if (reject.status === 422) {
                        var errors = reject.responseJSON.errors;
    
                        // Clear previous error messages
                        form.find('.text-danger').remove();
    
                        // Display errors dynamically
                        $.each(errors, function (key, message) {
                            var inputField = form.find('[name=' + key + ']');
                            inputField.after('<span class="text-danger">' + message[0] + '</span>');
                        });
                    }
                }
            });
        }
    });

    $('body').on('click', '.btn-search-clear', function () {
        $('#search_broker_no').val('');
        $('#search_name').val('');
        $('#search_email').val('');
        $('#search_phone').val('');
        $('#search_daterange').val('');
        table.draw();
    });

    $('body').on('click', '.btn-search-apply', function () {
        table.draw();
    });
    
    $("body").on("click", ".broker-delete", function() {
        
        var id = $(this).data('id');
        var url = $(this).attr('data-action');

        // Show a confirmation alert
        var confirmation = confirm("Are you sure you want to delete this broker?");
        
        if (confirmation) {
            // If user confirms, proceed with the AJAX request
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: {id: id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    console.log(response);
                    toaserMessage(response.status, response.message);
                    table.draw();
                },
                error: function (reject) {
                    if(reject.status === 422) {
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
    
    $("body").on("click", ".broker-accept", function() {
        
        var id = $(this).data('id');
        var url = $(this).attr('data-action');

        // Show a confirmation alert
        var confirmation = confirm("Are you sure you want to accepted this broker?");
        
        if (confirmation) {
            // If user confirms, proceed with the AJAX request
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: {id: id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    toaserMessage(response.status, response.message);
                    table.draw();
                },
                error: function (reject) {
                    if(reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        errors = errors['errors'];
                        toaserMessage(422, Object.values(errors)[0]);
                    }
                    table.draw();
                }
            });
        } else {
            // If user cancels, you can add logic here if needed (optional)
            console.log('canceled');
            table.draw();
        }
    });

});

</script>

<script>
function excel_download(){

    var search_name = $('#search_name').val();
    var search_phone = $('#search_phone').val();
    var search_email = $('#search_email').val();
    var search_daterange = $('#search_daterange').val();
    
    if(typeof search_name === 'undefined'){ search_name = ""; } else { search_name = search_name; }
    if(typeof search_phone === 'undefined'){ search_phone = ""; } else { search_phone = search_phone; }
    if(typeof search_email === 'undefined'){ search_email = ""; } else { search_email = search_email; }
    if(typeof search_daterange === 'undefined'){ search_daterange = ""; } else { search_daterange = search_daterange; }

    var permater = 'search_name=' + search_name + '&search_phone=' + search_phone + '&search_email=' + search_email + '&search_daterange=' + search_daterange;

    var csv_url = "{{ url('admin/brokers-export') }}?" + permater;

    window.location.href = csv_url;
}
</script>
@endsection
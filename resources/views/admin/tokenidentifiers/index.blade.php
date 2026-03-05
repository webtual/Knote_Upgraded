@extends('layouts._comman')
@section('title', 'Token Identifiers - Knote')
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
                  <a class="btn btn-warning" href="{{route('tokenidentifiers.create')}}">Create</a>
               </div>
                <h4 class="page-title">
                   Token Identifiers
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
                                <div class="col-lg-6">
                                    <div class="form-group mt-0">
                                        <label for="search_title">Token Key</label>
                                        <input type="text" class="form-control" id="search_title" name="search_title" value="" placeholder="Token Key">
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
								<th>Token Key</th>
								<th>Token Identifiers</th>
								<th>Token Description</th>
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
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

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
</script>

<script>
$(function () {
  
  var column_name = "DT_RowIndex";
  
  var table = $('.internal-data-table').DataTable({
    lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, 'All'] ],
    processing: true,
    pageLength: 25,
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
        url:"{{ url('admin/tokenidentifiers/ajax') }}",
        data: function(data){
            data.search_title = $('#search_title').val();
            data.search_daterange = $('#search_daterange').val();
        }
    },
    columns: [        
        {data: 'order_by_val', name: 'order_by_val'},
        {data: 'title', name: 'title'},
        {data: 'token_identifiers', name: 'token_identifiers'},
        {data: 'description', name: 'description'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action'},
      ]
  });
  
  $('body').on('click', '.btn-search-clear', function () {
        $('#search_title').val('');
        $('#search_daterange').val('');
        table.draw();
    });

    $('body').on('click', '.btn-search-apply', function () {
        table.draw();
    });
  
});
</script>
<script>
function excel_download(){

    var search_title = $('#search_title').val();
    var search_daterange = $('#search_daterange').val();
    
    if(typeof search_title === 'undefined'){ search_title = ""; } else { search_title = search_title; }
    if(typeof search_daterange === 'undefined'){ search_daterange = ""; } else { search_daterange = search_daterange; }

    var permater = 'search_title=' + search_title + '&search_daterange=' + search_daterange;

    var csv_url = "{{ url('admin/tokenidentifiers-export') }}?" + permater;

    window.location.href = csv_url;
}
</script>
@endsection
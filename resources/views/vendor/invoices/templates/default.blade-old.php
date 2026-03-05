<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $invoice->name }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="{{ asset('/vendor/invoices/bootstrap.min.css') }}">
        <style type="text/css" media="screen">
            * {
                font-family: "DejaVu Sans";
            }
            html {
                margin: 0;
            }
            body {
                font-size: 13px;
                margin: 20px 30px;
            }
            body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p div {
                line-height: 1.1;
            }
            .total-amount {
                font-size: 12px;
                font-weight: 700;
            }
            .seller-info p { line-height: 1px; }
            .buyer-info p { line-height: 1px; }
            .table { border: none; }
            .gst_table td {
                padding: 2px 0px;
            }
            .product-list {
                border: 1px solid #d3d3d3;
            }
            .product-list th,
            .product-list td {
                padding: 10px 15px;
            }
            table td {
                padding: 0;
				font-size: 13px;
            }
        </style>
    </head>

    <body>
		<table width="100%" role="presentation" style="border-spacing:0">
			<tbody>
				<tr>
					<td style="margin-bottom: 0;font-size: 45px;width: 100%;text-align: right;text-transform: uppercase;font-weight: 800;font-family: 'DejaVu Sans';color: #17365d;" align="right">
						 <h1 style="margin-bottom: 0px;margin-top: 0px;text-align: right;font-size: 45px;" class="text-uppercase">Invoice</h1>
					</td>
				</tr>
			</tbody>
		</table>
		
		<table width="100%" role="presentation" style="border-spacing:0;margin-top:40px;">
			<tbody>
				<tr>
					<td style="margin-bottom: 0;font-family: 'DejaVu Sans';color: #17365d;width:70%;" align="left">
						<h3 style="margin-top: 0px;margin-bottom: 0;">{{ $invoice->buyer->name }}</h3>
						<p style="margin-top: 10px;margin-bottom: 0;"><span style="display:inline-block;vertical-align:middle;text-align:left;">ABN :</span> <span style="display:inline-block;vertical-align:middle;">{{ $invoice->buyer->referral_abn }}</span></p>
						<p style="margin-top: 5px;margin-bottom: 0;"><span style="display:inline-block;vertical-align:middle;text-align:left;">Address :</span> <span style="display:inline-block;vertical-align:middle;">{{ $invoice->buyer->address }}</span></p>
						<p style="margin-top: 5px;margin-bottom: 0;"><span style="display:inline-block;vertical-align:middle;text-align:left;">Phone :</span> <span style="display:inline-block;vertical-align:middle;">{{ $invoice->buyer->phone }}</span></p>
					</td>
				</tr>
			</tbody>
		</table>
		
		<table width="100%" role="presentation" style="border-spacing:0;margin-top:40px;">
			<tbody>
				<tr>
					<td style="margin-bottom: 0;font-family: 'DejaVu Sans';color: #17365d;width:60%;" align="left">	</td>
					<td style="margin-bottom: 0;width: 100%;font-family: 'DejaVu Sans';color: #17365d;width:40%;text-align:right;" align="right">
						<h3 style="margin-top: 0px;margin-bottom: 0;text-align:right;width: 100%;"><span style="">Invoice No. : </span> <span style="">{{ $invoice->buyer->invoice_no }}</span> </h3>
						<p style="margin-top: 0;font-size:15px;text-align:right;width: 100%;"><strong style="">Date : </strong> <span style="">{{ $invoice->getDate() }}</span></p>
					</td>
				</tr>
			</tbody>
		</table>
		
		<table width="100%" role="presentation" style="border-spacing:0;margin-top:20px;">
			<tbody>
				<tr>
					<td style="margin-bottom: 0;font-family: 'DejaVu Sans';color: #17365d;width:60%;" align="left">
						<h3 style="margin-top: 0px;margin-bottom: 0;">Billing To :</h3>
						<h3 style="margin-top: 0px;margin-bottom: 0;">{{ $invoice->seller->name }}</h3>
						<p style="margin-top:3px;">{{ $invoice->seller->address }}</p>
					</td>
					<td style="margin-bottom: 0;width: 100%;font-family: 'DejaVu Sans';color: #17365d;width:40%;text-align:right;" align="right">	</td>
				</tr>
			</tbody>
		</table>
         
        <table role="table" style="display: table;border-collapse: separate;box-sizing: border-box;text-indent: initial;border-spacing: 2px;border-color: grey;width: 100%;color: #6e6b7b;border-collapse: collapse;border-bottom-left-radius: .357rem;border-bottom-right-radius: .357rem;margin-top:30px;">
			<thead style="display: table-header-group;">
				<tr style="display: table-row;vertical-align: inherit;border-color: inherit;page-break-inside: avoid;">
				   <th width="85%" style="text-align:center;vertical-align: middle;text-transform: uppercase;font-size: .757rem;letter-spacing: .5px;border: 1px solid #ccc;border-top: 1px solid #cccccc;border-bottom: 2px solid #cccccc;outline: none;padding: .72rem 1.3rem;color: #17365d;">
						DESCRIPTION
				   </th>
				   <th width="15%" style="text-align:center;vertical-align: middle;text-transform: uppercase;font-size: .757rem;letter-spacing: .5px;border: 1px solid #ccc;border-top: 1px solid #cccccc;border-bottom: 2px solid #cccccc;outline: none;padding: .72rem 1.3rem;color: #17365d;">
						AMOUNT
				   </th>
				</tr>
			</thead>
			<tbody>
				<tr style="display: table-row;vertical-align: inherit;border-color: inherit;page-break-inside: avoid;">
					<td width="85%" style="height:40px;outline: none;border: 1px solid #ccc; padding: 0px;border-bottom: none;border-top: none;"></td>
					<td width="15%" style="height:40px;outline: none;border: 1px solid #ccc; padding: 0px;border-bottom: none;border-top: none;"></td>
				</tr>
			    @php
			        $items_count = count($invoice->items);
			        $tr_hight_val = 350;
			        $tr_hight_singel_val = 50;
			        $tr_hight_minus = ($tr_hight_singel_val * $items_count);
			        $tr_hight = ($tr_hight_val - $tr_hight_minus);
			    @endphp
			    
			    @foreach($invoice->items as $item)
				<tr style="display: table-row;vertical-align: inherit;border-color: inherit;page-break-inside: avoid;">
					<td width="85%" style="border: 1px solid #ccc;border-top: none;border-bottom: none; outline: none; padding: 0.7rem 1.1rem; background-color: #fff;color: #17365d;">
						{{ $item->title }}
					</td>
					<td width="15%" align="right" style="border: 1px solid #ccc;border-top: none;border-bottom: none; outline: none; padding: 0.7rem 1.1rem; background-color: #fff;color: #17365d;">${{ number_format($item->price_per_unit, 2) }}</td>
				</tr>
				<tr style="display: table-row;vertical-align: inherit;border-color: inherit;page-break-inside: avoid;">
					<td width="85%" style="height:20px;outline: none;border: 1px solid #ccc; padding: 0px;border-bottom: none;border-top: none;"></td>
					<td width="15%" style="height:20px;outline: none;border: 1px solid #ccc; padding: 0px;border-bottom: none;border-top: none;"></td>
				</tr>
				@endforeach
				
				<tr style="display: table-row;vertical-align: inherit;border-color: inherit;page-break-inside: avoid;">
					<td width="85%" style="height:{{$tr_hight}}px;outline: none;border: 1px solid #ccc; padding: .72rem 1.1rem;border-top: none;"></td>
					<td width="15%" style="height:{{$tr_hight}}px;outline: none;border: 1px solid #ccc; padding: .72rem 1.1rem;border-top: none;"></td>
				</tr>
				
			</tbody>
			<tfoot>
				<tr style="display: table-row;vertical-align: inherit;border-color: inherit;page-break-inside: avoid;">
					<td width="85%" align="right" style="outline: none; padding: .72rem 1.1rem;border-left: none;color: #17365d;">
						<strong>TOTAL</strong>
					</td>
					<td width="15%" style="border: 1px solid #cccccc;outline: none; padding: .72rem 1.1rem;color: #17365d;" align="right">
						<strong>${{ number_format($invoice->buyer->total_amount,2) }}</strong>
						<span style="margin-top:5px;display:block;">(Incl GST)</span>
					</td>
				</tr>
			</tfoot>
		</table>
		
		<table width="100%" role="presentation" style="border-spacing:0;margin-top:10px;">
			<tbody>
				<tr>
					<td style="margin-bottom: 0;width: 100%;text-align: right;font-weight: 800;font-family: 'DejaVu Sans';color: #17365d;" align="right">
						<strong>(Payment Terms: 7 Days from invoice)</strong>
					</td>
				</tr>
			</tbody>
		</table>
		
		<table width="100%" role="presentation" style="border-spacing:0;margin-top:20px;">
			<tbody>
				<tr>
					<td style="margin-bottom: 0;font-family: 'DejaVu Sans';color: #17365d;width:70%;" align="left">
						<h3 style="margin-top: 0px;margin-bottom: 0;text-decoration:underline;">Payment Direct To :</h3>
						<!--<p style="margin-bottom: 0;"><strong>{{ $invoice->buyer->referral_account_name }}</strong></p>-->
						<p style="margin-top: 5px;margin-bottom: 0;">Referral Account Name : {{ $invoice->buyer->referral_account_name }}</p>
						<p style="margin-top: 5px;margin-bottom: 0;">Account No. : {{ $invoice->buyer->referral_account_details }}</p>
						<p style="margin-top: 5px;margin-bottom: 0;">BSB No. : {{ $invoice->buyer->referral_account_bsb_no }} {{ $invoice->buyer->referral_branch_name }}</p>
						<p style="margin-top: 5px;margin-bottom: 0;font-size: 10px;">*This is computer generated invoice</p>
					</td>
				</tr>
			</tbody>
		</table>

        <script type="text/php">
            if (isset($pdf) && $PAGE_COUNT > 1) {
                $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Verdana");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width);
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>
    </body>
</html>

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
                font-size: 10px;
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
				font-size: 12px;
            }
        </style>
    </head>

    <body>
		<table width="100%" role="presentation" style="border-spacing:0;padding-left:20px;padding-right:20px;padding-top:20px;">
			<tbody>
				<tr>
					<td style="margin-bottom: 0;width: 100%;text-align: left;" align="left">
						@if($invoice->logo)
                            <img src="{{ $invoice->getLogo() }}" alt="logo" style="height:40px;">
                        @endif
					</td>
				</tr>
			</tbody>
		</table>
		
		<table width="100%" role="presentation" style="border-spacing:0;margin-top:20px;padding-left:20px;padding-right:20px;">
			<tbody>
				<tr>
					<td style="margin-bottom: 0px;width:40%;" align="left">	</td>
					<td style="margin-bottom: 0px;font-family: 'DejaVu Sans';color: #000000;width:60%;" align="right">
						<p style="margin-top: 0px;margin-bottom: 0;text-align:right;width: 100%;">Credit Hub Australia</p>
						<p style="margin-top: 0px;margin-bottom: 0;text-align:right;width: 100%;">Unit 108, 22-30 Wallace Avenue, Point Cook</p>
						<p style="margin-top: 0px;margin-bottom: 0;text-align:right;width: 100%;">Phone: 1300 782 944</p>
						<p style="margin-top: 0px;margin-bottom: 0;text-align:right;width: 100%;">ABN: 69 138 938 646</p>
					</td>
				</tr>
			</tbody>
		</table>

		
		<table width="100%" role="presentation" style="border-spacing:0;margin-top:40px;padding-left:20px;padding-right:20px;">
			<tbody>
				<tr>
					<td style="margin-bottom: 0;font-family: 'DejaVu Sans';color: #000000;width:60%;padding-top:0px;" align="left">
						<p style="margin-top: 5px;margin-bottom: 0;">&nbsp;</p>
						<p style="margin-top: 0px;margin-bottom: 0;">Referral Partner Name: {{ $invoice->buyer->name }}</p>
						<p style="margin-top: 0px;margin-bottom: 0;">Address: {{ $invoice->buyer->address }}</p>
					</td>
					<td style="margin-bottom: 0;width: 100%;font-family: 'DejaVu Sans';color: #000000;width:40%;text-align:right;" align="right">
						<p style="margin-top: 0px;margin-bottom: 0;text-align:right;width: 100%;"><strong>RECIPIENT CREATED TAX INVOICE</strong></p>
						<p style="margin-top: 0px;margin-bottom: 0;text-align:right;width: 100%;">ABN: {{ $invoice->buyer->referral_abn }}</p>
						<p style="margin-top: 0px;margin-bottom: 0;text-align:right;width: 100%;">Invoice No: {{ $invoice->buyer->invoice_no }}</p>
						<p style="margin-top: 0px;margin-bottom: 0;text-align:right;width: 100%;">Invoice Date: {{ $invoice->buyer->invoice_date }}</p>
					</td>
				</tr>
			</tbody>
		</table>

         
        <table role="table" style="display: table;border-collapse: separate;box-sizing: border-box;text-indent: initial;border-spacing: 2px;border-color: grey;width: 100%;color: #6e6b7b;border-collapse: collapse;border-bottom-left-radius: .357rem;border-bottom-right-radius: .357rem;margin-top:30px;padding-left:20px;padding-right:20px;">
			<thead style="display: table-header-group;">
				<tr style="display: table-row;vertical-align: inherit;border-color: inherit;page-break-inside: avoid;">
				   <th width="80%" style="text-align:left;vertical-align: middle;text-transform: uppercase;font-size: .6rem;letter-spacing: .5px;border: 1px solid #ccc;border-top: 1px solid #cccccc;border-bottom: 2px solid #cccccc;outline: none;padding: 3px 0.8rem;color: #17365d;">
						DESCRIPTION
				   </th>
				   <th width="20%" style="text-align:center;vertical-align: middle;text-transform: uppercase;font-size: .6rem;letter-spacing: .5px;border: 1px solid #ccc;border-top: 1px solid #cccccc;border-bottom: 2px solid #cccccc;outline: none;padding: 3px 0.8rem;color: #17365d;">
						Amount Paid
				   </th>
				</tr>
			</thead>
			<tbody>
				<tr style="display: table-row;vertical-align: inherit;border-color: inherit;page-break-inside: avoid;">
					<td width="80%" style="height:25px;outline: none;border: 1px solid #ccc; padding: 0px;border-bottom: none;border-top: none;"></td>
					<td width="20%" style="height:25px;outline: none;border: 1px solid #ccc; padding: 0px;border-bottom: none;border-top: none;"></td>
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
					<td width="80%" style="border: 1px solid #ccc;border-top: none;border-bottom: none; outline: none; padding: 0.7rem 1.1rem; background-color: #fff;color: #17365d;">
						{{ $item->title }}
					</td>
					<td width="20%" align="center" style="border: 1px solid #ccc;border-top: none;border-bottom: none; outline: none; padding: 0.7rem 1.1rem; background-color: #fff;color: #17365d;">${{ number_format($item->price_per_unit, 2) }}</td>
				</tr>
				<tr style="display: table-row;vertical-align: inherit;border-color: inherit;page-break-inside: avoid;">
					<td width="80%" style="height:10px;outline: none;border: 1px solid #ccc; padding: 0px;border-bottom: none;border-top: none;"></td>
					<td width="20%" style="height:10px;outline: none;border: 1px solid #ccc; padding: 0px;border-bottom: none;border-top: none;"></td>
				</tr>
				@endforeach
				
				<tr style="display: table-row;vertical-align: inherit;border-color: inherit;page-break-inside: avoid;">
					<td width="80%" style="height:{{$tr_hight}}px;outline: none;border: 1px solid #ccc; padding: .72rem 1.1rem;border-top: none;"></td>
					<td width="20%" style="height:{{$tr_hight}}px;outline: none;border: 1px solid #ccc; padding: .72rem 1.1rem;border-top: none;"></td>
				</tr>
				
			</tbody>
			<tfoot>
				<tr style="display: table-row;vertical-align: inherit;border-color: inherit;page-break-inside: avoid;">
					<td width="85%" align="right" style="outline: none; padding: .72rem 1.1rem;border-left: none;color: #17365d;">
						<strong>Total Paid</strong>
					</td>
					<td width="20%" style="border: 1px solid #cccccc;outline: none; padding: .72rem 1.1rem;color: #17365d;" align="center">
						<strong>${{ number_format($invoice->buyer->total_amount,2) }}</strong>
						<span style="margin-top:5px;display:block;">(Incl GST)</span>
					</td>
				</tr>
			</tfoot>
		</table>
		
		<table width="100%" role="presentation" style="border-spacing:0;margin-top:20px;padding-left:20px;padding-right:20px;">
			<tbody>
				<tr>
					<td style="margin-bottom: 0;font-family: 'DejaVu Sans';color: #000000;width:70%;" align="left">
						<!--<p style="margin-bottom: 0;"><strong>{{ $invoice->buyer->referral_account_name }}</strong></p>-->
						<p style="margin-top: 0px;margin-bottom: 0;">The amount of: ${{ number_format($invoice->buyer->total_amount,2) }}</p>
						<p style="margin-top: 0px;margin-bottom: 0;">Was credited to: {{ $invoice->buyer->name }}</p>
						<p style="margin-top: 0px;margin-bottom: 0;"><strong>BSB: {{ $invoice->buyer->referral_account_bsb_no }} {{ $invoice->buyer->referral_branch_name }}</strong></p>
						<p style="margin-top: 0px;margin-bottom: 0;"><strong>Account: {{ $invoice->buyer->referral_account_details }}</strong></p>
					</td>
				</tr>
			</tbody>
		</table>
		
		<table width="100%" role="presentation" style="border-spacing:0;margin-top:60px;padding-left:20px;padding-right:20px;">
			<tbody>
				<tr>
					<td style="margin-bottom: 0;font-family: 'DejaVu Sans';color: #000000;width:70%;" align="left">
						<p style="margin-top: 0px;margin-bottom: 0;color:#59597a;">
							<i>If you have any questions, please send us an email at <u>info@credithub.com.au</u> or give us a call on 1300 782 944 and quote the invoice No. with your query.</i>
						</p>
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

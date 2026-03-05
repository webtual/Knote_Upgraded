<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    {{ $header ?? '' }}

                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        {{ Illuminate\Mail\Markdown::parse($slot) }}

                                        {{ $subcopy ?? '' }}
                                    </td>
                                </tr>

                                <!-- Signature -->
                                
                                <!--<tr>
                                    <td class="content-cell" style="font-size: 14px;" width="100%" align="left">
                                        <a href="https://www.knote.com.au/" target="_blank"><img style="width:100px"  src="{{ asset('user/img/logo.png') }}" title="cliceat" alt="cliceat" border="0" id="imglogo" style="height: 30px;"></a><br><br>
                                        <p style="font-size: 12px;"><strong style="font-size: 14px;">Knote Group Aus Pty Ltd</strong><br><b>Corporate Office</b> : Unit 108, 22-30 Wallace Ave, Point Cook VIC 3030 <br/> 
                                        PO BOX 6493, Point Cook VIC 3030<br>
                                        <b>Phone</b> : 1300 056 683  | <b>Fax</b> : 03 8370 3144  | <b>Email</b> : info@knote.com.au <br/> <b>Website</b> : www.knote.com.au</p>
                                    </td>
                                </tr>-->
                                
                                <tr>
                                    <td class="content-cell" style="font-size: 14px;" width="100%" align="left">
                                        <a href="https://www.knote.com.au/" target="_blank">
                                            <img style="width:100px"  src="{{ asset('user/img/logo.png') }}" title="cliceat" alt="cliceat" border="0" id="imglogo" style="height: 30px;">
                                        </a>
                                        <br><br>
                                        <p style="font-size: 12px;">
                                            <strong style="font-size: 14px;">Knote Group Aus Pty Ltd</strong>
                                            <br/>
                                            <b>Phone</b> : 1300 056 683  | <b>Email</b> : info@knote.com.au 
                                            <br/>
                                            <b>Website</b> : www.knote.com.au
                                        </p>
                                    </td>
                                </tr>
                                
                                <!-- End Signature -->

                            </table>
                        </td>
                    </tr>

                    {{ $footer ?? '' }}
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

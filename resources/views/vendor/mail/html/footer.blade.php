<tr align="center">
	<td align="center" style="padding-top:30px;" >
	
	 <a href="https://www.facebook.com/Knote-107676638846366" target="_blank" style="padding-right:5px;">
	 	<span><img height="30"  src="{{ asset('user/img/facebook-share.png') }}" /></span>
	 </a>
	 <a href="https://www.instagram.com/knote.australia/"  target="_blank" style="padding-right:5px;">
	 	<span><img height="30"  src="{{ asset('user/img/instagram-share.png') }}"  /></span>
	 </a>
	 <a href="https://www.linkedin.com/company/knotegroup/about/"  target="_blank">
	 	<span><img height="30"  src="{{ asset('user/img/linkedin-share.png') }}" /></span>
	 	</a>
	
	
	</td>
</tr>

<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td class="content-cell" align="center">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
        </table>
    </td>
</tr>

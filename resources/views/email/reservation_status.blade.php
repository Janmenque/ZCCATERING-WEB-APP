<x-email-template>
 <!-- slot ======-->
 <p style="line-height: 24px; margin-bottom:15px;">

    Hello {{ $info->user->name }}

</p>
<p style="line-height: 24px;margin-bottom:15px;">
Your reservation was marked as '{{ $info->reservation_status->name }}' on {{ config('settings')->name }}.
</p>
<br />
<p style="line-height: 24px; margin-bottom:20px;">
    Kindly login using the button below.
</p>
<table border="0" align="center" width="180" cellpadding="0" cellspacing="0" bgcolor="5caad2" style="margin-bottom:20px;">

    <tr>
        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
    </tr>

    <tr>
        <td align="center" style="color: #ffffff; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;">
            <!-- main section button -->

            <div style="line-height: 22px;">
                <a href="{{ route('login') }}" style="color: #ffffff; text-decoration: none;">LOGIN</a>
            </div>
        </td>
    </tr>

    <tr>
        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
    </tr>

</table>
<!-- slot end-->
</x-email-template>
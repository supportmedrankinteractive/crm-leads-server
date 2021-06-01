<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="http://medrankcrm.com/mrilogo.png" class="logo" alt="{{config('app.name')}}" style="width: 20%;">
@else
<img src="http://medrankcrm.com/mrilogo.png" class="logo" alt="{{config('app.name')}}" style="width: 20%;">
<!--{{ $slot }}-->
@endif
</a>
</td>
</tr>

@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'PrimeStore')
<img src="{{ asset('backend/assets/img/logo.png') }}" class="logo" alt="Prime Store">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>

@props(['action' => '#', 'title', 'icon', 'disabled' => false])

@if($disabled)
<span title="{{ $title }}">
    <i class="fa {{ $icon }}"></i>
</span>
@else
<a href="{{ $action }}" title="{{ $title }}" style="text-decoration: none;">
    <i class="fa {{ $icon }}"></i>
</a>
@endif
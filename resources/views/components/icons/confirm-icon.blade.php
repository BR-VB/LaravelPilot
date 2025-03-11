@props(['action' => '#', 'message' => '', 'title' => '', 'id', 'disabled' => false])

@if($disabled)
<span title="{{ $title }}">
    <i class="fa fa-trash"></i>
</span>
@else
<form id="delete-form-{{ $id }}" action="{{ $action }}" method="POST" style="display: inline;">
    @csrf
    @method('DELETE')
    <a href="javascript:void(0);"
        onclick="showConfirmation('{{ addslashes($message) }}', () => document.getElementById('delete-form-{{ $id }}').submit())"
        title="{{ $title }}">
        <i class="fa fa-trash"></i>
    </a>
</form>
@endif
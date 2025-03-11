@props(['projectId'])

<a href="{{ route('projects.show', ['project' => $projectId]) }}"
    title="{{ __('config.show_details') }}"
    class="show-details-link">
    {{ __('config.show_details') }}<i class="fa fa-info-circle icon"></i>
</a>
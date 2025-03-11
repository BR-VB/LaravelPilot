@extends('layouts.app')

@section('headline', $project->title)
@section('subpage_content')

<!-- project info -->
<x-projects.show-project-data :project="$project" />

<!-- show all scopes and tasks -->
<div class="model-index-details">
    @foreach($scopes as $index => $scope)
    <div @php echo 'class="scope-container' . (isset($scope['scopeBgcolor']) ? '"' : ' bg-default"' ) .
        (isset($scope['scopeBgcolor']) ? ' style="background-color: ' . $scope['scopeBgcolor'] . ';"' : '' );
        @endphp>
        <ul class="task-list">
            <li><strong style="color: #e67e22">{{ $scope['taskOccurredAt']->isoFormat('D. MMMM YYYY, HH:mm:ss') }} - {{ $scope['scopeLabel'] }}:</strong> <br />
                {!! $scope['taskIcon'] !!} {!! $scope['taskPrefix'] !!} {!! $scope['taskTitle'] !!}
                @if($scope['taskDescription'])
                <ul class="task-sublist">
                    <li>
                        <p class="white-space-pre-wrap">{!! $scope['taskDescription'] !!}</p>
                    </li>
                </ul>
                @endif
            </li>
            @if(!empty($scope['task_details']))
            <ul class="task-details">
                @foreach($scope['task_details'] as $task_detail)
                <li>
                    <strong>{{ $task_detail['taskDetailOccurredAt']->isoFormat('D. MMMM YYYY, HH:mm:ss') }} - {{ $task_detail['taskDetailTypeLabel'] }}:</strong> <br />
                    @if($task_detail['taskDetailTypeId'] === config('project.project.view.task_detail_type_id_for_code_snippet'))
                    <pre><code>{{ $task_detail['taskDetailDescription'] }}</code></pre>
                    @else
                    <div class="white-space-pre-wrap">{!! $task_detail['taskDetailDescription'] !!}</div>
                    @endif
                </li>
                @endforeach
            </ul>
            @endif
        </ul>
    </div>
    @endforeach
</div>

@if(!is_array($scopes) && $scopes)
<div class="pagination justify-content-center">
    {{ $scopes->links('pagination::bootstrap-4') }}
</div>
@endif

<div class="model-index-scopes">
    <div>&nbsp;</div>
</div>

<div class="icons-action-icon">
    <x-icons.action-icon
        :action="route('projects.index')"
        :title="__('project.projects_index_headline')"
        icon="fa-th-large" />

    <x-icons.action-icon
        :action="session('return_to_show_origin', url()->previous())"
        :title="__('config.history_back')"
        icon="fa-arrow-left" />
</div>
@endsection
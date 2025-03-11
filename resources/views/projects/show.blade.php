@extends('layouts.app')

@section('headline', $project->title)
@section('subpage_content')
@php
session(['return_to_edit_origin' => request()->fullUrl()]);
session(['return_to_translate_origin' => request()->fullUrl()]);
@endphp
<!-- project info -->
<x-projects.show-project-data :project="$project" />

<!-- search block -->
@if($view == 'byscope')
<div class="model-index-view">
    <!-- Suchblock -->
    <form action="{{ route('projects.show', ['project' => $project->id, 'view' => $view]) }}?page=1&scopeId={{ $scopeId }}" method="GET" class="search-block">
        @php
        $selectedScopeId = request('scopeId') ? request('scopeId') : $scopeId;
        @endphp
        <x-form.select
            label="{{ __('project.projects_search_scope_label') }}"
            name="scopeId"
            :options="$scopeSelect"
            :selected="$selectedScopeId"
            :required="false"
            :disabled="false"
            classname="search-field" />

        <div class="search-button">
            <button type="submit" class="btn btn-primary">
                {{ __('task.tasks_search_button') }}
            </button>
        </div>
    </form>
</div>
@endif

<!-- show all scopes and tasks -->
<div class="model-index-details">
    @foreach($scopes as $index => $scope)
    @if(!empty($scope['tasks']))
    <div class="scope-container">
        <h5>{{ $scope['scopeLabel'] }}</h5>
        <p>
        <ul class="task-list">
            @foreach($scope['tasks'] as $task)
            <li>{!! $task['taskIcon'] !!} {!! $task['taskPrefix'] !!} {!! $task['taskTitle'] !!}</li>
            @if($task['taskDescription'])
            <ul class="task-sublist">
                <li>
                    <p class="white-space-pre-wrap">{!! $task['taskDescription'] !!}</p>
                </li>
            </ul>
            @endif

            @if(!empty($task['task_details']))
            <ul class="task-details">
                @foreach($task['task_details'] as $task_detail)
                <li>
                    <strong>{{ $task_detail['taskDetailOccurredAt']->isoFormat('D. MMMM YYYY, HH:mm:ss') }} - {{ $task_detail['taskDetailTypeLabel'] }}:</strong> <br />
                    @if($task_detail['taskDetailTypeId'] === config('project.project.view.task_detail_type_id_for_code_snippet'))
                    <pre><code>{{ $task_detail['taskDetailDescription'] }}</code></pre>
                    @else
                    <p class="white-space-pre-wrap">{!! $task_detail['taskDetailDescription'] !!}</p>
                    @endif
                </li>
                @endforeach
            </ul>
            @endif

            @endforeach
        </ul>
        </p>
    </div>
    @endif
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
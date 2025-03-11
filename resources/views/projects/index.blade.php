@extends('layouts.app')

@section('headline', __('project.projects_index_headline'))
@section('subpage_content')
@php
session(['return_to_create_origin' => request()->fullUrl()]);
session(['return_to_show_origin' => request()->fullUrl()]);
session(['return_to_edit_origin' => request()->fullUrl()]);
session(['return_to_translate_origin' => request()->fullUrl()]);
session(['return_to_delete_origin' => request()->fullUrl()]);
@endphp
<div class="model-index">
    @php
    $isAdminUser = auth()->check() && auth()->user()->is_admin;
    $views = trans('config.view');
    $viewIcon = trans('config.view-icon');
    @endphp
    <div>
        @forelse($projects as $project)
        @if ($loop->first)
        <ul>
            @endif
            <li>
                <span class="model-title">{{ $project->getTranslatedField('title') }}</span>
                <span class="model-links">
                    @php
                    $isDifferentFromOriginalLocale = app()->getLocale() != $project->locale;
                    $isDifferentFromSelectedProject = session('projectId') != $project->id;
                    @endphp
                    @if($isAdminUser)
                    <x-icons.action-icon
                        :action="route('projects.show', ['project' => $project->id] + request()->query())"
                        :title="__('project.projects_index_show_hover')"
                        icon="fa-eye" />
                    @else
                    <x-icons.action-icon
                        :action="$isDifferentFromSelectedProject ? route('projects.switch', ['projectId' => $project->id] + request()->query()) : route('projects.show', ['project' => $project->id] + request()->query())"
                        :title="$isDifferentFromSelectedProject ? __('project.projects_switch_hover') : __('project.projects_index_show_hover')"
                        icon="{{ $isDifferentFromSelectedProject ? 'fa-exchange-alt' : 'fa-eye' }}" />
                    @endif

                    @if($isAdminUser)
                    <x-icons.action-icon
                        :action="$isDifferentFromOriginalLocale ? '#' : route('projects.edit', ['project' => $project->id] + request()->query())"
                        :title="__('project.projects_index_edit_hover')"
                        icon="fa-pencil-alt"
                        :disabled="$isDifferentFromOriginalLocale" />

                    <x-icons.action-icon
                        :action="route('translations.translate', ['table_name' => 'projects', 'record_id' => $project->id] + request()->query())"
                        :title="__('project.projects_index_translate_hover')"
                        icon="fa-language" />

                    <x-icons.confirm-icon
                        :action="$isDifferentFromOriginalLocale ? '#' : route('projects.destroy', ['project' => $project->id] + request()->query())"
                        :message="$isDifferentFromOriginalLocale ? '' : __('project.projects_delete_question', ['project' => $project->title, 'projectId' => $project->id])"
                        :title="__('project.projects_index_delete_hover')"
                        :id="$project->id"
                        :disabled="$isDifferentFromOriginalLocale" />
                    @else
                    @foreach($views as $viewLabel => $view)
                    @if($viewLabel != 'default')
                    <x-icons.action-icon
                        :action="$isDifferentFromSelectedProject ? '#' : route('projects.show', ['project' => $project->id, 'view' => $viewLabel] + request()->query())"
                        :title="__('project.projects_index_show_hover') . ' - ' . $viewLabel"
                        :icon="$viewIcon[$viewLabel]"
                        :disabled="$isDifferentFromSelectedProject" />
                    @endif
                    @endforeach
                    @endif
                </span>
            </li>
            @if ($loop->last)
        </ul>
        @endif
        @empty
        <div class="model-no-records">
            <p>{{ __('project.projects_index_no_records_found') }}</p>
        </div>
        @endforelse
    </div>
</div>

@if($projects)
<div class=" pagination justify-content-center">
    {{ $projects->links('pagination::bootstrap-4') }}
</div>
@endif

@if($isAdminUser)
<div class="icons-action-icon">
    <x-icons.action-icon
        :action="route('projects.create')"
        :title="__('project.projects_index_new_hover')"
        icon="fa-plus-circle" />
</div>
@endif
@endsection
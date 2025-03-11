@props(['project'])

<div class="model-form">
    @php
    $isOriginalLocale = $project->locale == session('locale') ? true : false;
    @endphp

    <div>
        <p class="white-space-pre-wrap">{!! $project->description !!}</p>
    </div>

    <!-- created_at, changed_at -->
    <x-form.created-updated
        :created_at="$project->created_at ?? null"
        :updated_at="$project->updated_at ?? null"
        created_label="{{ __('project.projects_create_created_at_label') }}"
        updated_label="{{ __('project.projects_create_updated_at_label') }}" />

    @can('administrate')
    <div class="submit-button">
        <!-- Edit Link -->
        @if($isOriginalLocale)
        <a href="{{ route('projects.edit', ['project' => $project->id] + request()->query()) }}" id="toggle-edit-link" class="create-submit-button">{{ __('project.projects_show_submit_label') }}</a>
        @endif
        <!-- Translate Link -->
        <a href="{{ route('translations.translate', ['table_name' => 'projects', 'record_id' => $project->id] + request()->query()) }}" id="translate-link" class="create-submit-button">{{ __('translation.translations_translate_button_label') }}</a>
    </div>
    @endcan

    @can('report', $project)
    <div class="submit-button">
        <!-- Report Link -->
        <a href="javascript:void(0);" id="translate-link" class="create-submit-button" onclick="submitReportForm()">
            {{ __('project.projects_reporting_button_label') }}
        </a>

        <!-- create post route -->
        <form id="report-form" action="{{ route('projects.report', ['project' => $project->id] + request()->query()) }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
    @endcan

    <script>
        function submitReportForm() {
            document.getElementById('report-form').submit();
        }
    </script>
</div>
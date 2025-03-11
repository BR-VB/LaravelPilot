    <footer>
        <div class="footer-content">
            <p>{{ __('footer.laravel_version') }}: {{ app()->version() }} | {{ __('footer.php_version') }}: {{ phpversion() }}</p>
            @auth
            <div class="separator"></div>
            <form action="{{ route('projects.switch') }}" method="GET" class="project-switcher">
                @csrf
                <label for="projectId">{{ __('footer.select_project') }}:</label>
                <select id="projectId" name="projectId" onchange="this.form.submit()">
                    @foreach($projects as $project)
                    <option value="{{ $project['id'] }}" {{ session('projectId') == $project['id'] ? 'selected' : '' }}>
                        {{ $project['title'] }}
                    </option>
                    @endforeach
                </select>
            </form>
            @endauth
        </div>
    </footer>
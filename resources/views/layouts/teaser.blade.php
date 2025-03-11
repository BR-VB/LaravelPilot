            <!-- Teaser Box 1: Random Quote -->
            <div class="teaser-box">
                <h2>{{ __('teaser.quote_header') }}</h2>
                <p>{!! $teaserInfo['quote'] !!}</p>
            </div>
            <!-- Teaser Box 2: Latest Task -->
            @auth
            <div class="teaser-box">
                <h2>{{ __('teaser.project_latest') }}</h2>
                @if(isset($teaserInfo['task']))
                @if(is_string($teaserInfo['task']))
                <p>{{ $teaserInfo['task'] }}</p>
                @else
                <p>{!! $teaserInfo['task']->title !!} <a href="{{ route('projects.show', ['project' => session('projectId'), 'view' => 'latesttask']) }}"><br>{{ __('teaser.show_details') }}</a></p>
                @endif
                @else
                <p>{{ __('teaser.teaser_load_task_error') }}</p>
                @endif
            </div>
            @endauth
            <!-- Teaser Box 3: Latest Blog Post -->
            <div class="teaser-box">
                <h2>{{ __('teaser.interesting_videos') }}</h2>
                <ul>
                    <li><a href="https://www.linkedin.com/learning/laravel-essential-training" class="external-link" target="_blank">{{ __('teaser.link_text_03') }}</a></li>
                </ul>
            </div>
            <!-- Teaser Box 4: Useful Links -->
            <div class="teaser-box">
                <h2>{{ __('teaser.useful_links') }}</h2>
                <ul>
                    <li><a href="https://laravel.com/docs/11.x" class="external-link" target="_blank">{{ __('teaser.link_text_01') }}</a></li>
                    <li><a href="https://www.apachefriends.org/de/index.html" class="external-link" target="_blank">{{ __('teaser.link_text_02') }}</a></li>
                </ul>
            </div>
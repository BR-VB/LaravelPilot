<!-- Hamburger Menu Icon -->
<div class="hamburger" id="hamburger-icon">
    <div class="line"></div>
    <div class="line"></div>
    <div class="line"></div>
</div>

<!-- Desktop Navigation (always visible on large screens) -->
<div class="desktop-nav">
    @foreach($navigation[0] as $index => $navItem)
    @if($index == 0)
    <div class="nav-main-home-icon">
        <a href="{{ route($navItem['route']) }}" title="{{ $navItem['label'] }}&nbsp;{{ $projectTitle }}">
            <img src="{{ Vite::asset('resources/images/icons/home-icon-free.png') }}" alt="{{ __('config.module.home') }}&nbsp;{{ $projectTitle }}">
        </a>
        @auth
        <a class="vertical-centered-link" href="{{ route('projects.show', ['project' => session('projectId')]) }}" title="{{ __('config.show_details_short') }}">{{ __('config.show_details_short') }}</a>
        @else
        <a class="vertical-centered-link" href="{{ route($navItem['route']) }}" title="{{ $navItem['label'] }}&nbsp;{{ $projectTitle }}">{{ $navItem['label'] }} >></a>
        @endauth
    </div>
    <ul>
        @else
        @if(
        ($index == 1 && $navItem['visible'] == true && auth()->check()) ||
        ($index > 1 && $navItem['visible'] == true && auth()->check() && auth()->user()->is_admin)
        )
        @php
        // Setze $itemTxt, abhängig von der Bedingung
        if ($navItem['active'] == true) {
        $itemTxt = '<strong>' . $navItem['label'] . '</strong>';
        } else {
        $itemTxt = $navItem['label'];
        }
        @endphp
        <li>
            <a href="{{ route($navItem['route']) }}">{!! $itemTxt !!}</a>
            @if($index == 1 && $navItem['active'] === true)
            <ul>
                @php
                $views = trans('config.view');
                @endphp
                @foreach($views as $view => $blade)
                <li>
                    <a href="{{ route('projects.show', ['project' => session('projectId'), 'view' => $view]) }}">{{ $view }}</a>
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @endif
        @endif
        @endforeach
    </ul>
</div>

<!-- Hamburger Navigation (only visible on small screens) -->
<div class="menu" id="menu">
    <ul>
        @foreach($navigation[0] as $index => $navItem)
        @if(
        ($index == 0 && $navItem['visible'] == true) ||
        ($index == 1 && $navItem['visible'] == true && auth()->check()) ||
        ($index > 1 && $navItem['visible'] == true && auth()->check() && auth()->user()->is_admin)
        )
        @php
        // Setze $itemTxt, abhängig von der Bedingung
        if ($navItem['active'] == true && trans('config.module.home') != $navItem['label']) {
        $itemTxt = '<strong>' . $navItem['label'] . '</strong>';
        } else {
        $itemTxt = $navItem['label'];
        }
        @endphp
        <li>
            <a href="{{ route($navItem['route']) }}">{!! $itemTxt !!}</a>
        </li>
        @endif
        @endforeach
    </ul>
</div>

<!-- JavaScript Hamburger-Menü -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.getElementById('hamburger-icon');
        const menu = document.getElementById('menu');

        hamburger.addEventListener('click', function() {
            menu.classList.toggle('show');
        });
    });
</script>
    <header>
        <div class="date">
            {{ \Carbon\Carbon::now()->locale(app()->getLocale())->isoFormat(app()->getLocale() == 'de' ? 'ddd, DD.MM.YYYY, HH:mm [Uhr]' : 'ddd, MM-DD-YYYY, hh:mm A') }}
        </div>
        <div class="logo">
            <a href="{{ route('home') }}" title="{{ __('config.module.home') }}&nbsp;{{ $projectTitle }}">{{ $projectTitle }}</a>
        </div>
        <div class="language-switcher">
            <form action="{{ route('language.switch') }}" method="GET" class="language-switcher">
                @csrf
                <select name="locale" onchange="this.form.submit()">
                    @foreach($languages as $locale)
                    <option value="{{ $locale }}" {{ app()->getLocale() == $locale ? 'selected' : '' }}>
                        {{ strtoupper($locale) }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>
        @if (Route::has('login'))
        <nav>
            @auth
            <a href="{{ route('profile.edit') }}">{{ __('header.profile_txt') }}</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('post-form-delete').submit();">{{ __('header.logout_txt') }}</a>
            <form id="post-form-delete" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @else
            <a href="{{ route('login') }}">{{ __('header.login_txt') }}</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}">{{ __('header.register_txt') }}</a>
            @endif
            @endauth
        </nav>
        @endif
    </header>
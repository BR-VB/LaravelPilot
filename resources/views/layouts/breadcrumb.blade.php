            <div class="breadcrumb">
                @foreach($navigation[1] as $index => $navItem)
                @if($index == 0)
                <a href="{{ route($navItem['route']) }}" title="{{ $navItem['label'] }}&nbsp;{{ $projectTitle }}">{{ $projectTitle }}</a>
                @else
                @php
                if ($navItem['model'] && $navItem['id']) {
                $paramModel = $navItem['model'];
                $paramId = $navItem['id'];
                $routeString = route($navItem['route'], [$paramModel => $paramId]);
                } else {
                $routeString = route($navItem['route']);
                }
                @endphp
                <a href="{{ $routeString }}" title="{{ $navItem['label'] }}">{{ $navItem['label'] }}</a>
                @endif
                @endforeach
            </div>
@props(['scope', 'showDescription' => false])

<div class="block">
    <h3>{{ $scope['label'] }}</h3>
    <p>
    <ul>
        @foreach($scope['tasks'] as $task)
        <li>
            {!! $task['icon'] !!}
            @if(!empty($task['icon']) && !empty($task['prefix']))
            &nbsp;
            @endif
            {!! $task['prefix'] !!}
            @if(!empty($task['prefix']) && !empty($task['title']))
            &nbsp;
            @endif
            {!! $task['title'] !!}
        </li>
        @if($showDescription && !empty($task['description']))
        <ul class="no-bullets">
            <li>
                <p class="white-space-pre-wrap">{!! $task['description'] !!}</p>
            </li>
        </ul>
        @endif
        @endforeach
    </ul>
    </p>
</div>
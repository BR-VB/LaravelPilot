@props(['heading', 'explain', 'scopes', 'showDescription' => false])

<div class="column-welcome">
    <h2>{{ $heading }}</h2>
    <p>{!! $explain !!}</p>

    @auth
    <p>
        <x-welcome.show-project-detail-link :projectId="session('projectId')" />
        <br /><br />
    </p>
    @endauth

    @foreach($scopes as $scope)
    @if(!empty($scope['tasks']))
    <x-welcome.scope-block :scope="$scope" :showDescription="$showDescription" />
    @endif
    @endforeach
</div>
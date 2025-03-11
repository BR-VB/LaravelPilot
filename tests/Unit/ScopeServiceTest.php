<?php

namespace Tests\Unit;

use App\Models\Scope;
use App\Services\ScopeService;
use Illuminate\Support\Facades\App;
use Mockery;
use PHPUnit\Framework\TestCase;

class ScopeServiceTest extends TestCase
{
    public function test_it_can_get_scopes_sorted_by_label_in_en(): void
    {
        //Facade App
        App::shouldReceive('getLocale')->andReturn('en');

        //mock scope model
        $mockScope = Mockery::mock('alias:'.Scope::class);
        $mockScope->shouldReceive('where')
            ->once()
            ->with('project_id', 1)
            ->andReturnSelf();
        $mockScope->shouldReceive('select')
            ->once()
            ->with('id', 'label', 'locale')
            ->andReturnSelf();
        $mockScope->shouldReceive('get')
            ->once()
            ->andReturn(collect([
                (object) ['id' => 1, 'label' => 'Scope B', 'locale' => 'en'],
                (object) ['id' => 2, 'label' => 'Scope A', 'locale' => 'en'],
            ]));

        //mock getTranslations
        $mockScope->shouldReceive('getTranslations')
            ->once()
            ->andReturnUsing(function ($scopes) {
                return $scopes->map(function ($scope) {
                    if ($scope->locale !== 'en') {
                        $scope->label = $scope->label.' (T)';
                    }

                    return $scope;
                });
            });

        $scopes = collect([
            (object) ['id' => 1, 'label' => 'Scope B', 'locale' => 'en'],
            (object) ['id' => 2, 'label' => 'Scope A', 'locale' => 'en'],
        ]);
        $scopes = $scopes->sortBy('label')->pluck('label', 'id');

        //act: invoke service
        $scopeService = new ScopeService;
        $scopeServiceResult = $scopeService->getScopes(1);

        //assert
        $this->assertCount(2, $scopes);
        $this->assertCount(2, $scopeServiceResult);
        $this->assertEquals($scopes->values()->toArray(), $scopeServiceResult->values()->toArray());
    }

    public function test_it_can_get_scopes_sorted_by_label_in_de(): void
    {
        //Facade App
        App::shouldReceive('getLocale')->andReturn('de');

        //mock scope model
        $mockScope = Mockery::mock('alias:'.Scope::class);
        $mockScope->shouldReceive('where')
            ->once()
            ->with('project_id', 1)
            ->andReturnSelf();
        $mockScope->shouldReceive('select')
            ->once()
            ->with('id', 'label', 'locale')
            ->andReturnSelf();
        $mockScope->shouldReceive('get')
            ->once()
            ->andReturn(collect([
                (object) ['id' => 1, 'label' => 'Scope B', 'locale' => 'en'],
                (object) ['id' => 2, 'label' => 'Scope A', 'locale' => 'en'],
            ]));

        //mock getTranslations
        $mockScope->shouldReceive('getTranslations')
            ->once()
            ->andReturnUsing(function ($scopes) {
                return $scopes->map(function ($scope) {
                    if ($scope->locale !== 'de') {
                        $scope->label = $scope->label.' (T)';
                    }

                    return $scope;
                });
            });

        $scopes = collect([
            (object) ['id' => 1, 'label' => 'Scope B (T)', 'locale' => 'en'],
            (object) ['id' => 2, 'label' => 'Scope A (T)', 'locale' => 'en'],
        ]);
        $scopes = $scopes->sortBy('label')->pluck('label', 'id');

        //act: invoke service
        $scopeService = new ScopeService;
        $scopeServiceResult = $scopeService->getScopes(1);

        //assert
        $this->assertCount(2, $scopes);
        $this->assertCount(2, $scopeServiceResult);
        $this->assertEquals($scopes->values()->toArray(), $scopeServiceResult->values()->toArray());
    }

    protected function tearDown(): void
    {
        //claen up
        Mockery::close();
        parent::tearDown();
    }
}

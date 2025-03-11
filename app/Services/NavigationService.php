<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class NavigationService
{
    protected ?array $navigation = null;

    public function getNavigation(): array
    {
        //if already loaded during loading process ...
        if ($this->navigation !== null) {
            Log::info(class_basename(self::class), [__('navigation.navigation_loaded_singleton')]);

            return $this->navigation;
        }

        //get current route
        $currentRoute = Route::currentRouteName();
        $currentModel = Str::singular(explode('.', $currentRoute, 2)[0]);
        $routeParam = request()->route($currentModel);
        $currentId = $routeParam instanceof \Illuminate\Database\Eloquent\Model ? $routeParam->getKey() : (is_numeric($routeParam) ? (int) $routeParam : null);

        //get supported modules
        $modules = trans('config.module');
        if (! is_array($modules)) {
            Log::warning(class_basename(self::class), [__('navigation.no_mdoules_found')]);

            return [];
        }

        $this->navigation = $this->buildNavigation($modules, $currentRoute, $currentModel, $currentId);

        Log::info(class_basename(self::class), [__('navigation.navigation_loaded')]);

        return $this->navigation;
    }

    private function buildNavigation(array $modules, string $currentRoute, ?string $currentModel, ?string $currentId): array
    {
        $navigation = [[], []];
        foreach ($modules as $route => $label) {
            $isHidden = str_starts_with($route, '#h#');
            $realRoute = $isHidden ? substr($route, 3) : $route;
            $isActive = $this->isActiveRoute($currentRoute, $realRoute, $label);

            $navigation[0][] = $this->buildNavigationItem($realRoute, $label, ! $isHidden, $isActive);

            if ($isActive) {
                $navigation[1][] = $this->buildActiveItem($realRoute, $label, $currentRoute, $currentModel, $currentId);
            }
        }

        return $navigation;
    }

    private function buildNavigationItem(string $route, string $label, bool $visible, bool $active): array
    {
        return [
            'route' => $route,
            'label' => $label,
            'visible' => $visible,
            'active' => $active,
        ];
    }

    private function buildActiveItem(string $route, string $label, string $currentRoute, ?string $model, ?string $id): array
    {
        return [
            'route' => $route,
            'label' => $label,
            'model' => $route === $currentRoute ? $model : null,
            'id' => $route === $currentRoute ? $id : null,
        ];
    }

    private function isActiveRoute(string $currentRoute, string $realRoute, string $label): bool
    {
        return $realRoute === $currentRoute ||
            $label === trans('config.module.home') ||
            ($this->compareBeginning($currentRoute, $realRoute) && (str_ends_with($realRoute, '.index')));
    }

    private function compareBeginning(string $firstString, string $secondString): bool
    {
        $part1 = strstr($firstString, '.', true) ?: $firstString;
        $part2 = strstr($secondString, '.', true) ?: $secondString;

        return $part1 === $part2;
    }
}

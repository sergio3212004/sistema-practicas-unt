<?php

namespace App\View;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

final class PageTitleResolver
{
    public function __construct(private readonly Request $request) {}

    public function pageTitle(?string $explicitTitle = null): string
    {
        if (filled($explicitTitle)) {
            return trim($explicitTitle);
        }

        $routeName = $this->request->route()?->getName();
        $titles = config('page-titles.routes', []);

        if ($routeName !== null && isset($titles[$routeName])) {
            return $titles[$routeName];
        }

        if ($routeName === null || str_starts_with($routeName, 'generated::')) {
            return 'Inicio';
        }

        return Str::of($routeName)
            ->afterLast('.')
            ->replace('-', ' ')
            ->headline()
            ->toString();
    }

    public function documentTitle(?string $explicitTitle = null): string
    {
        $applicationName = config('app.name', 'Sistema de Prácticas Preprofesionales UNT');

        return $this->pageTitle($explicitTitle).' | '.$applicationName;
    }
}

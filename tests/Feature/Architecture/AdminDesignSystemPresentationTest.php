<?php

use Illuminate\Support\Facades\File;

it('uses the institutional page structure throughout the administrator module', function () {
    $violations = [];

    foreach (File::allFiles(resource_path('views/admin')) as $file) {
        if (str_contains($file->getPathname(), DIRECTORY_SEPARATOR.'partials'.DIRECTORY_SEPARATOR)) {
            continue;
        }

        $contents = $file->getContents();

        if (! str_contains($contents, '<x-app-layout')
            || ! str_contains($contents, '<x-ui.page-header')
            || ! str_contains($contents, 'class="ui-page')) {
            $violations[] = $file->getRelativePathname();
        }
    }

    expect($violations)->toBeEmpty();
});

it('does not reintroduce decorative legacy styles into administrator views', function () {
    $adminViews = collect(File::allFiles(resource_path('views/admin')))
        ->map->getContents()
        ->implode("\n");

    expect($adminViews)
        ->not->toContain('bg-gradient-')
        ->not->toContain('shadow-xl')
        ->not->toContain('shadow-2xl')
        ->not->toContain('bg-indigo-')
        ->not->toContain('bg-purple-')
        ->not->toContain('bg-cyan-')
        ->not->toContain('bg-teal-');
});

it('uses shared fields and labels in role-specific administrator forms', function () {
    foreach ([
        'alumno-form.blade.php',
        'administrador-form.blade.php',
        'empresa-form.blade.php',
        'profesor-form.blade.php',
    ] as $component) {
        expect(File::get(resource_path("views/components/{$component}")))
            ->toContain('ui-label')
            ->toContain('ui-field')
            ->not->toContain('rounded-lg border-gray-300 shadow-sm');
    }
});

it('keeps administrator search filters when navigating paginated results', function () {
    $users = File::get(app_path('Http/Controllers/Admin/UserController.php'));
    $reports = File::get(app_path('Http/Controllers/Admin/InformeFinalController.php'));

    expect($users)
        ->toContain("'q' => ['nullable', 'string', 'max:100']")
        ->toContain('->withQueryString()')
        ->and($reports)
        ->toContain("->orWhere('codigo_matricula', 'like'")
        ->toContain('->withQueryString()');
});

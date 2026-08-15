<?php

use Illuminate\Support\Facades\File;

it('uses the institutional page structure throughout the professor module', function () {
    $violations = [];

    foreach (File::allFiles(resource_path('views/profesor')) as $file) {
        if ($file->getFilename() === 'pdf.blade.php') {
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

it('does not reintroduce decorative legacy styles into professor views', function () {
    $views = collect(File::allFiles(resource_path('views/profesor')))
        ->reject(fn ($file) => $file->getFilename() === 'pdf.blade.php')
        ->map->getContents()
        ->implode("\n");

    expect($views)
        ->not->toContain('bg-gradient-')
        ->not->toContain('shadow-xl')
        ->not->toContain('shadow-2xl')
        ->not->toContain('bg-indigo-')
        ->not->toContain('bg-purple-')
        ->not->toContain('bg-cyan-')
        ->not->toContain('bg-teal-')
        ->not->toContain('href="#"');
});

it('keeps final reports scoped to the authenticated professor', function () {
    $controller = File::get(app_path('Http/Controllers/Profesor/InformeFinalController.php'));

    expect($controller)
        ->toContain("whereHas('alumno.aula'")
        ->toContain("->orWhere('codigo_matricula', 'like'")
        ->toContain('->withQueryString()')
        ->toContain('abort_unless(');
});

<?php

use Illuminate\Support\Facades\File;

it('provides keyboard bypass links and a focusable main landmark', function () {
    foreach (['app', 'guest'] as $layoutName) {
        $layout = File::get(resource_path("views/layouts/{$layoutName}.blade.php"));

        expect($layout)
            ->toContain('href="#contenido-principal"')
            ->toContain('<main')
            ->toContain('id="contenido-principal"')
            ->toContain('tabindex="-1"');
    }
});

it('keeps hidden navigation out of the keyboard and accessibility trees', function () {
    $navigation = File::get(resource_path('views/layouts/navigation.blade.php'));
    $javascript = File::get(resource_path('js/app.js'));

    expect($navigation)
        ->toContain(':inert="!navigationVisible()"')
        ->toContain(':aria-hidden="(!navigationVisible()).toString()"')
        ->toContain(':aria-modal="!desktop && navigationOpen ? \'true\' : null"')
        ->and($javascript)
        ->toContain('trapNavigationFocus(event)')
        ->toContain('returnFocusTo');
});

it('does not remove global notifications before users dismiss them', function () {
    $flash = File::get(resource_path('views/components/ui/flash.blade.php'));

    expect($flash)
        ->not->toContain('setTimeout')
        ->toContain('aria-label="Notificaciones del sistema"')
        ->toContain('aria-atomic="true"');
});

it('gives every interactive data table an accessible caption', function () {
    $violations = [];

    foreach (File::allFiles(resource_path('views')) as $file) {
        $path = $file->getPathname();

        if (str_contains($path, DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR)
            || str_contains($path, DIRECTORY_SEPARATOR.'emails'.DIRECTORY_SEPARATOR)
            || str_ends_with($path, DIRECTORY_SEPARATOR.'pdf.blade.php')) {
            continue;
        }

        $contents = $file->getContents();
        $tables = substr_count($contents, '<table');
        $captions = substr_count($contents, '<caption');

        if ($tables > $captions) {
            $violations[] = $file->getRelativePathname()." ({$captions}/{$tables} captions)";
        }
    }

    expect($violations)->toBeEmpty();
});

it('offers a keyboard-operable image upload alternative for every signature canvas', function () {
    $violations = [];

    foreach (File::allFiles(resource_path('views')) as $file) {
        $contents = $file->getContents();

        if (str_contains($contents, '<canvas')
            && ! str_contains($contents, 'data-signature-upload')) {
            $violations[] = $file->getRelativePathname();
        }
    }

    expect($violations)->toBeEmpty();
});

it('associates shared validation errors with their form controls', function () {
    $textInput = File::get(resource_path('views/components/text-input.blade.php'));
    $passwordInput = File::get(resource_path('views/components/password-input.blade.php'));
    $inputError = File::get(resource_path('views/components/input-error.blade.php'));

    foreach ([$textInput, $passwordInput] as $component) {
        expect($component)
            ->toContain('aria-invalid="true"')
            ->toContain('aria-describedby');
    }

    expect($inputError)
        ->toContain('id="{{ $for }}-error"')
        ->toContain('role="alert"');
});

it('keeps custom dialogs keyboard operable and restores focus', function () {
    foreach ([
        'alumno/entregas/index.blade.php',
        'profesor/actividades/show.blade.php',
        'profesor/informes/show.blade.php',
    ] as $view) {
        $contents = File::get(resource_path("views/{$view}"));

        expect($contents)
            ->toContain('role="dialog"')
            ->toContain('aria-modal="true"')
            ->toContain("e.key === 'Escape'")
            ->toContain('document.activeElement')
            ->toContain('?.focus()');
    }
});

it('secures and announces links that open a new tab', function () {
    $violations = [];

    foreach (File::allFiles(resource_path('views')) as $file) {
        $path = $file->getPathname();

        if (str_contains($path, DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR)
            || str_contains($path, DIRECTORY_SEPARATOR.'emails'.DIRECTORY_SEPARATOR)
            || str_ends_with($path, DIRECTORY_SEPARATOR.'pdf.blade.php')) {
            continue;
        }

        $contents = $file->getContents();
        $newTabs = substr_count($contents, 'target="_blank"');

        if ($newTabs > substr_count($contents, 'rel="noopener noreferrer"')
            || $newTabs > substr_count($contents, '(se abre en una pestaña nueva)')) {
            $violations[] = $file->getRelativePathname();
        }
    }

    expect($violations)->toBeEmpty();
});

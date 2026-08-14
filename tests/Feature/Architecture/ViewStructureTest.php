<?php

use Illuminate\Support\Facades\File;

it('keeps database access and model imports out of Blade templates', function () {
    $violations = [];
    $rules = [
        'model import' => '/(?:App\\\\Models|\\\\App\\\\Models)/',
        'database facade' => '/\b(?:DB|Auth|Gate)::/',
        'relationship query' => '/->\w+\(\)->(?:where|count|sum|first|get|exists|max|min|with|orderBy)\s*\(/',
    ];

    foreach (File::allFiles(resource_path('views')) as $file) {
        if (str_contains($file->getPathname(), DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR)) {
            continue;
        }

        $contents = $file->getContents();

        foreach ($rules as $rule => $pattern) {
            if (preg_match($pattern, $contents) === 1) {
                $violations[] = $file->getRelativePathname()." ({$rule})";
            }
        }
    }

    expect($violations)->toBeEmpty();
});

<?php

use Illuminate\Support\Facades\Blade;

it('renders academic Markdown without executable HTML or unsafe links', function () {
    $html = Blade::render('<x-ui.markdown-content :content="$content" />', [
        'content' => "## Avance\n\n**Completado**\n\n<script>alert(1)</script>\n\n[Enlace](javascript:alert(1))",
    ]);

    expect($html)->toContain('<h2>Avance</h2>')
        ->toContain('<strong>Completado</strong>')
        ->not->toContain('<script>')
        ->not->toContain('href="javascript:');
});

<?php

use Illuminate\Support\Facades\File;

it('provides a global collapsible navigation in the authenticated layout', function () {
    $layout = File::get(resource_path('views/layouts/app.blade.php'));
    $navigation = File::get(resource_path('views/layouts/navigation.blade.php'));
    $javascript = File::get(resource_path('js/app.js'));

    expect($layout)
        ->toContain('x-data="navigation"')
        ->toContain('@click="toggleNavigation()"')
        ->toContain('aria-controls="primary-navigation"')
        ->toContain(":aria-expanded=\"navigationVisible()\"")
        ->and($navigation)
        ->toContain('id="primary-navigation"')
        ->toContain("'lg:translate-x-0': navigationExpanded")
        ->toContain("'lg:-translate-x-full': ! navigationExpanded")
        ->and($javascript)
        ->toContain("Alpine.data('navigation'")
        ->toContain("window.localStorage.getItem('navigation.expanded')")
        ->toContain('toggleNavigation()')
        ->toContain('closeNavigation()');
});

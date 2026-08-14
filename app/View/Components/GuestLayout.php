<?php

namespace App\View\Components;

use App\View\PageTitleResolver;
use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public readonly string $documentTitle;

    public readonly string $heading;

    public function __construct(
        PageTitleResolver $pageTitles,
        public readonly ?string $title = null,
        public readonly ?string $subtitle = null,
    ) {
        $this->documentTitle = $pageTitles->documentTitle($this->title);
        $this->heading = $pageTitles->pageTitle($this->title);
    }

    public function render(): View
    {
        $companyActive = request()->routeIs('empresa.*');
        $loginActive = request()->routeIs('login');

        return view('layouts.guest', [
            'description' => $this->subtitle ?? ($loginActive
                ? 'Continúa con tus credenciales para acceder a tu espacio de trabajo.'
                : 'Completa la información solicitada para continuar con el proceso.'),
            'loginActive' => $loginActive,
            'companyActive' => $companyActive,
            'currentYear' => now()->year,
        ]);
    }
}

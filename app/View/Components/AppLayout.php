<?php

namespace App\View\Components;

use App\View\PageTitleResolver;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public readonly string $documentTitle;

    public function __construct(
        PageTitleResolver $pageTitles,
        public readonly ?string $title = null,
    ) {
        $this->documentTitle = $pageTitles->documentTitle($this->title);
    }

    public function render(): View
    {
        return view('layouts.app');
    }
}

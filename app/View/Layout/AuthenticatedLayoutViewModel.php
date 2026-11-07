<?php

namespace App\View\Layout;

final readonly class AuthenticatedLayoutViewModel
{
    /**
     * @param  array<int, array<string, mixed>>  $menuItems
     */
    public function __construct(
        public string $userName,
        public string $roleLabel,
        public string $initial,
        public bool $dashboardActive,
        public array $menuItems,
        public bool $treeNavigation = false,
    ) {}
}

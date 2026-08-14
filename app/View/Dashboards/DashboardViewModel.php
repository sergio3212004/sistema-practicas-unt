<?php

namespace App\View\Dashboards;

use App\Enums\UserRole;

interface DashboardViewModel
{
    public function role(): UserRole;
}

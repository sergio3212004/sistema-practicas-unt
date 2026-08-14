<?php

use App\Actions\Companies\ApproveCompanyApplication;
use App\Models\RazonSocial;
use App\Models\Rol;
use App\Models\SolicitudEmpresa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

test('approving a company resolves the role by name and activates the company', function () {
    Event::fake([Registered::class]);

    Rol::query()->create(['nombre' => 'administrador']);
    $companyRole = Rol::query()->create(['nombre' => 'empresa']);
    $businessType = RazonSocial::query()->create(['acronimo' => 'SAC']);
    $application = SolicitudEmpresa::query()->create([
        'ruc' => '20123456789',
        'nombre' => 'Empresa de prueba',
        'email' => 'empresa@unit.test',
        'password' => 'password',
        'razon_social_id' => $businessType->id,
        'email_verificado' => true,
        'estado' => 'pendiente',
    ]);

    $user = app(ApproveCompanyApplication::class)->handle($application);

    expect($user->rol_id)->toBe($companyRole->id)
        ->and($user->empresa->aprobado)->toBeTrue()
        ->and($application->fresh()->estado)->toBe('aprobado');

    Event::assertDispatched(Registered::class);
});

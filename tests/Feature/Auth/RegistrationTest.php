<?php

use App\Models\RazonSocial;
use App\Models\SolicitudEmpresa;
use Database\Seeders\RazonesSocialesSeeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

test('generic user registration is disabled', function () {
    $response = $this->get('/register');

    $response->assertNotFound();
});

test('company registration screen can be rendered', function () {
    $response = $this->get('/empresa/register');

    $response->assertOk()
        ->assertSee('Consultar RUC')
        ->assertSee('companyRegistration');
});

test('company data is obtained from the SUNAT RUC provider', function () {
    $this->seed(RazonesSocialesSeeder::class);
    config()->set('services.sunat.ruc_lookup_url', 'https://sunat-provider.test/ruc');
    config()->set('services.sunat.ruc_api_token', 'secret-token');
    Http::fake([
        'https://sunat-provider.test/ruc*' => Http::response([
            'razonSocial' => 'TECNOLOGIA TRUJILLO S.A.C.',
            'numeroDocumento' => '20601234567',
            'estado' => 'ACTIVO',
            'condicion' => 'HABIDO',
            'direccion' => 'AV. ESPAÑA NRO. 123',
            'departamento' => 'LA LIBERTAD',
            'provincia' => 'TRUJILLO',
            'distrito' => 'TRUJILLO',
            'tipo' => 'SOCIEDAD ANONIMA CERRADA',
        ]),
    ]);

    $businessType = RazonSocial::query()->where('acronimo', 'S.A.C.')->firstOrFail();

    $response = $this->postJson(route('empresa.ruc.lookup'), ['ruc' => '20601234567']);

    $response
        ->assertOk()
        ->assertJsonPath('status', 'complete')
        ->assertJsonPath('data.nombre', 'TECNOLOGIA TRUJILLO S.A.C.')
        ->assertJsonPath('data.razon_social_id', $businessType->id)
        ->assertJsonPath('data.departamento', 'LA LIBERTAD')
        ->assertJsonPath('data.estado', 'ACTIVO')
        ->assertJsonPath('data.condicion', 'HABIDO')
        ->assertJsonPath('missing_fields', []);

    $response->assertSessionHas('company_registration.ruc_lookup.ruc', '20601234567');

    Http::assertSent(fn ($request): bool => $request->hasHeader('Authorization', 'Bearer secret-token')
        && $request['numero'] === '20601234567');
});

test('only missing SUNAT fields remain available for manual completion', function () {
    $this->seed(RazonesSocialesSeeder::class);
    config()->set('services.sunat.ruc_lookup_url', 'https://sunat-provider.test/ruc');
    config()->set('services.sunat.ruc_api_token', 'secret-token');
    Http::fake([
        'https://sunat-provider.test/ruc*' => Http::response([
            'razonSocial' => 'EMPRESA SIN SUFIJO',
            'estado' => 'ACTIVO',
            'departamento' => 'LA LIBERTAD',
            'provincia' => 'TRUJILLO',
        ]),
    ]);

    $this->postJson(route('empresa.ruc.lookup'), ['ruc' => '20601234567'])
        ->assertOk()
        ->assertJsonPath('status', 'incomplete')
        ->assertJsonFragment(['razon_social_id'])
        ->assertJsonFragment(['distrito'])
        ->assertJsonFragment(['direccion'])
        ->assertJsonPath('data.nombre', 'EMPRESA SIN SUFIJO');
});

test('manual fallback is enabled when the SUNAT provider is unavailable', function () {
    $this->seed(RazonesSocialesSeeder::class);
    config()->set('services.sunat.ruc_lookup_url', 'https://sunat-provider.test/ruc');
    config()->set('services.sunat.ruc_api_token', 'secret-token');
    Http::fake([
        'https://sunat-provider.test/ruc*' => Http::response([], 503),
    ]);

    $response = $this->postJson(route('empresa.ruc.lookup'), ['ruc' => '20601234567']);

    $response
        ->assertServiceUnavailable()
        ->assertJsonPath('allow_manual', true);

    $response->assertSessionHas('company_registration.ruc_lookup.ruc', '20601234567');

    Mail::fake();
    $businessType = RazonSocial::query()->where('acronimo', 'S.R.L.')->firstOrFail();

    $this->post(route('empresa.register'), [
        'ruc' => '20601234567',
        'nombre' => 'EMPRESA REGISTRADA MANUALMENTE S.R.L.',
        'razon_social_id' => $businessType->id,
        'email' => 'manual@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'departamento' => 'LA LIBERTAD',
        'provincia' => 'TRUJILLO',
        'distrito' => 'TRUJILLO',
        'direccion' => 'JR. INDEPENDENCIA 123',
    ])->assertRedirect(route('empresa.verify.form'));

    $this->assertDatabaseHas('solicitudes_empresa', [
        'ruc' => '20601234567',
        'nombre' => 'EMPRESA REGISTRADA MANUALMENTE S.R.L.',
        'razon_social_id' => $businessType->id,
    ]);
});

test('SUNAT values cannot be replaced when the company submits its registration', function () {
    $this->seed(RazonesSocialesSeeder::class);
    config()->set('services.sunat.ruc_lookup_url', 'https://sunat-provider.test/ruc');
    config()->set('services.sunat.ruc_api_token', 'secret-token');
    Http::fake([
        'https://sunat-provider.test/ruc*' => Http::response([
            'razonSocial' => 'EMPRESA VERIFICADA S.A.C.',
            'direccion' => 'AV. OFICIAL 456',
            'departamento' => 'LA LIBERTAD',
            'provincia' => 'TRUJILLO',
            'distrito' => 'TRUJILLO',
            'tipo' => 'SOCIEDAD ANONIMA CERRADA',
        ]),
    ]);
    Mail::fake();

    $this->postJson(route('empresa.ruc.lookup'), ['ruc' => '20601234567'])->assertOk();
    $businessType = RazonSocial::query()->where('acronimo', 'S.A.C.')->firstOrFail();

    $this->post(route('empresa.register'), [
        'ruc' => '20601234567',
        'nombre' => 'EMPRESA ALTERADA',
        'razon_social_id' => RazonSocial::query()->where('acronimo', 'S.R.L.')->value('id'),
        'email' => 'empresa@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'departamento' => 'LIMA',
        'provincia' => 'LIMA',
        'distrito' => 'LIMA',
        'direccion' => 'DIRECCION ALTERADA',
    ])->assertRedirect(route('empresa.verify.form'));

    $application = SolicitudEmpresa::query()->firstOrFail();

    expect($application->nombre)->toBe('EMPRESA VERIFICADA S.A.C.')
        ->and($application->razon_social_id)->toBe($businessType->id)
        ->and($application->departamento)->toBe('LA LIBERTAD')
        ->and($application->direccion)->toBe('AV. OFICIAL 456');
});

test('company registration requires a previous RUC lookup', function () {
    $this->seed(RazonesSocialesSeeder::class);

    $this->from(route('empresa.register.form'))->post(route('empresa.register'), [
        'ruc' => '20601234567',
    ])->assertRedirect(route('empresa.register.form'))
        ->assertSessionHasErrors('ruc');

    expect(SolicitudEmpresa::query()->exists())->toBeFalse();
});

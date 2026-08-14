<?php

namespace App\Services\Companies;

use App\Services\Sunat\RucCompanyData;
use App\Services\Sunat\SunatRucService;
use Illuminate\Support\Facades\Session;

class CompanyRegistrationLookup
{
    private const SESSION_KEY = 'company_registration.ruc_lookup';

    public function __construct(
        private readonly SunatRucService $sunat,
        private readonly BusinessTypeResolver $businessTypes,
    ) {}

    /**
     * @return array{data: array<string, string|int|null>, readonly_fields: list<string>, missing_fields: list<string>}
     */
    public function lookup(string $ruc): array
    {
        $company = $this->sunat->lookup($ruc);
        $data = $this->formData($company);
        $readonlyFields = array_keys(array_filter(
            $data,
            fn (mixed $value, string $field): bool => $field !== 'ruc' && $value !== null,
            ARRAY_FILTER_USE_BOTH,
        ));
        $missingFields = array_values(array_diff(
            ['nombre', 'razon_social_id', 'departamento', 'provincia', 'distrito', 'direccion'],
            $readonlyFields,
        ));

        $this->remember($ruc, $data, $readonlyFields);

        return [
            'data' => $data,
            'readonly_fields' => $readonlyFields,
            'missing_fields' => $missingFields,
        ];
    }

    public function allowManualFallback(string $ruc): void
    {
        $this->remember($ruc, [], []);
    }

    /**
     * Returns only fields obtained from the provider, so values submitted for
     * those fields cannot replace the SUNAT lookup result.
     *
     * @return array<string, string|int>|null
     */
    public function trustedDataFor(string $ruc): ?array
    {
        $lookup = Session::get(self::SESSION_KEY);

        if (! is_array($lookup) || ($lookup['ruc'] ?? null) !== $ruc) {
            return null;
        }

        $data = is_array($lookup['data'] ?? null) ? $lookup['data'] : [];
        $fields = is_array($lookup['readonly_fields'] ?? null) ? $lookup['readonly_fields'] : [];

        return array_intersect_key($data, array_flip($fields));
    }

    public function forget(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * @return array<string, string|int|null>
     */
    private function formData(RucCompanyData $company): array
    {
        return [
            'ruc' => $company->ruc,
            'nombre' => $company->name,
            'razon_social_id' => $this->businessTypes->resolveId($company),
            'departamento' => $company->department,
            'provincia' => $company->province,
            'distrito' => $company->district,
            'direccion' => $company->address,
            'estado' => $company->status,
            'condicion' => $company->condition,
        ];
    }

    /**
     * @param  array<string, string|int|null>  $data
     * @param  list<string>  $readonlyFields
     */
    private function remember(string $ruc, array $data, array $readonlyFields): void
    {
        Session::put(self::SESSION_KEY, [
            'ruc' => $ruc,
            'data' => $data,
            'readonly_fields' => $readonlyFields,
        ]);
    }
}

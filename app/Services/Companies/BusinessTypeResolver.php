<?php

namespace App\Services\Companies;

use App\Models\RazonSocial;
use App\Services\Sunat\RucCompanyData;
use Illuminate\Support\Str;

class BusinessTypeResolver
{
    public function resolveId(RucCompanyData $company): ?int
    {
        $acronym = $this->detectAcronym($company->taxpayerType, $company->name);

        if ($acronym === null) {
            return null;
        }

        return RazonSocial::query()
            ->where('acronimo', $acronym)
            ->value('id');
    }

    public function detectAcronym(?string $taxpayerType, ?string $companyName): ?string
    {
        $type = $this->compact($taxpayerType);

        $types = [
            'SOCIEDADPORACCIONESCERRADASIMPLIFICADA' => 'S.A.C.S.',
            'SOCIEDADANONIMACERRADA' => 'S.A.C.',
            'SOCIEDADANONIMAABIERTA' => 'S.A.A.',
            'SOCIEDADCOMERCIALDERESPONSABILIDADLIMITADA' => 'S.R.L.',
            'EMPRESAINDIVIDUALDERESPONSABILIDADLIMITADA' => 'E.I.R.L.',
            'SOCIEDADANONIMA' => 'S.A.',
        ];

        foreach ($types as $description => $acronym) {
            if ($type !== '' && str_contains($type, $description)) {
                return $acronym;
            }
        }

        $name = $this->compact($companyName);
        $suffixes = [
            'SACS' => 'S.A.C.S.',
            'EIRL' => 'E.I.R.L.',
            'SAC' => 'S.A.C.',
            'SRL' => 'S.R.L.',
            'SAA' => 'S.A.A.',
            'SA' => 'S.A.',
        ];

        foreach ($suffixes as $suffix => $acronym) {
            if (str_ends_with($name, $suffix)) {
                return $acronym;
            }
        }

        return null;
    }

    private function compact(?string $value): string
    {
        return preg_replace('/[^A-Z0-9]/', '', Str::upper(Str::ascii($value ?? ''))) ?? '';
    }
}

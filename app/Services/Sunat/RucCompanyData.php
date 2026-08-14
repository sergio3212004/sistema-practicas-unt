<?php

namespace App\Services\Sunat;

final readonly class RucCompanyData
{
    public function __construct(
        public string $ruc,
        public ?string $name,
        public ?string $address,
        public ?string $department,
        public ?string $province,
        public ?string $district,
        public ?string $taxpayerType,
        public ?string $status,
        public ?string $condition,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function fromProvider(string $ruc, array $payload): self
    {
        return new self(
            ruc: $ruc,
            name: self::stringValue($payload['razonSocial'] ?? $payload['nombre'] ?? null),
            address: self::stringValue($payload['direccion'] ?? null),
            department: self::stringValue($payload['departamento'] ?? null),
            province: self::stringValue($payload['provincia'] ?? null),
            district: self::stringValue($payload['distrito'] ?? null),
            taxpayerType: self::stringValue($payload['tipo'] ?? null),
            status: self::stringValue($payload['estado'] ?? null),
            condition: self::stringValue($payload['condicion'] ?? null),
        );
    }

    private static function stringValue(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value === '' || $value === '-' ? null : $value;
    }
}

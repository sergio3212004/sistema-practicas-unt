<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMINISTRADOR = 'administrador';
    case ALUMNO = 'alumno';
    case EMPRESA = 'empresa';
    case PROFESOR = 'profesor';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(
            static fn (self $role): string => $role->value,
            self::cases(),
        );
    }

    public function label(): string
    {
        return match ($this) {
            self::ADMINISTRADOR => 'Administrador',
            self::ALUMNO => 'Estudiante',
            self::EMPRESA => 'Empresa',
            self::PROFESOR => 'Docente',
        };
    }
}

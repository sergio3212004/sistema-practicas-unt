<?php

namespace App\Actions\Companies;

use App\Enums\UserRole;
use App\Models\Rol;
use App\Models\SolicitudEmpresa;
use App\Models\User;
use DomainException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class ApproveCompanyApplication
{
    public function handle(SolicitudEmpresa $application): User
    {
        if (! $application->isApprovable()) {
            throw new DomainException('Esta solicitud no puede ser aprobada.');
        }

        $user = DB::transaction(function () use ($application): User {
            $companyRole = Rol::query()
                ->where('nombre', UserRole::EMPRESA->value)
                ->firstOrFail();

            $user = User::query()->create([
                'email' => $application->email,
                'password' => $application->password,
                'rol_id' => $companyRole->getKey(),
            ]);

            $user->empresa()->create([
                'ruc' => $application->ruc,
                'nombre' => $application->nombre,
                'razon_social_id' => $application->razon_social_id,
                'telefono' => $application->telefono,
                'departamento' => $application->departamento,
                'provincia' => $application->provincia,
                'distrito' => $application->distrito,
                'direccion' => $application->direccion,
                'aprobado' => true,
            ]);

            $application->update(['estado' => 'aprobado']);

            return $user;
        });

        event(new Registered($user));

        return $user;
    }
}

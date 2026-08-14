<?php

namespace App\Http\Requests\Alumno;

use App\Models\Actividad;

class StoreEntregaRequest extends EntregaRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('submit', $this->route('actividad')) === true;
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        /** @var Actividad $actividad */
        $actividad = $this->route('actividad');

        return $this->deliveryRules($actividad->tipoActividad->modo_entrega);
    }
}

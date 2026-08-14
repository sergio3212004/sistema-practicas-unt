<?php

namespace App\Http\Requests\Alumno;

use App\Models\Entrega;

class UpdateEntregaRequest extends EntregaRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage', $this->route('entrega')) === true;
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        /** @var Entrega $entrega */
        $entrega = $this->route('entrega');

        return $this->deliveryRules(
            $entrega->actividad->tipoActividad->modo_entrega,
            includeObservations: true,
        );
    }
}

<?php

namespace App\Http\Requests\Empresa;

class UpdatePublicacionRequest extends StorePublicacionRequest
{
    public function authorize(): bool
    {
        $publicacion = $this->route('publicacion');

        return $publicacion !== null
            && $this->user()?->can('manage', $publicacion) === true;
    }
}

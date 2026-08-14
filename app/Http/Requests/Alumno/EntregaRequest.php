<?php

namespace App\Http\Requests\Alumno;

use Illuminate\Foundation\Http\FormRequest;

abstract class EntregaRequest extends FormRequest
{
    /**
     * @return array<string, array<mixed>>
     */
    protected function deliveryRules(string $mode, bool $includeObservations = false): array
    {
        $rules = match ($mode) {
            'pdf' => [
                'archivo' => ['required', 'file', 'mimes:pdf,doc,docx,zip,rar', 'max:10240'],
            ],
            'drive' => [
                'drive_file_id' => ['required', 'string'],
                'drive_file_name' => ['required', 'string'],
            ],
            default => [],
        };

        if ($includeObservations) {
            $rules['observaciones'] = ['nullable', 'string', 'max:500'];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'archivo.required' => 'Debes adjuntar un archivo para la entrega.',
            'archivo.mimes' => 'El archivo debe ser PDF, DOC, DOCX, ZIP o RAR.',
            'archivo.max' => 'El archivo no puede superar los 10MB.',
            'drive_file_id.required' => 'Debes seleccionar un archivo de Google Drive.',
            'drive_file_name.required' => 'El nombre del archivo es requerido.',
        ];
    }
}

<?php

namespace App\Http\Requests\Admin;

class StoreUserRequest extends UserRequest
{
    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            ...$this->baseRules(),
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            ...$this->profileRules(),
        ];
    }
}

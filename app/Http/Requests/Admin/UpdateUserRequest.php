<?php

namespace App\Http\Requests\Admin;

class UpdateUserRequest extends UserRequest
{
    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        $user = $this->routeUser();

        return [
            ...$this->baseRules($user),
            ...$this->profileRules($user),
        ];
    }
}

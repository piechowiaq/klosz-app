<?php

declare(strict_types=1);

namespace App\Domains\User\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    use PasswordValidationRules;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array|string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'roleId' => 'required|exists:roles,id',
            'password' => $this->passwordRules(),
            'email' => 'required|string|email|max:255|unique:users',
        ];








    }
}

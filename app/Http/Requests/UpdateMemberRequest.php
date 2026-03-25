<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // Ignore the current member being updated so their own email doesn't trigger the unique rule.
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('members')->ignore($this->member)],
            'phone' => ['nullable', 'string', 'max:50'],
            'plan_name' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'in:Active,Pending,Expired'],
        ];
    }
}

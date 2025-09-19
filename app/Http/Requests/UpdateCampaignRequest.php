<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * - For now: always true; policy handles actual permissions.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * - Placeholder: will define real rules later.
     */
    public function rules(): array
    {
        return [
            // 'title' => ['required', 'string', 'max:255'],
            // 'description' => ['nullable', 'string'],
        ];
    }
}

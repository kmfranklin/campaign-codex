<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreCustomItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:255'],

            // Foreign keys
            'item_category_id' => [
                'required',
                Rule::exists('item_categories', 'id'),
            ],
            'item_rarity_id'   => [
                'nullable',
                Rule::exists('item_rarities', 'id'),
            ],

            // Other attributes
            'type'             => ['required', 'in:Gear,Weapon,Armor'],
            'description'      => ['nullable', 'string'],
            'weapon_key'       => ['nullable', 'string', 'max:100'],
            'armor_key'        => ['nullable', 'string', 'max:100'],
            'item_key'         => ['nullable', 'string', 'max:100'],
            'base_item_id'     => ['nullable', 'exists:items,id'],
        ];
    }
}

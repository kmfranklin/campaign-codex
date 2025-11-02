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
            'description'      => ['nullable', 'string'],
            'weapon_key'       => ['nullable', 'string', 'max:100'],
            'armor_key'        => ['nullable', 'string', 'max:100'],
            'item_key'         => ['nullable', 'string', 'max:100'],
            'base_item_id'     => ['nullable', 'exists:items,id'],

            // Weapon
            'damage_dice'      => ['nullable', 'string'],
            'damage_type_id'   => ['nullable', Rule::exists('damage_types', 'id')],
            'range'            => ['nullable', 'numeric'],
            'long_range'       => ['nullable', 'numeric'],
            'distance_unit'    => ['nullable', 'string'],
            'is_improvised'    => ['boolean'],
            'is_simple'        => ['boolean'],

            // Armor
            'base_ac'                  => ['nullable', 'integer'],
            'adds_dex_mod'             => ['boolean'],
            'dex_mod_cap'              => ['nullable', 'integer'],
            'imposes_stealth_disadvantage' => ['boolean'],
            'strength_requirement'     => ['nullable', 'integer'],

        ];
    }
}

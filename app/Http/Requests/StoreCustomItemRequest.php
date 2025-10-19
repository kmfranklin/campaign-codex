<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCustomItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'category'    => ['required', 'string', 'max:100'],
            'rarity'      => ['nullable', 'string', 'max:50'],
            'type'        => ['required', 'in:Gear,Weapon,Armor'],
            'description' => ['nullable', 'string'],
            'weapon_key'  => ['nullable', 'string', 'max:100'],
            'armor_key'   => ['nullable', 'string', 'max:100'],
            'item_key'    => ['nullable', 'string', 'max:100'],
            'base_item_id'=> ['nullable', 'exists:items,id'],
        ];
    }
}


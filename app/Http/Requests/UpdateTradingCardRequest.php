<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTradingCardRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'card_code' => ['required', 'string', 'unique:trading_cards,card_code,' . $this->route('trading_card')],
            'member_name' => ['required', 'string'],
            'tour_id' => ['required', 'exists:tours,id'],
            'possession_status' => ['required', 'in:not_owned,owned'],
            'description' => ['nullable', 'string'],
        ];
    }
}

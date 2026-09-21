<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGoodsRequest extends FormRequest
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
            'tour_id' => ['required_without:new_tour_name', 'nullable', 'integer', 'exists:tours,id'],
            'new_tour_name' => ['required_without:tour_id', 'nullable', 'string', 'max:255'],
            'new_tour_start_date' => ['nullable', 'date'],
            'new_tour_end_date' => ['nullable', 'date', 'after_or_equal:new_tour_start_date'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'purchase_status' => ['required', 'in:unpurchased,purchased'],
            'purchased_at' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $image = 'required|mimes:png,jpg,jpeg';

        if (request()->isMethod('put')) {
            $image = 'nullable|mimes:png,jpg,jpeg';
        } elseif ($this->type == 'combo') {
            $image = 'nullable|mimes:png,jpg,jpeg';
        }

        $unit_id = 'required|integer';
        $price = 'required|integer';

        if ($this->type == 'combo') {
            $unit_id = 'nullable|integer';
            $price = 'nullable|integer';
            $image = 'required|mimes:png,jpg,jpeg';
        }

        return [
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'image' => $image,
            'code' => 'required|numeric|digits_between:8,8|unique:products,code,' . $this->product?->id,
            'price' => $price,
            'barcode_symbology' => 'required|string|max:255',
            'brand_id' => 'required|integer',
            'category_id' => 'required|integer',
            'unit_id' => $unit_id,
            'alert_quantity' => 'nullable|integer',
            'is_featured' => 'nullable',
            'product_details' => 'nullable|string',
        ];
    }
}

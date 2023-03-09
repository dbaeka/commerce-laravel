<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'contact' => 'required|array',
            'contact.email' => 'required|email',
            'shipping' => 'required|array',
            'shipping.first_name' => 'required|string|min:2|max:150',
            'shipping.last_name' => 'required|string|min:2|max:150',
            'shipping.address' => 'required|string|min:2|max:150',
            'shipping.apartment_suite' => 'max:60',
            'shipping.city' => 'required|string|min:2|max:100',
            'shipping.country' => 'required|string|min:2|max:60',
            'shipping.state_province' => 'required|string|min:2|max:150',
            'shipping.postal_code' => 'required|string|max:40',
            'shipping.phone' => 'required|string|min:6|max:25',
            'order' => 'required|array',
            'order.name' => 'required|string|min:3|max:100',
            'order.items' => 'required|array|min:1',
            'order.items.*.name' => 'required|string',
            'order.items.*.slug' => 'required|string',
            'order.items.*.product_id' => 'required|string',
            'order.items.*.quantity' => 'required|integer|gt:0',
            'order.shipping_cost' => 'required|numeric|min:0',
            'order.sub_total' => 'required|numeric|min:0',
            'order.total' => 'required|numeric|gt:0'
        ];
    }
}

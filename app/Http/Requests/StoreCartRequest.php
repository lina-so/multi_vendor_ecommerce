<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\QuantityRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id'=>['required','integer','exists:products,id' , new QuantityRule($this->getProductQuantity())],
            'quantity'=>['required','numeric','min:1'],
            'selected_options' => 'required|array',
            'selected_options.*.*' => 'required|exists:option_values,id',


        ];
    }

    public function getProductQuantity()
    {
        $productId = $this->input('product_id');
        $product = Product::find($productId);
        return $product ? $product->quantity : 0;
    }
}

<?php

namespace App\Http\Requests;

use App\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Http\FormRequest;

class OrderAddRequest extends FormRequest
{

    protected function getProductService() : ProductService
    {
        return new ProductService();
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'integer',
            'qty' => 'integer'
        ];
    }

    public function getProduct() : Product
    {
        $item = $this->getProductService()->findItemById($this->product_id);
        if (!isset($item)) {
            throw new \Exception('not find product by id');
        }
        return $item;
    }
}

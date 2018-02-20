<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 19.02.18
 * Time: 17:46
 */

namespace App\Services;


use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Product;

class ProductService
{
    const PRODUCT_LIMIT = 100;


    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return Product::query()->limit(self::PRODUCT_LIMIT)->get();
    }

    public function findItemById(int $id): Product
    {
        return Product::query()->findOrFail($id);
    }


    /**
     * @param ProductRequest $productRequest
     * @return Product
     * @throws \Throwable
     */
    public function createItem(ProductRequest $productRequest)
    {
        $item = new Product();
        $item->setPrice($productRequest->price);
        $item->name = $productRequest->name;
        $item->saveOrFail();

        return $item;
    }

    public function updateItem(ProductRequest $productRequest, Product $item)
    {
        $item->setPrice($productRequest->price);
        $item->name = $productRequest->name;
        $item->saveOrFail();

        return $item;
    }

    public function deleteItem(Product $product)
    {
        $product->delete();
    }
}
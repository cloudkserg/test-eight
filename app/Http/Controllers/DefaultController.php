<?php

namespace App\Http\Controllers;


use App\Services\ProductService;

class DefaultController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;


    /**
     * DefaultController constructor.
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getProducts();
        return view('default.index', ['products' => $products]);
    }
}

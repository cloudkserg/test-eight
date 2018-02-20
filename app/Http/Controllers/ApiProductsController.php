<?php

namespace App\Http\Controllers;

use App\Formatters\ProductFormatter;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Services\ProductService;
use Illuminate\Routing\ResponseFactory;

use Swagger\Annotations as SWG;

class ApiProductsController extends Controller
{
    /**
     * @var ProductService
     */
    private $service;
    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    public function __construct(ProductService $service, ResponseFactory $responseFactory)
    {
        $this->service = $service;
        $this->responseFactory = $responseFactory;
    }


    /**
     * @SWG\Get(
     *     path="/products",
     *     summary="Get products",
     *     tags={"product"},
     *     description="",
     *     operationId="getProducts",
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="array",
     *              @SWG\Items(
     *                 type="object",
     *                  @SWG\Property(
     *                      property="id",
     *                      type="integer"
     *                  ),
     *                  @SWG\Property(
     *                      property="name",
     *                      type="string"
     *                  ),
     *                  @SWG\Property(
     *                      property="price",
     *                      type="string"
     *                  ),
     *               )
     *          )
     *     ),
     *
     *     security={{ "apiKey": {} }}
     * )
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->service->getProducts();


        return $this->responseFactory->json(
            collect($products)->map(function (Product $product) {
                return (new ProductFormatter())->format($product);
            })->toArray()
        );
    }



    /**
     * @SWG\Post(
     *     path="/products",
     *     summary="Create product",
     *     tags={"product"},
     *     description="",
     *     operationId="createProducts",
     *     @SWG\Parameter(
     *          name="Product",
     *          in="body",
     *          @SWG\Schema(
     *             @SWG\Property(
     *               property="name",
     *               type="string",
     *             ),
     *             @SWG\Property(
     *               property="price",
     *               type="string",
     *             )
     *         )
     *      ),
     *     @SWG\Response(
     *         response=202,
     *         description="successful operation",
     *         @SWG\Header(header="location", type="string", description="/products/1")
     *     ),
     *
     *     security={{ "token": {} }}
     * )
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $item = $this->service->createItem($request);
        return $this->responseFactory->make('', 200, [
            'Location' => '/products/' . $item->id
        ]);
    }


    /**
     * @SWG\Get(
     *     path="/products/{id}",
     *     summary="get product",
     *     tags={"product"},
     *     description="",
     *     operationId="getProduct",
     *     @SWG\Parameter(name="id", in="path", required=true, type="integer"),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *                 type="object",
     *                  @SWG\Property(
     *                      property="id",
     *                      type="integer"
     *                  ),
     *                  @SWG\Property(
     *                      property="name",
     *                      type="string"
     *                  ),
     *                  @SWG\Property(
     *                      property="price",
     *                      type="string"
     *                  )
     *          )
     *     ),
     *
     *     security={{ "apiKey": {} }}
     * )
     */
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json((new ProductFormatter())->format($product));
    }


    /**
     * @SWG\Put(
     *     path="/products/{id}",
     *     summary="Update product",
     *     tags={"product"},
     *     description="",
     *     operationId="updateProducts",
     *     @SWG\Parameter(name="id", in="path", required=true, type="integer"),
     *     @SWG\Parameter(
     *          name="Product",
     *          in="body",
     *          @SWG\Schema(
     *             @SWG\Property(
     *               property="name",
     *               type="string",
     *             ),
     *             @SWG\Property(
     *               property="price",
     *               type="string",
     *             )
     *         )
     *      ),
     *     @SWG\Response(
     *         response=202,
     *         description="successful operation",
     *     ),
     *
     *     security={{ "token": {} }}
     * )
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->service->updateItem($request, $product);
        return response('', 202);

    }


    /**
     * @SWG\Delete(
     *     path="/products/{id}",
     *     summary="Delete product",
     *     tags={"product"},
     *     description="",
     *     operationId="deleteProducts",
     *     @SWG\Parameter(name="id", in="path", required=true, type="integer"),
     *     @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *     ),
     *
     *     security={{ "token": {} }}
     * )
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->service->deleteItem($product);
        return response('', 201);
    }
}

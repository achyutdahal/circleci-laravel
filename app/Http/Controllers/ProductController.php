<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\Product;
use App\DBService\ProductEloquentDAO;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller {

    //Product service instance to handle all the product operations
    private $productService;

    /**
     * Construct sets the product service with the injected dependency of the database layer
     * This injection is necessary in case where we want to use different database layer in the future
     * 
     * As Laravel models can directly talk to an extra dependency of product model instance is
     * necessary for using the Laravel Eloquent facades on the implementer class
     */
    function __construct() {
        $this->productService = new ProductService(new ProductEloquentDAO);
        $this->productService->setProduct(Product::class);
    }

    /**
     * Displays all the products in the database
     * It is built to paginate and sort using trait
     * @param Request $request
     * @return View
     */
    public function products() {

        $products = $this->productService->allProducts();
        return view('product.all', compact('products'));
    }

    /**
     * Helps creating a new product into the system with the use of product service after
     * server-side validation
     * @param Request $request
     * @return View
     */
    public function create(Request $request) {
        if ($request->isMethod('post')) {
            $this->productService->validatedProduct($request, ProductService::ADD);
            $product = $this->productService->addProduct($request->all());
            $product ? Session::flash(ProductService::SUCCESS, ProductService::PRODUCT_ADD_SUCCESS) : Session::flash(ProductService::ERROR, ProductService::PRODUCT_ADD_ERROR);

            return redirect('/create-product');
        }
        return view('product.create');
    }

    /**
     * A controller function to edit the existing product. It also uses the product service
     * to operate on the product
     * @param Request $request
     * @param type $id
     * @return type
     */
    public function edit(Request $request, $id) {

        if ($request->isMethod('post')) {
            $this->productService->validatedProduct($request, ProductService::EDIT);
            $productUpdated = $this->productService->updateProduct($request->all());
            $productUpdated ?  Session::flash(ProductService::SUCCESS, ProductService::PRODUCT_UPDATE_SUCCESS) : Session::flash(ProductService::ERROR, ProductService::PRODUCT_UPDATE_ERROR);
            return redirect('/');
        } else {
            $product = $this->productService->getProduct($id);
            if (!$product) {
                abort(404);
            }
        }
        return view('product.edit', compact('product'));
    }

    /**
     * Returns a view of the product details page
     * If non-existent product is browse, it will abort with 
     * the 404 response
     * @param type $id
     * @return View
     */
    public function view($id) {
        $product = $this->productService->getProduct($id);
        if (!$product) {
            abort(404);
        }
        return view('product.view', compact('product'));
    }

    /**
     * Deletes the product by calling the product service 
     * @param type $id
     * @return type
     */
    public function delete($id) {
        $product = $this->productService->getProduct($id);
        if (!$product) {
            abort(404);
        }
        $deleted = $this->productService->deleteProduct($product);
        $deleted ?  Session::flash(ProductService::SUCCESS, ProductService::PRODUCT_DELETE_SUCCESS) : Session::flash(ProductService::ERROR, ProductService::PRODUCT_DELETE_ERROR);
        return redirect('/');
    }

}

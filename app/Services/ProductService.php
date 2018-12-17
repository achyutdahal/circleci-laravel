<?php

namespace App\Services;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Interfaces\Persistence;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

/**
 * Description of ProductService
 *
 * @author achyut
 */
class ProductService {

    protected $productDbLayer;

    const PRODUCT_ADD_SUCCESS = 'The product has been added.';
    const PRODUCT_ADD_ERROR = 'Could not add the product. Try Again.';
    const PRODUCT_UPDATE_SUCCESS = 'The product has been updated.';
    const PRODUCT_UPDATE_ERROR = 'Could not update the product. Try Again.';
    const PRODUCT_DELETE_SUCCESS = 'The product has been deleted.';
    const PRODUCT_DELETE_ERROR = 'Could not delete the product. Try Again.';
    const SUCCESS = 'message';
    const ERROR = 'error';
    const ADD = 'ADD';
    const EDIT = 'EDIT';

    /**
     * Dependency injection for product db layer implementation
     * @param Persistence $productDbPersistence
     */
    function __construct(Persistence $productDbPersistence) {
        $this->productDbLayer = $productDbPersistence;
    }

    /**
     * Sets the product class reference helping the utilizing the laravel facades services
     * @param string $productReference
     */
    public function setProduct(string $productReference) {
        $this->productDbLayer->setProduct($productReference);
    }

    /**
     * Returns all the products available in the database
     * @return type
     */
    public function allProducts() {
        return $this->productDbLayer->all();
    }

    /**
     * Adds the product to the database
     * @param Request $request
     */
    public function addProduct(array $request): Persistence {
        try {
            $product = $this->prepareProduct($request);
            $this->productDbLayer->setProduct($product);
            $productObj = $this->productDbLayer->add();
        } catch (\Exception $ex) {
            Log::error($ex->getTraceAsString());
            return false;
        }

        return $productObj ? $productObj : false;
    }

    /**
     * Get a single product with the supplication product id
     * @param type $id
     * @return Product
     */
    public function getProduct($id) {
        return $this->productDbLayer->get($id);
    }

    /**
     * Updated the product with the supplied details of product
     * If image is not provided, it will not get updated
     * @param Request $requests
     */
    public function updateProduct(array $requests) {
        try {
            $productObj = $this->productDbLayer->get($requests['id']);
            $product = $this->prepareProductUpdate($productObj, $requests);
            $this->productDbLayer->setProduct($product);
            $productUpdated = $this->productDbLayer->add();
        } catch (\Exception $ex) {
            Log::error($ex->getTraceAsString());
            return false;
        }
        return $productUpdated ? $productUpdated : false;
    }

    /**
     * Deleted the product from the database based on the passed product object
     * @param Product $product
     */
    public function deleteProduct(Product $product) {
        try {
            $this->productDbLayer->setProduct($product);
            $productImageService = new ProductImageUploadService();
            $productImageService->deleteImages($product);
        } catch (\Exception $ex) {
            Log::error($ex->getTraceAsString());
            return false;
        }
        return $this->productDbLayer->delete() ? true : false;
    }

    /**
     * Validates the incoming request for the product operation
     * If user wants to create the product then image is mandatory else the image is 
     * optional to retain the existing image
     * @param Request $request
     * @param type $action
     * @return type
     */
    public function validatedProduct(Request $request, $action = ProductService::ADD) {

        $toValidate = [
            'name' => 'required|max:60',
            'price' => 'required|numeric',
            'image' => 'required',
            'description' => 'required'
        ];
        if ($action == ProductService::EDIT) {
            unset($toValidate['image']);
        }

        $validatedData = $request->validate($toValidate);
        return $validatedData;
    }

    /**
     * Prepares the request object to a product instance 
     * @param type $request
     * @return Product
     */
    private function prepareProduct($request): Product {
        $product = new Product();
        $product->name = $request['name'];
        $product->price = $request['price'];
        //Upload Image
        $imageUploader = new ProductImageUploadService($request['image']);
        $imageFile = $imageUploader->uploadImage();

        $product->image = $imageFile['main'];
        $product->description = $request['description'];
        return $product;
    }

    /**
     * Prepares a product against the incoming request and the existing product in the dataabase
     * for the update
     * @param Product $product
     * @param Request $request
     * @return Product
     */
    private function prepareProductUpdate(Product $product, array $request): Product {
        $product->name = $request['name'];
        $product->price = $request['price'];

        if (!empty($request['image'])) {
            $productImgService = new ProductImageUploadService($request['image']);
            $productImgService->deleteImages($product);
            $imageFile = $productImgService->uploadImage();
            $product->image = $imageFile['main'];
        }

        $product->description = $request['description'];
        return $product;
    }

}

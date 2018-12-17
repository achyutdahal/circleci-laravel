<?php

namespace Tests\Unit;

use Tests\TestCase;
use \Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Services\ProductService;
use App\DBService\ProductEloquentDAO;
use Illuminate\Http\UploadedFile;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductServiceDBTest extends TestCase {

    use DatabaseMigrations;

    protected $productService;

    public function setUp() {
        parent::setUp();
        $this->productService = new ProductService(new ProductEloquentDAO);
        $this->productService->setProduct(Product::class);
    }

    /**
     * @test
     */
    public function createProducts() {
        $file = UploadedFile::fake()->image('productOne.jpg');
        $request = ['name' => 'MyProduct', 'price' => 25.0, 'description' => 'demo description', 'image' => $file];
        $productAdded = $this->productService->addProduct($request);
        $this->assertInstanceOf(Product::class, $productAdded);
        $this->productService->deleteProduct($productAdded);
        return $productAdded;
    }

    /**
     * @depends createProducts
     * @test
     */
    public function verifyTheDetailsOfAddedProduct($product) {
        $this->assertEquals('MyProduct', $product->name);
        $this->assertEquals(25.0, $product->price);
        $this->assertEquals('demo description', $product->description);
        $this->assertNotEmpty($product->getImage());
        return $product;
    }

    /**
     * @test
     */
    public function updateProductsWithImage() {

        $file = UploadedFile::fake()->image('productOne.jpg');
        $requestAdd = ['name' => 'MyProduct', 'price' => 25.0, 'description' => 'demo description', 'image' => $file];
        $productAdded = $this->productService->addProduct($requestAdd);

        $this->assertNotEmpty($productAdded->id);
        $updatedFile = UploadedFile::fake()->image('productOneUpdated.jpg');
        $requestUpdate = ['id' => $productAdded->id, 'name' => 'NewProduct', 'price' => 26.0, 'description' => 'demo description for the updated product', 'image' => $updatedFile];
        $productUpdated = $this->productService->updateProduct($requestUpdate);
        $this->assertInstanceOf(Product::class, $productUpdated);
        $this->productService->deleteProduct($productUpdated);
        return $productUpdated;
    }

    /**
     * @test
     */
    public function updateProducts() {

        $file = UploadedFile::fake()->image('productOne.jpg');
        $requestAdd = ['name' => 'MyProduct', 'price' => 25.0, 'description' => 'demo description', 'image' => $file];
        $productAdded = $this->productService->addProduct($requestAdd);

        $this->assertNotEmpty($productAdded->id);
        $requestUpdate = ['id' => $productAdded->id, 'name' => 'NewProduct', 'price' => 26.0, 'description' => 'demo description for the updated product'];
        $productUpdated = $this->productService->updateProduct($requestUpdate);
        $this->assertInstanceOf(Product::class, $productUpdated);
        $this->productService->deleteProduct($productUpdated);
        return $productUpdated;
    }

    /**
     * @depends updateProducts
     * @test
     * @param type $product
     * @return type
     */
    public function verifyDetailsOfThe($product) {
        $this->assertEquals('NewProduct', $product->name);
        $this->assertEquals(26.0, $product->price);
        $this->assertEquals('demo description for the updated product', $product->description);
        $this->assertNotEmpty($product->getImage());
        return $product;
    }

    /**
     * @test
     */
    public function getASingleProduct() {
        $file1 = UploadedFile::fake()->image('productOne.jpg');
        $requestProduct1 = ['name' => 'Double Bed', 'price' => 200, 'description' => 'My product description', 'image' => $file1];
        $productAdded1 = $this->productService->addProduct($requestProduct1);

        $this->assertEquals('Double Bed', $productAdded1->name);
        $this->assertEquals(200, $productAdded1->price);
        $this->assertEquals('My product description', $productAdded1->description);
        $this->assertNotEmpty($productAdded1->getImage());

        $productObj = $this->productService->getProduct($productAdded1->id);
        $this->assertInstanceOf(Product::class, $productObj);
        $this->productService->deleteProduct($productAdded1);
    }

    /**
     * @test
     */
    public function deleteProduct() {
        $file = UploadedFile::fake()->image('productOne.jpg');
        $requestAdd = ['name' => 'Washing Machine', 'price' => 500.0, 'description' => 'demo description', 'image' => $file];
        $productAdded = $this->productService->addProduct($requestAdd);
        $this->assertInstanceOf(Product::class, $productAdded);
        $productDeleted = $this->productService->deleteProduct($productAdded);
        $this->assertTrue($productDeleted);
        $product = $this->productService->getProduct($productAdded->id);
        $this->assertNull($product);
    }

    /**
     * @test
     */
    public function getAllProducts() {
        $file1 = UploadedFile::fake()->image('productOne.jpg');
        $requestProduct1 = ['name' => 'MyProduct1', 'price' => 15, 'description' => 'My product description', 'image' => $file1];
        $product1 = $this->productService->addProduct($requestProduct1);

        $file2 = UploadedFile::fake()->image('productTwo.jpg');
        $requestProduct2 = ['name' => 'MyProduct2', 'price' => 15, 'description' => 'My product description', 'image' => $file2];
        $product2 = $this->productService->addProduct($requestProduct2);

        $file3 = UploadedFile::fake()->image('productTwo.jpg');
        $requestProduct3 = ['name' => 'MyProduct3', 'price' => 15, 'description' => 'My product description', 'image' => $file3];
        $product3 = $this->productService->addProduct($requestProduct3);

        $products = $this->productService->allProducts();
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $products);
        $this->productService->deleteProduct($product1);
        $this->productService->deleteProduct($product2);
        $this->productService->deleteProduct($product3);
    }

    /**
     * @test
     */
    public function validateAnInValidProduct() {
        $file = 'dummy text';
        $requestAdd = ['name' => 'Refrigirator', 'price' => 800.0, 'description' => 'demo description', 'image' => $file];
        $request = new Request([], [], $requestAdd);
        $this->expectException(ValidationException::class);
        $this->productService->validatedProduct($request, ProductService::ADD);
    }

    /**
     * @test
     */
    public function validateAValidProductForUpdate() {
        $requestAdd = ['name' => 'MacBook', 'price' => 4000.0, 'description' => 'MacBook'];
        $request = new Request([], [], $requestAdd);
        $this->expectException(ValidationException::class);
        $this->productService->validatedProduct($request, ProductService::EDIT);
    }

}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use \Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Services\ProductService;
use App\DBService\ProductEloquentDAO;
use Illuminate\Http\UploadedFile;
use App\Models\Product;

class ProductControllerTest extends TestCase {

    use DatabaseMigrations;

    protected $productService;
    protected $request;

    public function setUp() {
        parent::setUp();
        $this->productService = new ProductService(new ProductEloquentDAO);
        $this->productService->setProduct(Product::class);
        $this->request = ['name' => 'MyProduct', 'price' => 25.0, 'description' => 'demo description', 'image' => UploadedFile::fake()->image('productOne.jpg')];
    }

    /**
     * @test
     */
    public function createProducts() {

        $response = $this->call('POST', '/create-product', $this->request);
        $response->assertRedirect('/create-product');
        $this->deleteMockedFileUploads();
    }

    /**
     * @test
     */
    public function updateProducts() {


        $productAdded = $this->productService->addProduct($this->request);

        $productId = $productAdded->id;

        $file2 = UploadedFile::fake()->image('productOneUpdate.jpg');
        $requestUpdate = ['id' => $productId, 'name' => 'MyProduct', 'price' => 25.0, 'description' => 'demo description', 'image' => $file2];
        $response = $this->call('POST', '/edit-product/' . $productId, $requestUpdate);
        $response->assertRedirect('/');
        $this->deleteMockedFileUploads();
    }

    /**
     * @test
     */
    public function viewProducts() {


        $productAdded = $this->productService->addProduct($this->request);

        $productId = $productAdded->id;

        $this->assertNotEmpty($productId);

        $response = $this->call('GET', '/product/' . $productId);
        $response->assertSuccessful();
        $response->assertSee('MyProduct');
        $this->deleteMockedFileUploads();
    }

    /**
     * @test
     */
    public function deleteProduct() {


        $productAdded = $this->productService->addProduct($this->request);

        $productId = $productAdded->id;
        $this->assertNotEmpty($productId);
        $response = $this->call('GET', '/delete/' . $productId);
        $response->assertRedirect('/');
    }

    /**
     * @test
     */
    public function allProducts() {

        $this->productService->addProduct($this->request);
        $response = $this->call('GET', '/');
        $response->assertSee('MyProduct');
        $this->deleteMockedFileUploads();
    }

    /**
     * @test
     */
    public function viewNonExistingProducts() {
        $response = $this->call('GET', '/product/' . 1);
        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function deleteNonExistingProducts() {
        $response = $this->call('GET', '/delete/' . 1);
        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function editNonExistingProducts() {
        $response = $this->call('GET', '/edit-product/' . 1);
        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function createProductForm() {
        $response = $this->call('GET', '/create-product');
        $response->assertSee('Product Name');
        $response->assertSee('Price');
        $response->assertSee('Description');
        $response->assertSee('Product Image');
    }

    /**
     * @test
     */
    public function viewProductsEditForm() {


        $productAdded = $this->productService->addProduct($this->request);

        $productId = $productAdded->id;

        $this->assertNotEmpty($productId);

        $response = $this->call('GET', '/edit-product/' . $productId);
        $response->assertSee('Product Name');
        $response->assertSee('Price');
        $response->assertSee('Description');
        $response->assertSee('Product Image');
        $this->deleteMockedFileUploads();
    }

    private function deleteMockedFileUploads() {
        $product = $this->productService->getProduct(1);
        $this->productService->deleteProduct($product);
    }

}

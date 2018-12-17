<?php

namespace App\DBService;

use App\Interfaces\EloquentDBInterface;
use \App\Interfaces\Persistence;

/**
 * Description of ProductDAO
 *
 * @author achyut
 */
class ProductEloquentDAO implements EloquentDBInterface {

    //put your code here
    /**
     *
     * @var type 
     */
    private $productDBConnector;

    function __construct() {
        
    }

    /**
     * Set the Database Connector for the product
     * @param Product $classReference
     */
    public function setProduct($classReference) {

        $this->productDBConnector = $classReference;
    }

    /**
     * Add the product model to the database
     * @return type
     */
    public function add(): Persistence {
        $this->productDBConnector->save();
        return $this->productDBConnector;
    }

    /**
     * Delete the model from the database
     * @return bool
     */
    public function delete(): bool {

        return $this->productDBConnector->delete();
    }

    /**
     * Get the model from the database
     * @param int $id
     * @return Product
     */
    public function get(int $id) {
        return $this->productDBConnector::find($id);
    }
    

    /**
     * Get all the collection of the products with the pagination
     * @param type $orderby
     * @return type
     */
    public function all($paginate = 10) {
        return $this->productDBConnector::sortable()->paginate($paginate);
    }

}

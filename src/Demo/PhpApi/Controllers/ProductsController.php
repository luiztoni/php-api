<?php

namespace Demo\PhpApi\Controllers;

use Demo\PhpApi\Models\Product;
use Demo\PhpApi\Repositories\ProductRepository as Repository;

/**
 * Products controller
 */
class ProductsController extends Controller
{
    /**
   * The data access layer instance.
   *
   * @var \Demo\PhpApi\Repositories\ProductRepository
   */
    private $repository;

    /**
    * List products
    */
    public function index()
    {
        $this->repository = new Repository;
        $products = $this->repository->index();
        $this->jsonParse($products);
    }
    
    /**
     * Show product
     * @param int $id
     */
    public function show($id = null)
    {   
        if (!$id) {
            return $this->index();
        }
        
        $this->repository = new Repository;
        $product = $this->repository->read($id);
    
        if (!$product) {
            return $this->index();
        }
        $this->jsonParse($product);
    }

    /**
     * Search product
     */
    public function search()
    {
        $this->repository = new Repository;
        $param = filter_input(INPUT_GET, 'search');
        $products = $this->repository->find($param);
        $this->jsonParse($products);
    }

    /**
     * Create product
     */
    public function store()
    {
        $values = file_get_contents("php://input");
        $values = json_decode($values, true);
        $product = new Product(null, $values['name'], $values['price']);
        $this->repository = new Repository;
        $this->repository->create($product);
        $this->index();   
    }

    /**
     * Update product
     * @param int $id product id
     */
    public function update($id = null)
    {
        if (!$id) {
            return $this->index();
        }

        $this->repository = new Repository;
        $product = $this->repository->read($id);

        if (!$product) {
            return $this->index();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $values = file_get_contents("php://input");
            $values = json_decode($values, true);
            $product = new Product($id, $values['name'], $values['price']);
            $this->repository->update($id, $product);    
        }    
        $this->index();
    }

    /**
     * Delete one product
     * @param int $id product id
     */
    public function destroy($id = null)
    {
        if (!$id) {
            return $this->index();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $this->repository = new Repository;
            $this->repository->delete($id);
            $this->index();
        }
    }
}

<?php

namespace Demo\PhpApi\Repositories;

use Demo\PhpApi\Config\DbConfig;
use Demo\PhpApi\Models\Product;

/**
 * Repository layer
 */
class ProductRepository implements Repository
{
    private $connection;

    /**
     * Create new instance
     */
    public function __construct()
    {
        $this->connection = DbConfig::getConnection();
    }

    /**
     * Create one
     * @param $model
     * @return int $id
     * @throws \InvalidArgumentException 
     */
    public function create($model) 
    {
        if (!($model instanceof Product)) {
            throw new InvalidArgumentException("Model not accepted.");
        }

        $row = [
            'name' => $model->getName(),
            'price' => $model->getPrice()
        ];

        $sql = "INSERT INTO products VALUES (null, :name, :price);";
        $statement = $this->connection->prepare($sql);
        $status = $statement->execute($row);
        
        if ($status) 
            return $this->connection->lastInsertId();
        else 
            return -1;
    }

    /**
     * Update one
     * @param int $id
     * @param $model
     * @throws \InvalidArgumentException 
     */
    public function update($id, $model) 
    {
        if (!($model instanceof Product)) {
            throw new InvalidArgumentException("Model not accepted.");
        }

        $row = [
            'id' => $id,
            'name' => $model->getName(),
            'price' => $model->getPrice()
        ];
        
        $sql = "UPDATE products SET name = :name, price = :price WHERE id = :id;";
        $status = $this->connection->prepare($sql)->execute($row);
    }

    /**
     * Find by id
     * @param int $id
     * @return array $product 
     */
    public function read($id)
    {
        $statement = $this->connection->prepare("SELECT * FROM products WHERE id = :id;");
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();
        
        if (!$row) 
            return null;
        
        $product = array('product' => array('id' => $row['id'], 'name' => $row['name'], 'price' => $row['price']));
        return $product;
    }

    /**
     * Delete one
     * @param int $id 
     */
    public function delete($id)
    {
        $this->connection->prepare("DELETE FROM products WHERE id = :id;")->execute(['id' => $id]);
    }

    /**
     * List all
     * @return array 
     */
    public function index()
    {
        $rows = $this->connection->query('SELECT * FROM products;')->fetchAll();
        
        $products = [];
        foreach ($rows as $row) {
            $products[] = array('product' => array('id' => $row['id'], 'name' => $row['name'], 'price' => $row['price']));
        }
        return array('products' => $products);
    }

    /**
     * Find by name
     * @param string $param
     * @return array $products 
     */
    public function find($param)
    { 
        $statement = $this->connection->prepare("SELECT * FROM products WHERE name LIKE :name;");
        $statement->execute(['name' => $param.'%']);

        $products = [];
        foreach ($statement as $row) {
            $products[] = array('product' => array('id' => $row['id'], 'name' => $row['name'], 'price' => $row['price']));
        }
        return array('products' => $products);
    }
}

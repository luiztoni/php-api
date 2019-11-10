<?php

namespace Demo\PhpApi\Models; 

/**
 * Anemic model
 */
class Product
{
    private $id;
    private $name;
    private $price;

    /**
     * Create new model instance.
     *
     * @param int $id
     * @param string $name
     * @param double $price 
     */
    public function __construct($id = null, $name, $price)
    {
        $this->id = $id;
        $this->setName($name);
        $this->setPrice($price);
    }

    /**
     * Set id
     * @param int $id 
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id
     * @return int $id 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     * @param string $name
     * @throws \InvalidArgumentException 
     */
    public function setName($name)
    {
        if (!$name || strlen($name) < 3) {
            throw new InvalidArgumentException("Name invalid.");
        }

        $this->name = $name;
    }

    /**
     * Get name
     * @return string $id 
     */
    public function getName() 
    {
        return $this->name;
    }

    /**
     * Set price
     * @param double $price
     * @throws \InvalidArgumentException
     */
    public function setPrice($price)
    {
        if ($price <= 0) {
            throw new InvalidArgumentException("Price invalid.");
        }

        $this->price = $price;
    }
    
    /**
     * Get price
     * @return double $price 
     */
    public function getPrice()
    {
        return $this->price;
    }
}

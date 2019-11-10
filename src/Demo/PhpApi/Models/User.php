<?php

namespace Demo\PhpApi\Models; 

/**
 * Anemic model
 */
class User
{
    private $id;
    private $email;
    private $password;
    private $image;
    private $token;

    /**
     * Create model instance.
     *
     * @param int $id
     * @param string $email
     * @param string $password
     * @param string $image 
     */
    public function __construct($id = null, $email, $password, $image)
    {
        $this->id = $id;
        $this->setEmail($email);
        $this->password = $password;
        $this->image = $image;
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
     * Set email
     * @param string $email
     * @throws \InvalidArgumentException
     */
    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("E-mail invalid.");
        }

        $this->email = $email;
    }

    /**
     * Get email
     * @return string $email 
     */
    public function getEmail() 
    {
        return $this->email;
    }

    /**
     * Set password
     * @param string $password 
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    /**
     * Get password
     * @return string $password 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set image
     * @param string $image 
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     * @param string $image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set token
     * @param string $token 
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get token
     * @return string $token 
     */
    public function getToken()
    {
        return $this->token;
    }
}

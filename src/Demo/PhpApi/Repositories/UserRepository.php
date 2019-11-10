<?php

namespace Demo\PhpApi\Repositories;

use Demo\PhpApi\Config\DbConfig;
use Demo\PhpApi\Models\User;

/**
 * Repository layer
 */
class UserRepository implements Repository
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
     * @throws \InvalidArgumentException
     * @return int $id 
     */
    public function create($model) 
    {
        if (!($model instanceof User)) {
            throw new InvalidArgumentException("Model not accepted.");
        }

        $row = [
            'email' => $model->getEmail(),
            'password' => $model->getPassword(),
            'image' => "default.png",
            'token' => null,
        ];

        $sql = "INSERT INTO users VALUES (null, :email, :password, :image, :token);";
        $statement = $this->connection->prepare($sql);
        $status = $statement->execute($row);
        
        if ($status) 
            return $this->connection->lastInsertId();
        else 
            return -1;
    }

    /**
     * Find by email and password
     * @param string $email
     * @param string $password
     * @return User 
     */
    public function match($email, $password)
    { 
        $statement = $this->connection->prepare("SELECT * FROM users WHERE email = :email;");
        $statement->execute(['email' => $email]);
        $row = $statement->fetch();
        
        if (password_verify($password, $row['password'])) {
            return new User($row['id'], $row['email'], $row['password'], $row['image']);
        } 
        return null;
    }

    /**
     * Update one
     * @param int $id
     * @param $model
     * @throws \InvalidArgumentException 
     */
    public function update(int $id, $model)
    {
        if (!($model instanceof User)) {
            throw new InvalidArgumentException("Model not accepted.");
        }

        $row = [
            'id' => $id,
            'email' => $model->getEmail(),
            'password' => $model->getPassword(),
            'image' => $model->getImage(),
            'token' => $model->getToken()
        ];

        $sql = "UPDATE users SET email = :email, password = :password, image = :image, token = :token WHERE id = :id;";
        $status = $this->connection->prepare($sql)->execute($row);
    }

    /**
     * Find by id
     * @param int $id
     * @return User 
     */
    public function read(int $id)
    {
        $statement = $this->connection->prepare("SELECT * FROM users WHERE id = :id;");
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();
        
        if (!$row) 
            return null;

        return new User($row['id'], $row['email'], $row['password'], $row['image']);
    }

    /**
     * Delete one
     * @param int $id
     * @throws \Exception not implemented 
     */
    public function delete(int $id)
    {
        //TODO
        throw new Exception("Method not implemented.");
    }

    /**
     * List all
     * @throws \Exception not implemented 
     */
    public function index()
    {
        //TODO
        throw new Exception("Method not implemented.");
    }

    /**
     * Find by name
     * @param string $param
     * @throws \Exception not implemented 
     */
    public function find(string $param)
    {
        //TODO
        throw new Exception("Method not implemented.");
    }

    /**
     * Find by token
     * @param string $token
     * @return User 
     */
    public function matchToken($token)
    { 
        $statement = $this->connection->prepare("SELECT * FROM users WHERE token = :token LIMIT 1;");
        $statement->execute(['token' => $token]);
        $row = $statement->fetch();
        
        if (!$row) 
            return null;

        return new User($row['id'], $row['email'], $row['password'], $row['image']);    
    }
}

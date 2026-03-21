<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class UserController extends BaseController
{ 
   protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

public function index()
{
    $users = $this->model->findAll();
    return $this->response->setStatusCode(200)->setJSON($users);
}
    // Get user
   public function getUser()
    {
        $id = $this->request->getVar('id');

        if (!$id) {
            return $this->response->setStatusCode(400)
                                  ->setJSON(['error' => 'User ID is required']);
        }

        $user = $this->model->find($id);
        return $this->response->setStatusCode(200)->setJSON($user);
    }

    // create user
    public function createUser()
    {
       $data=$this->request->getPost();
       if (!$data) {
        return $this->response->setStatusCode(400)
                              ->setJSON(['error' => 'Enter the correct inputs']);
       }
       if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->response->setStatusCode(400)
                                  ->setJSON(['error' => 'Email id was invalid']);
        }

        if (!isset($data['password']) || strlen($data['password']) < 8) {
            return $this->response->setStatusCode(400)
                                  ->setJSON(['error' => 'Password should contains 8 characters']);
        }
    $existing=$this->model->where('email',$data['email'])->first();
    if($existing)
        {
            return $this->response->setStatusCode(409)->setJSON(['error'=>'Email already exists']);
        }
    $data['password']= password_hash($data['password'],PASSWORD_DEFAULT);
    $user = $this->model->insert($data);
    return $this->response->setStatusCode(201)
    ->setJSON(['message'=>'User created','User Info'=>$user]);
    }

   public function updateUser()
{
    $data = $this->request->getJSON(true); 
   
    $email = $data['email'];
    $password = $data['password'];

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $this->response->setStatusCode(400)
                              ->setJSON(['error' => 'Email id was invalid']);
    }

    if (!$password || strlen($password) < 8) {
        return $this->response->setStatusCode(400)
                              ->setJSON(['error' => 'Password should contains 8 characters']);
    }

    $user = $this->model->where('email', $email)->first();
    if (!$user) {
        return $this->response->setStatusCode(404)
                              ->setJSON(['error' => 'User not found']);
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $updated = $this->model->update($user['id'], [
        'password' => $hashedPassword
    ]);
    return $this->response->setStatusCode(200)
                          ->setJSON(['message' => 'Password updated successfully']);
}

     public function deleteUser()
    {
        $id = $this->request->getVar('id');

        if (!$id) {
            return $this->response->setStatusCode(400)
                                  ->setJSON(['error' => 'User ID is required']);
        }

        $user = $this->model->find($id);
        if (!$user) {
            return $this->response->setStatusCode(404)
                                  ->setJSON(['error' => 'User not found']);
        }

        $deleted = $this->model->delete($id);
        return $this->response->setStatusCode(200)
                              ->setJSON(['message' => 'User deleted successfully']);
    }
}

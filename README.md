# CRUD-project- Codeigniter-4
CRUD project with REST API using CodeIgniter 4 Framework
## 📌 Project Overview
This project is a **RESTful API** built using **CodeIgniter 4** to perform CRUD operations (Create, Read, Update, Delete) on users table.  
Users can be created, retrieved, updated, and deleted. Passwords are stored securely using hashing. The API supports JSON payloads for PUT requests and standard query parameters for GET and DELETE.

## ⚙️ Technologies Used
- PHP 
- CodeIgniter 4 Framework  
- MySQL   
- Postman (for API testing)
## Installation 
1.Download CodeIgniter 4
Download the framework from the official site:
https://codeigniter.com/download

2.Extract to your local server directory
For XAMPP, for example:
- C:\xampp\htdocs\codeigniter4-rest-api

3.Create Controller and Model using PHP Spark CLI
Open your terminal or command prompt, navigate to your project folder, and run:

- php spark make:controller UserController
- php spark make:model UserModel

This will generate UserController.php in app/Controllers/
And UserModel.php in app/Models/

4.Using user table which was already create in csci6040_study Database.

5.Configure database in .env and set your database settings:
- database.default.hostname = localhost
- database.default.database = database
- database.default.username = username
- database.default.password = password
- database.default.DBDriver = MySQLi
- database.default.DBPrefix =
- database.default.port =3306
  
and change this CI_ENVIRONMENT in to development.
- CI_ENVIRONMENT = development
  
 CodeIgniter automatically uses these .env settings for database connections. 
 
6.Run the project using PHP Spark

Open your terminal in your project folder and run:
- php spark serve

You should see:
- CodeIgniter development server started on http://localhost:8080

Now open your browser and access your API via:
- http://localhost:8080
## Model
UserModel (app/Models/UserModel.php)

- The model interacts with the users table:

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model

{
  
    protected $table = 'users';
    
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['name','email', 'password'];
}

Key points:

$table specifies the database table (users)

$primaryKey is id

$allowedFields defines which fields can be (name,email and password)

## Controller 
UserController (app/Controllers/UserController.php)

This controller handles all CRUD operations for the users table. The main functions are:

1. index() – List all users

2.getUser() – Get a single user by ID
- Accepts id as query parameter
- Returns 400 if ID is missing, 404 if user not found
- Returns JSON of the user

3.createUser() – Create a new user

- Accepts name, email and password via POST
- Validation for email and password
- Hashes password before store in db and minimum password length should be 8
- Checks for existing email
- Returns success JSON with new user ID

4.updateUser() – Update a user’s password
- Accepts email and password via PUT (JSON)
- Validation for email and password
- Updates hashed password if user exists

5.deleteUser() – Delete a user by ID
- Accepts id as query parameter
- Returns 400 if missing, 404 if user not found
- Deletes the user and returns a success message

## Routes

Adding the routes for above crud operation

- $routes->get('allusers','UserController::index'); here it will give all users
- $routes->get('user', 'UserController::getUser');  # here user will get by id from query params   
- $routes->post('user','UserController::createUser'); # creating new user
- $routes->put('user/updateuser', 'UserController::updateUser'); # updating user password
- $routes->delete('user', 'UserController::deleteUser'); # deleting user

## API Testing using Postman

You can test all endpoints using Postman.

Steps:
Open Postman
Create a new request
Select HTTP method (GET, POST, PUT, DELETE)
Enter URL:
http://localhost:8080/<endpoint>

1. Get All Users
Method: GET
- URL: http://localhost:8080/allusers

2. Get User by Id
Method: GET
- URL: http://localhost:8080/user?id=1
- 
3. Create User
Method: POST
- URL:http://localhost:8080/user

Body → form-data / JSON:
- name: John
- email: john@example.com
- password: 12345678

4. Update Password

Method: PUT
- Body → raw JSON:

{

  "email": "john@example.com",
  
  "password": "john123456"
  
}

5.Delete User
Method: DELETE
- URL: http://localhost:8080/user?id=1



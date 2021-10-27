# coding-challenge

## Code Architucture
### Data Layer
In data layer we have an interface **IRepository** that represents what a repository can do.
```php
interface IRepository
{
   function get(array $conditions);

   function getMany(array $conditions, array $options);

   function getOrCreate(array $conditions, array $options);

   function create(array $models);

   function createMany(array $data);

   function delete(array $conditions);

   function getModelName() : string;
}
```
then we have a basic implementation represented by the abstract class **Repository**, so we avoid code duplication and only implement a method if needed.
```php
abstract class Repository implements IRepository {...}
```
```php
class ProductRepository extends Repository {...}
```
all of the repository classes extends the class **Repository** and therefore implements the IRepository interface.
doing so and with the help of DI we will depends on the interface not the implementation, making our code less coupled and easy to test.

### Service Layer

again we have the **IService** interface that represents what a service can do, and a basic implementation represented by the abstract class **Service**.
```php
interface IService
{
    function create(array $data, array $models);

    function createMany(array $data);

    function getMany(array $conditions, array $options);

    function get(array $conditions);

    function delete(array $conditions);
}
```
```php
abstract class Service implements IService {...}
```
```php
class ProductService extends Service {...}
```
all of the service classes extends the **Service** class, so they implement the **IService** interface, this will make our code less coupled and we can swap implementations.

### Presentation Layer
in this layer we have controllers that do some validation and communicate to the service layer. 

## Features

### Create categories
```http
POST http://127.0.0.1:8000/api/categories
Content-Type: application/json
Accept: application/json

{
  "categories": [
    { "name": "my category", "parent": "parent category name" }
  ]
}
```
**Notes**:
* we can create many categories at once.
* the parent property can be null.

### Delete categories
```http
DELETE http://127.0.0.1:8000/api/categories/id
Content-Type: application/json
Accept: application/json
```
**Notes**:
* **id**: is the id of the category we want to delete.

### Create products
```http
POST http://127.0.0.1:8000/api/products
Content-Type: application/json, 
Accept: application/json

{
  "product": {
    "name": "product name",
    "price": 999,
    "description": "a description"
  },
  "categories": ["categorie a", "categorie b"]
}
```
**Notes**:
* categories can be null or array of strings representing categories names.
* when creating a product, if a category does not exists it will be created.

### Delete products
```http
DELETE http://127.0.0.1:8000/api/products/id
Content-Type: application/json
Accept: application/json
```
**Notes**:
* **id**: is the id of the product we want to delete.

### Browse products
```http
GET http://127.0.0.1:8000/api/products?category=category_name&sort-name=asc&sort-price=desc
Content-Type: application/json
Accept: application/json
```
**Notes**:
* we can filter by category, sort by name and by price.

## Run it locally
1-prepare mysql:
```sql
CREATE USER youcan_user@localhost;
GRANT ALL PRIVILEGES ON youcan_db.* TO youcan_user@localhost;
CREATE DATABASE youcan_db;
```
2-clone the project and inside the project directory run these commands:
```shell
php artisan migrate
php artisan serve
```
now the app should be up and running.

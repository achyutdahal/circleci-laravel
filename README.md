# A Simple CRUD application for product management

This is a simple CRUD application for product management. A new product can be added, updated and viewed in the application. A list of all products is shown where one can sort the list with the product name and price.

# Framework Used

This application has been developed with **Laravel** PHP framework. Laravel framework is very efficient for PHP application development with its Artisan console, easy routing, eloquent services, caching and many more. It provides PHPUnit out of the box with its own classes and methods for several testing purposes.

### Requirement
The application requires PHP version > 7.1.3
(The application has been developed in LAMP environment with PHP version **7.2.11** and **Laravel v5.7.9**

## Steps to setup the application

1. Clone the application
2. Copy .env.example and rename to .env
3. Update MySQL credentials on the .env file
4. Open terminal and change directory to the root of the application
5. Run **composer update**
6. Run **php artisan migrate** to create the product table
7. Run **php artisan serve** to run the PHP's built-in development server. Alternatively, one can use Apache or Nginx

## Steps to run the test
1. Run **phpunit** in the root of the project to run the test
2. Run **phpunit --coverage-html /yourpath** to generate the coverage report

## Time Taken to complete the application
As it is a small laravel application with no complex business logic and involves only CRUD, it took approximately seven hours to complete the application including the test.

## Future Improvement
1. Catching specific exception rather than dealing with the generic.
2. Thumbnail image sized and no of thumbnails for specific models in the configuration files
3. PHP Docblock is not highly considered in this small project and can be improved in the future.

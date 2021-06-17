# Simple Customer Importer App

This app is build using Lumen a micro-framework from Laravel.

## Setup Guide

  1. Clone project
  2. Install dependencies using terminal command: <code>composer install</code>
  3. Copy <code>.env.example</code> file to <code>.env</code>
  4. Setup Local database and configure connection in .env file
  5. To import customer table run <code>php artisan doctrine:schema:create </code>
  6. Run application <code>php -S localhost:8000 -t public</code>
   

   Cheers!
   
#### Importer
  1. To run customer importer <code>php artisan import:data</code>

#### API Routes
  * <code>/customers</code> - To get all customers from database.
  * <code>/customers/{id}</code> - To get a customer data based on id. 


## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

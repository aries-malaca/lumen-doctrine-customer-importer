<?php

namespace App\Classes;

use App\Entities\Customer;

class Importer
{
    /**
     * The attributes that indicates how many data to be imported.
     *
     * @var int
     */
    private $count;

    /**
     * The attributes that indicates how many data is allow to be imported.
     *
     * @var int
     */
    private static $minimum = 100;

    function __construct($count)
    {
        $this->count = $count;
    }

    public static function getMinimum()
    {
        return self::$minimum;
    }

    /**
     * Execute the import process, data will be requested from third-party provider.
     *
     * @return object
     */
    function startImport()
    {
        if($this->count < self::$minimum)
            return (object)["message" => "Can only import minimum of " . self::$minimum, "result"=> false];

        if(env('APP_ENV') !== 'testing'){
            $url = env('CUSTOMERS_API_ENDPOINT') . '/?nat='. env('CUSTOMERS_NATIONALITY') .'&results=' . $this->count;
            $response = @file_get_contents($url);
        }
        else
            $response = file_get_contents(__DIR__ .'/../../tests/mocks/Customers.json');
        

        if(!$response)
            return (object)["message" => "API ERROR", "result"=> false];
        
        $results = json_decode($response)->results;

        // Perform Data adding/updating to database for all the results.
        foreach($results as $result){
            // apply mappings on fields
            $result = $this->mapData($result);

            // find customer by email
            $existing_customer = $this->findCustomer(['email'=>$result->email]); 

            if($existing_customer)
                $this->updateCustomer($existing_customer->getID(), $result);
            else
                $this->saveCustomer($result);
        }
        
        return (object)["message" => "Import data success", "result"=> true];
    }

    /**
     * Save single customer to the database.
     * @param object $customer
     * @return void
     */
    private function saveCustomer($customer)
    {
        $new_customer = new Customer(
            $customer->first_name,
            $customer->last_name,
            $customer->email,
            $customer->username,
            md5($customer->password),
            $customer->gender,
            $customer->country,
            $customer->city,
            $customer->phone
        );
        app()->make('em')->persist($new_customer);
        app()->make('em')->flush();
    }

    /**
     * Update customer's data by ID
     *
     * @param int $id
     * @param object $customer
     * @return void
     */
    private function updateCustomer($id, $customer)
    {
        $old_customer = app()->make('em')->getRepository(Customer::class)->find($id);
        $old_customer->setFirstName($customer->first_name);
        $old_customer->setLastName($customer->last_name);
        $old_customer->setUsername($customer->username);
        $old_customer->setPassword($customer->password);
        $old_customer->setGender($customer->gender);
        $old_customer->setCountry($customer->country);
        $old_customer->setCity($customer->city);

        app()->make('em')>flush();
    }

    /**
     * Get exising customer based on query object.
     *
     * @param object $query
     * @return int|false
     */
    private function findCustomer($query)
    {
        $customers = app()->make('em')->getRepository(Customer::class)->findBy($query);
        return count($customers) > 0 ? $customers[0] : false;
    }

    /**
     * Map the customer data, this is make the object more uniform, schema of API provider might change, we can configure 
     * mappings in this function.
     *
     * @param object $query
     * @return object
     */
    private function mapData($customer)
    {
        return (object)[
            'first_name' => $customer->name->first,
            'last_name' => $customer->name->last,
            'email' => $customer->email,
            'username' => $customer->login->username,
            'password' => $customer->login->password,
            'gender' => $customer->gender,
            'country' => $customer->location->country,
            'city' => $customer->location->city,
            'phone' => $customer->phone,
        ];
    }
}
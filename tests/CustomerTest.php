<?php
class CustomerTest extends TestCase
{
    /**
     * Test if the getCustomers API is returning correct json structure.
     *
     * @return void
     */
    public function testGetCustomers()
    {
        $this->get("customers", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'email',
                    'country',
                    'full_name',
                ]
            ],
        ]);
    }

    /**
     * Test if the getCustomer is returning a customer data with correct structure.
     * If customer not found return 404 status code.
     *
     * @return void
     */
    public function testGetCustomer()
    {
        $customers = app()->make('em')->getRepository('App\Entities\Customer')->findAll();
        $this->get("customers/1", []);

        // assuming that customers table are not empty
        if(count($customers) > 0){
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                'data' => [
                    'full_name',
                    'email',
                    'username',
                    'gender',
                    'country',
                    'city',
                    'phone'
                ],
            ]);
        }
        // customers table empty
        else
            $this->seeStatusCode(404);
    }
}
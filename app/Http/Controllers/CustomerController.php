<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Customer;

class CustomerController extends Controller
{
    /**
     * Retrieve all customers.
     *
     * @return Response
     */
    public function getAll()
    {
        $results = app()->make('em')->getRepository(Customer::class)->findAll();
        $customers = [];

        foreach($results as $result){
            $customers[] = [
                "full_name" => $result->getFullName(),
                "email" => $result->getEmail(),
                "country" => $result->getCountry()
            ];
        }

        return response()->json(
            [
                "data" => $customers
            ]
        );
    }

    /**
     * Retrieve the customer for the given customer ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function get(Request $request)
    {
        $result = app()->make('em')->getRepository(Customer::class)->find($request->segment(2));
        if(!$result)
            return response()->json(["message" => "Customer not found"], 404);

        $customer = [
            "full_name" => $result->getFullName(),
            "email" => $result->getEmail(),
            "username" => $result->getUsername(),
            "gender" => $result->getGender(),
            "country" => $result->getCountry(),
            "city" => $result->getCity(),
            "phone" => $result->getPhone()
        ];

        return response()->json(
            [
                "data" => $customer
            ]
        );
    }
}

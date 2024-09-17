<?php

namespace App\Repositories;

use App\Classes\ApiResponse;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAllCustomers()
    {
        return Customer::all();
    }

    public function getCustomerById($id)
    {
        return Customer::find($id);
    }

    public function createCustomer(array $data)
    {
        return Customer::create($data);
    }

    public function updateCustomer(array $data, $id)
    {
        $customer = Customer::findOrFail($id);

        if (!$customer) {
            // If the customer is not found, return a 404 error response
            return ApiResponse::error(null, 'Customer not found', [], 404);
        }

        $customer->update($data);
        return $customer;
    }

    public function deleteCustomer($id)
    {
        // Receive the customer by ID
        $customer = Customer::find($id);

        // Check if the customer exists
        if (!$customer) {
            return null;
        }

        // If customer ID exists, delete it
        $customer->delete();

        // Return the deleted customer
        return $customer;
    }
}

<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponse;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class CustomerController extends Controller
{

    protected $customerRepositoryInterface;

    public function __construct(CustomerRepositoryInterface $customerRepositoryInterface)
    {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }

    public function index()
    {
        $customers = $this->customerRepositoryInterface->getAllCustomers();

        return ApiResponse::success($customers, 'Customer retrived successfully!');
    }

    public function show($id)
    {

        // Retrieve the customer by ID
        $customer = $this->customerRepositoryInterface->getCustomerById($id);

        // Check if the customer exists
        if (!$customer) {
            return ApiResponse::error(null, 'Customer not found', [], 404);
        }

        // If the customer is found, return a success response
        return ApiResponse::success($customer, 'Customer found!', 200);
    }

    public function store(StoreCustomerRequest $request)
    {
        // Validation is automatically handled by the StoreCustomerRequest
        $customer = $this->customerRepositoryInterface->createCustomer($request->all());
        return ApiResponse::success($customer, "Customer created successfully!", 201);
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = $this->customerRepositoryInterface->updateCustomer($request->all(), $id);
        $customer->update($request->all());

        return ApiResponse::success($customer, "Customer updated successfully!", 200);
    }

    public function destroy($id)
    {
        $customer = $this->customerRepositoryInterface->deleteCustomer($id);

        if (!$customer) {
            return ApiResponse::error(null, 'Customer not found', [], 404);
        }

        return ApiResponse::success($customer, "Customer deleted successfully!", 202);
    }
}

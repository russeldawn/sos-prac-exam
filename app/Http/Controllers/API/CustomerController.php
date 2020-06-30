<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $all = $request->all();

        $pageSize = 10;
		$customers = collect([]);

		if ($request->has('page_size')) {

			$pageSize = $request->page_size;

		}

		$customers = Customer::paginate($pageSize);

		return response()->json($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all = $request->all();

        $validator = Validator::make($all, [
            "first_name" => "required|string",
            "last_name" => "required|string",
            'email' => 'required|unique:customers,email|email:rfc',
            "address" => "required|string",
            "gender" => "required|string",
        ]);

        if ($validator->fails()) {

			$errors = $validator->errors();

			return response()->json([
				'status' => 400,
				'errors' => $errors->all()
			]);
        }

        $cloneData = $all;

        if ($request->has('gender')) {
            switch ($cloneData['gender']) {
                case 'male':
                    $cloneData['gender'] = 1;
                    break;

                case 'female':
                    $cloneData['gender'] = 0;
                    break;
            }
        }

        $new = Customer::create($cloneData);
        $response = [];

        if ($new) {
            $response = [
                'status' => 200,
                'data'  => $new
            ];

            return response()->json($response);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $response = [];

        if($customer) {
            $response = [
                'status' => 200,
                'data'   => $customer
            ];

        } else {
            $response = [
                'status' => 400,
                'error'   => 'Customer does not exists in our records.'
            ];
        }

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $all = $request->all();

        $validator = Validator::make($all, [
            "first_name" => "string",
            "last_name" => "string",
            'email' => 'unique:customers,email|email:rfc',
            "address" => "string",
            "gender" => "string",
        ]);

        if ($validator->fails()) {

			$errors = $validator->errors();

			return response()->json([
				'status' => 400,
				'errors' => $errors->all()
			]);
        }

        $cloneData = $all;

        if ($request->has('gender')) {
            switch ($cloneData['gender']) {
                case 'male':
                    $cloneData['gender'] = 1;
                    break;

                case 'female':
                    $cloneData['gender'] = 0;
                    break;
            }
        }


        $updated = Customer::where('id', $customer->id)
                            ->update($cloneData);
        $response = [];

        if ($updated) {
            $response = [
                'status' => 200,
                'data'  => $updated
            ];

            return response()->json($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {

        $response = [];

        if($customer) {

            $deleted = Customer::destroy($customer->id);

            $response = [
                'status' => 200,
                'data'   => $deleted
            ];

        } else {
            $response = [
                'status' => 400,
                'error'   => 'Customer does not exists in our records.'
            ];
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function checker(Request $request)
    {
        $all = $request->all();

        $validator = Validator::make($all, [
            'email' => 'required|unique:customers,email|email:rfc',
        ]);

        if ($validator->fails()) {

			$errors = $validator->errors();

			return response()->json([
				'status' => 400,
				'errors' => $errors->all()
			]);
        }

        dd($all);
    }
}

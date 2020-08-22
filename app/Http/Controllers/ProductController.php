<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        //
        $sortBy = ($request->sortDesc === 'false' || !$request->sortDesc) ? 'DESC' : 'ASC';
        $sort = $request->sortBy ? $request->sortBy : 'created_at';
        $products = Product::where(function($q) {
                            if ($this->user->role == "admin") {
                                $q->where('created_by', $this->user->id);
                            } else {
                                $q->where('status', "enable");
                            }
                        })
                        ->orderBy($sort, $sortBy)->paginate((int) $request->itemsPerPage);
        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
        if ($this->user->role != "admin") {
            return response()->json("Cannot create product", 403);
        }
        $request['id'] = null;

        $this->productValidator($request->except('image'))->validate();
        $this->imageValidator($request->only('image'))->validate();

        $extension = $request->file('image')->extension();
        $imagePath = Storage::disk('public')->putFileAs("products", $request->image, $request->name . "." . $extension);

        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->status = "enable";
        $product->image = '/storage/' . $imagePath;
        $product->created_by = $this->user->id;
        $product->save();

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {
        //
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product) {
        //
        if ($product->created_by != $this->user->id) {
            return response()->json("Cannot update product", 403);
        }
        $request['id'] = $product->id;
        $this->productValidator($request->except('image'))->validate();
        if ($request->imageChange == "true") {
            $this->imageValidator($request->only('image'))->validate();
            $extension = $request->file('image')->extension();
            $imagePath = Storage::disk('public')->putFileAs("products", $request->image, $request->name . "." . $extension);
            $imagePath = '/storage/' . $imagePath;
            $product->image = $imagePath;
        }
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->save();
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        //
        if ($product->created_by != $this->user->id) {
            return response()->json("Cannot delete product", 403);
        }
        $product->delete();
        return response()->json("Deleted", 200);
    }

    /**
     * Disable the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function status($id) {
        //
        $product = Product::find($id);
        if ($product->created_by != $this->user->id) {
            return response()->json("Cannot update product status", 403);
        }
        $product->status = $product->status == "enable" ? 'disable' : 'enable';
        $product->save();
        return response()->json($product->status, 200);
    }

    /**
     * Get a validator for an incoming product request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function productValidator(array $data) {
        return Validator::make($data, [
                    'name' => ['required', 'string'],
                    'price' => ['required', 'numeric','gt:0' ,'lte:999999.99'],
                    'description' => ['required'],
                    'discount' => ['required', 'numeric', 'gte:0', 'lt:100'],
        ]);
    }

    /**
     * Get a validator for an incoming image request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function imageValidator(array $data) {
        return Validator::make($data, [
                    'image' => ['required', 'mimes:jpeg,jpg,png']
        ]);
    }

}

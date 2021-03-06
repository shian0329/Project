<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(25);

        return view('inventory.products.index', compact('products'));
        // Return inventory.products.index page with splitted products array
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all();

        return view('inventory.products.create', compact('categories'));
        // Return inventory.products.create page with categories array
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductRequest  $request
     * @param  App\Product  $model
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request, Product $model)
    {
        $model->create($request->all());

        return redirect()
            ->route('products.index')
            ->withStatus('Product registered successfully.');
        // Store new created product in the database and redirect user to products.index page with message 'Product registered successfully.'
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $solds = $product->solds()->latest()->limit(25)->get();

        $receiveds = $product->receiveds()->latest()->limit(25)->get();

        return view('inventory.products.show', compact('product', 'solds', 'receiveds'));
        // Return inventory.products.show page with product, sold products, received products in array
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();

        return view('inventory.products.edit', compact('product', 'categories'));
        // Return inventory.products.edit pagw with product and categories in array
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());

        return redirect()
            ->route('products.index')
            ->withStatus('Product updated successfully.');
        // Update the products with input from view component and return products.index page with message 'Product updated successfully.'
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->withStatus('Product removed successfully.');
        // Delete the product in database and return product.index page with message 'Product removed successfully.'
    }

    public function export(Request $request)
    {
        $fileName = 'products.csv'; // Define .csv file name
        $products = DB::table("products")
                    ->leftJoin("product_categories", function($join){
                        $join->on("products.product_category_id", "=", "product_categories.id");
                    })
                    ->select("products.name", "product_categories.name as category", "products.price", "products.stock", "products.stock_defective")
                    ->whereNull("products.deleted_at")
                    ->get(); // Query the needed data from DB
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $columns = array('product_category', 'name', 'price', 'stock', 'stock_defective'); // Define columns in the csv file
        $callback = function() use($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($products as $product) {
                $row['product_category'] = $product->category;
                $row['name'] = $product->name;
                $row['price'] = $product->price;
                $row['stock'] = $product->stock;
                $row['stock_defective'] = $product->stock_defective;
                fputcsv($file, array($row['product_category'], $row['name'], $row['price'], $row['stock'], $row['stock_defective']));
            }
            fclose($file);
            // Write the data into the csv and close the writer
        };
        return response()->stream($callback, 200, $headers);
        // Create a new streamed response object to make a download file
    }
}

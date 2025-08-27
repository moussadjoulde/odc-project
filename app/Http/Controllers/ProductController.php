<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['image'] = $request->file('image')->store('products', 'public');
        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        Product::where('id', $id)->update($validated);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function exportCSV()
    {
        $filename = 'products_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Name', 'Price', 'Description', 'Image', 'Slug', 'SKU', 'Weight', 'Dimensions', 'Brand', 'Created At', 'Updated At'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            // Ajouter BOM UTF-8 pour Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, $columns);

            // Boucle sur les produits
            foreach (Product::cursor() as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->price,
                    $product->description,
                    $product->image,
                    $product->slug,
                    $product->sku,
                    $product->weight,
                    $product->dimensions,
                    $product->brand,
                    $product->created_at,
                    $product->updated_at
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportCSVWithId(string $id)
    {
        $product = Product::findOrFail($id);
        $filename = 'product_' . $product->id . '_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Name', 'Price', 'Description', 'Image', 'Slug', 'SKU', 'Weight', 'Dimensions', 'Brand', 'Created At', 'Updated At'];

        $callback = function () use ($columns, $product) {
            $file = fopen('php://output', 'w');
            // Ajouter BOM UTF-8 pour Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, $columns);

            fputcsv($file, [
                $product->id,
                $product->name,
                $product->price,
                $product->description,
                $product->image,
                $product->slug,
                $product->sku,
                $product->weight,
                $product->dimensions,
                $product->brand,
                $product->created_at,
                $product->updated_at
            ]);

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
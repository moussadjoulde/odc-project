<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(20);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('products.create', compact('categories'));
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

    public function storeReview(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|min:10',
        ]);

        // Vérifier si l'utilisateur a déjà noté ce produit
        if ($product->reviews()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Vous avez déjà noté ce produit.');
        }

        // Créer l'avis en ajoutant explicitement le product_id
        $review = $product->reviews()->create([
            'product_id' => $product->id, // Ajout explicite
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
            'approved' => true,
        ]);

        // Mettre à jour la note moyenne du produit
        $product->updateRating();

        return back()->with('success', 'Votre avis a été publié avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function showDetails(string $id)
    {
        $product = Product::findOrFail($id);
        return view('product-show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::latest()->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $validated['image'] = $request->file('image')->store('products', 'public');
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
    
    public function loadMoreReviews(Request $request, Product $product)
    {
        $offset = $request->get('offset', 0);

        $reviews = $product->reviews()
            ->with('user')
            ->where('approved', true)
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take(5)
            ->get();

        $html = '';
        foreach ($reviews as $review) {
            $stars = '';
            for ($i = 1; $i <= 5; $i++) {
                $stars .= '<i class="bi bi-star' . ($i <= $review->rating ? '-fill' : '') . ' text-warning"></i>';
            }

            $html .= '
        <div class="review-item floating-card p-4 mb-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h6 class="fw-600 mb-1">' . ($review->user->name ?? 'Utilisateur anonyme') . '</h6>
                    <div class="rating small">' . $stars . '</div>
                </div>
                <small class="text-muted">' . $review->created_at->format('d/m/Y') . '</small>
            </div>
            <h6 class="fw-600 text-primary mb-2">' . htmlspecialchars($review->title) . '</h6>
            <p class="mb-0">' . htmlspecialchars($review->comment) . '</p>
        </div>';
        }

        return response()->json([
            'success' => true,
            'reviews' => $reviews->toArray(),
            'html' => $html
        ]);
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
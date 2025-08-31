<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
 
class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:2',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'rating' => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'stock_quantity' => 'nullable|numeric|min:0',
            'in_stock' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du produit est obligatoire.',
            'name.string' => 'Le nom du produit doit être une chaîne de caractères.',
            'name.max' => 'Le nom du produit ne doit pas dépasser 255 caractères.',
            'name.min' => 'Le nom du produit doit contenir au moins 2 caractères.',
            'price.required' => 'Le prix du produit est obligatoire.',
            'price.numeric' => 'Le prix du produit doit être un nombre.',
            'price.min' => 'Le prix du produit doit être au moins de 0.',
            'old_price.numeric' => 'Le prix ancien doit être un nombre.',
            'old_price.min' => 'Le prix ancien doit être au moins de 0.',
            'discount_percentage.numeric' => 'Le pourcentage de réduction doit être un nombre.',
            'discount_percentage.min' => 'Le pourcentage de réduction doit être au moins de 0.',
            'discount_percentage.max' => 'Le pourcentage de réduction ne doit pas dépasser 100.',
            'short_description.string' => 'La description courte doit être une chaîne de caractères.',
            'short_description.max' => 'La description courte ne doit pas dépasser 500 caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'rating.numeric' => 'La note doit être un nombre.',
            'rating.min' => 'La note doit être au moins de 0.',
            'rating.max' => 'La note ne doit pas dépasser 5.',
            'review_count.numeric' => 'Le nombre d\'avis doit être un nombre.',
            'review_count.min' => 'Le nombre d\'avis doit être au moins de 0.',
            'stock_quantity.numeric' => 'La quantité en stock doit être un nombre.',
            'stock_quantity.min' => 'La quantité en stock doit être au moins de 0.',
            'in_stock.boolean' => 'La disponibilité doit être vrai ou faux.',
            'is_featured.boolean' => 'La mise en avant doit être vrai ou faux.',
            'is_active.boolean' => 'L\'activation doit être vrai ou faux.',
            'image.image' => "Le fichier doit être une image.",
            'image.mimes' => "L'image doit être au format jpeg, png ou jpg.",
            'image.max' => "L'image ne doit pas dépasser 2MB.",
            'weight.numeric' => 'Le poids doit être un nombre.',
            'weight.min' => 'Le poids doit être au moins de 0.',
            'dimensions.string' => 'Les dimensions doivent être une chaîne de caractères.',
            'brand.string' => 'La marque doit être une chaîne de caractères.',
            'brand.max' => 'La marque ne doit pas dépasser 255 caractères.',
            'meta_title.string' => 'Le méta titre doit être une chaîne de caractères.',
            'meta_title.max' => 'Le méta titre ne doit pas dépasser 255 caractères.',
            'meta_description.string' => 'La méta description doit être une chaîne de caractères.',
            'meta_description.max' => 'La méta description ne doit pas dépasser 500 caractères.',
            'category_id.exists' => 'La catégorie sélectionnée n\'est pas valide.'
        ];
    }
}

<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
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
            'description.string' => 'La description doit être une chaîne de caractères.',
            'image.image' => "Le fichier doit être une image.",
            'image.mimes' => "L'image doit être au format jpeg, png ou jpg.",
            'image.max' => "L'image ne doit pas dépasser 2MB.",
            'weight.numeric' => 'Le poids doit être un nombre.',
            'weight.min' => 'Le poids doit être au moins de 0.',
            'dimensions.string' => 'Les dimensions doivent être une chaîne de caractères.',
            'brand.string' => 'La marque doit être une chaîne de caractères.',
            'brand.max' => 'La marque ne doit pas dépasser 255 caractères.',
        ];
    }
}

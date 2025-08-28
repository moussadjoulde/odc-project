<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Product
 * 
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string|null $description
 * @property string|null $image
 * @property string $slug
 * @property string $sku
 * @property float|null $weight
 * @property string|null $dimensions
 * @property string|null $brand
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Product extends Model
{
	use HasFactory;
	protected $table = 'products';

	protected $casts = [
		'price' => 'float',
		'weight' => 'float'
	];

	protected $fillable = [
		'name',
		'price',
		'old_price',
		'discount_percentage',
		'description',
		'short_description',
		'image',
		'slug',
		'sku',
		'weight',
		'dimensions',
		'brand',
		'rating',
		'review_count',
		'stock_quantity',
		'in_stock',
		'is_featured',
		'is_active',
		'category_id',
		'meta_title',
		'meta_description'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	protected static function boot()
	{
		parent::boot();

		static::creating(function ($product) {
			// Générer le slug unique
			$slug = Str::slug($product->name);
			$count = Product::where('slug', 'like', "{$slug}%")->count();
			$product->slug = $count ? "{$slug}-{$count}" : $slug;

			// Générer un SKU unique (ex: PROD-ABC123)
			$product->sku = 'PROD-' . strtoupper(Str::random(6));
		});

		static::updating(function ($product) {
			// Mettre à jour le slug si le nom change
			if ($product->isDirty('name')) {
				$slug = Str::slug($product->name);
				$count = Product::where('slug', 'like', "{$slug}%")
					->where('id', '!=', $product->id)
					->count();
				$product->slug = $count ? "{$slug}-{$count}" : $slug;
			}
		});
	}
}

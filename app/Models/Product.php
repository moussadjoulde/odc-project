<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
		'old_price' => 'float',
		'discount_percentage' => 'float',
		'weight' => 'float',
		'rating' => 'float',
		'review_count' => 'integer',
		'stock_quantity' => 'integer',
		'in_stock' => 'boolean',
		'is_featured' => 'boolean',
		'is_active' => 'boolean',
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

	// Relations existantes
	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	// Nouvelles relations pour les commandes
	public function orderItems(): HasMany
	{
		return $this->hasMany(OrderItem::class);
	}

	public function orders()
	{
		return $this->belongsToMany(Order::class, 'order_items')
			->withPivot('quantity', 'unit_price', 'total_price', 'product_name', 'product_sku')
			->withTimestamps();
	}

	public function reviews()
	{
		return $this->hasMany(Review::class, 'product_id');
	}

	public function approvedReviews()
	{
		return $this->reviews()->where('approved', true)->orderBy('created_at', 'desc');
	}

	public function updateRating()
	{
		$this->rating = $this->reviews()->avg('rating') ?? 0;
		$this->review_count = $this->reviews()->count();
		$this->save();
	}

	// Méthodes utiles pour les commandes
	public function getTotalSoldAttribute(): int
	{
		return $this->orderItems()
			->whereHas('order', function ($query) {
				$query->whereIn('status', ['confirmed', 'processing', 'shipped', 'delivered']);
			})
			->sum('quantity');
	}

	public function getRevenueAttribute(): float
	{
		return $this->orderItems()
			->whereHas('order', function ($query) {
				$query->whereIn('status', ['confirmed', 'processing', 'shipped', 'delivered'])
					->where('payment_status', 'paid');
			})
			->sum('total_price');
	}

	// Vérifier si le produit est en stock suffisant pour une quantité donnée
	public function hasStock(int $quantity = 1): bool
	{
		return $this->in_stock && $this->stock_quantity >= $quantity;
	}

	// Réduire le stock (après confirmation de commande)
	public function decreaseStock(int $quantity): bool
	{
		if ($this->hasStock($quantity)) {
			$this->decrement('stock_quantity', $quantity);

			// Mettre à jour le statut in_stock si nécessaire
			if ($this->stock_quantity <= 0) {
				$this->update(['in_stock' => false]);
			}

			return true;
		}

		return false;
	}

	// Augmenter le stock (en cas d'annulation/retour)
	public function increaseStock(int $quantity): void
	{
		$this->increment('stock_quantity', $quantity);

		// Remettre en stock si ce n'était pas le cas
		if (!$this->in_stock && $this->stock_quantity > 0) {
			$this->update(['in_stock' => true]);
		}
	}

	// Getter pour le prix avec remise
	public function getDiscountPriceAttribute(): ?float
	{
		if ($this->old_price && $this->old_price > $this->price) {
			return $this->price;
		}

		return null;
	}

	// Getter pour le pourcentage de remise calculé
	public function getCalculatedDiscountPercentageAttribute(): ?int
	{
		if ($this->old_price && $this->old_price > $this->price) {
			return round((($this->old_price - $this->price) / $this->old_price) * 100);
		}

		return null;
	}

	// Scopes pour les requêtes courantes
	public function scopeInStock($query)
	{
		return $query->where('in_stock', true)->where('stock_quantity', '>', 0);
	}

	public function scopeFeatured($query)
	{
		return $query->where('is_featured', true);
	}

	public function scopeActive($query)
	{
		return $query->where('is_active', true);
	}

	public function scopeOnSale($query)
	{
		return $query->whereNotNull('old_price')->whereColumn('price', '<', 'old_price');
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

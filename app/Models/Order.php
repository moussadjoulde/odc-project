<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $id
 * @property string $number
 * @property Carbon|null $ordered_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';

	protected $casts = [
		'ordered_at' => 'datetime'
	];

	protected $fillable = [
		'number',
		'ordered_at'
	];

	public function products()
	{
		return $this->belongsToMany(Product::class, 'product_order')
					->withPivot('id', 'quantity', 'price', 'total')
					->withTimestamps();
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductOrder
 * 
 * @property int $id
 * @property int $product_id
 * @property int $order_id
 * @property int $quantity
 * @property float $price
 * @property float $total
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Order $order
 * @property Product $product
 *
 * @package App\Models
 */
class ProductOrder extends Model
{
	protected $table = 'product_order';

	protected $casts = [
		'product_id' => 'int',
		'order_id' => 'int',
		'quantity' => 'int',
		'price' => 'float',
		'total' => 'float'
	];

	protected $fillable = [
		'product_id',
		'order_id',
		'quantity',
		'price',
		'total'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}

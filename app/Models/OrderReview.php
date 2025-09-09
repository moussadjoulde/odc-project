<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderReview
 * 
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property int $rating
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Order $order
 * @property User $user
 *
 * @package App\Models
 */
class OrderReview extends Model
{
	protected $table = 'order_reviews';

	protected $casts = [
		'order_id' => 'int',
		'user_id' => 'int',
		'rating' => 'int'
	];

	protected $fillable = [
		'order_id',
		'user_id',
		'rating',
		'comment'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * 
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property int $rating
 * @property string $title
 * @property string $comment
 * @property bool $approved
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property User $user
 *
 * @package App\Models
 */
class Review extends Model
{
	protected $table = 'reviews';

	protected $casts = [
		'product_id' => 'int', // Ajoutez ceci
		'user_id' => 'int',
		'rating' => 'int',
		'approved' => 'bool'
	];

	protected $fillable = [
		'product_id', // Ajoutez ce champ
		'user_id',
		'rating',
		'title',
		'comment',
		'approved'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function scopeApproved($query)
	{
		return $query->where('approved', true);
	}
}

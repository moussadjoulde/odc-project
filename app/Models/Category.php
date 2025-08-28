<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property int $order
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Category extends Model
{
	use HasFactory;
	protected $table = 'categories';

	protected $casts = [
		'order' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'slug',
		'description',
		'image',
		'order',
		'is_active'
	];

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}

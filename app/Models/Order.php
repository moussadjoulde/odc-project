<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * Class Order
 * 
 * @property int $id
 * @property string $order_number
 * @property int|null $user_id
 * @property string $customer_name
 * @property string $customer_email
 * @property string|null $customer_phone
 * @property string $shipping_address
 * @property string $shipping_city
 * @property string|null $shipping_postal_code
 * @property string $shipping_country
 * @property string|null $billing_address
 * @property string|null $billing_city
 * @property string|null $billing_postal_code
 * @property string|null $billing_country
 * @property float $subtotal
 * @property float $tax_amount
 * @property float $shipping_cost
 * @property float $discount_amount
 * @property float $total_amount
 * @property string $status
 * @property string $payment_status
 * @property string|null $payment_method
 * @property string $shipping_method
 * @property Carbon|null $shipped_at
 * @property Carbon|null $delivered_at
 * @property string|null $tracking_number
 * @property string|null $coupon_code
 * @property string|null $notes
 * @property string|null $admin_notes
 * @property string|null $session_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|OrderItem[] $orderItems
 * @property Collection|OrderStatusHistory[] $statusHistories
 *
 * @package App\Models
 */
class Order extends Model
{
	use HasFactory;

	protected $table = 'orders';

	protected $fillable = [
		'order_number',
		'user_id',
		'customer_name',
		'customer_email',
		'customer_phone',
		'shipping_address',
		'shipping_city',
		'shipping_postal_code',
		'shipping_country',
		'billing_address',
		'billing_city',
		'billing_postal_code',
		'billing_country',
		'subtotal',
		'tax_amount',
		'shipping_cost',
		'discount_amount',
		'total_amount',
		'status',
		'payment_status',
		'payment_method',
		'shipping_method',
		'shipped_at',
		'delivered_at',
		'tracking_number',
		'coupon_code',
		'notes',
		'admin_notes',
		'session_id',
	];

	protected $casts = [
		'subtotal' => 'float',
		'tax_amount' => 'float',
		'shipping_cost' => 'float',
		'discount_amount' => 'float',
		'total_amount' => 'float',
		'shipped_at' => 'datetime',
		'delivered_at' => 'datetime',
	];


	// Relations
	public function orderItems(): HasMany
	{
		return $this->hasMany(OrderItem::class);
	}

	public function statusHistories(): HasMany
	{
		return $this->hasMany(OrderStatusHistory::class)->orderBy('created_at', 'desc');
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function reviews(): HasMany
	{
		return $this->hasMany(OrderReview::class);
	}


	// Méthodes utiles
	public function getTotalItemsAttribute(): int
	{
		return $this->orderItems->sum('quantity');
	}

	public function getStatusColorAttribute(): string
	{
		return match ($this->status) {
			'pending' => 'warning',
			'confirmed' => 'info',
			'processing' => 'primary',
			'shipped' => 'secondary',
			'delivered' => 'success',
			'cancelled' => 'danger',
			'refunded' => 'dark',
			default => 'light'
		};
	}

	public function getPaymentStatusColorAttribute(): string
	{
		return match ($this->payment_status) {
			'pending' => 'warning',
			'paid' => 'success',
			'failed' => 'danger',
			'refunded' => 'dark',
			'partial' => 'info',
			default => 'light'
		};
	}

	public function getFormattedStatusAttribute(): string
	{
		return match ($this->status) {
			'pending' => 'En attente',
			'confirmed' => 'Confirmée',
			'processing' => 'En préparation',
			'shipped' => 'Expédiée',
			'delivered' => 'Livrée',
			'cancelled' => 'Annulée',
			'refunded' => 'Remboursée',
			default => ucfirst($this->status)
		};
	}

	public function getFormattedPaymentStatusAttribute(): string
	{
		return match ($this->payment_status) {
			'pending' => 'En attente',
			'paid' => 'Payé',
			'failed' => 'Échec',
			'refunded' => 'Remboursé',
			'partial' => 'Partiel',
			default => ucfirst($this->payment_status)
		};
	}

	public function canBeCancelled(): bool
	{
		return in_array($this->status, ['pending', 'confirmed']);
	}

	public function canBeRefunded(): bool
	{
		return $this->payment_status === 'paid' &&
			in_array($this->status, ['delivered', 'shipped']);
	}

	// Scopes
	public function scopePending($query)
	{
		return $query->where('status', 'pending');
	}

	public function scopeConfirmed($query)
	{
		return $query->where('status', 'confirmed');
	}

	public function scopeProcessing($query)
	{
		return $query->where('status', 'processing');
	}

	public function scopeShipped($query)
	{
		return $query->where('status', 'shipped');
	}

	public function scopeDelivered($query)
	{
		return $query->where('status', 'delivered');
	}

	public function scopePaid($query)
	{
		return $query->where('payment_status', 'paid');
	}

	public function scopeUnpaid($query)
	{
		return $query->where('payment_status', '!=', 'paid');
	}

	// Boot method pour générer le numéro de commande
	protected static function boot()
	{
		parent::boot();

		static::creating(function ($order) {
			// Générer un numéro de commande unique
			$order->order_number = 'ORD-' . date('Y') . '-' . str_pad(
				Order::whereYear('created_at', date('Y'))->count() + 1,
				6,
				'0',
				STR_PAD_LEFT
			);
		});

		static::updated(function ($order) {
			// Créer un historique quand le statut change
			if ($order->isDirty('status')) {
				OrderStatusHistory::create([
					'order_id' => $order->id,
					'status' => $order->status,
					'comment' => 'Statut mis à jour automatiquement',
					'changed_by' => Auth::user()->name ?? 'Système',
				]);
			}
		});
	}
}

/**
 * Modèle OrderItem pour les articles de commande
 */
class OrderItem extends Model
{
	use HasFactory;

	protected $table = 'order_items';

	protected $casts = [
		'unit_price' => 'float',
		'total_price' => 'float',
		'quantity' => 'integer',
		'product_options' => 'array',
	];

	protected $fillable = [
		'order_id',
		'product_id',
		'product_name',
		'product_sku',
		'unit_price',
		'quantity',
		'total_price',
		'product_image',
		'product_options',
	];

	public function order(): BelongsTo
	{
		return $this->belongsTo(Order::class);
	}

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}
}

/**
 * Modèle OrderStatusHistory pour l'historique des statuts
 */
class OrderStatusHistory extends Model
{
	use HasFactory;

	protected $table = 'order_status_histories';

	protected $fillable = [
		'order_id',
		'status',
		'comment',
		'changed_by',
	];

	public function order(): BelongsTo
	{
		return $this->belongsTo(Order::class);
	}
}

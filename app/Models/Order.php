<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    use HasFactory;

    public const STATUS_CREATED = 'CREATED';

    public const STATUS_PAYED = 'PAYED';

    public const STATUS_PENDING = 'PENDING';

    public const STATUS_REJECTED = 'REJECTED';

    protected $fillable = [
        "reference",
        "product_id",
        "customer_name",
        "customer_email",
        "customer_mobile",
        "status",
        "transaction_id",
        "payment_url"
    ];

    public function scopeFilterByCustomerEmail(Builder $query, string $customerEmail): Builder
    {
        return $query->where("customer_email", $customerEmail)->orderBy('updated_at');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function requireUpdateStatus(): bool
    {
        return $this->status == self::STATUS_PENDING || $this->status == self::STATUS_CREATED;
    }

    public function updateStatus(string $status): void
    {
        $this->status = $status;
        $this->save();
    }

    public function isRejected(): bool
    {
        return $this->status == self::STATUS_REJECTED;
    }
}

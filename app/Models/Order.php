<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

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

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

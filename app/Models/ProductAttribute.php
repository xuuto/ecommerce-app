<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
      'attribute_id',
      'value',
      'quantity',
      'price',
      'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}

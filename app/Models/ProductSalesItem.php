<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSalesItem extends Model
{
    use HasFactory;
    protected $fillable=['sales_id','product_id','big_unit_sales_price','small_unit_sales_price','big_unit_qty','small_unit_qty'];
}

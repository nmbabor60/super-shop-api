<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSales extends Model
{
    use HasFactory;
    protected $fillable=[
        'client_id','invoice_no','sales_date','total_amount','payable_amount','paid_amount','prev_amount','discount','note','created_by'
    ];
}

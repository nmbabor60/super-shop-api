<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table ='products';
    protected $fillable = ['product_name','category_id','sub_category_id','brand_id','product_code','big_unit_id','small_unit_id','stock_limitation','specification','status','slug','created_by'];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id')->select('name','id','slug');
    }
    public function subCategory(){
        return $this->belongsTo(subCategory::class,'sub_category_id','id')->select('name','id','slug');
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id','id')->select('name','id','slug');
    }
    public function bigUnit(){
        return $this->belongsTo(Unit::class,'big_unit_id','id')->select('name','id');
    }
    public function smallUnit(){
        return $this->belongsTo(Unit::class,'small_unit_id','id')->select('name','id');
    }
    public function creator(){
        return $this->belongsTo(User::class,'created_by','id')->select('name','id','email');
    }
}

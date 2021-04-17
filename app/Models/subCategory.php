<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subCategory extends Model
{
    use HasFactory;
    protected $table ='sub_categories';
    protected $fillable = ['name','status','slug','created_by','category_id'];
}

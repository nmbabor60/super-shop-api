<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table ='categories';
    protected $fillable = ['name','status','slug','created_by'];

    public function subCategoryData(){
        return $this->hasMany(subCategory::class,'category_id','id');
    }
}

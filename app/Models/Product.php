<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable =['name', 'description', 'price', 'sub_category_id','user_id'];

    public function subcategory(){
        
        return $this->belongsTo(Sub_Category::class);
    }
    public function user(){
        
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name','user_id'
    ];

    public function subcategories(){

        return $this->hasMany(Sub_Category::class);
    }
    public function user(){
        
        return $this->belongsTo(User::class);
    }
}

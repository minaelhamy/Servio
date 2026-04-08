<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    public function total_service()
    {
        return $this->hasMany('App\Models\Service', 'category_id', 'id')->count();
    }
}

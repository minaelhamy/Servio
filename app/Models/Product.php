<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'vendor_id', 'category_id', 'name', 'price', 'slug', 'tax', 'description', 'stock_management', 'qty', 'min_order', 'max_order', 'low_qty', 'is_imported'];
    public function product_image()
    {
        return $this->hasOne('App\Models\ProductImage', 'product_id', 'id')->orderBy('reorder_id');
    }
    public function multi_image()
    {
        return $this->hasMany('App\Models\ProductImage', 'product_id', 'id')->select('product_images.id', 'product_images.product_id', 'product_images.image as image_name', DB::raw("CONCAT('" . url(env('ASSETPATHURL') . 'admin-assets/images/service') . "/', image) AS image"))->orderby('product_images.reorder_id');
    }
    public function category_info()
    {
        return $this->hasOne('App\Models\ProductCategory', 'id', 'category_id');
    }
    public function average_ratting()
    {
        return $this->hasOne('App\Models\Testimonials', 'service_id', 'id')->select('SUM(testimonials.star)/COUNT(testimonials.user_id) AS avg_rating');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Testimonials', 'product_id', 'id');
    }
    public function product_image_api()
    {
        return $this->hasOne('App\Models\ProductImage', 'product_id', 'id')->select('product_images.id', 'product_images.product_id', 'product_images.image as image_name', DB::raw("CONCAT('" . url(env('ASSETPATHURL') . 'admin-assets/images/service') . "/', image) AS image"))->orderbyDesc('product_images.reorder_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'vendor_id', 'category_id', 'name', 'price', 'slug', 'tax', 'description', 'staff_id', 'interval_time', 'interval_type', 'per_slot_limit', 'staff_assign', 'is_imported'];
    public function service_image()
    {
        return $this->hasOne('App\Models\ServiceImage', 'service_id', 'id')->orderBy('reorder_id');
    }
    public function multi_image()
    {
        return $this->hasMany('App\Models\ServiceImage', 'service_id', 'id')->select('service_images.id', 'service_images.service_id', 'service_images.image as image_name', DB::raw("CONCAT('" . url(env('ASSETPATHURL') . 'admin-assets/images/service') . "/', image) AS image"))->orderby('service_images.reorder_id');
    }
    public function category_info()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
    public function average_ratting()
    {
        return $this->hasOne('App\Models\Testimonials', 'service_id', 'id')->select('SUM(testimonials.star)/COUNT(testimonials.user_id) AS avg_rating');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Testimonials', 'service_id', 'id');
    }
    public function service_image_api()
    {
        return $this->hasOne('App\Models\ServiceImage', 'service_id', 'id')->select('service_images.id', 'service_images.service_id', 'service_images.image as image_name', DB::raw("CONCAT('" . url(env('ASSETPATHURL') . 'admin-assets/images/service') . "/', image) AS image"))->orderbyDesc('service_images.reorder_id');
    }
     public function additional_service()
    {
        return $this->hasMany('App\Models\AdditionalService', 'service_id', 'id');
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    public function category_info()
    {
        return $this->hasOne('App\Models\Category','id','category_id')->select('id','name','slug');
    }
    public function service_info()
    {
        return $this->hasOne('App\Models\Service','id','service_id')->select('id','name');
    }
}

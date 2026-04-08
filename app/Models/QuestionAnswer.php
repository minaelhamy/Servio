<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class QuestionAnswer extends Model
{
    use HasFactory;
    protected $table = 'question_answer';
    public function product()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }
    public function service()
    {
        return $this->hasOne('App\Models\Service','id','service_id');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    use HasFactory;
    protected $table='sales';
    protected $fillable = ['category_id', 'sales_quantity'];
       public function category(){
        return $this->belongsTo(category::class);
    }
}

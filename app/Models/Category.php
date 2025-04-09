<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table='categories';

    protected $fillable = ['categoryName', 'sales_price', 'purchase_price'];

  
        public function purchase(){
            return $this->hasMny(sales::class);
        }
    
}

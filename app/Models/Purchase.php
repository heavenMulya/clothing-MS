<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table='purchases';
    protected $fillable = ['category_id', 'purchase_quantity'];

    public function category(){
        return $this->belongsTo(category::class);
    }
}

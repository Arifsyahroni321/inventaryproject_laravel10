<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $primaryKey = 'id_product';
    protected $fillable = ['name', 'categori_id', 'desc', 'price','stock_quantity','minimum_stock_level'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categori_id','id_categori');
    }
    public function stockout()
    {
        return $this->hasMany(Stockout::class, 'product_id', 'id_product');
     }
        public function stockin()
    {
        return $this->hasMany(Stockin::class, 'product_id', 'id_product');
     }
}

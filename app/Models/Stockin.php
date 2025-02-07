<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockin extends Model
{
    use HasFactory;

    protected $table = 'stock_in';
    protected $primaryKey = 'id_stockin';
    protected $fillable = ['product_id', 'quantity', 'date', 'added_by','description','created_at','updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id_product');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by','id_user');
    }

}

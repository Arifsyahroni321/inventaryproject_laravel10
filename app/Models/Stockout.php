<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockout extends Model
{
    use HasFactory;
    protected $table = 'stock_out';

    protected $primaryKey = 'id_stockout';
    protected $fillable = ['id_product','product_id', 'quantity', 'date', 'removed_by','descr','created_at','updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id_product');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'removed_by','id_user');
    }

}

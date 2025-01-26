<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $primaryKey = 'id_categori';
    protected $fillable = ['id_categori','name','created_at','updated_at'];

    // Relasi One-to-Many dengan Product
    public function product()
    {
        return $this->hasMany(Product::class, 'categori_id', 'id_categori');    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Agora também permitimos salvar a imagem (campo photo) junto com os outros campos
    protected $fillable = ['name', 'price', 'stock', 'category_id', 'photo'];

    // Dizendo ao Laravel que o modelo 'Product' tem um relacionamento com a tabela 'categories'
    public function category()
    {
        // Um produto pertence a uma categoria
        return $this->belongsTo(Category::class);
    }
}

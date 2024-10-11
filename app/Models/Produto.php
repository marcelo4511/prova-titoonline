<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nome', 'descricao', 'preco', 'categoria_id'];

    protected $appends = ['price'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function getPriceAttribute()
    {
        return "R$ " . number_format($this->preco, 2, ',', '.');
    }
}

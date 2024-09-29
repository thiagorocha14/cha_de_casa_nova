<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'categoria', 'comprado', 'nome_comprador'];

    public function links()
    {
        return $this->hasMany(PresenteLinks::class);
    }
}

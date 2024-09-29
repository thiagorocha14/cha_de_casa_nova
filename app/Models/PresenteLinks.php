<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenteLinks extends Model
{
    use HasFactory;

    protected $table = 'presente_links';

    protected $fillable = ['link'];

    public function presente()
    {
        return $this->belongsTo(Presente::class);
    }
}

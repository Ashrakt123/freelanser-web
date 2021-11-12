<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'portfolio_id'
    ];

    public function portfolio(){
        return $this->belongsTo(portfolio::class);
    }
}

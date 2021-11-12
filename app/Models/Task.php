<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'file',
        'text',
        'owner_id',
        'developer_id',
        'project_id',
        'submitted',
        'accepted'
    ];
    protected $casts = [

        'file'=> 'array'
    ];
    public function client(){
        return $this->belongsTo(User::class , 'owner_id');
    }

    public function developer(){
        return $this->belongsTo(User::class , 'developer_id');
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}

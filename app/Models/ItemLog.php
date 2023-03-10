<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function list_items()
    {
        return $this->hasMany(ListLog::class, 'log_id', 'log_id');
    }
}
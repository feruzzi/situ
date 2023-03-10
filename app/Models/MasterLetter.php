<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterLetter extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function companies()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}

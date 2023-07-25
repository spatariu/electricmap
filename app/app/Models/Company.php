<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'parent_company_id'];
    public $timestamps = false;
    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}
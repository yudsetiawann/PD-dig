<?php

namespace App\Models;

use App\Models\OrganizationMember;
use Illuminate\Database\Eloquent\Model;

class OrganizationPosition extends Model
{
    protected $guarded = [];
    protected $fillable = ['name', 'order_level', 'is_active'];

    // Scope untuk mengambil jabatan aktif & terurut
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order_level', 'asc');
    }

    public function members()
    {
        return $this->hasMany(OrganizationMember::class);
    }
}

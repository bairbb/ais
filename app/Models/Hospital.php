<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Biopsy;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['old_id', 'name', 'full_name', 'is_active'])]
class Hospital extends Model
{
    use SoftDeletes;
    
    public function biopsies(): HasMany
    {
        return $this->hasMany(Biopsy::class);
    }
}

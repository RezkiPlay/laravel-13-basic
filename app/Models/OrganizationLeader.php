<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['Leader_name', 'organization_id'])]
class OrganizationLeader extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizationLeaderFactory> */
    use HasFactory, HasUuids;

    public function organizatiom(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}

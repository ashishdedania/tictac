<?php

namespace App\Models\Games\Traits\Relationship;

use App\Models\Access\User\User;

/**
 * Class GameRelationship.
 */
trait GameRelationship
{
    /**
     * Games belongsTo with User.
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

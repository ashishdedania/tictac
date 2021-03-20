<?php

namespace App\Models\Games;

use App\Models\BaseModel;
use App\Models\Blogs\Traits\Attribute\GameAttribute;
use App\Models\Blogs\Traits\Relationship\GameRelationship;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends BaseModel
{
    use ModelTrait,
        SoftDeletes,
        GameAttribute,
        GameRelationship {
            
        }

    protected $fillable = [
        'game_id',
        'user_id',
        'x_position',
        'y_position',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('module.games.table');
    }
}

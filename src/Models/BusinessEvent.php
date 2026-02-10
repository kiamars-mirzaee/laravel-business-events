<?php

namespace BusinessEvents\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BusinessEvent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'business_events';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'event_data' => 'array',
    ];

    /**
     * Get the parent model (polymorphic manually or via custom logic since standard morph columns changed).
     * The user uses model_type and model_id.
     */
    public function subject()
    {
         // Assuming model_type maps to a full class name, or we need a map.
         // For now, let's keep it simple or defining a relationship might be tricky if model_type is just a short string.
         // We can define a dynamic accessor or just leave it for now until we know the mapping.
         return $this->morphTo(__FUNCTION__, 'model_type', 'model_id');
    }
}
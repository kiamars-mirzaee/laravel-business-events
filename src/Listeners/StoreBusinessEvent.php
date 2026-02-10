<?php

namespace BusinessEvents\Listeners;

use BusinessEvents\Contracts\ShouldBeStored;
use BusinessEvents\Models\BusinessEvent;
use BusinessEvents\Jobs\ProcessBusinessEvent;

class StoreBusinessEvent
{
    public function handle(ShouldBeStored $event): void
    {
        $businessEvent = BusinessEvent::create([
            'model_type' => $event->getModelType(),
            'model_id' => $event->getModelId(),
            'name' => $event->getEventName(),
            'event_data' => $event->getEventData(),
            'state' => 'queue',
        ]);

        dispatch(new ProcessBusinessEvent($businessEvent));
    }
}
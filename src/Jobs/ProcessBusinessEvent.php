<?php

namespace BusinessEvents\Jobs;

use BusinessEvents\Models\BusinessEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessBusinessEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $businessEvent;

    public function __construct(BusinessEvent $businessEvent)
    {
        $this->businessEvent = $businessEvent;
    }

    public function handle(): void
    {
        $this->businessEvent->update(['state' => 'processing']);

        try {
            // Logic to handle the specific event can go here.
            // Or we might fire another event that listeners can hook into.
            // For now, we just mark it as success.

            $this->businessEvent->update(['state' => 'success']);
        }
        catch (\Throwable $e) {
            $this->businessEvent->update(['state' => 'fail']);
            throw $e;
        }
    }
}
<?php

namespace BusinessEvents\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements \BusinessEvents\Contracts\ShouldBeStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The order instance.
     *
     * @var object
     */
    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    public function getModelType(): string
    {
        return 'order';
    }

    public function getModelId(): string|int
    {
        return $this->order->id;
    }

    public function getEventName(): string
    {
        return 'order_created';
    }

    public function getEventData(): array
    {
        return (array)$this->order;
    }
}
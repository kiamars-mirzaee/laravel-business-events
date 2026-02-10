<?php

namespace BusinessEvents\Tests\Unit;

use BusinessEvents\Models\BusinessEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusinessEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_business_event()
    {
        $event = BusinessEvent::create([
            'event_type' => 'OrderCreated',
            'eventable_type' => 'App\\Models\\Order',
            'eventable_id' => 1,
            'priority' => 1,
            'status' => 'pending',
            'metadata' => ['total' => 100],
        ]);

        $this->assertDatabaseHas('business_events', [
            'event_type' => 'OrderCreated',
            'priority' => 1,
            'status' => 'pending',
        ]);

        $this->assertEquals('OrderCreated', $event->event_type);
        $this->assertEquals(1, $event->priority);
        $this->assertEquals('pending', $event->status);
    }

    /** @test */
    public function it_can_update_event_status()
    {
        $event = BusinessEvent::create([
            'event_type' => 'PaymentProcessed',
            'eventable_type' => 'App\\Models\\Payment',
            'eventable_id' => 1,
            'priority' => 1,
            'status' => 'pending',
        ]);

        $event->update(['status' => 'processing']);

        $this->assertEquals('processing', $event->fresh()->status);
    }

    /** @test */
    public function it_stores_metadata_as_json()
    {
        $metadata = [
            'customer_id' => 123,
            'total' => 250.50,
            'items' => ['item1', 'item2'],
        ];

        $event = BusinessEvent::create([
            'event_type' => 'OrderCreated',
            'eventable_type' => 'App\\Models\\Order',
            'eventable_id' => 1,
            'priority' => 5,
            'status' => 'pending',
            'metadata' => $metadata,
        ]);

        $this->assertEquals($metadata, $event->fresh()->metadata);
    }

    /** @test */
    public function it_can_query_events_by_priority()
    {
        BusinessEvent::create([
            'event_type' => 'HighPriority',
            'eventable_type' => 'App\\Models\\Order',
            'eventable_id' => 1,
            'priority' => 1,
            'status' => 'pending',
        ]);

        BusinessEvent::create([
            'event_type' => 'LowPriority',
            'eventable_type' => 'App\\Models\\Order',
            'eventable_id' => 2,
            'priority' => 10,
            'status' => 'pending',
        ]);

        $events = BusinessEvent::where('status', 'pending')
            ->orderBy('priority')
            ->get();

        $this->assertEquals(1, $events->first()->priority);
        $this->assertEquals(10, $events->last()->priority);
    }

    /** @test */
    public function it_can_query_events_by_status()
    {
        BusinessEvent::create([
            'event_type' => 'Event1',
            'eventable_type' => 'App\\Models\\Order',
            'eventable_id' => 1,
            'priority' => 1,
            'status' => 'pending',
        ]);

        BusinessEvent::create([
            'event_type' => 'Event2',
            'eventable_type' => 'App\\Models\\Order',
            'eventable_id' => 2,
            'priority' => 1,
            'status' => 'completed',
        ]);

        $pendingEvents = BusinessEvent::where('status', 'pending')->count();
        $completedEvents = BusinessEvent::where('status', 'completed')->count();

        $this->assertEquals(1, $pendingEvents);
        $this->assertEquals(1, $completedEvents);
    }
}
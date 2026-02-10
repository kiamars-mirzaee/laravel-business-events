<?php

namespace BusinessEvents\Contracts;

interface ShouldBeStored
{
    public function getModelType(): string;
    public function getModelId(): string|int;
    public function getEventName(): string;
    public function getEventData(): array;
}
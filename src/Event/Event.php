<?php

namespace App\Event;

interface Event
{
    public function getType(): string;
    public function getMatchId(): string;
    public function toArray(): array;
}

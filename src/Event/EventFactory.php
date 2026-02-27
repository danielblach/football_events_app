<?php

namespace App\Event;

use InvalidArgumentException;

class EventFactory
{
    public static function create(array $data): Event
    {
        return match ($data['type']) {
            'foul' => new FoulEvent(
                $data['player'],
                $data['team_id'],
                $data['match_id'],
                $data['minute'],
                $data['second']
            ),

            default => throw new InvalidArgumentException('Unsupported event type')
        };
    }
}

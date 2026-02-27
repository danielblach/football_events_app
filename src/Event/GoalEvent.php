<?php

namespace App\Event;

class GoalEvent implements Event
{
    public function __construct(
        private string $player,
        private string $teamId,
        private string $matchId,
        private int $minute,
        private int $second
    ) {}

    public function getType(): string
    {
        return 'goal';
    }

    public function getMatchId(): string
    {
        return $this->matchId;
    }

    public function toArray(): array
    {
        return [
            'type' => 'goal',
            'player' => $this->player,
            'team_id' => $this->teamId,
            'match_id' => $this->matchId,
            'minute' => $this->minute,
            'second' => $this->second
        ];
    }
}

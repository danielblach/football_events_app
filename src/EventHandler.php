<?php

namespace App;

use App\Event\EventFactory;
use App\Event\EventNotifier;

class EventHandler
{
    private FileStorage $storage;
    private StatisticsManager $statisticsManager;
    private EventNotifier $notifier;
    
    public function __construct(string $storagePath, ?StatisticsManager $statisticsManager = null, ?EventNotifier $notifier = null)
    {
        $this->storage = new FileStorage($storagePath);
        $this->statisticsManager = $statisticsManager ?? new StatisticsManager(__DIR__ . '/../storage/statistics.txt');
        $this->notifier = $notifier ?? new LogNotifier(__DIR__ . '/../storage/notifications.log');
    }
    
    public function handleEvent(array $data): array
    {
        if (!isset($data['type'])) {
            throw new \InvalidArgumentException('Event type is required');
        }

        $event = EventFactory::create($data);
        
        $this->storage->save($event->toArray());
        $this->notifier->notify($event);
        
        // Update statistics for foul events
        if ($data['type'] === 'foul') {
            if (!isset($data['match_id']) || !isset($data['team_id'])) {
                throw new \InvalidArgumentException('match_id and team_id are required for foul events');
            }
            
            $this->statisticsManager->updateTeamStatistics(
                $data['match_id'],
                $data['team_id'],
                'fouls'
            );
        }

        // Update statistics for goal events
        if ($data['type'] === 'goal') {
            if (!isset($data['match_id']) || !isset($data['team_id'])) {
                throw new \InvalidArgumentException('match_id and team_id are required for goal events');
            }
            
            $this->statisticsManager->updateTeamStatistics(
                $data['match_id'],
                $data['team_id'],
                'goals'
            );
        }
        
        
        return [
            'status' => 'success',
            'message' => 'Event saved successfully',
            'event' => $event
        ];
    }
}
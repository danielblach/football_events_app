<?php

namespace App;

use App\Event\EventNotifier;
use App\Event\Event;

class LogNotifier implements EventNotifier
{
    private string $filePath;
    
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        
        $directory = dirname($filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    public function notify(Event $event): void
    {
        file_put_contents(
            $this->filePath,
            json_encode($event->toArray()) . PHP_EOL,
            FILE_APPEND
        );
    }
}

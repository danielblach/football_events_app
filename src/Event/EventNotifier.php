<?php

namespace App\Event;

interface EventNotifier
{
    public function notify(Event $event): void;
}

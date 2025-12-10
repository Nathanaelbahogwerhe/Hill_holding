<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class DashboardUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $type;
    public array $payload;

    public function __construct(string $type, array $payload = [])
    {
        $this->type = $type;       // ex: 'employee','department','payroll','message'
        $this->payload = $payload;
    }

    public function broadcastOn(): Channel
    {
        // channel public simple "dashboard"
        return new Channel('dashboard');
    }

    public function broadcastWith(): array
    {
        return [
            'type' => $this->type,
            'payload' => $this->payload,
        ];
    }
}








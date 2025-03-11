<?php

namespace App\Events\Admin\Export;

use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExportBegin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct() {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'admin.export.begin';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => 'Export has been started. It can take a few minutes.',
            'type' => 'info',
        ];
    }
}

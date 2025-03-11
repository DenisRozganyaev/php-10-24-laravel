<?php

namespace App\Events\Admin\Export;

use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DownloadLink implements ShouldBroadcast
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(protected string $link) {}

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
        return 'admin.export.download';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => "Your CSV file is ready. Download it here: <a href='$this->link' class='link-dark'>Download</a>",
            'type' => 'success',
        ];
    }
}

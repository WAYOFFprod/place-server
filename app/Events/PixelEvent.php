<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PixelEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $x;
    public $y;
    public $color;
    public $canvas;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($x, $y, $color, $canvas)
    {
        $this->x = $x;
        $this->y = $y;
        $this->color = $color;
        $this->canvas = $canvas;
    }

    public function broadcastWith () {
        return [
            'x' => $this->x,
            'y' => $this->y,
            'color' => $this->color,
            'on' => now()->toDateTimeString()
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('pixel-change-'.$this->canvas);
    }
}

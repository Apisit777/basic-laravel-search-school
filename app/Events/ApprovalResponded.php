<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApprovalResponded implements ShouldBroadcastNow
{
    use SerializesModels;

    public string $brand;
    public string $product;
    public string $createdBy;
    public string $createdAt;

    public function __construct(string $brand, string $product, string $createdBy)
    {
        $this->brand     = $brand;
        $this->product   = $product;
        $this->createdBy = $createdBy;
        $this->createdAt = now()->toDateTimeString();
    }

    public function broadcastOn()
    {
        return new PrivateChannel('account.global');
    }

    public function broadcastAs()
    {
        return 'account.approval.requested';
    }

    public function broadcastWith(): array
    {
        return [
            'brand'      => $this->brand,
            'product'    => $this->product,
            'created_by' => $this->createdBy,
            'created_at' => $this->createdAt,
        ];
    }
}

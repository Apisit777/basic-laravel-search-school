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

class AccountApprovalRequested implements ShouldBroadcastNow
{
    use SerializesModels;

    public string $brand;
    public string $product;
    public string $createdBy;
    public string $createdAt;
    public string $activeDate;

    public function __construct(string $brand, string $product, string $createdBy, string $activeDate = '')
    {
        $this->brand      = $brand;
        $this->product    = $product;   // 👈 ต้องมีบรรทัดนี้
        $this->createdBy  = $createdBy;
        $this->createdAt  = now()->toDateTimeString();
        $this->activeDate = $activeDate;

        \Log::info('✅ AccountApprovalRequested::__construct', [
            'brand'   => $this->brand,
            'product' => $this->product,
        ]);
    }

    public function broadcastOn()
    {
        // แยก channel ตาม brand -> account.BRAND
        // return new PrivateChannel("account.{$this->brand}");

        // ชั่วคราวให้ global ไปก่อน เพื่อเทสให้ติดก่อน
        return new PrivateChannel('account.global');

    }

    public function broadcastAs()
    {
        // ให้สอดคล้องกับเมนู Account
        return 'account.approval.requested';
    }

    public function broadcastWith(): array
    {
        \Log::info("📡 SEND TO REVERB", [
            'brand'   => $this->brand,
            'product' => $this->product,
        ]);

        return [
            'brand'       => $this->brand,
            'product'     => $this->product,
            'created_by'  => $this->createdBy,
            'created_at'  => $this->createdAt,
            'active_date' => $this->activeDate,
        ];
    }

    public function broadcastConnection(): ?string
    {
        return 'reverb';  // 👈 ให้ชัดเลยว่าใช้ connection reverb
    }
}

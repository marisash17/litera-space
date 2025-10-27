<?php
namespace App\Listeners;

use App\Events\OrderCreated;
use App\Services\WhatsappService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWhatsappNotification implements ShouldQueue
{
    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        $phone = $order->member->no_hp;

        $message = "Halo {$order->member->nama}, pesanan #{$order->id} berhasil! Total: Rp{$order->total}. Terima kasih sudah berbelanja.";

        $wa = new WhatsappService();
        $wa->sendMessage($phone, $message);
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class SuccessfulOrderEmail extends Notification
{
    use Queueable;

    public function __construct(public int $orderId)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $items = DB::table('chi_tiet_don_hang')
            ->where('ma_don_hang', $this->orderId)
            ->join('san_pham', 'chi_tiet_don_hang.laptop_id', '=', 'san_pham.id')
            ->select('san_pham.tieu_de', 'chi_tiet_don_hang.so_luong', 'chi_tiet_don_hang.don_gia')
            ->get();

        $tableData = $items->map(function ($item) {
            return [
                'Sản phẩm' => $item->tieu_de,
                'Số lượng' => $item->so_luong,
                'Đơn giá' => number_format($item->don_gia, 0, '.', ',') . ' VND'
            ];
        })->toArray();

        $totalPrice = $items->sum(function ($item) {
            return $item->so_luong * $item->don_gia;
        });

        return (new MailMessage)
            ->markdown('emails.successful-order', [
                'orderId' => $this->orderId,
                'items' => $items,
                'totalPrice' => $totalPrice,
                'notifiable' => $notifiable
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

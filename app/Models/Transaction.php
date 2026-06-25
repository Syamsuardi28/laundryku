<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_number',
        'user_id',
        'customer_id',
        'service_id',
        'berat',
        'total_harga',
        'status',
        'tanggal_masuk',
        'tanggal_estimasi',
        'tanggal_diambil',
        'status_pembayaran',
    ];

    protected function casts(): array
    {
        return [
            'berat' => 'decimal:2',
            'tanggal_masuk' => 'datetime',
            'tanggal_estimasi' => 'datetime',
            'tanggal_diambil' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV-'.now()->format('Ymd');
        $last = static::where('invoice_number', 'like', $prefix.'%')
            ->orderByDesc('id')
            ->value('invoice_number');

        $sequence = $last ? ((int) substr($last, -4)) + 1 : 1;

        return $prefix.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }

    public static function statusLabel(string $status): string
    {
        return $status;
    }

    public static function statusBadgeClass(string $status): string
    {
        return match ($status) {
            'Diproses' => 'bg-warning-100 text-warning-600 dark:bg-warning-500/20 dark:text-warning-500',
            'Siap Diambil' => 'bg-primary-100 text-primary dark:bg-primary/20 dark:text-primary-100',
            'Selesai' => 'bg-success-100 text-success-600 dark:bg-success-500/20 dark:text-success-500',
            default => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
        };
    }
}

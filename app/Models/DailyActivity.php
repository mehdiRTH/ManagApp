<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class DailyActivity extends Model
{
    use HasFactory,hasUuids;

    protected $guarded=[];

    protected $casts=[
        'in_out'=>'array'
    ];

    protected $filterable=[
        'start_date',
        'end_date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterInOut() : array | null
    {
        $appliedFilters = request('filter', []);
        $start = $appliedFilters['start_date'] ?? null;
        $end = $appliedFilters['end_date'] ?? null;

        if ($start && $end) {
            return array_filter(
                $this->in_out,
                fn($value, $key) => $key >= $start && $key <= $end,
                ARRAY_FILTER_USE_BOTH
            );
        }

        return $this->in_out;
    }
}

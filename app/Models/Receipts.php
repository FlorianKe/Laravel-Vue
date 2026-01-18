<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([UserScope::class])]
class Receipts extends Model
{
    use HasUlids;

    protected $fillable = [
        'user_id',
        'merchant',
        'date',
        'total',
        'currency',
        'vat',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'total' => 'decimal:2',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

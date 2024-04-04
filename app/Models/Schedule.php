<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    const OPEN = 'open';
    const CONCLUDED = 'concluded';

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'status',
        'title',
        'type',
        'description',
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

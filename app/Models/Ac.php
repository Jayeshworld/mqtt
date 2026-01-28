<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ac extends Model
{
    use HasFactory;

    protected $fillable = [
        'maac_id',
        'name',
        'location',
        'capacity',
        'status',
        'remarks',
        'user_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Accessor for status badge
    public function getStatusBadgeAttribute()
    {
        $statusColors = [
            'active' => 'success',
            'inactive' => 'secondary',
            'maintenance' => 'warning',
            'out_of_order' => 'danger'
        ];

        return [
            'color' => $statusColors[$this->status] ?? 'secondary',
            'text' => ucwords(str_replace('_', ' ', $this->status))
        ];
    }

    // Scope for filtering by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope for searching
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('maac_id', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }
}
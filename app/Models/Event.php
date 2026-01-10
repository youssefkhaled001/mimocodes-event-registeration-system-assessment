<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Event Model
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $date_time
 * @property string $location
 * @property int $capacity
 * @property float $price
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Registeration> $registrations
 */
class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'date_time',
        'location',
        'capacity',
        'price',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_time' => 'datetime',
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get all registrations for this event.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registeration::class);
    }

    // Get Count of confirmed registrations
    public function confirmedRegistrationsCountAttribute(): int
    {
        return $this->registrations()->where('status', 'confirmed')->count();
    }

    // Get Count of waitlisted registrations
    public function waitlistedRegistrationsCountAttribute(): int
    {
        return $this->registrations()->where('status', 'waitlisted')->count();
    }

    public function firstWaitlisted(): ?Registeration
    {
        return $this->registrations()->where('status', 'waitlisted')->first();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attendee extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
    ];

    /**
     * Get all registrations for this attendee.
     * 
     * @return HasMany
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registeration::class);
    }

    // Get all events this attendee is registered for
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'registerations')
                    ->withPivot('registration_date', 'status', 'payment_status')
                    ->withTimestamps();
    }
}

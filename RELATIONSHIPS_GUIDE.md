# Laravel Eloquent Relationships Guide

## Overview

This guide explains how relationships are defined in your Event Registration System using Laravel's Eloquent ORM.

## Database Structure

Your system has three main tables:

1. **events** - Stores event information
2. **attendees** - Stores attendee/participant information
3. **registerations** - Junction/pivot table connecting events and attendees

## Relationship Types

### 1. One-to-Many (hasMany)

A parent model has multiple child records.

**Example:** One Event has many Registrations

```php
// In Event model
public function registrations(): HasMany
{
    return $this->hasMany(Registeration::class);
}
```

**Usage:**

```php
$event = Event::find(1);
$registrations = $event->registrations; // Get all registrations for this event
```

### 2. Belongs To (belongsTo)

A child model belongs to a parent model (inverse of hasMany).

**Example:** A Registration belongs to an Event

```php
// In Registeration model
public function event(): BelongsTo
{
    return $this->belongsTo(Event::class);
}
```

**Usage:**

```php
$registration = Registeration::find(1);
$event = $registration->event; // Get the event for this registration
```

### 3. Many-to-Many (belongsToMany)

Two models are connected through a pivot/junction table.

**Example:** Events and Attendees (through registrations)

```php
// In Event model
public function attendees(): BelongsToMany
{
    return $this->belongsToMany(Attendee::class, 'registerations')
                ->withPivot('registration_date', 'status', 'payment_status')
                ->withTimestamps();
}

// In Attendee model
public function events(): BelongsToMany
{
    return $this->belongsToMany(Event::class, 'registerations')
                ->withPivot('registration_date', 'status', 'payment_status')
                ->withTimestamps();
}
```

**Usage:**

```php
$event = Event::find(1);
$attendees = $event->attendees; // Get all attendees for this event

// Access pivot data
foreach ($attendees as $attendee) {
    echo $attendee->pivot->status; // confirmed, waitlisted, cancelled
    echo $attendee->pivot->payment_status; // pending, paid, refunded
}
```

## Complete Relationship Map

```
Event Model:
├── registrations() → hasMany(Registeration)
└── attendees() → belongsToMany(Attendee) through 'registerations'

Attendee Model:
├── registrations() → hasMany(Registeration)
└── events() → belongsToMany(Event) through 'registerations'

Registeration Model:
├── event() → belongsTo(Event)
└── attendee() → belongsTo(Attendee)
```

## Practical Usage Examples

### 1. Get all attendees for an event

```php
$event = Event::find(1);
$attendees = $event->attendees;
```

### 2. Get all events an attendee is registered for

```php
$attendee = Attendee::find(1);
$events = $attendee->events;
```

### 3. Create a new registration

```php
$event = Event::find(1);
$attendee = Attendee::find(1);

// Method 1: Using the Registration model directly
Registeration::create([
    'event_id' => $event->id,
    'attendee_id' => $attendee->id,
    'registration_date' => now(),
    'status' => 'confirmed',
    'payment_status' => 'pending',
]);

// Method 2: Using the relationship
$event->attendees()->attach($attendee->id, [
    'registration_date' => now(),
    'status' => 'confirmed',
    'payment_status' => 'pending',
]);
```

### 4. Get registrations with related data (Eager Loading)

```php
// Load event with all registrations and their attendees
$event = Event::with('registrations.attendee')->find(1);

foreach ($event->registrations as $registration) {
    echo $registration->attendee->name;
    echo $registration->status;
}
```

### 5. Query through relationships

```php
// Get all confirmed registrations for an event
$event = Event::find(1);
$confirmedRegistrations = $event->registrations()
    ->where('status', 'confirmed')
    ->get();

// Get all paid attendees for an event
$paidAttendees = $event->attendees()
    ->wherePivot('payment_status', 'paid')
    ->get();
```

### 6. Count related records

```php
$event = Event::find(1);
$totalRegistrations = $event->registrations()->count();
$confirmedCount = $event->registrations()->where('status', 'confirmed')->count();
```

### 7. Check if attendee is registered for an event

```php
$event = Event::find(1);
$attendee = Attendee::find(1);

$isRegistered = $event->attendees()->where('attendee_id', $attendee->id)->exists();
```

## Important Notes

### Mass Assignment Protection

All models now have `$fillable` arrays defined to protect against mass assignment vulnerabilities:

```php
protected $fillable = ['field1', 'field2', ...];
```

### Type Casting

Models automatically cast certain fields to proper types:

-   `date_time` → Carbon datetime object
-   `registration_date` → Carbon datetime object
-   `price` → Decimal with 2 places

### withPivot() and withTimestamps()

When using many-to-many relationships:

-   `withPivot()` - Access additional columns from the pivot table
-   `withTimestamps()` - Include created_at and updated_at from pivot table

## Best Practices

1. **Use Eager Loading** to avoid N+1 query problems:

    ```php
    // Bad - N+1 queries
    $events = Event::all();
    foreach ($events as $event) {
        echo $event->attendees->count(); // Separate query for each event
    }

    // Good - 2 queries total
    $events = Event::withCount('attendees')->get();
    foreach ($events as $event) {
        echo $event->attendees_count;
    }
    ```

2. **Use relationship methods for queries**:

    ```php
    // Instead of
    Registeration::where('event_id', $eventId)->get();

    // Use
    $event->registrations;
    ```

3. **Define inverse relationships** for bidirectional access:
    - If Event hasMany Registrations, then Registration belongsTo Event

## Additional Resources

-   [Laravel Eloquent Relationships Documentation](https://laravel.com/docs/eloquent-relationships)
-   [Laravel Query Builder](https://laravel.com/docs/queries)
-   [Eager Loading](https://laravel.com/docs/eloquent-relationships#eager-loading)

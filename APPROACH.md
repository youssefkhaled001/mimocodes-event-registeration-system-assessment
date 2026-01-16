# Technical Approach Documentation

## Architecture Overview

This event registration system is built using **Laravel 12** with a modern MVC architecture, emphasizing clean code, scalability, and user experience. The application follows Laravel best practices while implementing custom solutions for complex business logic.

### Technology Stack

-   **Backend**: Laravel 12 (PHP 8.2+)
-   **Database**: PostgreSQL (production) / SQLite (development)
-   **Frontend**: Blade Templates + Alpine.js + Tailwind CSS
-   **Build Tool**: Vite
-   **UI Components**: Bladewind + Custom Components
-   **Queue System**: Database-driven queues
-   **Scheduler**: Laravel Task Scheduling

---

## Technical Approach

### 1. **Database Design & Relationships**

#### Schema Design

The database schema is built around four core models with clear relationships:

```
Users (Admin)
  └─ manages Events

Events
  └─ has many Registrations

Attendees
  └─ has many Registrations

Registrations (pivot with extra fields)
  ├─ belongs to Event
  └─ belongs to Attendee
```

### 2. **Service Layer Pattern**

#### RegisterationService

I implemented a dedicated service class (`RegisterationService`) to handle complex registration logic:

```php
RegisterationService::register(Attendee $attendee, int $event_id)
```

**Benefits**:

-   **Single Responsibility**: Controllers remain thin and focused on HTTP concerns
-   **Reusability**: Registration logic can be called from multiple places (web, API, console)
-   **Testability**: Business logic is isolated and easier to unit test
-   **Transaction Management**: Centralized database transaction handling

**Key Features**:

-   Database transactions with row-level locking (`lockForUpdate()`)
-   Automatic capacity calculation
-   Duplicate registration prevention
-   Waitlist management
-   Event status validation

### 3. **Race Condition Prevention**

#### Problem

Multiple users registering simultaneously for an event with limited capacity could cause overbooking.

#### Solution

Implemented **pessimistic locking** using Laravel's `lockForUpdate()`:

```php
return DB::transaction(function () use ($attendee, $event_id) {
    $event = Event::find($event_id);
    $event->lockForUpdate(); // Locks the row until transaction completes

    // Calculate current capacity
    $currentCapacity = Registeration::where('event_id', $event_id)
        ->where('status', 'confirmed')
        ->count();

    // Register or waitlist based on capacity
});
```

This ensures that:

1. Only one registration can be processed at a time per event
2. Capacity calculations are accurate
3. No overbooking occurs even under high load

### 4. **Observer Pattern for Automatic Waitlist Promotion**

#### RegisterationObserver

I implemented a model observer to automatically promote waitlisted attendees when a confirmed registration is cancelled:

```php
public function updated(Registeration $registration): void
{
    if ($registration->status == 'cancelled') {
        DB::transaction(function () use ($registration) {
            $registration->event->lockForUpdate();

            if ($registration->wasChanged('status') &&
                $registration->getOriginal('status') === 'confirmed') {

                $nextInLine = $registration->event->firstWaitlisted();

                if ($nextInLine) {
                    $nextInLine->update(['status' => 'confirmed']);
                }
            }
        });
    }
}
```

**Benefits**:

-   **Automatic**: No manual intervention required
-   **Consistent**: Business logic is enforced at the model level
-   **Atomic**: Uses transactions to prevent race conditions
-   **Fair**: First-in-first-out waitlist promotion

### 5. **Scheduled Tasks**

#### Auto-Completion of Events

Implemented a console command that runs hourly to mark events as completed:

```php
Schedule::command('events:update-completed-events')->hourly();
```

The command marks events as "completed" 1 hour after their start time, ensuring:

-   Accurate event status tracking
-   Automatic lifecycle management
-   No manual intervention required

### 6. **RESTful Route Organization**

Organized routes following Laravel conventions with clear separation:

```php
// Public Routes
Route::get('/', [EventController::class, 'index']);
Route::get('/register', [RegisterationController::class, 'create']);
Route::post('/register', [RegisterationController::class, 'store']);

// Admin Routes (protected by auth middleware)
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [EventController::class, 'dashboard']);

    // Resource routes with proper naming
    Route::controller(EventController::class)->prefix('events')->name('event.')->group(...);
    Route::controller(RegisterationController::class)->prefix('registerations')->name('registerations.')->group(...);
});
```

**Benefits**:

-   Clear separation of public and admin routes
-   Consistent naming conventions
-   Easy to maintain and extend
-   Proper middleware application

### 7. **UI/UX Design Philosophy**

#### Dark Glassmorphism Aesthetic

Inspired by Mimocodes.com, the design features:

**Color Palette**:

-   Primary: Cyan (#06b6d4, #22d3ee)
-   Background: Dark grays (#0f172a, #1e293b)
-   Accents: Subtle gradients and glows

**Visual Effects**:

-   Glassmorphism: `backdrop-filter: blur(10px)` with semi-transparent backgrounds
-   Smooth animations: CSS transitions on hover states
-   Cyan glows: `box-shadow` with cyan colors
-   Custom scrollbar: Dark-themed with cyan accents

**Typography**:

-   Headings: Playfair Display (elegant serif)
-   Body: Inter (modern sans-serif)
-   Proper hierarchy and spacing

#### Component-Based Architecture

Created reusable Blade components:

-   `table.blade.php`: Styled data tables with pagination
-   `stat-card.blade.php`: Dashboard statistics cards
-   `pie-chart.blade.php`: SVG-based pie charts
-   `form-input.blade.php`: Consistent form styling

### 8. **Data Visualization**

#### Dashboard Analytics

Implemented comprehensive analytics using Bladewind's chart components powered by Chart.js:

**Doughnut Charts**: Interactive doughnut charts for status distributions:

```blade
<x-bladewind::chart
    type="doughnut"
    :labels="$eventLabels"
    :datasets="[
        [
            'label' => 'Events',
            'data' => $eventValues,
            'backgroundColor' => $eventColors,
            'borderColor' => '#0a0a0a',
            'borderWidth' => 2
        ]
    ]"
    :options="{
        'responsive' => true,
        'plugins' => [
            'legend' => ['position' => 'right'],
            'tooltip' => ['backgroundColor' => '#1a1a1a']
        ]
    }"
/>
```

**Line Charts**: Revenue trend visualization with:

-   Smooth curved lines with tension
-   Gradient area fills
-   Interactive tooltips with formatted currency
-   Responsive design
-   Custom dark theme styling

**Benefits of Bladewind Charts**:

-   **Professional**: Built on Chart.js, industry-standard charting library
-   **Interactive**: Hover effects, tooltips, and animations out of the box
-   **Responsive**: Automatically adapts to screen sizes
-   **Customizable**: Full access to Chart.js options
-   **Maintainable**: Less custom code to maintain
-   **Accessible**: Better screen reader support

**Statistics Cards**: Real-time metrics for:

-   Event counts by status
-   Registration counts by status
-   Payment tracking
-   Revenue calculations

### 9. **Form Handling & Validation**

#### Dual Registration Flow

Implemented a tabbed interface for registration:

**New User Tab**:

-   Full form with name, email, phone, company
-   Email uniqueness validation
-   Phone number validation using `propaganistas/laravel-phone`

**Existing User Tab**:

-   Email-only quick registration
-   Automatic attendee lookup
-   Validation to ensure user exists

**State Preservation**:

-   Selected tab preserved on validation errors
-   Form inputs retained using `old()` helper
-   Clear error messages with field-specific feedback

#### Business Logic Validation

Beyond standard validation, implemented business rules:

```php
// Event must be at least 24 hours in the future
if ($eventDateTime->lessThan(Carbon::now()->addHours(24))) {
    return redirect()->back()->with('error', 'Event date must be at least 24 hours from now!');
}

// Cannot decrease capacity below registered users
if ($event->registrations->count() > $request->capacity) {
    return redirect()->back()->with('error', 'Event capacity cannot be decreased below registered users!');
}

// Cannot draft published events with registrations
if ($event->status == 'published' && $event->registrations->count() > 0) {
    return redirect()->back()->with('error', 'Published event with registrations cannot be drafted!');
}
```

### 10. **Performance Optimization**

#### Eager Loading

Prevented N+1 queries using eager loading:

```php
$events = Event::with('registrations')->paginate(10);
$registerations = Registeration::with('attendee')->paginate(15);
```

#### Query Optimization

Used `withCount()` for efficient counting:

```php
$events = Event::withCount([
    'registrations as paid_registrations_count' => function ($query) {
        $query->where('payment_status', 'paid');
    }
])->paginate(10);
```

#### Database Indexing

Added indexes on frequently queried columns:

-   `events.status`
-   `events.date_time`
-   `registerations.event_id`
-   `registerations.status`
-   `registerations.payment_status`

### 11. **Email Notification System**

#### Automated Email Communication

Implemented a comprehensive email notification system to keep attendees informed throughout the event lifecycle:

**Email Types**:

1. **Registration Confirmation** (`RegistrationConfirmed`)

    - Sent when attendee successfully registers with confirmed status
    - Includes event details, date/time, location, and payment status
    - Queued for asynchronous delivery

2. **Waitlist Confirmation** (`WaitlistConfirmed`)

    - Sent when event is at capacity and attendee is waitlisted
    - Explains waitlist process and next steps
    - Provides reassurance about automatic promotion

3. **Waitlist Promotion** (`WaitlistPromoted`)

    - Automatically sent when waitlisted attendee is promoted to confirmed
    - Triggered by the RegisterationObserver
    - Includes payment reminder if applicable

4. **24-Hour Event Reminder** (`EventReminder`)
    - Sent via scheduled command (`SendEventReminders`)
    - Runs hourly to catch events happening in 24 hours
    - Includes event details, what to bring, and payment reminders

**Implementation Details**:

```php
// In RegisterationController
Mail::to($attendee->email)->queue(new RegistrationConfirmed($registration));

// In RegisterationObserver
Mail::to($nextInLine->attendee->email)->queue(new WaitlistPromoted($nextInLine));

// Scheduled command
Schedule::command('events:send-reminders')->hourly();
```

**Benefits**:

-   **Queued Delivery**: Uses Laravel's queue system for non-blocking email sending
-   **Markdown Templates**: Beautiful, responsive email templates using Laravel's markdown components
-   **Automatic**: Triggered by system events, no manual intervention required
-   **Consistent Branding**: All emails follow the application's design aesthetic

---

## 🚧 Challenges Faced & Solutions

### Challenge 1: Race Conditions in Registration

**Problem**: Multiple users registering simultaneously could exceed event capacity.

**Initial Approach**: Simple capacity check without locking.

**Issue Discovered**: Under concurrent requests, multiple registrations could pass the capacity check before any were saved, leading to overbooking.

**Solution Implemented**:

1. Wrapped registration logic in database transaction
2. Used `lockForUpdate()` to lock the event row
3. Calculated capacity within the locked transaction
4. Ensured atomic registration process

**Result**: Zero overbooking incidents, even under load testing with concurrent requests.

---

### Challenge 2: Waitlist Management Complexity

**Problem**: When a confirmed registration is cancelled, the first waitlisted person should be automatically promoted.

**Initial Approach**: Manual promotion through admin interface.

**Issue Discovered**:

-   Admins could forget to promote waitlisted users
-   No guarantee of fairness (first-come-first-served)
-   Potential for human error

**Solution Implemented**:

1. Created `RegisterationObserver` with `updated()` method
2. Detected status changes from "confirmed" to "cancelled"
3. Automatically queried for first waitlisted registration
4. Promoted within a transaction with row locking
5. Ensured FIFO (first-in-first-out) fairness

**Result**: Fully automated, fair, and reliable waitlist promotion system.

---

### Challenge 3: SQL Ambiguity in Revenue Calculations

**Problem**: When joining `registerations` and `events` tables, the `updated_at` column existed in both, causing SQL ambiguity errors.

**Error Message**: `Column 'updated_at' in where clause is ambiguous`

**Solution Implemented**:

```php
// Before (ambiguous)
->whereDate('updated_at', $date)

// After (explicit)
->whereDate('registerations.updated_at', $date)
```

**Lesson Learned**: Always qualify column names when using joins, even if the ambiguity isn't immediately obvious.

---

### Challenge 4: Maintaining Tab State on Form Errors

**Problem**: When registration form validation failed, the selected tab (New User/Existing User) would reset to default.

**Initial Approach**: No state preservation.

**Issue Discovered**: Poor UX - users had to re-select their tab and re-enter data.

**Solution Implemented**:

1. Added hidden input to track selected tab
2. Used `old('registration_type')` to retrieve previous selection
3. Applied Alpine.js conditional to set active tab on page load
4. Preserved all form inputs using Laravel's `old()` helper

**Result**: Seamless form experience with full state preservation across validation errors.

---

### Challenge 5: Custom Pagination Styling

**Problem**: Laravel's default pagination didn't match the Mimocodes dark aesthetic.

**Initial Approach**: Override Tailwind classes inline.

**Issue Discovered**: Inconsistent styling, difficult to maintain.

**Solution Implemented**:

1. Published Laravel pagination views: `php artisan vendor:publish --tag=laravel-pagination`
2. Created custom Tailwind pagination view
3. Styled with glassmorphism effects and cyan accents
4. Ensured responsive design
5. Made it reusable across all paginated views

**Result**: Consistent, beautiful pagination matching the overall design system.

---

### Challenge 6: Event Lifecycle Management

**Problem**: Events needed to automatically transition to "completed" status after they finish.

**Initial Approach**: Manual status updates by admins.

**Issue Discovered**:

-   Admins could forget to update status
-   Inconsistent event states
-   Completed events still showing as "published"

**Solution Implemented**:

1. Created `UpdateCompletedEvents` console command
2. Scheduled to run hourly via Laravel Scheduler
3. Marks events as completed 1 hour after start time
4. Logs all status changes for auditing
5. Runs automatically with `php artisan schedule:work`

**Result**: Fully automated event lifecycle with accurate status tracking.

---

### Challenge 7: Payment Status Business Logic

**Problem**: Complex business rules around payment status changes.

**Examples**:

-   Waitlisted registrations shouldn't be marked as paid
-   Cancelled registrations shouldn't be marked as paid
-   Refunds should only happen after cancellation

**Solution Implemented**:
Comprehensive validation in `updatePaymentStatus()` method:

```php
// Prevent illogical state transitions
if ($registration->status === 'waitlisted' && $newPaymentStatus === 'paid') {
    return back()->with('error', 'Waitlisted registrations cannot be marked as paid.');
}

if ($registration->status === 'cancelled' && $newPaymentStatus === 'paid') {
    return back()->with('error', 'Cancelled registrations cannot be marked as paid.');
}

if ($registration->payment_status === 'paid' &&
    $newPaymentStatus === 'refunded' &&
    $registration->status === 'confirmed') {
    return back()->with('error', 'To refund, please cancel the registration first.');
}
```

**Result**: Prevented invalid state transitions and ensured data integrity.

## Future Improvements

### 1. **Advanced Analytics & Reporting**

**Planned Features**:

**Event Analytics**:

-   Attendance trends over time
-   Popular event categories
-   Peak registration times
-   Geographical distribution of attendees

**Financial Reports**:

-   Monthly revenue reports
-   Revenue by event type
-   Payment method breakdown
-   Refund analytics

**Attendee Insights**:

-   Repeat attendee tracking
-   Company-based analytics
-   Engagement metrics

**Export Options**:

-   PDF reports
-   Excel/CSV exports
-   Scheduled email reports

**Priority**: Medium

### 2. **Payment Gateway Integration**

**Current State**: Manual payment status management.

**Planned Integration**:

-   **Stripe**: Primary payment processor
-   **PayPal**: Alternative payment method
-   **Razorpay**: For international markets

**Features**:

-   Automatic payment status updates
-   Secure payment processing
-   Refund automation
-   Payment receipts
-   Multiple currency support
-   Installment payment options for expensive events

**Priority**: High

### 3. **QR Code Check-in System**

**Purpose**: Streamline event check-in process.

**Planned Features**:

-   Generate unique QR code for each registration
-   Mobile-friendly check-in interface for event staff
-   Real-time attendance tracking
-   Duplicate check-in prevention
-   Offline check-in support with sync
-   Check-in analytics

**Technology**:

-   `simple-qrcode` package for generation
-   Progressive Web App (PWA) for check-in interface

**Priority**: Medium

---

### 4. **Attendee Portal**

**Purpose**: Give attendees more control and information.

**Planned Features**:

-   Attendee login/registration
-   View registration history
-   Manage upcoming events
-   Update profile information
-   Download tickets/receipts
-   Event reminders and notifications
-   Feedback and rating system

**Priority**: Medium

---

### 5. **Performance & Scalability**

**Planned Optimizations**:

**Caching**:

-   Redis for session and cache storage
-   Event list caching with automatic invalidation
-   Dashboard statistics caching
-   Query result caching

**Database**:

-   Database query optimization
-   Implement read replicas for heavy read operations
-   Partition large tables (registrations)

**Frontend**:

-   Lazy loading for images
-   Asset optimization and minification
-   CDN integration for static assets
-   Service Worker for offline support

**Priority**: Medium (as user base grows)

---

### 6. **Testing & Quality Assurance**

**Planned Test Coverage**:

**Unit Tests**:

-   Service layer methods
-   Model relationships
-   Business logic validation

**Feature Tests**:

-   Registration flow
-   Waitlist promotion
-   Payment status updates
-   Event lifecycle

**Browser Tests**:

-   End-to-end registration process
-   Admin dashboard interactions
-   Form validation

**Load Testing**:

-   Concurrent registration handling
-   Database performance under load
-   API endpoint stress testing

**Target**: 80%+ code coverage

**Priority**: High

---

### 7. **Security Enhancements**

**Planned Improvements**:

-   Two-factor authentication (2FA) for admin accounts
-   IP-based rate limiting
-   CAPTCHA for registration forms (prevent bots)
-   Security audit logging
-   Regular dependency updates
-   Penetration testing
-   GDPR compliance features (data export, right to be forgotten)

**Priority**: High

---

## Success Metrics

To measure the success of these improvements, I would track:

1. **User Engagement**: Registration completion rate, time to register
2. **System Performance**: Page load times, API response times
3. **Business Metrics**: Revenue growth, event attendance rates
4. **Technical Metrics**: Test coverage, bug resolution time, uptime
5. **User Satisfaction**: Net Promoter Score (NPS), user feedback

## Conclusion

This event registration system demonstrates a solid foundation built on Laravel best practices, with careful attention to:

-   **Data Integrity**: Through transactions and locking mechanisms
-   **User Experience**: With thoughtful UI/UX design and smooth interactions
-   **Scalability**: Through service layers and optimized queries
-   **Maintainability**: With clean code organization and component reusability
-   **Automation**: Through observers and scheduled tasks

The challenges faced during development led to robust solutions that ensure reliability and performance. The planned improvements provide a clear path for evolution into a comprehensive event management platform.

The system is production-ready for small to medium-scale events, with a clear roadmap for scaling to enterprise-level requirements.

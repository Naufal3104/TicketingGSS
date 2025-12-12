# Sprint 2: Ticketing Core & FCFS Allocation (Backend Log)

**Date**: 2025-12-12
**Status**: Backend & Frontend Implementation Completed (Point 1 & 2)

## Summary of Changes

### 1. Backend Implementation (Point 1)

Implemented the core backend logic for managing Visit Tickets and assigning them to Technical Support (TS) using a "First Come First Serve" (FCFS) mechanism with race condition protection.

#### Ticket Logic (PJV-001)

-   **Controller**: `TicketController`
-   **Method**: `store`
-   **Features**:
    -   Generates unique Ticket ID: `T-YmdHis-Rand`.
    -   Validates inputs and creates ticket defined in `visit_tickets`.
    -   Wrapped in DB Transaction.

#### FCFS Allocation Logic (PJV-002)

-   **Controller**: `AssignmentController`
-   **Method**: `takeJob`
-   **Features**:
    -   **Locking**: Uses `lockForUpdate()` to prevent race conditions.
    -   **Clash Check**: Prevents TS from taking multiple active jobs.
    -   **Action**: Creates `VisitAssignment` and updates Ticket status to `ASSIGNED`.

### 2. Frontend Implementation (Point 2)

Implemented the user interfaces for CS to create tickets and for TS to view/take jobs on mobile.

#### CS View - Create Ticket

-   **Route**: `GET /tickets/create`
-   **File**: `resources/views/operational/tickets/create.blade.php`
-   **Features**: Form to input Customer, Issue, Address, Priority, and Quota. Redirects with Success Message containing Ticket ID.

#### TS View - Mobile Dashboard

-   **Route**: `GET /assignments/open`
-   **File**: `resources/views/operational/assignments/index.blade.php`
-   **Features**:
    -   **Tab 1 (Open Pool)**: Cards displaying available `OPEN` tickets. "Ambil Job" button triggers AJAX request to `takeJob`.
    -   **Tab 2 (My Jobs)**: Cards displaying active assignments for the logged-in TS.
    -   **Interaction**: AJAX handling with confirmation alert and page reload on success.

## Verification Walkthrough

1.  **CS: Create Ticket**

    -   Login as CS/Admin.
    -   Navigate to `/tickets/create`.
    -   Fill form (Select Customer, Issue: "WiFi Pelan", Priority: "HIGH").
    -   Submit -> "Ticket created successfully! ID: T-2025..."

2.  **TS: Open Job Pool**

    -   Login as TS User.
    -   Navigate to `/assignments/open`.
    -   View the "Open Pool" tab. You should see the ticket created above.

3.  **TS: Take Job**

    -   Click "AMBIL JOB" on the ticket card.
    -   Confirm dialog "Are you sure?".
    -   Success Alert "Job taken successfully!".
    -   Page reloads -> Ticket disappears from Open Pool -> Appears in "My Jobs" tab.

4.  **Verification of Constraints**
    -   Try to take another job while "My Jobs" has a PENDING/ON_SITE status ticket -> Error Alert "You cannot take a new job...".

## Files Modified/Created

-   `app/Http/Controllers/Operational/TicketController.php` (Updated view logic)
-   `app/Http/Controllers/Operational/AssignmentController.php` (Updated view logic)
-   `resources/views/operational/tickets/create.blade.php` (New)
-   `resources/views/operational/assignments/index.blade.php` (New)
-   `routes/web.php`

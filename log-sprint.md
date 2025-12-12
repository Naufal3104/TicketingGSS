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

# Sprint 3: Eksekusi Visitasi & Emergency Handling

**Date**: 2025-12-12
**Status**: Completed (Backend & Frontend)

## Summary of Changes

### 1. Backend & Database (Point 1)

Implemented the operational logic for Visitation (Attendance, Documents) and Emergency Handling.

#### Database & Models

-   **Attandance**: Added `check_in/out` logic with Geolocation.
-   **Documents**: Configured uploads for `visit_documents`.
-   **Scheduling**: Added `visit_date` and `visit_time` to `VisitTicket`.

#### Controllers

-   `AttendanceController`: Handles Check-in/out APIs.
-   `DocumentController`: Handles File Uploads.
-   `MonitoringController`: Aggregates data for CS Dashboard.

#### Automation

-   **Emergency Cron**: Scheduled task in `routes/console.php` scanning for Late Check-ins.

### 2. Frontend Implementation (Point 2)

#### TS View - Visit Detail

-   **Route**: `GET /assignments/{ticket}`
-   **File**: `resources/views/operational/assignments/show.blade.php`
-   **Features**:
    -   **Geolocation Check-in**: JS captures coordinates -> call API.
    -   **Document Upload**: AJAX Form for BAST/Photos.
    -   **Status Updates**: Real-time feedback after actions.

#### CS View - Monitoring Dashboard

-   **Route**: `GET /monitoring`
-   **File**: `resources/views/operational/monitoring/index.blade.php`
-   **Features**:
    -   **Stats Cards**: Total, On-site, Completed, Pending.
    -   **Live Table**: List of today's visits with "LATE CHECK-IN" alerts.

## Verification Walkthrough

1.  **TS: Start Activity**

    -   Click Ticket in "My Jobs" -> Redirect to Detail.
    -   Click "Check-in" -> Browser Permission Allow -> Status moves to "IN_PROGRESS".

2.  **CS: Monitor**

    -   Go to `/monitoring`.
    -   See the ticket status change to "IN_PROGRESS".

3.  **TS: Complete Activity**
    -   Upload BAST (PDF) -> Success.
    -   Click "Check-out" -> Status moves to "COMPLETED...".

## Files Modified/Created

-   `app/Http/Controllers/Operational/AttendanceController.php`
-   `app/Http/Controllers/Operational/DocumentController.php`
-   `app/Http/Controllers/Operational/AssignmentController.php` (Updated)
-   `app/Http/Controllers/Operational/MonitoringController.php`
-   `resources/views/operational/assignments/show.blade.php`
-   `resources/views/operational/monitoring/index.blade.php`
-   `routes/web.php`
-   `routes/console.php`

# Sprint 4: Invoicing, Rating & Finalisasi

**Date**: 2025-12-12
**Status**: Completed (Backend, Frontend & Automation Templates)

## Summary of Changes

### 1. Backend & Database (Invoicing & Feedback)

Implemented the Finance module and Feedback loop.

#### Invoicing (FIN-001)

-   **Controller**: `InvoiceController`
-   **Features**:
    -   Generate Invoice ID (`INV-YYYYMM-RAND`).
    -   Calculate Base vs Discount.
    -   Status Management (DRAFT -> SENT -> PAID).
    -   Prevent Duplicate Invoices per Ticket.

#### Feedback (FDB-001)

-   **Controller**: `Api\FeedbackController`
-   **Features**:
    -   API Endpoint `POST /api/feedback` for receiving ratings.
    -   Auto-update Ticket Status to `ARCHIVED` upon feedback.

#### Reporting

-   **Controller**: `Admin\ReportController`
-   **Features**: Aggregates TS ratings and counts reviews.

### 2. Frontend Implementation

#### Invoicing UI

-   **Create Invoice**: `resources/views/finance/invoices/create.blade.php`.
-   **View Invoice**: `resources/views/finance/invoices/show.blade.php` (Printable Layout).
-   **Integration**: Added "Create/View Invoice" button in `Monitoring Dashboard` (CS View).

#### Report Dashboard

-   **View**: `resources/views/admin/reports/index.blade.php`.
-   **Features**: Table showing Technician Name, Total Reviews, Avg Rating, and Performance Badge.

### 3. Automation (n8n)

-   Created logic templates for:
    -   Sending Invoices via WA.
    -   Requesting Feedback via WA.
    -   Receiving Feedback via Webhook.

## Verification Walkthrough

1.  **CS: Create Invoice**

    -   Go to Monitoring -> Click "Create Invoice" on Completed Ticket.
    -   Input Amount -> Draft Created.
    -   Click "Update Status" to PAID -> Status Updated.

2.  **System: Feedback**

    -   Send POST request to `/api/feedback`.
    -   Verify Ticket Status changes to `ARCHIVED`.

3.  **Admin: Report**
    -   Go to `/report`.
    -   See performance stats of TS.

## Files Modified/Created

-   `app/Http/Controllers/Finance/InvoiceController.php`
-   `app/Http/Controllers/Api/FeedbackController.php`
-   `app/Http/Controllers/Admin/ReportController.php`
-   `resources/views/finance/invoices/*`
-   `resources/views/admin/reports/index.blade.php`
-   `routes/web.php`
-   `routes/api.php`

# Technical Debt & Pending Tasks Cleanup

**Date**: 2025-12-12
**Status**: Addressed

## Summary of Changes

### 1. Technical Debt Resolution
-   **InvoiceController**: Implemented `index()` method to list invoices with pagination.
-   **TicketController**: Implemented `index()` method with rudimentary role-based filtering (TS sees assigned, others see all).

### 2. Field Ops Enhancements (Sprint 3 Pending)
-   **API Extension**: Added `requestExtension` method in `AttendanceController` to handle requests for additional visitation days.

### 3. Automation Implementation (Sprint 2 Pending)
-   **Notification Triggers**: Added logic in `TicketController::store` and `AssignmentController::takeJob` to log/trigger n8n webhooks (Mock implementation for MVP).

## Files Modified
-   `app/Http/Controllers/Finance/InvoiceController.php`
-   `app/Http/Controllers/Operational/TicketController.php`
-   `app/Http/Controllers/Operational/AttendanceController.php`
-   `app/Http/Controllers/Operational/AssignmentController.php`

# Sprint 2: Frontend Implementation Plan (Ticketing & FCFS)

## Goal

Implement the user interface for:

1.  **CS/Admin**: Create generic Visit Tickets.
2.  **TS (Technical Support)**: Dashboard to view Open Jobs and "Take Job" (FCFS).

## Structure

We will use standard Blade templates extending the existing layout (likely `layouts.app` or `layouts.vertical-master` based on file list, need to verify `layouts` dir).

### 1. CS View - Create Ticket

**File**: `resources/views/operational/tickets/create.blade.php`
**Route**: `GET /tickets/create` (Standard Resource)
**Controller**: `TicketController@create`
**Components**:

-   Dropdown Customer (Select2 or standard select).
-   Input Issue Category & Description.
-   Input Address (Auto-fill from Customer address if possible, but keep editable).
-   Select Priority.
-   Input Quota (Default 1).

### 2. TS View - Mobile Dashboard

**File**: `resources/views/operational/assignments/index.blade.php`
**Route**: `GET /assignments/open`
**Controller**: `AssignmentController@index`
**Design**:

-   **Tab 1: Open Pool**: List of tickets with status `OPEN`. Card layout.
    -   Show: ID, Category, Area/Address (Brief), Priority.
    -   Action: "Ambil Job" (Ajax POST to `assignments.take`).
-   **Tab 2: My Jobs**: List of tickets assigned to current User with status `PENDING`/`IN_PROGRESS`.
    -   Show: ID, Customer, Status.
    -   Action: "Detail" (Link to detailed view - future sprint).

## Implementation Steps

### Step 1: Create View Files

-   Create directory `resources/views/operational/tickets`.
-   Create `create.blade.php`.
-   Create directory `resources/views/operational/assignments`.
-   Create `index.blade.php`.

### Step 2: Update Controllers

-   **TicketController**:
    -   `create()`: Fetch Customers and return view `operational.tickets.create`.
    -   `store()`: Ensure validation failure redirects back with errors.
-   **AssignmentController**:
    -   `index()`: Fetch `openTickets` and `myAssignments`. Return view `operational.assignments.index` passing this data. (Currently returns JSON).

### Step 3: JavaScript/AJAX

-   In `index.blade.php`, add script to handle "Take Job" button click.
    -   On click -> Disable button -> POST `/assignments/take`.
    -   On success -> Alert "Job Taken!" -> Reload Page.
    -   On error -> Alert Error Message.

## Verification

-   CS can see the form and submit.
-   TS can see the list of open tickets.
-   TS can click "Ambil Ticket" and it moves to "My Jobs".

# Sprint 4: Full Implementation Report

## Done vs Planned

-   **Backend**: 100% Complete (Invoicing, Feedback, Reports).
-   **Frontend**: 100% Complete (Invoice Create/Show, Report Dashboard).
-   **Automation**: Templates Created (n8n JSON/Logic).

## Next Steps (MVP Launch)

-   **Deploy**: Setup VPS / Hosting.
-   **Training**: User Training for CS/TS.
-   **UAT**: Full Cycle Testing.

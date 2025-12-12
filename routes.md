# Routes Documentation

This document lists the routes defined in `routes/web.php`, their corresponding controllers, and the views they utilize.

## Overview

The application uses standard Laravel routing with a mix of closures for static pages and controllers for business logic.

## General Routes

### Landing/Home Page

-   **URI**: `GET /`
-   **Route Name**: `dashboard-analytics`
-   **Controller**: Closure
-   **View Rendered**: `dashboard-analytics`
-   **Purpose**: Analytics dashboard view.

### Reports Dashboard

-   **URI**: `GET /report`
-   **Route Name**: `dashboard-ecommerce`
-   **Controller**: `App\Http\Controllers\Admin\ReportController@index`
-   **View Rendered**: `admin.reports.index`
-   **Purpose**: Displays TS ratings and report data.

### Calendar View

-   **URI**: `GET /calendar`
-   **Route Name**: `calendar`
-   **Controller**: Closure
-   **View Rendered**: `ticketing`
-   **Purpose**: Visual representation of ticketing schedule.

### Store Event

-   **URI**: `POST /calendar/store`
-   **Route Name**: `calendar.store`
-   **Controller**: `CalendarController@store`
-   **View Rendered**: -
-   **Purpose**: Action to save calendar events.

### Customer List

-   **URI**: `GET /customers`
-   **Route Name**: `customers.index`
-   **Controller**: `App\Http\Controllers\Master\CustomerController@index`
-   **View Rendered**: `customers-index`
-   **Purpose**: List all customers.

### Customer Form

-   **URI**: `GET /customers/create`
-   **Route Name**: `customers.create`
-   **Controller**: `App\Http\Controllers\Master\CustomerController@create`
-   **View Rendered**: `customers-form`
-   **Purpose**: Create new customer.

### Customer Edit

-   **URI**: `GET /customers/{customer}/edit`
-   **Route Name**: `customers.edit`
-   **Controller**: `App\Http\Controllers\Master\CustomerController@edit`
-   **View Rendered**: `customers-form`
-   **Purpose**: Edit existing customer.

### Main Dashboard

-   **URI**: `GET /dashboard`
-   **Route Name**: `dashboard`
-   **Controller**: Closure
-   **View Rendered**: `dashboard`
-   **Purpose**: General user dashboard (requires auth).

### User Profile (Edit)

-   **URI**: `GET /profile`
-   **Route Name**: `profile.edit`
-   **Controller**: `ProfileController@edit`
-   **View Rendered**: `profile.edit`
-   **Purpose**: Edit user profile.

### Update Profile

-   **URI**: `PATCH /profile`
-   **Route Name**: `profile.update`
-   **Controller**: `ProfileController@update`
-   **View Rendered**: -
-   **Purpose**: Action to update user details.

### Delete Account

-   **URI**: `DELETE /profile`
-   **Route Name**: `profile.destroy`
-   **Controller**: `ProfileController@destroy`
-   **View Rendered**: -
-   **Purpose**: Action to delete user account.

---

## Auth & User Management (Admin)

### User List

-   **URI**: `GET /users`
-   **Route Name**: `users.index`
-   **Controller**: `App\Http\Controllers\Admin\UserController@index`
-   **View Rendered**: `admin.users.index`
-   **Purpose**: Admin view of all users.

### Create User

-   **URI**: `GET /users/create`
-   **Route Name**: `users.create`
-   **Controller**: `App\Http\Controllers\Admin\UserController@create`
-   **View Rendered**: `admin.users.create`
-   **Purpose**: Form to add new users.

### Show User

-   **URI**: `GET /users/{user}`
-   **Route Name**: `users.show`
-   **Controller**: `App\Http\Controllers\Admin\UserController@show`
-   **View Rendered**: `admin.users.show`
-   **Purpose**: View user details.

### Edit User

-   **URI**: `GET /users/{user}/edit`
-   **Route Name**: `users.edit`
-   **Controller**: `App\Http\Controllers\Admin\UserController@edit`
-   **View Rendered**: `admin.users.edit`
-   **Purpose**: Modify user details.

---

## Operational (Tickets & Assignments)

### Ticket List

-   **URI**: `GET /tickets`
-   **Route Name**: `tickets.index`
-   **Controller**: `App\Http\Controllers\Operational\TicketController@index`
-   **View Rendered**: `operational.tickets.index`
-   **Purpose**: Main ticket management view.

### Create Ticket

-   **URI**: `GET /tickets/create`
-   **Route Name**: `tickets.create`
-   **Controller**: `App\Http\Controllers\Operational\TicketController@create`
-   **View Rendered**: `operational.tickets.create`
-   **Purpose**: Form to log new tickets.

### Open Assignments

-   **URI**: `GET /assignments/open`
-   **Route Name**: `assignments.open`
-   **Controller**: `App\Http\Controllers\Operational\AssignmentController@index`
-   **View Rendered**: `operational.assignments.index`
-   **Purpose**: View for TS to see available jobs.

### Take Job

-   **URI**: `POST /assignments/take`
-   **Route Name**: `assignments.take`
-   **Controller**: `App\Http\Controllers\Operational\AssignmentController@takeJob`
-   **View Rendered**: -
-   **Purpose**: Action to assign a ticket to self.

### Job Detail

-   **URI**: `GET /assignments/{ticket}`
-   **Route Name**: `assignments.show`
-   **Controller**: `App\Http\Controllers\Operational\AssignmentController@show`
-   **View Rendered**: `operational.assignments.show`
-   **Purpose**: Detailed view of an assignment for execution.

### Monitoring Dashboard

-   **URI**: `GET /monitoring`
-   **Route Name**: `monitoring.index`
-   **Controller**: `App\Http\Controllers\Operational\MonitoringController@index`
-   **View Rendered**: `operational.monitoring.index`
-   **Purpose**: Real-time monitoring of operations.

### Check In

-   **URI**: `POST /attendance/check-in`
-   **Route Name**: `attendance.checkIn`
-   **Controller**: `App\Http\Controllers\Operational\AttendanceController@checkIn`
-   **View Rendered**: -
-   **Purpose**: Action for TS arrival.

### Check Out

-   **URI**: `POST /attendance/check-out`
-   **Route Name**: `attendance.checkOut`
-   **Controller**: `App\Http\Controllers\Operational\AttendanceController@checkOut`
-   **View Rendered**: -
-   **Purpose**: Action for TS departure.

### Upload Document

-   **URI**: `POST /documents/upload`
-   **Route Name**: `documents.upload`
-   **Controller**: `App\Http\Controllers\Operational\DocumentController@upload`
-   **View Rendered**: -
-   **Purpose**: Action to upload BA/Timesheets.

---

## Finance (Invoicing)

### Invoice List

-   **URI**: `GET /invoices`
-   **Route Name**: `invoices.index`
-   **Controller**: `App\Http\Controllers\Finance\InvoiceController@index`
-   **View Rendered**: `finance.invoices.index`
-   **Purpose**: List of all invoices.

### Generate Invoice

-   **URI**: `GET /invoices/create`
-   **Route Name**: `invoices.create`
-   **Controller**: `App\Http\Controllers\Finance\InvoiceController@create`
-   **View Rendered**: `finance.invoices.create`
-   **Purpose**: Form to create a new invoice from a ticket.

### Invoice Detail

-   **URI**: `GET /invoices/{invoice}`
-   **Route Name**: `invoices.show`
-   **Controller**: `App\Http\Controllers\Finance\InvoiceController@show`
-   **View Rendered**: `finance.invoices.show`
-   **Purpose**: View specific invoice.

<?php

use App\Http\Controllers\Api\WebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/n8n/customer-register', [WebhookController::class, 'handleCustomerRegistration']);

<?php

use App\Http\Controllers\WaitlistEntryController;
use App\Mail\AdminWaitlistSignupMail;
use App\Mail\WaitlistConfirmationMail;
use App\Models\WaitlistEntry;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'ComingSoon')->name('home');

Route::post('/waitlist', WaitlistEntryController::class)
    ->middleware('throttle:6,1')
    ->name('waitlist.store');

Route::prefix('/preview/mail/waitlist')
    ->name('preview.waitlist.')
    ->group(function (): void {
        Route::get('/admin-signup', function (): AdminWaitlistSignupMail {
            abort_unless(app()->environment(['local', 'testing']), 404);

            return new AdminWaitlistSignupMail(new WaitlistEntry([
                'email' => 'preview@example.com',
            ]));
        })->name('admin-signup');

        Route::get('/confirmation', function (): WaitlistConfirmationMail {
            abort_unless(app()->environment(['local', 'testing']), 404);

            return new WaitlistConfirmationMail(new WaitlistEntry([
                'email' => 'preview@example.com',
            ]));
        })->name('confirmation');
    });

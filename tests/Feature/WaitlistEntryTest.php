<?php

use App\Mail\AdminWaitlistSignupMail;
use App\Mail\WaitlistConfirmationMail;
use App\Models\WaitlistEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('a new waitlist signup is stored and queues both emails', function () {
    Mail::fake();

    config()->set('waitlist.notify.address', 'team@example.com');

    $response = $this->post(route('waitlist.store'), [
        'email' => 'NewUser@Example.com ',
    ]);

    $response
        ->assertRedirect(route('home'))
        ->assertSessionHas('waitlist.success', 'Thanks. You are on the waitlist.');

    expect(WaitlistEntry::query()->count())->toBe(1);
    expect(WaitlistEntry::query()->first()?->email)->toBe('newuser@example.com');

    Mail::assertQueued(AdminWaitlistSignupMail::class, function (AdminWaitlistSignupMail $mail): bool {
        return $mail->hasTo('team@example.com');
    });

    Mail::assertQueued(WaitlistConfirmationMail::class, function (WaitlistConfirmationMail $mail): bool {
        return $mail->hasTo('newuser@example.com');
    });
});

test('duplicate waitlist signups are idempotent and do not resend emails', function () {
    Mail::fake();

    config()->set('waitlist.notify.address', 'team@example.com');

    WaitlistEntry::query()->create([
        'email' => 'existing@example.com',
    ]);

    $response = $this->post(route('waitlist.store'), [
        'email' => ' Existing@Example.com ',
    ]);

    $response
        ->assertRedirect(route('home'))
        ->assertSessionHas('waitlist.success', 'Thanks. You are on the waitlist.');

    expect(WaitlistEntry::query()->count())->toBe(1);

    Mail::assertNothingQueued();
});

test('invalid emails are rejected', function () {
    Mail::fake();

    $response = $this->from(route('home'))->post(route('waitlist.store'), [
        'email' => 'not-an-email',
    ]);

    $response
        ->assertRedirect(route('home'))
        ->assertSessionHasErrors(['email']);

    expect(WaitlistEntry::query()->count())->toBe(0);

    Mail::assertNothingQueued();
});

test('signup succeeds without an admin notification address', function () {
    Mail::fake();

    config()->set('waitlist.notify.address', null);

    $response = $this->post(route('waitlist.store'), [
        'email' => 'person@example.com',
    ]);

    $response
        ->assertRedirect(route('home'))
        ->assertSessionHas('waitlist.success', 'Thanks. You are on the waitlist.');

    expect(WaitlistEntry::query()->count())->toBe(1);

    Mail::assertNotQueued(AdminWaitlistSignupMail::class);
    Mail::assertQueued(WaitlistConfirmationMail::class, function (WaitlistConfirmationMail $mail): bool {
        return $mail->hasTo('person@example.com');
    });
});

test('the admin waitlist email can be previewed in the browser', function () {
    $response = $this->get(route('preview.waitlist.admin-signup'));

    $response
        ->assertOk()
        ->assertSee('preview@example.com')
        ->assertSee('A new waitlist signup has been received');
});

test('the confirmation waitlist email can be previewed in the browser', function () {
    $response = $this->get(route('preview.waitlist.confirmation'));

    $response
        ->assertOk()
        ->assertSee('preview@example.com')
        ->assertSee('Thanks for joining the');
});

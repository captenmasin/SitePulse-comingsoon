<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Waitlist\StoreWaitlistEntry;
use App\Http\Requests\StoreWaitlistEntryRequest;
use Illuminate\Http\RedirectResponse;

class WaitlistEntryController extends Controller
{
    private const SUCCESS_MESSAGE = 'Thanks. You are on the waitlist.';

    /**
     * Handle the incoming request.
     */
    public function __invoke(
        StoreWaitlistEntryRequest $request,
        StoreWaitlistEntry $storeWaitlistEntry,
    ): RedirectResponse
    {
        $storeWaitlistEntry->handle($request->string('email')->toString());

        return to_route('home')->with('waitlist.success', self::SUCCESS_MESSAGE);
    }
}

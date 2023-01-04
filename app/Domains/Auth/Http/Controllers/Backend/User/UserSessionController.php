<?php

namespace App\Domains\Auth\Http\Controllers\Backend\User;

use App\Domains\Auth\Http\Requests\Backend\User\ClearUserSessionRequest;
use App\Domains\Auth\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class UserSessionController
{
    public function update(ClearUserSessionRequest $request, User $user): Redirector|RedirectResponse
    {
        $user->update(['to_be_logged_out' => true]);

        return redirect()
            ->back()
            ->withFlashSuccess(__('The user\'s session was successfully cleared.'));
    }
}

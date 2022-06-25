<?php

namespace App\Domains\Auth\Events\User;

use App\Domains\Auth\Models\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserCreated.
 */
class UserCreated
{
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

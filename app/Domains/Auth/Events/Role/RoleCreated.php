<?php

namespace App\Domains\Auth\Events\Role;

use App\Domains\Auth\Models\Role;
use Illuminate\Queue\SerializesModels;

/**
 * Class RoleCreated.
 */
class RoleCreated
{
    use SerializesModels;

    /**
     * @var Role
     */
    public $role;

    /**
     * @param  Role  $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }
}

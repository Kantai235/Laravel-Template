<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run(): void
    {
        $this->disableForeignKeys();

        // Create Roles
        Role::create([
            'id' => 1,
            'type' => User::TYPE_ADMIN,
            'name' => 'Administrator',
        ]);

        // Non Grouped Permissions
        //

        // Grouped permissions
        // Users category
        $users = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.access.user',
            'description' => 'All User Permissions',
        ]);

        $users->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.list',
                'description' => 'View Users',
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.deactivate',
                'description' => 'Deactivate Users',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.reactivate',
                'description' => 'Reactivate Users',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.clear-session',
                'description' => 'Clear User Sessions',
                'sort' => 4,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.impersonate',
                'description' => 'Impersonate Users',
                'sort' => 5,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.change-password',
                'description' => 'Change User Passwords',
                'sort' => 6,
            ]),
        ]);

        // Announcements category
        $announcements = Permission::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'admin.announcement',
            'description' => 'All Announcement Permissions',
        ]);

        $announcements->children()->saveMany([
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.announcement.list',
                'description' => 'View Announcements',
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.announcement.deactivate',
                'description' => 'Deactivate Announcements',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.announcement.reactivate',
                'description' => 'Reactivate Announcements',
                'sort' => 3,
            ]),
        ]);

        // Assign Permissions to other Roles
        //

        $this->enableForeignKeys();
    }
}

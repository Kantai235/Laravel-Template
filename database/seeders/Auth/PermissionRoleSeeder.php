<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run(): void
    {
        $this->disableForeignKeys();

        // Create Roles
        Role::create([
            'id' => 1,
            'type' => User::TYPE_ADMIN,
            'name' => config('template.access.role.admin'),
        ]);

        Role::create([
            'id' => 2,
            'type' => User::TYPE_ADMIN,
            'name' => config('template.access.role.announcement'),
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
                'sort' => 1,
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
                'name' => 'admin.announcement.edit',
                'description' => 'Create and Edit Announcements',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.announcement.deactivate',
                'description' => 'Deactivate and Reactivate Announcements',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.announcement.destore',
                'description' => 'Destroy and Restore Announcements',
                'sort' => 4,
            ]),
        ]);

        // Assign Permissions to other Roles
        //

        $this->enableForeignKeys();
    }
}

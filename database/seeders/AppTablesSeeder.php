<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AppTablesSeeder extends Seeder
{
    /**
     * Seed RBAC users, roles, and permissions.
     */
    public function run(): void
    {
        $now = now();

        $roles = [
            'super-admin' => DB::table('roles')->insertGetId([
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Full system access',
                'created_at' => $now,
                'updated_at' => $now,
            ]),
            'admin' => DB::table('roles')->insertGetId([
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrative access',
                'created_at' => $now,
                'updated_at' => $now,
            ]),
            'user' => DB::table('roles')->insertGetId([
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Basic authenticated access',
                'created_at' => $now,
                'updated_at' => $now,
            ]),
        ];

        $permissions = [
            'auth.login' => DB::table('permissions')->insertGetId([
                'name' => 'Login',
                'slug' => 'auth.login',
                'module' => 'auth',
                'description' => 'Allow user login',
                'created_at' => $now,
                'updated_at' => $now,
            ]),
            'users.view' => DB::table('permissions')->insertGetId([
                'name' => 'View Users',
                'slug' => 'users.view',
                'module' => 'users',
                'description' => 'View user profiles',
                'created_at' => $now,
                'updated_at' => $now,
            ]),
            'roles.manage' => DB::table('permissions')->insertGetId([
                'name' => 'Manage Roles',
                'slug' => 'roles.manage',
                'module' => 'roles',
                'description' => 'Create and update roles',
                'created_at' => $now,
                'updated_at' => $now,
            ]),
            'permissions.manage' => DB::table('permissions')->insertGetId([
                'name' => 'Manage Permissions',
                'slug' => 'permissions.manage',
                'module' => 'permissions',
                'description' => 'Create and update permissions',
                'created_at' => $now,
                'updated_at' => $now,
            ]),
        ];

        DB::table('role_permissions')->insert([
            ['role_id' => $roles['super-admin'], 'permission_id' => $permissions['auth.login']],
            ['role_id' => $roles['super-admin'], 'permission_id' => $permissions['users.view']],
            ['role_id' => $roles['super-admin'], 'permission_id' => $permissions['roles.manage']],
            ['role_id' => $roles['super-admin'], 'permission_id' => $permissions['permissions.manage']],
            ['role_id' => $roles['admin'], 'permission_id' => $permissions['auth.login']],
            ['role_id' => $roles['admin'], 'permission_id' => $permissions['users.view']],
            ['role_id' => $roles['user'], 'permission_id' => $permissions['auth.login']],
        ]);

        $superAdminUserId = DB::table('users')->insertGetId([
            'ulid' => (string) Str::ulid(),
            'firstname' => 'Super',
            'middlename' => null,
            'lastname' => 'Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'email_verified_at' => $now,
            'password' => Hash::make('password123'),
            'remember_token' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $adminUserId = DB::table('users')->insertGetId([
            'ulid' => (string) Str::ulid(),
            'firstname' => 'Admin',
            'middlename' => null,
            'lastname' => 'User',
            'username' => 'adminuser',
            'email' => 'admin@example.com',
            'email_verified_at' => $now,
            'password' => Hash::make('password123'),
            'remember_token' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $basicUserId = DB::table('users')->insertGetId([
            'ulid' => (string) Str::ulid(),
            'firstname' => 'Basic',
            'middlename' => null,
            'lastname' => 'User',
            'username' => 'basicuser',
            'email' => 'user@example.com',
            'email_verified_at' => $now,
            'password' => Hash::make('password123'),
            'remember_token' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('user_roles')->insert([
            ['user_id' => $superAdminUserId, 'role_id' => $roles['super-admin'], 'assigned_at' => $now, 'assigned_by' => null],
            ['user_id' => $adminUserId, 'role_id' => $roles['admin'], 'assigned_at' => $now, 'assigned_by' => $superAdminUserId],
            ['user_id' => $basicUserId, 'role_id' => $roles['user'], 'assigned_at' => $now, 'assigned_by' => $superAdminUserId],
        ]);
    }
}

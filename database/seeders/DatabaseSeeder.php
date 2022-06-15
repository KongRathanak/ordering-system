<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleModel = config('backpack.permissionmanager.models.role');

        $superAdmin = $roleModel::firstOrCreate(['id' => 1], ['name' => 'Superadmin']);
        $admin = $roleModel::firstOrCreate(['id' => 2], ['name' => 'Admin']);
        $editor = $roleModel::firstOrCreate(['id' => 3], ['name' => 'Editor']);
        $user = $roleModel::firstOrCreate(['id' => 4], ['name' => 'User']);

        collect([
            'users',
            'articles',
            'tags',
            'categories',
            'pages'
        ])->each(function($v) use ($superAdmin, $admin, $editor, $user) {
            collect([
                'list',
                'create',
                'update',
                'show',
                'delete',
            ])->each(function($vv) use ($v, $superAdmin, $admin, $editor, $user) {
                $permission = config('backpack.permissionmanager.models.permission')::firstOrCreate(['name' => "{$vv} {$v}"]);
                $superAdmin->givePermissionTo($permission->name);
                $admin->givePermissionTo($permission->name);
                if (!in_array($v, ['users', 'pages']) && $vv != 'delete') {
                    $editor->givePermissionTo($permission->name);
                }
                if (!in_array($v, ['users', 'pages']) && !in_array($vv, ['delete', 'update', 'create'])) {
                    $user->givePermissionTo($permission->name);
                }
            });
        });

        $userData = config('backpack.permissionmanager.models.user')::firstOrCreate([

            'email' => 'admin@admin.com',
        ], [
            'first_name' => 'System',
            'last_name' => 'Admin',
            'phone' => '070218869',
            'password' => 'not4youbro',
        ]);
        $userData->assignRole($superAdmin->name);

        $this->call(SettingsTableSeeder::class);
    }
}

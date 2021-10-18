<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo vai trò
        $admin = Role::create(['name' => 'Admin']);
        $test = Role::create(['name' => 'Test']);

        // Gán vai trò
        User::find(1)->assignRole('Admin');

        // Tạo quyền
        $category_manager = Permission::create(['name' => 'category_manager']);
        $project_manager = Permission::create(['name' => 'project_manager']);
        $contract_manager = Permission::create(['name' => 'contract_manager']);
        // $transaction_manager = Permission::create(['name' => 'transaction_manager']);
        // $statistic_manager = Permission::create(['name' => 'statistic_manager']);
        // $news_manager = Permission::create(['name' => 'news_manager']);
        // $staff_manager = Permission::create(['name' => 'staff_manager']);
        // $role_manager = Permission::create(['name' => 'role_manager']);
        // $permission_manager = Permission::create(['name' => 'permission_manager']);

        // Set quyền cho vai trò admin
        $test->givePermissionTo($category_manager);
        $test->givePermissionTo($project_manager);
        $test->givePermissionTo($contract_manager);


        // Set quyền cho vai trò admin
        // $admin->givePermissionTo($category_manager);
        // $admin->givePermissionTo($project_manager);
        // $admin->givePermissionTo($contract_manager);
        // $admin->givePermissionTo($transaction_manager);
        // $admin->givePermissionTo($statistic_manager);
        // $admin->givePermissionTo($news_manager);
        // $admin->givePermissionTo($staff_manager);
        // $admin->givePermissionTo($role_manager);
        // $admin->givePermissionTo($permission_manager);
    }
}

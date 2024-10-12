<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        Permission::create(['name' => 'view-dashboard']);

        Permission::create(['name' => 'view-category']);
        Permission::create(['name' => 'add-category']);
        Permission::create(['name' => 'edit-category']);
        Permission::create(['name' => 'delete-category']);

        Permission::create(['name' => 'view-product']);
        Permission::create(['name' => 'add-product']);
        Permission::create(['name' => 'edit-product']);
        Permission::create(['name' => 'delete-product']);

        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'add-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);

        Permission::create(['name' => 'view-customer']);
        Permission::create(['name' => 'add-customer']);
        Permission::create(['name' => 'edit-customer']);
        Permission::create(['name' => 'delete-customer']);

        Permission::create(['name' => 'view-forecast']);

        Permission::create(['name' => 'view-order']);
        Permission::create(['name' => 'add-order']);
        Permission::create(['name' => 'edit-order']);
        Permission::create(['name' => 'delete-order']);

        Permission::create(['name' => 'view-employment']);
        Permission::create(['name' => 'add-employment']);
        Permission::create(['name' => 'edit-employment']);
        Permission::create(['name' => 'delete-employment']);

        Permission::create(['name' => 'view-employee']);
        Permission::create(['name' => 'add-employee']);
        Permission::create(['name' => 'edit-employee']);
        Permission::create(['name' => 'delete-employee']);

        Permission::create(['name' => 'view-pembelian-barang']);
        Permission::create(['name' => 'add-pembelian-barang']);
        Permission::create(['name' => 'edit-pembelian-barang']);
        Permission::create(['name' => 'delete-pembelian-barang']);

        Permission::create(['name' => 'view-supplier']);
        Permission::create(['name' => 'add-supplier']);
        Permission::create(['name' => 'edit-supplier']);
        Permission::create(['name' => 'delete-supplier']);

        Permission::create(['name' => 'view-manajemen-penjualan']);
        Permission::create(['name' => 'add-manajemen-penjualan']);
        Permission::create(['name' => 'edit-manajemen-penjualan']);
        Permission::create(['name' => 'delete-manajemen-penjualan']);

        Permission::create(['name' => 'view-salary-payment']);
        Permission::create(['name' => 'add-salary-payment']);
        Permission::create(['name' => 'edit-salary-payment']);
        Permission::create(['name' => 'delete-salary-payment']);

        Permission::create(['name' => 'view-debts']);
        Permission::create(['name' => 'add-debts']);
        Permission::create(['name' => 'edit-debts']);
        Permission::create(['name' => 'delete-debts']);

        Permission::create(['name' => 'view-receivables']);
        Permission::create(['name' => 'add-receivables']);
        Permission::create(['name' => 'edit-receivables']);
        Permission::create(['name' => 'delete-receivables']);

        Permission::create(['name' => 'view-sales']);
        Permission::create(['name' => 'add-sales']);
        Permission::create(['name' => 'edit-sales']);
        Permission::create(['name' => 'delete-sales']);

        Permission::create(['name' => 'view-income-statement']);
        Permission::create(['name' => 'add-income-statement']);
        Permission::create(['name' => 'edit-income-statement']);
        Permission::create(['name' => 'delete-income-statement']);

        Permission::create(['name' => 'view-cash-flow']);
        Permission::create(['name' => 'add-cash-flow']);
        Permission::create(['name' => 'edit-cash-flow']);
        Permission::create(['name' => 'delete-cash-flow']);

        Permission::create(['name' => 'view-expert-system-symptom']);
        Permission::create(['name' => 'add-expert-system-symptom']);
        Permission::create(['name' => 'edit-expert-system-symptom']);
        Permission::create(['name' => 'delete-expert-system-symptom']);

        Permission::create(['name' => 'view-expert-system-pestdisease']);
        Permission::create(['name' => 'add-expert-system-pestdisease']);
        Permission::create(['name' => 'edit-expert-system-pestdisease']);
        Permission::create(['name' => 'delete-expert-system-pestdisease']);

        Permission::create(['name' => 'view-expert-system-rulebase']);
        Permission::create(['name' => 'add-expert-system-rulebase']);
        Permission::create(['name' => 'edit-expert-system-rulebase']);
        Permission::create(['name' => 'delete-expert-system-rulebase']);

        Permission::create(['name' => 'view-cashier']);
        Permission::create(['name' => 'add-cashier']);
        Permission::create(['name' => 'edit-cashier']);
        Permission::create(['name' => 'delete-cashier']);

        Permission::create(['name' => 'view-blog']);
        Permission::create(['name' => 'add-blog']);
        Permission::create(['name' => 'edit-blog']);
        Permission::create(['name' => 'delete-blog']);

        Permission::create(['name' => 'view-subscription']);
        Permission::create(['name' => 'add-subscription']);
        Permission::create(['name' => 'edit-subscription']);
        Permission::create(['name' => 'delete-subscription']);

        Permission::create(['name' => 'view-chat']);
        Permission::create(['name' => 'add-chat']);
        Permission::create(['name' => 'edit-chat']);
        Permission::create(['name' => 'delete-chat']);

        Permission::create(['name' => 'view-settings']);
        Permission::create(['name' => 'add-settings']);
        Permission::create(['name' => 'edit-settings']);
        Permission::create(['name' => 'delete-settings']);

        Permission::create(['name' => 'view-profile']);
        Permission::create(['name' => 'add-profile']);
        Permission::create(['name' => 'edit-profile']);
        Permission::create(['name' => 'delete-profile']);

        Permission::create(['name' => 'view-user-management']);
        Permission::create(['name' => 'add-user-management']);
        Permission::create(['name' => 'edit-user-management']);
        Permission::create(['name' => 'delete-user-management']);

        Permission::create(['name' => 'view-role-permission']);
        Permission::create(['name' => 'add-role-permission']);
        Permission::create(['name' => 'edit-role-permission']);
        Permission::create(['name' => 'delete-role-permission']);

        Permission::create(['name' => 'view-slider']);
        Permission::create(['name' => 'add-slider']);
        Permission::create(['name' => 'edit-slider']);
        Permission::create(['name' => 'delete-slider']);

        Permission::create(['name' => 'view-banner']);
        Permission::create(['name' => 'add-banner']);
        Permission::create(['name' => 'edit-banner']);
        Permission::create(['name' => 'delete-banner']);

        Permission::create(['name' => 'view-term-condition']);
        Permission::create(['name' => 'add-term-condition']);
        Permission::create(['name' => 'edit-term-condition']);
        Permission::create(['name' => 'delete-term-condition']);

        Permission::create(['name' => 'view-privacy-policy']);
        Permission::create(['name' => 'add-privacy-policy']);
        Permission::create(['name' => 'edit-privacy-policy']);
        Permission::create(['name' => 'delete-privacy-policy']);

        Permission::create(['name' => 'view-faq']);
        Permission::create(['name' => 'add-faq']);
        Permission::create(['name' => 'edit-faq']);
        Permission::create(['name' => 'delete-faq']);

        Permission::create(['name' => 'view-about-us']);
        Permission::create(['name' => 'add-about-us']);
        Permission::create(['name' => 'edit-about-us']);
        Permission::create(['name' => 'delete-about-us']);

        Permission::create(['name' => 'view-contact-us']);
        Permission::create(['name' => 'add-contact-us']);
        Permission::create(['name' => 'edit-contact-us']);
        Permission::create(['name' => 'delete-contact-us']);



        //create roles and assign existing permissions
        $cashierRole = Role::create(['name' => 'cashier']);
        $cashierRole->givePermissionTo('view-dashboard');

        $employeeRole = Role::create(['name' => 'employee']);
        $employeeRole->givePermissionTo('view-dashboard');
        $employeeRole->givePermissionTo('view-product');
        $employeeRole->givePermissionTo('add-product');
        $employeeRole->givePermissionTo('edit-product');
        $employeeRole->givePermissionTo('delete-product');
        $employeeRole->givePermissionTo('view-order');
        $employeeRole->givePermissionTo('add-order');
        $employeeRole->givePermissionTo('edit-order');
        $employeeRole->givePermissionTo('delete-order');


        $pakarRole = Role::create(['name' => 'pakar']);
        $pakarRole->givePermissionTo('view-dashboard');
        $pakarRole->givePermissionTo('view-expert-system-symptom');
        $pakarRole->givePermissionTo('view-expert-system-pestdisease');

        $adminPakarRole = Role::create(['name' => 'admin-pakar']);
        $adminPakarRole->givePermissionTo('view-dashboard');
        $adminPakarRole->givePermissionTo('view-expert-system-symptom');
        $adminPakarRole->givePermissionTo('add-expert-system-symptom');
        $adminPakarRole->givePermissionTo('edit-expert-system-symptom');
        $adminPakarRole->givePermissionTo('delete-expert-system-symptom');
        $adminPakarRole->givePermissionTo('view-expert-system-pestdisease');
        $adminPakarRole->givePermissionTo('add-expert-system-pestdisease');
        $adminPakarRole->givePermissionTo('edit-expert-system-pestdisease');
        $adminPakarRole->givePermissionTo('delete-expert-system-pestdisease');
        $adminPakarRole->givePermissionTo('view-expert-system-rulebase');
        $adminPakarRole->givePermissionTo('add-expert-system-rulebase');
        $adminPakarRole->givePermissionTo('edit-expert-system-rulebase');
        $adminPakarRole->givePermissionTo('delete-expert-system-rulebase');


        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo('view-dashboard');
        $managerRole->givePermissionTo('view-category');
        $managerRole->givePermissionTo('add-category');
        $managerRole->givePermissionTo('edit-category');
        $managerRole->givePermissionTo('delete-category');
        $managerRole->givePermissionTo('view-product');
        $managerRole->givePermissionTo('add-product');
        $managerRole->givePermissionTo('edit-product');
        $managerRole->givePermissionTo('delete-product');
        $managerRole->givePermissionTo('view-user');
        $managerRole->givePermissionTo('add-user');
        $managerRole->givePermissionTo('edit-user');
        $managerRole->givePermissionTo('delete-user');
        $managerRole->givePermissionTo('view-employee');
        $managerRole->givePermissionTo('add-employee');
        $managerRole->givePermissionTo('edit-employee');
        $managerRole->givePermissionTo('delete-employee');
        $managerRole->givePermissionTo('view-customer');
        $managerRole->givePermissionTo('add-customer');
        $managerRole->givePermissionTo('edit-customer');
        $managerRole->givePermissionTo('delete-customer');
        $managerRole->givePermissionTo('view-forecast');
        $managerRole->givePermissionTo('view-manajemen-penjualan');

        $superUserRole = Role::create(['name' => 'super-user']);

        $super = User::factory()->create([
            'name' => 'Super User',
            'email' => 'super@mitrajamur.com',
            'password' => bcrypt('password')
        ]);
        $super->assignRole($superUserRole);

        $manager = User::factory()->create([
            'name' => 'manager',
            'email' => 'manager@mitrajamur.com',
            'password' => bcrypt('password')
        ]);
        $manager->assignRole($managerRole);

        $employee = User::factory()->create([
            'name' => 'employee',
            'email' => 'employee@mitrajamur.com',
            'password' => bcrypt('password')
        ]);
        $employee->assignRole($employeeRole);

        $pakar = User::factory()->create([
            'name' => 'pakar',
            'email' => 'pakar@mitrajamur.com',
            'password' => bcrypt('password')
        ]);
        $pakar->assignRole($pakarRole);

        $adminPakar = User::factory()->create([
            'name' => 'Admin Pakar',
            'email' => 'admin-pakar@mitrajamur.com',
            'password' => bcrypt('password')
        ]);
        $adminPakar->assignRole($adminPakarRole);

        $cashier = User::factory()->create([
            'name' => 'cashier',
            'email' => 'cashier@mitrajamur.com',
            'password' => bcrypt('password')
        ]);
        $cashier->assignRole($cashierRole);
    }
}

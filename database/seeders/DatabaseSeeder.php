<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Project;
use App\Models\Supplier;
use App\Models\InventoryItem;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'System Administrator'],
            ['name' => 'Project Manager', 'slug' => 'project_manager', 'description' => 'Manages projects'],
            ['name' => 'Purchasing', 'slug' => 'purchasing', 'description' => 'Handles procurement'],
            ['name' => 'Warehouse', 'slug' => 'warehouse', 'description' => 'Manages inventory'],
            ['name' => 'Fabrication', 'slug' => 'fabrication', 'description' => 'Handles fabrication'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Create Users
        $adminRole = Role::where('slug', 'admin')->first();
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@erp.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        $pmRole = Role::where('slug', 'project_manager')->first();
        $pm = User::create([
            'name' => 'Project Manager',
            'email' => 'pm@erp.com',
            'password' => Hash::make('password'),
            'role_id' => $pmRole->id,
        ]);

        // Create Suppliers
        $suppliers = [
            ['name' => 'ABC Steel Supplies', 'contact_person' => 'John Doe', 'email' => 'contact@abcsteel.com', 'phone' => '123-456-7890'],
            ['name' => 'XYZ Materials Co', 'contact_person' => 'Jane Smith', 'email' => 'info@xyzmaterials.com', 'phone' => '234-567-8901'],
            ['name' => 'Global Hardware', 'contact_person' => 'Bob Johnson', 'email' => 'sales@globalhardware.com', 'phone' => '345-678-9012'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create(array_merge($supplier, [
                'code' => 'SUP-' . strtoupper(Str::random(8)),
                'status' => 'active',
            ]));
        }

        // Create Inventory Items
        $items = [
            ['name' => 'Steel Beam 6x6', 'item_type' => 'raw_material', 'unit_of_measure' => 'pcs', 'unit_cost' => 150.00, 'category' => 'Steel'],
            ['name' => 'Concrete Mix', 'item_type' => 'raw_material', 'unit_of_measure' => 'bags', 'unit_cost' => 25.00, 'category' => 'Concrete'],
            ['name' => 'Rebar #4', 'item_type' => 'raw_material', 'unit_of_measure' => 'pcs', 'unit_cost' => 12.50, 'category' => 'Steel'],
            ['name' => 'Welding Rods', 'item_type' => 'consumable', 'unit_of_measure' => 'kg', 'unit_cost' => 8.00, 'category' => 'Welding'],
            ['name' => 'Paint Primer', 'item_type' => 'consumable', 'unit_of_measure' => 'gallons', 'unit_cost' => 45.00, 'category' => 'Paint'],
        ];

        foreach ($items as $item) {
            InventoryItem::create(array_merge($item, [
                'item_code' => 'ITM-' . strtoupper(Str::random(8)),
                'status' => 'active',
                'reorder_level' => 10,
                'reorder_quantity' => 50,
            ]));
        }

        // Create Projects
        for ($i = 1; $i <= 5; $i++) {
            $project = Project::create([
                'project_code' => 'PRJ-' . strtoupper(Str::random(8)),
                'name' => "Construction Project {$i}",
                'description' => "Sample construction project number {$i}",
                'project_manager_id' => $pm->id,
                'start_date' => now()->addDays($i * 10),
                'end_date' => now()->addDays($i * 10 + 90),
                'status' => $i % 2 === 0 ? 'active' : 'planning',
                'budget' => 100000 * $i,
                'progress_percentage' => $i * 15,
            ]);

            // Create Purchase Request for each project
            $pr = PurchaseRequest::create([
                'pr_number' => 'PR-' . strtoupper(Str::random(8)),
                'project_id' => $project->id,
                'status' => 'approved',
                'requested_by' => $pm->id,
                'approved_by' => $adminRole->users()->first()->id,
                'approved_at' => now(),
            ]);

            // Add items to PR
            $inventoryItems = InventoryItem::take(3)->get();
            foreach ($inventoryItems as $invItem) {
                PurchaseRequestItem::create([
                    'purchase_request_id' => $pr->id,
                    'inventory_item_id' => $invItem->id,
                    'quantity' => rand(10, 100),
                    'unit_cost' => $invItem->unit_cost,
                ]);
            }
        }
    }
}

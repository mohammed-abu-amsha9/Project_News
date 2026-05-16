<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // إنشاء صلاحيات
        // Permission::create(['name' => 'Create User', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Read Users', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Edit User', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete User', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Create Category', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Read Categories', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Edit Category', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete Category', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Create Article', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Read Articles', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Drafts Article', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete Article', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Blocked Comments', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Read Articles', 'guard_name' => 'editor']);
        // Permission::create(['name' => 'Drafts Article', 'guard_name' => 'editor']);
        // Permission::create(['name' => 'Delete Article', 'guard_name' => 'editor']);
        // Permission::create(['name' => 'Blocked Comments', 'guard_name' => 'editor']);

        // Permission::create(['name' => 'Create Article', 'guard_name' => 'writer']);

        // Permission::firstOrCreate(['name' => 'Create User']);
        // Permission::firstOrCreate(['name' => 'Read Users']);
        // Permission::firstOrCreate(['name' => 'Edit User' ]);
        // Permission::firstOrCreate(['name' => 'Delete User']);

        // Permission::firstOrCreate(['name' => 'Create Category']);
        // Permission::firstOrCreate(['name' => 'Read Categories']);
        // Permission::firstOrCreate(['name' => 'Edit Category'  ]);
        // Permission::firstOrCreate(['name' => 'Delete Category']);

        // Permission::firstOrCreate(['name' => 'Create Article'  ]);
        // Permission::firstOrCreate(['name' => 'Read Articles'   ]);
        // Permission::firstOrCreate(['name' => 'Drafts Article'  ]);
        // Permission::firstOrCreate(['name' => 'Delete Article'  ]);
        // Permission::firstOrCreate(['name' => 'Blocked Comments']);

        // Permission::firstOrCreate(['name' => 'Read Articles']);
        // Permission::firstOrCreate(['name' => 'Drafts Article']);
        // Permission::firstOrCreate(['name' => 'Delete Article']);
        // Permission::firstOrCreate(['name' => 'Blocked Comments']);

        // Permission::firstOrCreate(['name' => 'Create Article']);

        // Permission::firstOrCreate(['name' => 'Create Role']);
        // Permission::firstOrCreate(['name' => 'Update Role']);
        // Permission::firstOrCreate(['name' => 'Delete Role']);
        // Permission::firstOrCreate(['name' => 'Read Role']);
        // Permission::firstOrCreate(['name' => 'Read Permission']);
        // Permission::firstOrCreate(['name' => 'Update Permission']);
        // Permission::firstOrCreate(['name' => 'Delete Permission']);
        // Permission::firstOrCreate(['name' => 'Edit User Permission']);
        // Permission::firstOrCreate(['name' => 'Update User Permission']);
        // Permission::firstOrCreate(['name' => 'Read One Article']);
        // Permission::firstOrCreate(['name' => 'Drafts Article']);
        // Permission::firstOrCreate(['name' => 'Deleted Articles']);




        // Permission::create(['name' => 'Create-User', 'guard_name' => 'writer']);
        // Permission::create(['name' => 'Read-Users', 'guard_name' => 'writer']);
        // Permission::create(['name' => 'Edit-User', 'guard_name' => 'writer']);
        // Permission::create(['name' => 'Delete-User', 'guard_name' => 'writer']);

        // Permission::firstOrCreate(['name' => 'create category']);
        // Permission::firstOrCreate(['name' => 'read categories']);
        // Permission::firstOrCreate(['name' => 'edit category']);
        // Permission::firstOrCreate(['name' => 'delete category']);

        // Permission::firstOrCreate(['name' => 'create article']);
        // Permission::firstOrCreate(['name' => 'read articles' ]);
        // Permission::firstOrCreate(['name' => 'drafts article']); // المقالات المعلقة
        // Permission::firstOrCreate(['name' => 'delete article']); // المقالات المرفوضة

        // Permission::firstOrCreate(['name' => 'blocked Comments']); // المقالات المرفوضة

        // إنشاء أدوار وربط الصلاحيات بها
        // $admin = Role::firstOrCreate(['name' => 'admin']);
        // $admin->givePermissionTo(Permission::all());

        // $editor = Role::firstOrCreate(['name' => 'editor']);
        // $editor->givePermissionTo(['drafts article', 'read articles', 'delete article', 'blocked Comments']);

        // $writer = Role::firstOrCreate(['name' => 'writer']);
        // $writer->givePermissionTo(['create article']);

        // تعيين دور لمستخدم موجود (مثلاً المستخدم رقم 1)
        // $user = User::find(1);
        // if($user) {
        //     $user->assignRole('admin');
        // }
    }
}

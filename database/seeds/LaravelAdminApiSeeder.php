<?php

use Illuminate\Database\Seeder;

class LaravelAdminApiSeeder extends Seeder
{
    public $time;

    public function __construct()
    {
        $this->time = date('Y-m-d H:i:s');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 管理员表填充
        $this->admin_api_user();
        // 角色表填充
        $this->roles();
        // 权限填充
        $this->permissions();
        // 角色权限填充
        $this->role_has_permissions();
        // 管理员角色-权限填充
        $this->user_role_permissions();
    }

    /**
     * 管理员表填充
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/2
     * Time: 16:11
     */
    public function admin_api_user()
    {
        $time = $this->time;
        $data = [
            [
                'id' => 1,
                'username' => 'admin',
                'password' => bcrypt('123456'),
                'name' => config('admin-api.root_role_name'),
                'avatar' => '',
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'id' => 2,
                'username' => 'admin1',
                'password' => bcrypt('123456'),
                'name' => '管理员',
                'avatar' => '',
                'created_at' => $time,
                'updated_at' => $time
            ],

        ];
        \Illuminate\Support\Facades\DB::table('admin_api_users')->insert($data);
    }

    /**
     * 角色表填充
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/2
     * Time: 15:53
     */
    public function roles()
    {
        $time = $this->time;
        $data = [
            [
                'id' => 1,
                'name' => config('admin-api.root_role_name'),
                'guard_name' => 'web',
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'id' => 2,
                'name' => '管理员',
                'guard_name' => 'web',
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
        \Illuminate\Support\Facades\DB::table('roles')->insert($data);
    }

    /**
     * 权限填充
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/2
     * Time: 16:17
     */
    public function permissions()
    {
        $time = $this->time;
        $array = [
            'admin_list' => '管理员list',
            'admin_detail' => '管理员详情',
            'admin_add' => '管理员添加',
            'admin_up' => '管理员修改',
            'admin_de' => '管理员删除',
            'role_list' => '角色list',
            'role_detail' => '角色详情',
            'role_add' => '角色添加',
            'role_up' => '角色修改',
            'role_de' => '角色删除',
            'permission_list' => '权限列表',
            'permission_deta' => '权限详情',
            'permission_add' => '权限添加',
            'permission_up' => '权限修改',
            'permission_de' => '权限删除',
            'log_list' => '日志list',
            'admin_api_test' => '新建路由测试',
        ];
        $data = [];
        $i = 1;
        foreach ($array as $k=>$v)
        {
            $data[] = [
                'id' => $i,
                'name' => $v,
                'guard_name' => 'web',
                'route_name' => config('admin-api.route.prefix').'/'.$k,
                'created_at' => $time,
                'updated_at' => $time,
            ];
            $i++;
        }
        \Illuminate\Support\Facades\DB::table('permissions')->insert($data);
    }

    /**
     * 角色权限填充
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/2
     * Time: 16:19
     */
    public function role_has_permissions()
    {
        $role = \Spatie\Permission\Models\Role::where('id',2)->first();
        $role->syncPermissions([16]);
    }

    /**
     * 管理员角色-权限填充
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/2
     * Time: 16:21
     */
    public function user_role_permissions()
    {
        // 系统管理员
        $xtgly_user = \Pl\LaravelAdminApi\Models\Admin_user::where('id',1)->first();
        $xtgly_user->syncRoles([1]);

        // 管理员
        $gly_user = \Pl\LaravelAdminApi\Models\Admin_user::where('id',2)->first();
        // 同步-管理员角色
        $gly_user->syncRoles([2]);
        // 同步权限-角色list权限
        $gly_user->syncPermissions([6]);
    }
}

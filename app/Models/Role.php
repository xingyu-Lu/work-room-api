<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    const ROOT = 'root';

    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);

        if (static::where('name', $attributes['name'])->where('guard_name', $attributes['guard_name'])->where('company_id', $attributes['company_id'])->first()) {
            throw RoleAlreadyExists::create($attributes['name'], $attributes['guard_name']);
        }

        return static::query()->create($attributes);
    }

    public function giveMenuTo($menu)
    {
        foreach ($menu as $key => $value) {
            DB::table('hr_role_has_menus')->insert(['role_id' => $this->id, 'menu_id' => $value]);
        }

        return true;
    }

    public function getMenuNames()
    {
        $menu_id = DB::table('hr_role_has_menus')->select('menu_id')->where('role_id', $this->id)->get()->toArray();

        $menu_id = array_column($menu_id, 'menu_id');
        
        $menus = Menu::whereIn('id', $menu_id)->get()->toArray();

        return $menus;
    }

    public function syncMenus($menu)
    {
        DB::table('hr_role_has_menus')->where('role_id', $this->id)->delete();

        foreach ($menu as $key => $value) {
            DB::table('hr_role_has_menus')->insert(['role_id' => $this->id, 'menu_id' => $value]);
        }

        return true;
    }

    public function menuDelete($ids)
    {
        foreach ($ids as $key => $value) {
            DB::table('hr_role_has_menus')->where('role_id', $value)->delete();
        }
        
        return true;
    }
}

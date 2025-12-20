<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::with('permissions')->latest();

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $roles = $query->paginate(10)->withQueryString();

        // Logic Grouping yang lebih cerdas
        $all_permissions = Permission::orderBy('name', 'asc')->get()->groupBy(function ($item) {
            $name = $item->name;

            // Cek apakah pakai titik (.) atau dash (-) sebagai pemisah aksi terakhir
            // Kita ambil teks sebelum pemisah terakhir
            $delimiter = str_contains($name, '.') ? '.' : (str_contains($name, '-') ? '-' : null);

            if ($delimiter) {
                $lastDelimiterPos = strrpos($name, $delimiter);
                $group = substr($name, 0, $lastDelimiterPos);
            } else {
                $group = $name;
            }

            // Bersihkan tampilan (ganti titik/dash sisa dengan spasi dan uppercase)
            // Contoh: 'karang-taruna' -> 'KARANG TARUNA'
            return strtoupper(str_replace(['.', '-'], ' ', $group));
        });

        return view('admin.pages.roles.index', compact('roles', 'all_permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        if ($request->permissions) {
            $role->permissions()->sync($request->permissions);
        }

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('User menambahkan role baru: ' . $request->name);

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('User mengubah role dari ' . $role->name . ' menjadi ' . $request->name);

        $role->update(['name' => $request->name]);
        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui');
    }

    public function destroy(Role $role)
    {
        $role->permissions()->detach();
        $role->delete();
        $deleted = 1;

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'deleted_count' => $deleted,
                'method' => request()->method(),
                'ip' => request()->ip(),
            ])
            ->log('Menghapus role: ' . $role->name);

        return back()->with('success', 'Role berhasil dihapus');
    }
}

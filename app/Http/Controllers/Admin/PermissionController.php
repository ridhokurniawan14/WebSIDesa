<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;


class PermissionController extends Controller
{
    public function index(Request $request)
    {
        // Logic Search & Pagination
        $query = Permission::query();

        // Jika ada input pencarian (q)
        if ($request->has('q') && $request->q != '') {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // Ubah angka 10 sesuai keinginan jumlah data per halaman
        $permissions = $query->latest()->paginate(10)->withQueryString()->onEachSide(0);

        return view('admin.pages.permissions.index', compact('permissions'));
    }


    public function create()
    {
        // return view('admin.pages.permissions.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);


        Permission::create($request->only('name'));

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('User menambahkan permission baru: ' . $request->name);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission berhasil ditambahkan');
    }


    public function edit(Permission $permission)
    {
        // return view('admin.pages.permissions.edit', compact('permission'));
    }


    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id
        ]);

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('User mengubah permission dari ' . $permission->name . ' menjadi ' . $request->name);

        $permission->update($request->only('name'));

        return redirect()->route('permissions.index')
            ->with('success', 'Permission berhasil diperbarui');
    }


    public function destroy(Permission $permission)
    {
        $permission->delete();
        $deleted = 1;

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'deleted_count' => $deleted,
                'method' => request()->method(),
                'ip' => request()->ip(),
            ])
            ->log('Menghapus permission: ' . $permission->name);

        return back()->with('success', 'Permission berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        // Menambahkan fitur pencarian & pagination (agar sinkron dengan UI)
        $users = User::with('roles')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.user.index', [
            'users' => $users,
            'roles' => Role::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'roles' => 'required|array'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->sync($request->roles);

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'ip' => request()->ip(),
                'method' => request()->method(),
            ])
            ->log('User menambahkan user baru: ' . $request->name);

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'roles' => 'required|array'
        ]);

        $oldData = $user->only(['name', 'email']); // ambil data lama

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->roles()->sync($request->roles);

        // cek perubahan
        $changes = [];
        foreach ($data as $key => $value) {
            if (($oldData[$key] ?? null) != $value) {
                $changes[$key] = [
                    'old' => $oldData[$key] ?? null,
                    'new' => $value,
                ];
            }
        }

        if (!empty($changes)) {
            activity('user')
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties([
                    'changes' => $changes,
                    'roles' => $request->roles, // bisa juga log roles yang di-sync
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                ])
                ->log('Mengubah data user');
        }

        return redirect()->back()->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();
        $deleted = 1;

        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'deleted_count' => $deleted,
                'method' => request()->method(),
                'ip' => request()->ip(),
            ])
            ->log('Menghapus user: ' . $user->name);

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
    public function __construct()
    {
        $this->middleware('permission:user.view')->only(['index', 'show']);
        $this->middleware('permission:user.create')->only(['create', 'store']);
        $this->middleware('permission:user.update')->only(['edit', 'update']);
        $this->middleware('permission:user.delete')->only(['destroy']);
    }
}

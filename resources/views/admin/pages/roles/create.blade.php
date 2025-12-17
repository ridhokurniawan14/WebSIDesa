@extends('admin.layouts.main')


@section('content')
    <div class="bg-white rounded-xl shadow p-6 max-w-2xl">
        <h1 class="text-xl font-semibold mb-4">{{ isset($role) ? 'Edit' : 'Tambah' }} Role</h1>


        <form method="POST" action="{{ isset($role) ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
            @csrf
            @isset($role)
                @method('PUT')
            @endisset


            <div class="mb-4">
                <label class="block mb-1">Nama Role</label>
                <input type="text" name="name" value="{{ old('name', $role->name ?? '') }}"
                    class="w-full border rounded-lg px-3 py-2" required>
            </div>


            <div class="mb-6">
                <label class="block mb-2">Permissions</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach ($permissions as $permission)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                {{ in_array($permission->id, $rolePermissions ?? []) ? 'checked' : '' }}>
                            {{ $permission->name }}
                        </label>
                    @endforeach
                </div>
            </div>


            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 border rounded-lg">Batal</a>
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
@endsection

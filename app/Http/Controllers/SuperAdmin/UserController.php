<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('alumniProfile')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('super-admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('super-admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'       => ['sometimes', 'string', 'max:255'],
            'email'      => ['sometimes', 'email', 'max:255'],
            'admin_note' => ['nullable', 'string'],
        ]);

        $user->fill($data);
        $user->save();

        return back()->with('success', 'Данные аккаунта сохранены.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('super-admin.users.index')
            ->with('success', 'Пользователь удалён.');
    }

    public function updateStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'verification_status' => 'required|in:pending,verified,rejected,inactive,expired,suspended',
        ]);

        $profile = $user->alumniProfile ?? $user->alumniProfile()->create([
            'verification_status' => 'pending',
        ]);

        $profile->verification_status = $validated['verification_status'];
        $profile->save();

        return back()->with('success', 'Статус верификации обновлён.');
    }

    public function resetPassword(User $user)
    {
        // Заглушка: логика сброса пароля не реализована
        return back()->with('error', 'Сброс пароля ещё не настроен.');
    }
}

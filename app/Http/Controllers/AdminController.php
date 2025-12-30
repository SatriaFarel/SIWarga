<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Agenda;
use App\Models\Artikel;
use App\Models\Informasi;
use App\Services\IuranService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show Admin Dashboard
     *
     * This method prepares all data needed
     * for the main admin dashboard page.
     * 
     * NOTE:
     * - Heavy logic should NOT be placed here
     * - Business logic is delegated to Service (IuranService)
     */
    public function show()
    {
        // Auto-generate monthly iuran when admin opens dashboard
        // This ensures iuran data is always up to date
        IuranService::generateBulanan();

        // Temporary RT profile data
        // Can be moved to database in the future
        $profilRT = [
            'ketua_rt'  => 'Budi Santoso',
            'periode'   => '2023 - 2028',

            'alamat_rt' => 'Jl. Mawar RT 01 RW 05, Pulo Gebang',
            'kelurahan' => 'Pulo Gebang',
            'kecamatan' => 'Cakung',
            'kota'      => 'Jakarta Timur',
        ];

        // Send all required data to admin dashboard view
        return view('admin.dashboard', [

            // Total residents count
            'warga' => Warga::count(),

            // Total articles count
            'artikel' => Artikel::count(),

            // Placeholder for future announcement feature
            'pengumumanList' => null,

            // Latest information / announcement
            'informasi' => Informasi::latest()->first(),

            // Latest 5 articles
            'artikelTerbaru' => Artikel::latest()
                                       ->take(5)
                                       ->get(),

            // RT profile data
            'profilRT' => $profilRT,

            // Nearest upcoming agendas (max 5)
            'agendaTerdekat' => Agenda::where('Tanggal_Mulai', '>=', now())
                                       ->orderBy('Tanggal_Mulai', 'asc')
                                       ->take(5)
                                       ->get(),
        ]);
    }

    /**
     * Display list of admin users
     *
     * Only users with role:
     * - admin
     * - super_admin
     * will be shown here.
     */
    public function index(Request $request)
    {
        $users = User::whereIn('role', ['admin', 'super_admin'])
            // Apply search filter if exists
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.admin', compact('users'));
    }

    /**
     * Show form to create new admin
     */
    public function create()
    {
        return view('admin.form.adminForm');
    }

    /**
     * Store new admin user
     *
     * - Validate input data
     * - Hash password before saving
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,super_admin',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Admin successfully created');
    }

    /**
     * Show edit form for admin
     *
     * Route Model Binding is used here:
     * {user} will be automatically resolved
     * into User model instance.
     */
    public function edit(User $user)
    {
        return view('admin.form.adminForm', compact('user'));
    }

    /**
     * Update admin data
     *
     * Password update is OPTIONAL:
     * - If password field is empty, it will not be changed
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,super_admin',
            'password' => 'nullable|min:6',
        ]);

        // Only update selected fields
        $data = $request->only('name', 'email', 'role');

        // Update password only if filled
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Admin successfully updated');
    }

    /**
     * Delete admin user
     *
     * Protection:
     * - Admin cannot delete their own account
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        return back()->with('success', 'Admin successfully deleted');
    }
}

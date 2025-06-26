<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');
    if ($request->unit) {
        $query->where('unit', $request->unit);
    }
    $users = $query->paginate(10);
    return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'rfid' => 'required|string|unique:users,rfid',
            'unit' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
            'is_admin' => 'required|boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rfid' => $request->rfid,
            'unit' => $request->unit,
            'balance' => $request->balance,
            'is_admin' => $request->is_admin,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function create()
    {
        return view('admin.users-create');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

    public function addSaldo()
    {
        $users = \App\Models\User::orderBy('name')->get();
        return view('admin.users-add-saldo', compact('users'));
    }

    public function addSaldoProcess(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);
        $user->balance += $request->amount;
        $user->save();

        // Catat transaksi untuk user
        \App\Models\Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'type' => 'credit',
            'description' => $request->description ?? 'Penambahan saldo oleh admin',
        ]);

        // Catat transaksi untuk admin (opsional, jika ingin tahu siapa adminnya)
        \App\Models\Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'type' => 'credit',
            'description' => 'Menambah saldo ke user: ' . $user->name . ' (' . $user->email . ')',
        ]);

        return redirect()->route('admin.users')->with('success', 'Saldo berhasil ditambahkan!');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $file);

        // Asumsi data di sheet pertama, baris pertama adalah header
        $rows = $data[0];
        unset($rows[0]); // hapus header

        $skipped = [];

        foreach ($rows as $row) {
            // Cek duplikasi email atau RFID
            $emailExists = \App\Models\User::where('email', $row[1])->exists();
            $rfidExists = \App\Models\User::where('rfid', $row[3])->exists();

            // Jika email atau RFID sudah ada, skip dan catat
            if ($emailExists || $rfidExists) {
                $skipped[] = [
                    'nama' => $row[0] ?? '',
                    'email' => $row[1] ?? '',
                    'rfid' => $row[3] ?? '',
                    'alasan' => $emailExists ? 'Email sudah terdaftar' : 'RFID sudah terdaftar'
                ];
                continue;
            }

            // Jika aman, buat user baru
            \App\Models\User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password' => Hash::make($row[2]),
                'rfid' => $row[3],
                'unit' => $row[4] ?? null,
                'balance' => $row[5] ?? 0,
                'is_admin' => $row[6] ?? 0,
            ]);
        }

        // Buat notifikasi
        if (count($skipped) > 0) {
            $msg = 'Import selesai. ' . count($skipped) . ' data dilewati karena email atau RFID sudah terdaftar:<br><ul>';
            foreach ($skipped as $skip) {
                $msg .= '<li>' . $skip['nama'] . ' (' . $skip['email'] . ', RFID: ' . $skip['rfid'] . ') - ' . $skip['alasan'] . '</li>';
            }
            $msg .= '</ul>';
            return back()->with('warning', $msg)->with('success', 'Sebagian user berhasil diimport.');
        }

        return redirect()->route('admin.users')->with('success', 'Import user berhasil!');
    }
    public function importSaldo(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $file);

        $rows = $data[0];
        unset($rows[0]); // hapus header

        $skipped = [];
        $updated = 0;

        foreach ($rows as $row) {
            $email = $row[0] ?? null;
            $amount = $row[1] ?? 0;

            $user = \App\Models\User::where('email', $email)->first();
            if (!$user) {
                $skipped[] = $email;
                continue;
            }

            $user->balance += $amount;
            $user->save();

            // Catat transaksi
            \App\Models\Transaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'credit',
                'description' => 'Tambah saldo massal via import',
            ]);

            $updated++;
        }

        $msg = "$updated user saldo berhasil ditambah.";
        if (count($skipped) > 0) {
            $msg .= ' Email berikut tidak ditemukan: ' . implode(', ', $skipped);
            return back()->with('warning', $msg);
        }
        return back()->with('success', 'Tambah saldo massal berhasil!');
    }
}
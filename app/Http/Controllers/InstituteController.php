<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstituteController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        // URL base API Anda (sesuaikan dengan endpoint API)
        $this->apiBaseUrl = env('API_BASE_URL');
    }

    public function index()
    {
        // Panggil API untuk mendapatkan daftar institusi
        $response = Http::get("{$this->apiBaseUrl}/institutions");

        if ($response->successful()) {
            $institutes = $response->json(); // Ambil data JSON dari API
            return view('institute', compact('institutes'));
        }

        return redirect()->back()->withErrors('Gagal mendapatkan data institusi.');
    }

    public function create()
    {
        return view('addUserInstitute'); // Tampilan tambah institusi
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'npsn' => 'required|char|size:10',
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'educational_level' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|unique:institutes,email',
            'account_number' => 'required|string|max:255',
        ]);

        // Kirim data ke API untuk disimpan
        $response = Http::post("{$this->apiBaseUrl}/institutions", $validated);

        if ($response->successful()) {
            return redirect()->route('institute.index')->with('success', 'Institusi berhasil ditambahkan.');
        }

        return redirect()->back()->withErrors('Gagal menambahkan institusi.');
    }

    public function edit($id)
    {
        // Panggil API untuk mendapatkan detail institusi
        $response = Http::get("{$this->apiBaseUrl}/institutions/{$id}");

        if ($response->successful()) {
            $institute = $response->json();
            return view('editInstitute', compact('institute'));
        }

        return redirect()->back()->withErrors('Gagal mendapatkan data institusi.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:institutes,email,' . $id,
        ]);

        // Kirim data yang diperbarui ke API
        $response = Http::put("{$this->apiBaseUrl}/institutions/{$id}", $validated);

        if ($response->successful()) {
            return redirect()->route('institute.index')->with('success', 'Institusi berhasil diperbarui.');
        }

        return redirect()->back()->withErrors('Gagal memperbarui institusi.');
    }

    public function destroy($id)
    {
        // Panggil API untuk menghapus data institusi
        $response = Http::delete("{$this->apiBaseUrl}/institutions/{$id}");

        if ($response->successful()) {
            return redirect()->route('institute.index')->with('success', 'Institusi berhasil dihapus.');
        }

        return redirect()->back()->withErrors('Gagal menghapus institusi.');
    }
}

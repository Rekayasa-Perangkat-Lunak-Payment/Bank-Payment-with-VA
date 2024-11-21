<?php

namespace App\Http\Controllers;

use App\Models\PaymentPeriod;
use Illuminate\Http\Request;

class PaymentPeriodController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data filter
        $filterPeriode = $request->get('filterPeriode');

        // Ambil daftar periode bayar, filter jika ada parameter
        $periods = PaymentPeriod::when($filterPeriode, function ($query, $filterPeriode) {
            $query->where('id', $filterPeriode);
        })->get();

        // Ambil daftar semua periode untuk dropdown filter
        $availablePeriods = PaymentPeriod::all();

        return view('paymentPeriod', compact('periods', 'availablePeriods'));
    }

    public function edit($id)
    {
        $period = PaymentPeriod::findOrFail($id);
        return view('editPaymentPeriod', compact('period'));
    }

    public function update(Request $request, $id)
    {
        $period = PaymentPeriod::findOrFail($id);

        // Validasi input
        $request->validate([
            'periode' => 'required|string|max:255',
            'dibayar' => 'required|numeric',
            'belum_dibayar' => 'required|numeric',
        ]);

        // Update data
        $period->update($request->all());

        return redirect()->route('payment-period.index')->with('success', 'Periode pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $period = PaymentPeriod::findOrFail($id);
        $period->delete();

        return redirect()->route('payment-period.index')->with('success', 'Periode pembayaran berhasil dihapus.');
    }
}

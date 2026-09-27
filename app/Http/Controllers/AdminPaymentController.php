<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    private function checkAdmin()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->user()->is_admin) {
            abort(403);
        }

        return null;
    }

    public function edit()
    {
        $check = $this->checkAdmin();

        if ($check) {
            return $check;
        }

        $settings = PaymentSetting::first();

        if (!$settings) {
            $settings = PaymentSetting::create([
                'bank_name' => '',
                'account_number' => '',
                'account_holder' => '',
                'qris_image' => 'qris.png',
                'qris_enabled' => true,
                'transfer_enabled' => true,
                'cod_enabled' => true,
            ]);
        }

        return view('admin.payment.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $check = $this->checkAdmin();

        if ($check) {
            return $check;
        }

        $request->validate([
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:100',
            'account_holder' => 'nullable|string|max:150',
            'qris_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $settings = PaymentSetting::first();

        if (!$settings) {
            $settings = new PaymentSetting();
        }

        $settings->bank_name = $request->bank_name;
        $settings->account_number = $request->account_number;
        $settings->account_holder = $request->account_holder;

        $settings->qris_enabled = $request->has('qris_enabled');
        $settings->transfer_enabled = $request->has('transfer_enabled');
        $settings->cod_enabled = $request->has('cod_enabled');

        if ($request->hasFile('qris_image')) {

            $imageName = 'qris_' . time() . '.' .
                $request->file('qris_image')->getClientOriginalExtension();

            $request->file('qris_image')->move(
                public_path('img'),
                $imageName
            );

            $settings->qris_image = $imageName;
        }

        if (!$settings->qris_image) {
            $settings->qris_image = 'qris.png';
        }

        $settings->save();

        return redirect('/admin/payment-settings')
            ->with('success', 'Pengaturan pembayaran berhasil disimpan!');
    }
}
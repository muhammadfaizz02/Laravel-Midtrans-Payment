<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use App\Services\TwilioService;

class MidtransController extends Controller
{
    public function index()
    {
        return view('payment');
    }

    public function checkout(Request $request)
    {
        // Setup Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') == 'true';
        Config::$isSanitized = true;

        $request->validate([
            'payment_method' => 'required',
            'bank' => 'required_if:payment_method,bank_transfer',
        ]);

        $orderId = 'ORDER-' . time();
        $amount = 100000;

        // Simpan transaksi awal ke database
        $transaction = Transaction::create([
            'user_id' => 1,
            'order_id' => $orderId,
            'amount' => $amount,
            'payment_type' => 'snap',
            'status' => 'pending',
        ]);

        // Parameter Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => 'Customer',
                'email' => 'customer@example.com',
                'phone' => '08123456789',
            ],
        ];

        // Jika transfer bank
        if ($request->payment_method === 'bank_transfer' && $request->bank) {
            $params['payment_type'] = 'bank_transfer';
            $params['bank_transfer'] = [
                'bank' => $request->bank
            ];
        }

        try {
            $snapToken = Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);

            return view('checkout', compact('snapToken'));
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat pembayaran.');
        }
    }

    public function handleCallback(Request $request)
    {
        Log::info('Midtrans callback received', $request->all());
        Log::info('== CALLBACK MASUK ==');

        $payload = $request->getContent();
        Log::info('PAYLOAD:', [$payload]);

        try {
            $notif = new Notification();
            $orderId = $notif->order_id;
            $transactionStatus = $notif->transaction_status;
            $paymentType = $notif->payment_type ?? 'unknown';

            Log::info("Callback Order ID: $orderId, Status: $transactionStatus");

            $transaction = Transaction::where('order_id', $orderId)->first();

            if ($transaction) {
                $transaction->status = $transactionStatus;
                $transaction->payment_type = $paymentType;
                $transaction->save();

                if ($transactionStatus === 'settlement') {
                    $message = "✅ Pembayaran #{$orderId} berhasil!";
                    (new TwilioService())->sendWhatsApp('+6281395163254', $message);
                }

                return response()->json(['status' => 'updated']);
            }

            return response()->json(['status' => 'not_found'], 404);
        } catch (\Exception $e) {
            Log::error('Callback Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
    public function list()
    {
        $transactions = \App\Models\Transaction::latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function checkStatus($orderId)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') == 'true';

        try {
            $status = \Midtrans\Transaction::status($orderId);

            $transaction = \App\Models\Transaction::where('order_id', $orderId)->first();

            if ($transaction) {
                $transaction->status = data_get($status, 'transaction_status');
                $transaction->payment_type = data_get($status, 'payment_type');
                $transaction->save();
            }

            return redirect()->route('transactions.index')->with('success', "Status transaksi $orderId diperbarui.");
        } catch (\Exception $e) {
            return redirect()->route('transactions.index')->with('error', "Gagal cek status: " . $e->getMessage());
        }
    }
}

@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 space-y-6">
    <h1 class="text-2xl font-bold mb-4">📋 Daftar Transaksi</h1>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Transaksi --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
            <thead class="bg-gray-100 text-left text-gray-700 text-sm uppercase">
                <tr>
                    <th class="py-2 px-4 border-b">Order ID</th>
                    <th class="py-2 px-4 border-b">Jumlah</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Tipe Pembayaran</th>
                    <th class="py-2 px-4 border-b">Dibuat</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $trx)
                    <tr class="hover:bg-gray-50 text-sm">
                        <td class="py-2 px-4 border-b">{{ $trx->order_id }}</td>
                        <td class="py-2 px-4 border-b">Rp{{ number_format($trx->amount, 0, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b">
                            @if ($trx->status == 'settlement')
                                <span class="text-green-600 font-semibold">Berhasil</span>
                            @elseif ($trx->status == 'pending')
                                <span class="text-yellow-600 font-semibold">Menunggu</span>
                            @else
                                <span class="text-red-600 font-semibold">{{ ucfirst($trx->status) }}</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">{{ $trx->payment_type ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $trx->created_at->format('d M Y H:i') }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <form action="{{ route('transactions.check', $trx->order_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-blue-600 hover:underline text-sm">🔄 Cek Status</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">Belum ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

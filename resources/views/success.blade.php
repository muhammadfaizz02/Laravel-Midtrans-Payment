@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-green-100 flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-xl w-full max-w-md p-8 text-center space-y-4">
        <h1 class="text-3xl font-bold text-green-600">✅ Pembayaran Berhasil!</h1>
        <p class="text-gray-700">Terima kasih! Pembayaran Anda telah berhasil dikonfirmasi.</p>
        <a href="/" class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Kembali ke Halaman Utama
        </a>
    </div>
</div>
@endsection

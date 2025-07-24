<!DOCTYPE html>
<html>
<head>
    <title>Form Pembayaran</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 py-12">
    <div class="max-w-xl mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-xl font-bold mb-4">🔐 Pilih Metode Pembayaran</h2>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 p-3 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-semibold">Metode Pembayaran</label>
                <select name="payment_method" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih --</option>
                    <option value="bank_transfer">Transfer Bank</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Pilih Bank</label>
                <select name="bank" class="w-full border p-2 rounded">
                    <option value="">-- Pilih Bank --</option>
                    <option value="bca">BCA</option>
                    <option value="bni">BNI</option>
                    <option value="bri">BRI</option>
                </select>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                Bayar Sekarang
            </button>
        </form>
    </div>
</body>
</html>

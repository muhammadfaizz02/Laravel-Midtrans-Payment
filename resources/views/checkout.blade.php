<!DOCTYPE html>
<html>
<head>
    <title>Midtrans Checkout</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>
<body>
    <script type="text/javascript">
        window.onload = function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    alert("Pembayaran berhasil!");
                    console.log(result);
                },
                onPending: function(result){
                    alert("Menunggu pembayaran...");
                    console.log(result);
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                    console.log(result);
                },
                onClose: function(){
                    alert("Transaksi dibatalkan.");
                }
            });
        }
    </script>
</body>
</html>

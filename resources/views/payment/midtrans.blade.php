@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Pembayaran via Midtrans</h1>
            <p class="text-gray-600 mb-8">Silakan selesaikan pembayaran dengan metode pilihan Anda</p>

            <div id="snap-container" class="my-8"></div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mt-8">
                <p class="text-sm text-blue-700">
                    <strong>ℹ️ Info:</strong> Jangan tutup halaman ini sampai pembayaran selesai.
                </p>
            </div>

            <a href="{{ route('home') }}" class="inline-block mt-8 text-blue-600 hover:text-blue-700">← Kembali</a>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    snap.embed('{{ $snapToken }}', {
        embedId: 'snap-container',
        onSuccess: function(result){
            console.log('Success:', result);
            window.location.href = '{{ route("dashboard") }}?payment_status=success';
        },
        onPending: function(result){
            console.log('Pending:', result);
        },
        onError: function(result){
            console.log('Error:', result);
            alert('Pembayaran gagal. Silakan coba lagi.');
        },
        onClose: function(){
            console.log('Customer closed the popup without finishing the payment');
        }
    });
</script>
@endsection

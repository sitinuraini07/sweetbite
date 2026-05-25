@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 4rem auto; padding: 0 2rem; text-align: center;">
    <div style="background: #fff; border-radius: var(--radius-lg); padding: 4rem 2rem; box-shadow: var(--shadow-lg);">
        <div style="background: #fdf2f8; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
            <i class="fas fa-credit-card text-strawberry" style="font-size: 2rem;"></i>
        </div>
        
        <h1 class="font-heading" style="font-size: 2.2rem; margin-bottom: 0.5rem;">Selesaikan Pembayaran</h1>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">Order ID: #SB-{{ $transaction->id }}</p>

        <div style="background: var(--bg-soft); padding: 2rem; border-radius: 1.5rem; margin-bottom: 2.5rem; text-align: left; border: 1px solid rgba(107, 62, 38, 0.05);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <span style="color: var(--text-muted); font-weight: 500;">Total yang harus dibayar</span>
                <span style="font-weight: 800; font-size: 1.6rem; color: var(--primary);">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
            </div>
            <p style="font-size: 0.85rem; color: var(--text-muted); border-top: 1px solid rgba(0,0,0,0.05); padding-top: 1rem; margin-top: 1rem;">
                <i class="fas fa-info-circle mr-1"></i> Selesaikan pembayaran dalam 24 jam untuk mengamankan pesanan manis Anda.
            </p>
        </div>

        <div class="d-grid gap-3">
            <button id="pay-button" class="btn btn-secondary btn-block rounded-pill py-3 font-weight-bold shadow-lg" style="font-size: 1.1rem;">
                Bayar Sekarang 💳
            </button>
            <a href="/profile" class="text-muted mt-3 d-inline-block small text-decoration-none">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Profil
            </a>
        </div>
        
        <div class="mt-5 pt-4 border-top border-light">
            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/Midtrans_logo.png" alt="Midtrans Secured" style="height: 25px; opacity: 0.6;">
        </div>
    </div>
</div>

<form action="/pay/success/{{ $transaction->id }}" id="submit-form" method="POST" style="display: none;">
    @csrf
</form>

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        // SnapToken acquired from previous step
        snap.pay('{{ $snapToken }}', {
            // Optional
            onSuccess: function (result) {
                /* You may add your own js here, this is just example */
                document.getElementById('submit-form').submit();
            },
            // Optional
            onPending: function (result) {
                /* You may add your own js here, this is just example */
                window.location.href = '/profile';
            },
            // Optional
            onError: function (result) {
                /* You may add your own js here, this is just example */
                alert('Pembayaran gagal, silakan coba lagi.');
            }
        });
    };
</script>
@endsection
@endsection

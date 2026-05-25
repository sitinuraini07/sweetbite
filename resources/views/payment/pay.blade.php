@extends('layouts.app')

@section('content')
<h2>Payment</h2>
<p>Total: Rp {{ $transaction->total_price }}</p>
<button>Bayar Sekarang</button>
@endsection
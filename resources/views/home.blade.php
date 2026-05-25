@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 4rem auto; padding: 0 2rem;">
    <div style="background: #fff; border-radius: var(--radius); padding: 3rem; box-shadow: var(--shadow); text-align: center;">
        <h1 class="font-heading" style="font-size: 2rem; margin-bottom: 1rem;">Welcome back, {{ Auth::user()->name }}!</h1>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">You are successfully logged in to your SweetBite account.</p>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <a href="/products" class="btn-primary">Browse Menu</a>
            <a href="/cart" class="btn-secondary" style="padding: 1rem 2.5rem; border-radius: 100px; text-decoration: none; border: 2px solid var(--primary); color: var(--primary); font-weight: 600;">View Cart</a>
        </div>
    </div>
</div>
@endsection

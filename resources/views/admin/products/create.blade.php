@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-chocolate font-weight-bold">Tambah Produk Baru</h2>
                <a href="/admin/products" class="btn btn-outline-chocolate rounded-pill px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-lg rounded-lg p-4">
                <form action="/admin/products" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-chocolate">Kategori Produk</label>
                        <select name="category_id" class="form-control rounded-pill border-0 shadow-sm bg-light px-4" style="height: 50px;" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-chocolate">Nama Produk</label>
                        <input type="text" name="name" class="form-control rounded-pill border-0 shadow-sm bg-light px-4" style="height: 50px;" placeholder="Contoh: Strawberry Cheesecake" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-chocolate">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control rounded-pill border-0 shadow-sm bg-light px-4" style="height: 50px;" placeholder="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-chocolate">Stock</label>
                                <input type="number" name="stock" class="form-control rounded-pill border-0 shadow-sm bg-light px-4" style="height: 50px;" placeholder="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-chocolate">Deskripsi Produk</label>
                        <textarea name="description" class="form-control rounded-lg border-0 shadow-sm bg-light px-4 py-3" rows="4" placeholder="Jelaskan kelezatan produk ini..."></textarea>
                    </div>

                    <div class="form-group mb-5">
                        <label class="font-weight-bold text-chocolate">Foto Produk</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="customFile" required>
                            <label class="custom-file-label border-0 shadow-sm bg-light rounded-pill px-4 d-flex align-items-center" for="customFile" style="height: 50px;">Pilih Gambar</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-secondary btn-block btn-pill py-3 font-weight-bold shadow-lg">
                        Simpan Produk ✨
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .text-chocolate { color: #5D4037; }
    .btn-outline-chocolate { color: #5D4037; border-color: #5D4037; }
    .btn-outline-chocolate:hover { background-color: #5D4037; color: white; }
    .custom-file-label::after {
        content: "Browse";
        height: 50px;
        display: flex;
        align-items: center;
        background: var(--primary);
        color: white;
        border-radius: 0 50px 50px 0;
        padding: 0 20px;
    }
</style>

<script>
    document.querySelector('.custom-file-input').addEventListener('change',function(e){
        var fileName = document.getElementById("customFile").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    })
</script>
@endsection
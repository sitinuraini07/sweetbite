@extends('layouts.app')

@section('content')
<div class="edit-profile-header py-3 px-3 d-flex align-items-center bg-white border-bottom position-sticky t-0 z-index-100">
    <a href="{{ route('profile.index') }}" class="text-primary mr-3">
        <i data-lucide="arrow-left" style="width: 24px;"></i>
    </a>
    <h5 class="mb-0 font-weight-bold">Ubah Profil</h5>
</div>

<div class="container py-4">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Profile Photo -->
        <div class="card border-0 shadow-sm rounded-lg mb-4">
            <div class="card-body text-center py-4">
                <div class="position-relative d-inline-block">
                    @if($user->profile_photo)
                        <img id="preview" src="{{ asset($user->profile_photo) }}" class="rounded-circle border" style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                        <div id="preview-placeholder" class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary border" style="width: 100px; height: 100px; font-size: 40px; font-weight: bold;">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                    <label for="profile_photo" class="position-absolute b-0 r-0 bg-white border rounded-circle p-2 shadow-sm" style="bottom: 0; right: 0; cursor: pointer;">
                        <i data-lucide="camera" style="width: 16px; color: var(--primary);"></i>
                    </label>
                    <input type="file" name="profile_photo" id="profile_photo" class="d-none" onchange="previewImage(this)">
                </div>
                <div class="mt-2 small text-muted"><i data-lucide="edit-3" style="width: 12px;" class="mr-1"></i> Ubah</div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4 small">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4 small">
                <ul class="mb-0 pl-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Basic Info -->
        <div class="card border-0 shadow-sm rounded-lg mb-3">
            <div class="list-group list-group-flush">
                <div class="list-group-item border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-4 small font-weight-bold">Nama</div>
                        <div class="col-8">
                            <input type="text" name="name" class="form-control-plaintext text-right small p-0" value="{{ $user->name }}" placeholder="Atur Sekarang >" required>
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-top py-3">
                    <div class="row align-items-center">
                        <div class="col-4 small font-weight-bold">Bio</div>
                        <div class="col-8">
                            <input type="text" name="bio" class="form-control-plaintext text-right small p-0" value="{{ $user->bio }}" placeholder="Atur Sekarang >">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Info -->
        <div class="card border-0 shadow-sm rounded-lg mb-3">
            <div class="list-group list-group-flush">
                <div class="list-group-item border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-4 small font-weight-bold">Jenis Kelamin</div>
                        <div class="col-8">
                            <select name="gender" class="form-control-plaintext text-right small p-0 text-primary">
                                <option value="" {{ !$user->gender ? 'selected' : '' }}>Atur Sekarang ></option>
                                <option value="Laki-laki" {{ $user->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ $user->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-top py-3">
                    <div class="row align-items-center">
                        <div class="col-4 small font-weight-bold">Tanggal Lahir</div>
                        <div class="col-8 text-right">
                            <input type="date" name="birthdate" class="form-control-plaintext text-right small p-0 text-primary" value="{{ $user->birthdate }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="card border-0 shadow-sm rounded-lg mb-4">
            <div class="list-group list-group-flush">
                <div class="list-group-item border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col-4 small font-weight-bold">No. Handphone</div>
                        <div class="col-8">
                            <input type="text" name="phone_number" class="form-control-plaintext text-right small p-0" value="{{ $user->phone_number }}" placeholder="Atur Sekarang >">
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-top py-3">
                    <div class="row align-items-center">
                        <div class="col-4 small font-weight-bold">Email</div>
                        <div class="col-8 d-flex justify-content-end align-items-center">
                            <input type="email" name="email" class="form-control-plaintext text-right small p-0 mr-2" value="{{ $user->email }}" required>
                            <span class="text-primary small">Verifikasi ></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block rounded-pill py-2 shadow-sm font-weight-bold mb-4">Simpan Perubahan</button>
    </form>

    <hr class="my-4">

    <!-- Addresses -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 font-weight-bold">Alamat Saya</h6>
        <button class="btn btn-outline-primary btn-sm rounded-pill px-3" data-toggle="modal" data-target="#addAddressModal" style="font-size: 0.7rem;">
            + Tambah Alamat
        </button>
    </div>

    @if($addresses->isEmpty())
        <div class="card border-0 shadow-sm rounded-lg mb-4">
            <div class="card-body text-center py-4">
                <p class="text-muted small mb-0">Belum ada alamat yang tersimpan.</p>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-lg mb-4">
            <div class="list-group list-group-flush">
                @foreach($addresses as $address)
                    <div class="list-group-item p-3 border-0 border-top d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 font-weight-bold small text-primary">{{ $address->alamat_lengkap }}</p>
                            <p class="text-muted mb-0" style="font-size: 0.7rem;">{{ $address->phone_number }} | {{ $address->postal_code }}</p>
                        </div>
                        <button class="btn btn-link text-primary p-0 small font-weight-bold" data-toggle="modal" data-target="#editAddressModal{{ $address->id }}">Edit</button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Modals for Addresses -->
@foreach($addresses as $address)
<div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg">
            <form action="{{ route('profile.address.update', $address->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">Edit Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="small font-weight-bold">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control bg-light border-0" rows="3" required>{{ $address->alamat_lengkap }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Kode Pos</label>
                                <input type="text" name="postal_code" class="form-control bg-light border-0" value="{{ $address->postal_code }}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Nomor Telepon</label>
                                <input type="text" name="phone_number" class="form-control bg-light border-0" value="{{ $address->phone_number }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary px-4 rounded-pill">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg">
            <form action="{{ route('profile.address.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">Tambah Alamat Baru</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="small font-weight-bold">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control bg-light border-0" rows="3" required placeholder="Contoh: Jl. Mawar No. 123, Jakarta Selatan"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Kode Pos</label>
                                <input type="text" name="postal_code" class="form-control bg-light border-0" required placeholder="12345">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Nomor Telepon</label>
                                <input type="text" name="phone_number" class="form-control bg-light border-0" required placeholder="08123456789">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary px-4 rounded-pill">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body { background-color: #FFF9F6; }
    main { padding-top: 0 !important; }
    nav { display: none !important; }
    .text-primary { color: #5D4037 !important; }
    .btn-primary { background-color: #5D4037; border-color: #5D4037; color: white; }
    .btn-primary:hover { background-color: #4E342E; border-color: #4E342E; color: white; }
    .form-control-plaintext { color: #5D4037; }
    .form-control-plaintext::placeholder { color: #F28CAB; }
    select.form-control-plaintext { appearance: none; -webkit-appearance: none; color: #F28CAB; }
</style>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('preview');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    var placeholder = document.getElementById('preview-placeholder');
                    var img = document.createElement('img');
                    img.id = 'preview';
                    img.src = e.target.result;
                    img.className = 'rounded-circle border';
                    img.style = 'width: 100px; height: 100px; object-fit: cover;';
                    placeholder.parentNode.replaceChild(img, placeholder);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

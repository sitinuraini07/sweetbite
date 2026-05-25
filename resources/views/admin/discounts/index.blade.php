@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-chocolate font-weight-bold">Manajemen Diskon</h2>
        <button class="btn btn-chocolate rounded-pill px-4 shadow-sm" data-toggle="modal" data-target="#addDiscountModal">
            <i class="fas fa-plus mr-2"></i> Tambah Diskon Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr class="text-chocolate">
                        <th class="border-0 px-4 py-3">Nama</th>
                        <th class="border-0 py-3">Persentase</th>
                        <th class="border-0 py-3">Hari Aktif</th>
                        <th class="border-0 py-3">Bulan Aktif</th>
                        <th class="border-0 py-3 text-center">Status</th>
                        <th class="border-0 px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($discounts as $d)
                    <tr>
                        <td class="px-4 py-4 align-middle font-weight-bold text-chocolate">{{ $d->name }}</td>
                        <td class="py-4 align-middle">
                            <span class="badge badge-pill badge-strawberry px-3 py-2">{{ $d->percentage }}%</span>
                        </td>
                        <td class="py-4 align-middle text-muted small">
                            {{ $d->active_days ?: 'Setiap Hari' }}
                        </td>
                        <td class="py-4 align-middle text-muted small">
                            @if($d->active_months)
                                @php
                                    $months = explode(',', $d->active_months);
                                    $monthNames = [
                                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 
                                        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 
                                        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                                    ];
                                    $display = [];
                                    foreach($months as $m) $display[] = $monthNames[$m];
                                    echo implode(', ', $display);
                                @endphp
                            @else
                                Setiap Bulan
                            @endif
                        </td>
                        <td class="py-4 align-middle text-center">
                            @if($d->is_active)
                                <span class="badge badge-pill badge-soft-success px-3 py-2 font-weight-bold">AKTIF</span>
                            @else
                                <span class="badge badge-pill badge-soft-secondary px-3 py-2 font-weight-bold">NON-AKTIF</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 align-middle text-right">
                            <button class="btn btn-sm btn-outline-chocolate rounded-circle px-3 mr-2" data-toggle="modal" data-target="#editModal{{ $d->id }}" data-tooltip="tooltip" data-placement="top" title="Edit Diskon">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('discounts.destroy', $d->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-circle px-3" onclick="return confirm('Hapus diskon ini?')" data-tooltip="tooltip" data-placement="top" title="Hapus Diskon">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $d->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 shadow rounded-lg">
                                <form action="{{ route('discounts.update', $d->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title font-weight-bold">Edit Diskon</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body pt-0">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Nama Promo</label>
                                            <input type="text" name="name" class="form-control bg-light border-0" value="{{ $d->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Persentase (%)</label>
                                            <input type="number" name="percentage" class="form-control bg-light border-0" value="{{ $d->percentage }}" min="0" max="100" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Banner Promo (Opsional)</label>
                                            @if($d->banner_image)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $d->banner_image) }}" class="rounded" style="height: 50px;">
                                                </div>
                                            @endif
                                            <input type="file" name="banner_image" class="form-control-file">
                                        </div>
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Hari Aktif (Kosongkan untuk setiap hari)</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                    <div class="custom-control custom-checkbox mr-3">
                                                        <input type="checkbox" name="active_days[]" value="{{ $day }}" class="custom-control-input" id="editDay{{ $d->id }}{{ $day }}" {{ str_contains($d->active_days, $day) ? 'checked' : '' }}>
                                                        <label class="custom-control-label small" for="editDay{{ $d->id }}{{ $day }}">{{ $day }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Bulan Aktif (Kosongkan untuk setiap bulan)</label>
                                            <div class="row">
                                                @php $monthNames = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des']; @endphp
                                                @foreach($monthNames as $num => $name)
                                                    <div class="col-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="active_months[]" value="{{ $num }}" class="custom-control-input" id="editMonth{{ $d->id }}{{ $num }}" {{ str_contains($d->active_months, (string)$num) ? 'checked' : '' }}>
                                                            <label class="custom-control-label small" for="editMonth{{ $d->id }}{{ $num }}">{{ $name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="is_active" class="custom-control-input" id="editActive{{ $d->id }}" {{ $d->is_active ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="editActive{{ $d->id }}">Aktifkan Promo</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="submit" class="btn btn-strawberry btn-block rounded-pill">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addDiscountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-lg">
            <form action="{{ route('discounts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title font-weight-bold">Tambah Diskon Baru</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="form-group">
                        <label class="small font-weight-bold">Nama Promo</label>
                        <input type="text" name="name" class="form-control bg-light border-0" placeholder="Contoh: Weekend Sale" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Persentase (%)</label>
                        <input type="number" name="percentage" class="form-control bg-light border-0" placeholder="10" min="0" max="100" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Banner Promo (Opsional - Muncul di Home)</label>
                        <input type="file" name="banner_image" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Hari Aktif (Kosongkan untuk setiap hari)</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <div class="custom-control custom-checkbox mr-3">
                                    <input type="checkbox" name="active_days[]" value="{{ $day }}" class="custom-control-input" id="addDay{{ $day }}">
                                    <label class="custom-control-label small" for="addDay{{ $day }}">{{ $day }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Bulan Aktif (Kosongkan untuk setiap bulan)</label>
                        <div class="row">
                            @foreach([1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'] as $num => $name)
                                <div class="col-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="active_months[]" value="{{ $num }}" class="custom-control-input" id="addMonth{{ $num }}">
                                        <label class="custom-control-label small" for="addMonth{{ $num }}">{{ $name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="is_active" class="custom-control-input" id="addActive" checked>
                        <label class="custom-control-label" for="addActive">Aktifkan Promo</label>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-chocolate btn-block rounded-pill">Tambah Diskon</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .text-chocolate { color: #5D4037; }
    .btn-chocolate { background-color: #5D4037; color: white; }
    .btn-chocolate:hover { background-color: #4E342E; color: white; }
    .btn-outline-chocolate { color: #5D4037; border-color: #5D4037; }
    .btn-outline-chocolate:hover { background-color: #5D4037; color: white; }
    .badge-strawberry { background-color: #F28CAB; color: white; }
    .badge-soft-success { background-color: #E8F5E9; color: #2E7D32; }
    .badge-soft-secondary { background-color: #F5F5F5; color: #757575; }
    .gap-2 { gap: 0.5rem; }
</style>
@endsection

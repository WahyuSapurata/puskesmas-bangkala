@extends('layouts.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('style')
@endpush

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-fluid" id="kt_content_container">
        @include('components.alert')
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    Data Pengajuan Nomor Surat : {{ $pengajuan->nomor_surat }} <br>
                    Status : {{ $pengajuan->status }}
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-50px">No</th>
                            <th class="min-w-100px">Nama</th>
                            <th class="min-w-60px">Kategori</th>
                            <th class="min-w-60px">Jumlah</th>
                            <th class="min-w-60px">Gambar</th>
                            <th class="min-w-50px">Created Date</th>
                            <th class="min-w-50px">Status</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->item->nama }}</td>
                            <td>{{ $item->item->kategori }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>
                                @if ($item->gambar != NULL)
                                    <a href="{{ url(Storage::url($item->gambar)) }}"><img src="{{ url(Storage::url($item->gambar)) }}" width="80px"></a>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y'); }}</td>
                            <td>
                                @if ($item->status_item == NULL)
                                    -
                                @else
                                    @if ($item->status_item == 'TERIMA')
                                        <span class="badge badge-success">{{ $item->status_item }}</span>                                        
                                    @else
                                        <span class="badge badge-danger">{{ $item->status_item }}</span>                                        
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/user-management/permissions/list.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/user-management/permissions/add-pengajuan.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/user-management/permissions/update-permission.js') }}"></script>
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
@endpush

@push('custom-scripts')
@endpush
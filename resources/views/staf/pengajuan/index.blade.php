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
                    
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <a href="{{ route('pengajuan.cetak') }}" class="btn btn-light-primary">
                        <i class="ki-duotone ki-printer fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>Cetak</a>
                </div>
                <!--end::Card toolbar-->
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
                            <th class="min-w-100px">Email</th>
                            <th class="min-w-100px">Nomor Surat</th>
                            <th class="min-w-100px">File Pengajuan</th>
                            <th class="min-w-125px">Created Date</th>
                            <th class="min-w-50">Status</th>
                            <th class="min-w-190">Verifikasi Apoteker</th>
                            <th class="text-end min-w-150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->user->email }}</td>
                            <td>{{ $item->nomor_surat }}</td>
                            <td><a href="{{ url(Storage::url($item->file_pengajuan)) }}" target="_blank">Lihat File</a></td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y'); }}</td>
                            <td>
                                @if ($item->status == NULL)
                                    -
                                @else
                                    @if ($item->status == 'TERIMA')
                                        <span class="badge badge-success">{{ $item->status }}</span>                                        
                                    @elseif ($item->status == 'DIPROSES')
                                        <span class="badge badge-primary">{{ $item->status }}</span>                                        
                                    @else
                                        <span class="badge badge-danger">{{ $item->status }}</span>                                        
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->status_apoteker == NULL && auth()->user()->role != 'apoteker')
                                    -
                                @elseif ($item->status_apoteker == NULL && auth()->user()->role == 'apoteker')
                                    <a href="{{ route('pengajuan.approve-apoteker', $item->id) }}" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                        <i class="ki-duotone ki-check-square fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </a>
                                @else
                                    @if ($item->status_apoteker == 'SELESAI')
                                        <span class="badge badge-success">{{ $item->status_apoteker }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $item->status_apoteker }}</span>                                        
                                    @endif
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('pengajuan.show', $item->id) }}" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                    <i class="ki-duotone ki-file fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        <!--begin::Modal - Add permissions-->
        <div class="modal fade" id="kt_modal_add_permission" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Tambah Data jenis</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-permissions-modal-action="close">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <!--begin::Form-->
                        <form id="kt_modal_add_permission_form" class="form" action="{{ route('jenis.store') }}" method="POST">
                            @csrf
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Nama jenis</span>
                                    <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Nama jenis is required.">
                                        <i class="ki-duotone ki-information fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="Nama Jenis" name="nama_jenis" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3" data-kt-permissions-modal-action="cancel">Discard</button>
                                <button type="submit" class="btn btn-primary" data-kt-permissions-modal-action="submit">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Add permissions-->
    </div>
    <!--end::Container-->
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/user-management/permissions/list.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/user-management/permissions/add-permission.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/user-management/permissions/update-permission.js') }}"></script>
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
@endpush

@push('custom-scripts')
@endpush

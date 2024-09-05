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
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-50px">No</th>
                            <th class="min-w-125px">Name</th>
                            <th class="min-w-200px">Email</th>
                            <th class="min-w-75px">Role</th>
                            <th class="min-w-125px">Created Date</th>
                            <th class="min-w-75px">Status</th>
                            <th class="text-end min-w-150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                {{ $item->email }}
                            </td>
                            <td><span class="badge badge-light-primary fs-7 m-1">{{ $item->role }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y'); }}</td>
                            <td>
                                @if ($item->is_aktif == 1)
                                <span class="badge badge-light-success fs-7 m-1">Aktif</span>
                                @else
                                <span class="badge badge-light-danger fs-7 m-1">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($item->is_aktif != 1)
                                <a href="{{ route('apoteker.approve', $item->id) }}" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                    <i class="ki-duotone ki-setting-3 fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </a>
                                @endif
                                <a href="{{ route('apoteker.destroy', $item->id) }}" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this data?')) {document.getElementById('delete-form-{{ $item->id }}').submit();}">
                                    <i class="ki-duotone ki-trash fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('apoteker.destroy', $item->id) }}" method="POST" style="display: none;">
                                    @method('DELETE')
                                    @csrf
                                </form>
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

<div class="aside-footer flex-column-auto px-6 px-lg-9" id="kt_aside_footer">
  <!--begin::User panel-->
  <div class="d-flex flex-stack ms-7">
    <!--begin::Link-->
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="btn btn-sm btn-icon btn-active-color-primary btn-icon-gray-600 btn-text-gray-600">
        <i class="ki-duotone ki-entrance-left fs-1 me-2">
          <span class="path1"></span>
          <span class="path2"></span>
        </i>
        <!--begin::Major-->
        <span class="d-flex flex-shrink-0 fw-bold">Log Out</span>
        <!--end::Major-->
      </a>
    </form>

    <!--end::Link-->
    <!--begin::User menu-->
    <div class="ms-1">
      <div class="btn btn-sm btn-icon btn-icon-gray-600 btn-active-color-primary position-relative me-n1" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start">
        <i class="ki-duotone ki-setting-2 fs-1">
          <span class="path1"></span>
          <span class="path2"></span>
        </i>
      </div>
      <!--begin::User account menu-->
      <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
        <!--begin::Menu item-->
        <div class="menu-item px-3">
          <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
              <img alt="Logo" src="assets/media/avatars/blank.png" />
            </div>
            <!--end::Avatar-->
            <!--begin::Username-->
            <div class="d-flex flex-column">
              <div class="fw-bold d-flex align-items-center fs-5">{{ auth()->user()->name }}
              <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{ auth()->user()->role }}</span></div>
              <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
            </div>
            <!--end::Username-->
          </div>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->
        <!--begin::Menu item-->
        <div class="menu-item px-5">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="menu-link px-5">Log Out</a>
          </form>
        </div>
        <!--end::Menu item-->
      </div>
      <!--end::User account menu-->
    </div>
    <!--end::User menu-->
  </div>
  <!--end::User panel-->
</div>
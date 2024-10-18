<header id="page-topbar">
  <div class="navbar-header">
    <div class="d-flex">
      <!-- LOGO -->
      <div class="navbar-brand-box">
        <a class="logo logo-dark" href="index">
          <span class="logo-sm">
            <img src="{{ URL::asset('/assets/images/logo.svg') }}" alt="" height="22">
          </span>
          <span class="logo-lg">
            <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="" height="17">
          </span>
        </a>

        <a class="logo logo-light" href="index">
          <span class="logo-sm">
            <img src="{{ URL::asset('/assets/images/logo-light.svg') }}" alt="" height="22">
          </span>
          <span class="logo-lg">
            <img src="{{ URL::asset('/assets/images/logo_dashboard.png') }}" alt="" height="50">
          </span>
        </a>
      </div>

      <button class="btn btn-sm font-size-16 header-item waves-effect px-3" id="vertical-menu-btn" type="button">
        <i class="fa fa-fw fa-bars"></i>
      </button>

      <!-- App Search-->
{{--      <form class="app-search d-none d-lg-block">--}}
{{--        <div class="position-relative">--}}
{{--          <input class="form-control" type="text" placeholder="@lang('translation.Search')">--}}
{{--          <span class="bx bx-search-alt"></span>--}}
{{--        </div>--}}
{{--      </form>--}}
    </div>

    <div class="d-flex">

      <div class="dropdown d-inline-block d-lg-none ms-2">
        <button class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
          data-bs-toggle="dropdown" type="button" aria-haspopup="true" aria-expanded="false">
          <i class="mdi mdi-magnify"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

          <form class="p-3">
            <div class="form-group m-0">
              <div class="input-group">
                <input class="form-control" type="text" aria-label="Search input" placeholder="@lang('translation.Search')">

                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
              </div>
            </div>
          </form>
        </div>
      </div>

      {{-- <div class="dropdown d-inline-block">
        <button class="btn header-item waves-effect" data-bs-toggle="dropdown" type="button" aria-haspopup="true"
          aria-expanded="false">
          @switch(Lang::locale())
            @case('id')
              <img src="{{ URL::asset('/assets/images/flags/indonesia.png') }}" alt="Header Language" height="16">
            @break

            @default
              <img src="{{ URL::asset('/assets/images/flags/us.jpg') }}" alt="Header Language" height="16">
          @endswitch
        </button>
        <div class="dropdown-menu dropdown-menu-end">

          <!-- item-->
          <a class="dropdown-item notify-item language" data-lang="id" href="{{ url('admin/id') }}">
            <img class="me-1" src="{{ URL::asset('/assets/images/flags/indonesia.png') }}" alt="user-image"
              height="12"> <span class="align-middle">Indonesia</span>
          </a>
          <!-- item-->
          <a class="dropdown-item notify-item language" data-lang="eng" href="{{ url('admin/en') }}">
            <img class="me-1" src="{{ URL::asset('/assets/images/flags/us.jpg') }}" alt="user-image" height="12">
            <span class="align-middle">English</span>
          </a>
        </div>
      </div> --}}

      <div class="dropdown d-none d-lg-inline-block ms-1">
        <button class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen" type="button">
          <i class="bx bx-fullscreen"></i>
        </button>
      </div>
{{--      <div class="dropdown d-inline-block">--}}
{{--        <button class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"--}}
{{--          data-bs-toggle="dropdown" type="button" aria-haspopup="true" aria-expanded="false">--}}
{{--          <i class="bx bx-bell bx-tada"></i>--}}
{{--          <span class="badge bg-danger rounded-pill">3</span>--}}
{{--        </button>--}}
{{--        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"--}}
{{--          aria-labelledby="page-header-notifications-dropdown">--}}
{{--          <div class="p-3">--}}
{{--            <div class="row align-items-center">--}}
{{--              <div class="col">--}}
{{--                <h6 class="m-0" key="t-notifications"> @lang('translation.Notifications') </h6>--}}
{{--              </div>--}}
{{--              <div class="col-auto">--}}
{{--                <a class="small" href="#!" key="t-view-all"> @lang('translation.View_All')</a>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <div data-simplebar style="max-height: 230px;">--}}
{{--            <a class="text-reset notification-item" href="">--}}
{{--              <div class="d-flex">--}}
{{--                <div class="avatar-xs me-3">--}}
{{--                  <span class="avatar-title bg-primary rounded-circle font-size-16">--}}
{{--                    <i class="bx bx-cart"></i>--}}
{{--                  </span>--}}
{{--                </div>--}}
{{--                <div class="flex-grow-1">--}}
{{--                  <h6 class="mt-0 mb-1" key="t-your-order">@lang('translation.Your_order_is_placed')</h6>--}}
{{--                  <div class="font-size-12 text-muted">--}}
{{--                    <p class="mb-1" key="t-grammer">@lang('translation.If_several_languages_coalesce_the_grammar')</p>--}}
{{--                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span--}}
{{--                        key="t-min-ago">@lang('translation.3_min_ago')</span></p>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </a>--}}
{{--            <a class="text-reset notification-item" href="">--}}
{{--              <div class="d-flex">--}}
{{--                <img class="me-3 rounded-circle avatar-xs"--}}
{{--                  src="{{ URL::asset('/assets/images/users/userLogo.png') }}" alt="user-pic">--}}
{{--                <div class="flex-grow-1">--}}
{{--                  <h6 class="mt-0 mb-1">@lang('translation.James_Lemire')</h6>--}}
{{--                  <div class="font-size-12 text-muted">--}}
{{--                    <p class="mb-1" key="t-simplified">@lang('translation.It_will_seem_like_simplified_English')</p>--}}
{{--                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span--}}
{{--                        key="t-hours-ago">@lang('translation.1_hours_ago')</span></p>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </a>--}}
{{--            <a class="text-reset notification-item" href="">--}}
{{--              <div class="d-flex">--}}
{{--                <div class="avatar-xs me-3">--}}
{{--                  <span class="avatar-title bg-success rounded-circle font-size-16">--}}
{{--                    <i class="bx bx-badge-check"></i>--}}
{{--                  </span>--}}
{{--                </div>--}}
{{--                <div class="flex-grow-1">--}}
{{--                  <h6 class="mt-0 mb-1" key="t-shipped">@lang('translation.Your_item_is_shipped')</h6>--}}
{{--                  <div class="font-size-12 text-muted">--}}
{{--                    <p class="mb-1" key="t-grammer">@lang('translation.If_several_languages_coalesce_the_grammar')</p>--}}
{{--                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span--}}
{{--                        key="t-min-ago">@lang('translation.3_min_ago')</span></p>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </a>--}}

{{--            <a class="text-reset notification-item" href="">--}}
{{--              <div class="d-flex">--}}
{{--                <img class="me-3 rounded-circle avatar-xs"--}}
{{--                  src="{{ URL::asset('/assets/images/users/userLogo.png') }}" alt="user-pic">--}}
{{--                <div class="flex-grow-1">--}}
{{--                  <h6 class="mt-0 mb-1">@lang('translation.Salena_Layfield')</h6>--}}
{{--                  <div class="font-size-12 text-muted">--}}
{{--                    <p class="mb-1" key="t-occidental">@lang('translation.As_a_skeptical_Cambridge_friend_of_mine_occidental')</p>--}}
{{--                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span--}}
{{--                        key="t-hours-ago">@lang('translation.1_hours_ago')</span></p>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </a>--}}
{{--          </div>--}}
{{--          <div class="border-top d-grid p-2">--}}
{{--            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">--}}
{{--              <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">@lang('translation.View_More')</span>--}}
{{--            </a>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}

      <div class="dropdown d-inline-block">
        <button class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown"
          type="button" aria-haspopup="true" aria-expanded="false">
          <img class="rounded-circle header-profile-user"
            src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/assets/images/users/userLogo.png') }}"
            alt="Header Avatar">
          <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ ucfirst(Auth::user()->name) }}</span>
          <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
          <!-- item-->
{{--          <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 me-1 align-middle"></i> <span--}}
{{--              key="t-profile">@lang('translation.Profile')</span></a>--}}
{{--          <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 me-1 align-middle"></i> <span--}}
{{--              key="t-my-wallet">@lang('translation.My_Wallet')</span></a>--}}
          <a class="dropdown-item d-block" data-bs-toggle="modal" data-bs-target=".change-password"
            href="#"><span class="badge bg-success float-end"></span><i
              class="bx bx-wrench font-size-16 me-1 align-middle"></i> <span
              key="t-settings">@lang('translation.Settings')</span></a>
{{--          <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 me-1 align-middle"></i>--}}
{{--            <span key="t-lock-screen">@lang('translation.Lock_screen')</span></a>--}}
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="javascript:void();"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
              class="bx bx-power-off font-size-16 me-1 text-danger align-middle"></i> <span
              key="t-logout">@lang('translation.Logout')</span></a>
          <form id="logout-form" style="display: none;" action="{{ route('logout') }}" method="POST">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
</header>
<!--  Change-Password example -->
<div class="modal fade change-password" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myLargeModalLabel">Change Password</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="change-password" method="POST">
          @csrf
          <input id="data_id" type="hidden" value="{{ Auth::user()->id }}">
          <div class="mb-3">
            <label for="current_password">Current Password</label>
            <input class="form-control @error('current_password') is-invalid @enderror" id="current-password"
              name="current_password" type="password" value="{{ old('current_password') }}"
              autocomplete="current_password" placeholder="Enter Current Password">
            <div class="text-danger" id="current_passwordError" data-ajax-feedback="current_password"></div>
          </div>

          <div class="mb-3">
            <label for="newpassword">New Password</label>
            <input class="form-control @error('password') is-invalid @enderror" id="password" name="password"
              type="password" autocomplete="new_password" placeholder="Enter New Password">
            <div class="text-danger" id="passwordError" data-ajax-feedback="password"></div>
          </div>

          <div class="mb-3">
            <label for="userpassword">Confirm Password</label>
            <input class="form-control" id="password-confirm" name="password_confirmation" type="password"
              autocomplete="new_password" placeholder="Enter New Confirm password">
            <div class="text-danger" id="password_confirmError" data-ajax-feedback="password-confirm"></div>
          </div>

          <div class="d-grid mt-3">
            <button class="btn btn-primary waves-effect waves-light UpdatePassword" data-id="{{ Auth::user()->id }}"
              type="submit">Update Password</button>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

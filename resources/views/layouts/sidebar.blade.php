<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

  <div class="h-100" data-simplebar>

    <!--- Sidemenu -->
    <div id="sidebar-menu">
      <!-- Left Menu Start -->
      <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" key="t-menu">@lang('translation.Main')</li>

        @can('view-dashboard')
          <li>
            <a class="waves-effect" href="{{ route('root') }}">
              <i class="bx bx-home-circle"></i>
              <span key="t-dashboards">@lang('translation.Dashboards')</span>
            </a>
          </li>
        @endcan

        @if (auth()->user()->can('view-product') ||
                auth()->user()->can('view-category') ||
                auth()->user()->can('view-label') ||
                auth()->user()->can('view-voucher'))
          <li>
            <a class="has-arrow waves-effect" href="javascript: void(0);">
              <i class="bx bx-store"></i>
              <span key="t-ecommerce">@lang('translation.Ecommerce')</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
              @can('view-product')
                <li><a href="{{ route('admin.products.index') }}" key="t-products">@lang('translation.Products')</a></li>
              @endcan
              @can('view-category')
                <li><a href="{{ route('admin.categories.index') }}" key="t-product-category">@lang('translation.Product_Category')</a></li>
              @endcan
              @can('view-label')
                <li><a href="{{ route('admin.labels.index') }}" key="t-product-category">@lang('translation.Product_Label')</a></li>
              @endcan
              {{-- @can('view-voucher')
                <li><a href="{{ route('admin.vouchers.index') }}" key="t-voucher">@lang('translation.Voucher')</a></li>
              @endcan --}}
            </ul>
          </li>
        @endif

        @can('view-order')
          <li>
            <a class="waves-effect" href="{{ route('admin.orders.index') }}">
              <i class="bx bx-shopping-bag"></i>
              @stack('order-count')
              <span key="t-orders">@lang('translation.Orders')</span>
            </a>
          </li>
        @endcan

        @can('view-forecast')
          <li style="display: none">
            <a class="waves-effect" href="{{ route('admin.forecasting.index') }}">
              <i class="bx bx-stats"></i>
              <span key="t-forecast">Forecasting</span>
            </a>
          </li>
        @endcan

        @if (auth()->user()->can('view-employment') ||
                auth()->user()->can('view-employee') ||
                auth()->user()->can('view-pembelian-barang') ||
                auth()->user()->can('view-supplier') ||
                auth()->user()->can('view-manajemen-penjualan'))
          <li class="menu-title" key="t-data-master">
            @lang('translation.Data_Master')
          </li>
        @endif

        @can('view-employment')
          <li>
            <a class="waves-effect" href="{{ route('admin.employment.index') }}">
              <i class="bx bxs-user-badge"></i>
              <span key="t-employement">@lang('translation.Employment')</span>
            </a>
          </li>
        @endcan

        @can('view-employee')
          <li>
            <a class="waves-effect" href="{{ route('admin.employee.index') }}">
              <i class='bx bxs-user-rectangle'></i>
              <span key="t-employee">@lang('translation.Employees')</span>
            </a>
          </li>
        @endcan

        @can('view-pembelian-barang')
          <li>
            <a class="waves-effect" href="{{ route('admin.purchases.index') }}">
              <i class="bx bx-box"></i>
              <span key="t-stock">Pembelian Barang</span>
            </a>
          </li>
        @endcan

        @can('view-supplier')
          <li>
            <a class="waves-effect" href="{{ route('admin.suppliers.index') }}">
              <i class="bx bx-package"></i>
              <span key="t-stock">Supplier</span>
            </a>
          </li>
        @endcan

        @can('view-member')
          <li>
            <a class="waves-effect" href="{{ route('admin.member.index') }}">
              <i class="bx bxs-user-circle"></i>
              <span key="t-stock">Member</span>
            </a>
          </li>
        @endcan

        @can('view-asset')
          <li>
            <a class="waves-effect" href="{{ route('admin.asset.index') }}">
              <i class="bx bx-file"></i>
              <span key="t-stock">Asset</span>
            </a>
          </li>
        @endcan

        @can('view-manajemen-penjualan')
          <li style="display: none">
            <a class="waves-effect" href="{{ route('admin.custom-transaction.index') }}">
              <i class="bx bx-extension"></i>
              <span key="t-stock">Manajemen Penjualan</span>
            </a>
          </li>
        @endcan

        @if (auth()->user()->can('view-salary-payment') ||
                auth()->user()->can('view-debts') ||
                auth()->user()->can('view-receivables'))
          <li class="menu-title" key="t-accounting">@lang('translation.Accounting')</li>
        @endif

        @can('view-salary-payment')
          <li>
            <a class="waves-effect" href="{{ route('admin.salary-payment.index') }}">
              <i class='bx bx-money'></i>
              <span key="t-salary-payment">@lang('translation.Salary-Payment')</span>
            </a>
          </li>
        @endcan

        @can('view-debts')
          <li>
            <a class="waves-effect" href="{{ route('admin.debts.index') }}">
              <i class="bx bx-home-circle"></i>
              <span key="t-debts">@lang('translation.Debts')</span>
            </a>
          </li>
        @endcan

        @can('view-receivables')
          <li>
            <a class="waves-effect" href="{{ route('admin.receivables.index') }}">
              <i class="bx bx-file"></i>
              <span key="t-receivables">@lang('translation.Receivables')</span>
            </a>
          </li>
        @endcan

        @if (auth()->user()->can('view-sales') ||
                auth()->user()->can('view-income-statement') ||
                auth()->user()->can('view-cash-flow'))
          <li class="menu-title" key="t-reports">@lang('translation.Reports')</li>
        @endif

        {{-- @can('view-sales')
          <li>
            <a class="has-arrow waves-effect" href="javascript: void(0);">
              <i class="bx bx-receipt"></i>
              <span key="t-sales">@lang('translation.Sales')</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
              <li><a href="#" key="t-invoice-list">@lang('translation.Invoice_List')</a></li>
              <li><a href="#" key="t-invoice-detail">@lang('translation.Invoice_Detail')</a>
              </li>
            </ul>
          </li>
        @endcan --}}

        @can('view-income-statement')
          <li>
            <a class="waves-effect" href="{{ route('admin.profit-loss.index') }}">
              <i class="bx bx-file"></i>
              <span key="t-income-statement">Laba Rugi</span>
            </a>
          </li>
        @endcan

        @can('view-cash-flow')
          <li>
            <a class="waves-effect" href="{{ route('admin.cash.index') }}">
              <i class="bx bx-file"></i>
              <span key="t-cash-flow">Arus Kas</span>
            </a>
          </li>
        @endcan

        @can('view-report')
          <li>
            <a class="waves-effect" href="{{ route('admin.report.index') }}">
              <i class="bx bx-chart"></i>
              <span key="t-report">Laporan Penjualan</span>
            </a>
          </li>
        @endcan

        @can('view-balance')
          <li>
            <a class="waves-effect" href="{{ route('admin.balance.index') }}">
              <i class="bx bx-file"></i>
              <span key="t-balance">Neraca</span>
            </a>
          </li>
        @endcan

        @if (auth()->user()->can('view-expert-system-symptom') ||
                auth()->user()->can('view-expert-system-pestdisease') ||
                auth()->user()->can('view-expert-system-rulebase'))
          <li class="menu-title" key="t-apps" style="display: none">@lang('translation.Expert_System')</li>
        @endif

        @can('view-expert-system-symptom')
          <li style="display: none">
            <a class="waves-effect" href="{{ route('admin.symptoms.index') }}">
              <i class="bx bx-file"></i>
              <span key="t-cash-flow">@lang('translation.Expert_System_Symptom')</span>
            </a>
          </li>
        @endcan

        @can('view-expert-system-pestdisease')
          <li style="display: none">
            <a class="waves-effect" href="{{ route('admin.pest-diseases.index') }}">
              <i class="bx bx-file"></i>
              <span key="t-cash-flow">@lang('translation.Expert_System_PestDisease')</span>
            </a>
          </li>
        @endcan

        @can('view-expert-system-rulebase')
          <li style="display: none">
            <a class="waves-effect" href="{{ route('admin.rules.index') }}">
              <i class="bx bx-file"></i>
              <span key="t-cash-flow">@lang('translation.Expert_System_RuleBase')</span>
            </a>
          </li>
        @endcan

        @if (auth()->user()->can('view-expert-system-symptom') ||
                auth()->user()->can('view-expert-system-pestdisease') ||
                auth()->user()->can('view-expert-system-rulebase'))
          <li style="display: none">
            <a class="waves-effect" href="{{ route('admin.diagnoses.history') }}">
              <i class="bx bx-file"></i>
              <span key="t-cash-flow">History Diagnosis</span>
            </a>
          </li>
        @endif

        @if (auth()->user()->can('view-cashier') ||
                auth()->user()->can('view-blog') ||
                auth()->user()->can('view-subscription') ||
                auth()->user()->can('view-chat'))
          <li class="menu-title" key="t-apps">@lang('translation.Apps')</li>
        @endif

        @can('view-cashier')
          <li>
            <a class="waves-effect" href="{{ route('admin.cashier.index') }}">
              <i class="bx bx-bx bx-server"></i>
              <span key="t-cashier">@lang('translation.Cashier')</span>
            </a>
          </li>
        @endcan

        {{-- @can('view-blog')
          <li>
            <a class="has-arrow waves-effect" href="javascript: void(0);">
              <i class="bx bx-detail"></i>
              <span key="t-blog">@lang('translation.Blog')</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
              <li><a href="#" key="t-blog-list">@lang('translation.Blog_List')</a></li>
              <li><a href="#" key="t-blog-grid">@lang('translation.Blog_Grid')</a></li>
              <li><a href="#" key="t-blog-details">@lang('translation.Blog_Details')</a></li>
            </ul>
          </li>
        @endcan

        @can('view-subscription')
          <li>
            <a class="waves-effect" href="#">
              <i class="bx bx-mail-send"></i>
              <span key="t-subscriptions">@lang('translation.Subscriptions')</span>
            </a>
          </li>
        @endcan

        @can('view-chat')
          <li>
            <a class="waves-effect" href="#">
              <i class="bx bx-chat"></i>
              <span key="t-chat">@lang('translation.Chat')</span>
            </a>
          </li>
        @endcan

        @if (auth()->user()->can('view-profile') || auth()->user()->can('view-settings'))
          <li class="menu-title" key="t-settings">@lang('translation.Settings')</li>
        @endif

        @can('view-profile')
          <li>
            <a class="waves-effect" href="javascript: void(0);">
              <i class="bx bx-user"></i>
              <span class="align-middle" key="t-profile">@lang('translation.Profile')</span>
            </a>
          </li>
        @endcan

        @can('view-settings')
          <li>
            <a class="waves-effect" href="javascript: void(0);">
              <i class="bx bx-wrench"></i>
              <span key="t-settings">@lang('translation.Settings')</span>
            </a>
          </li>
        @endcan --}}

        @if (auth()->user()->can('view-user') ||
                auth()->user()->can('view-role-permission') ||
                auth()->user()->can('view-user-management'))
          <li class="menu-title" key="t-user_management">@lang('translation.User_Management')</li>
        @endif

        @can('view-user')
          <li>
            <a class="has-arrow waves-effect" href="javascript: void(0);">
              <i class="bx bxs-user-detail"></i>
              <span key="t-Users">@lang('translation.Users')</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
              <li><a href="{{ route('admin.users.index') }}">@lang('translation.Users_List')</a></li>
              <li><a href="{{ route('admin.customers.index') }}" key="t-customers-list">@lang('translation.Customers_List')</a></li>
            </ul>
          </li>
        @endcan

        @can('view-role-permission')
          <li>
            <a class="has-arrow waves-effect" href="javascript: void(0);">
              <i class="bx bx-share-alt"></i>
              <span key="t-role-permission">@lang('translation.Role_Permission')</span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
              <li><a href="{{ route('admin.roles.index') }}" key="t-roles">@lang('translation.Roles')</a></li>
              <li><a href="{{ route('admin.permissions.index') }}" key="t-permissions">@lang('translation.Permissions')</a></li>
            </ul>
          </li>
        @endcan

        {{-- @if (auth()->user()->can('view-slider') || auth()->user()->can('view-banner') || auth()->user()->can('view-term-condition') || auth()->user()->can('view-contact-us') || auth()->user()->can('view-faq') || auth()->user()->can('view-privacy-policy') || auth()->user()->can('view-about-us'))
          <li class="menu-title" key="t-cms">@lang('translation.CMS')</li>
        @endif
        @can('view-slider')
          <li>
            <a class="waves-effect" href="{{ route('admin.slider.index') }}">
              <i class="bx bx-pyramid"></i>
              <span key="t-sliders">@lang('translation.Sliders')</span>
            </a>
          </li>
        @endcan

        @can('view-term-condition')
          <li>
            <a class="waves-effect" href="{{ route('admin.terms-and-conditions.index') }}">
              <i class="bx bx-pyramid"></i>
              <span key="t-terms-conditions">@lang('translation.Terms_Conditions')</span>
            </a>
          </li>
        @endcan

        @can('view-privacy-policy')
          <li>
            <a class="waves-effect" href="{{ route('admin.privacy-policy.index') }}">
              <i class="bx bx-pyramid"></i>
              <span key="t-privacy_policy">@lang('translation.Privacy_Policy')</span>
            </a>
          </li>
        @endcan

        @can('view-faq')
          <li>
            <a class="waves-effect" href="{{ route('admin.faq.index') }}">
              <i class="bx bx-pyramid"></i>
              <span key="t-faq">@lang('translation.FAQ')</span>
            </a>
          </li>
        @endcan

        @can('view-about-us')
          <li>
            <a class="waves-effect" href="{{ route('admin.about-us.index') }}">
              <i class="bx bx-pyramid"></i>
              <span key="t-about-us">@lang('translation.About_Us')</span>
            </a>
          </li>
        @endcan

        @can('view-contact-us')
          <li>
            <a class="waves-effect" href="{{ route('admin.contact-us.index') }}">
              <i class="bx bx-pyramid"></i>
              <span key="t-contact-us">@lang('translation.Contact_Us')</span>
            </a>
          </li>
        @endcan

        @can('view-product-highlight')
          <li>
            <a class="waves-effect" href="{{ route('admin.product-highlights.index') }}">
              <i class="bx bx-pyramid"></i>
              <span>Product Highlight</span>
            </a>
          </li>
        @endcan --}}

      </ul>
    </div>
    <!-- Sidebar -->
  </div>
</div>
<!-- Left Sidebar End -->

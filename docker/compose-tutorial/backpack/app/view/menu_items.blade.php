{{-- This file is used for menu items by any Backpack v7 theme --}}
<li class="nav-item">
  <a class="nav-link" href="{{ backpack_url('dashboard') }}">
    <i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ backpack_url('dbadmin') }}">
    <i class="la la-database nav-icon"></i> DB Admin
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ backpack_url('dbaudit') }}">
    <i class="la la-database nav-icon"></i> DB Audit Logs
  </a>
</li>

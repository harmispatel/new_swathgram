@php
    // UserDetails
    if (auth()->user()){
        $userID = encrypt(auth()->user()->id);
        $userName = auth()->user()->username;
        $userImage = auth()->user()->image;
        $current_route = Route::currentRouteName();
    }else{
        $userID = '';
        $userName = '';
        $userImage = '';
        $current_route = '';
    }
@endphp
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{route('super_admin.dashboard')}}" class="logo d-flex align-items-center">
        <img src="{{ asset('public/assets/default_image/logo/accuster_logo.png') }}" alt="">
        <span class="d-none d-lg-block">Accuster</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <div class="search-bar">
      @php
          $titles = [
              'super_admin.dashboard' => 'Dashboard',
              'organization' => 'Organization',
              'organization.create' => 'Create Organization',
              'organization.edit' => 'Edit Organization',

              'managers' => 'Managers',
              'manager.create' => 'Create Manager',
              'manager.edit' => 'Edit Manager',

              'pathologists' => 'Pathologists',
              'pathologist.create' => 'Create Pathologist',
              'pathologist.edit' => 'Edit Pathologist',

              'lab_technician' => 'Lab Technicians',
              'lab_technician.create' => 'Create Lab Technician',
              'lab_technician.edit' => 'Edit Lab Technician',

              'package' => 'Packages',
              'package.create' => 'Create Package',
              'package.edit' => 'Edit Package',

              'device' => 'Devices',
              'device.create' => 'Create Device',
              'device.edit' => 'Edit Device',

              'device.category' => 'Device Categories',
              'device.category.create' => 'Create Device Category',
              'device.category.edit' => 'Edit Device Category',

              'admin.profile.view' => 'My Profile',
              'admin.profile.edit' => 'Edit Profile',

              'camp' => 'My Camps',
              'camp.create' => 'Create Camp',
              'camp.edit' => 'Edit Camp',

              'department' => 'Department',
              'test.profile' => 'Test Profile',
              'test.sub-profile' => 'Test Sub Profile',
          ];

          $pageTitle = $titles[$current_route] ?? 'Dashboard';
      @endphp
        <h5 class="page-titel text-white pt-2">{{ $pageTitle }}</h5>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                @if (!empty($userImage) || $userImage != null)
                    <img src="{{ asset('public/super_admin_uploads/users/'.$userImage)}}" alt="Profile" class="rounded-circle">
                @else
                    <img src="{{ asset('public/assets/default_image/user/defualt_user.png') }}" alt="Profile" class="rounded-circle">
                @endif
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ $userName }}</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ $userName }}</h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile.view',$userID) }}">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a href="{{ route('logout') }}" class="dropdown-item d-flex align-items-center">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>
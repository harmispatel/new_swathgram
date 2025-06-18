@php
    $routeName = Route::currentRouteName();
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'super_admin.dashboard') ? 'active-tab' : '' }}" href="{{route('admin.dashboard')}}">
                <i class="bi bi-grid {{ ($routeName == 'super_admin.dashboard') ? 'icon-tab' : '' }}"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'organization') || ($routeName == 'organization.create') || ($routeName == 'organization.edit') ? 'active-tab' : '' }}" href="{{ route('organization') }}">
                <i class="bi bi-bank {{ ($routeName == 'organization') || ($routeName == 'organization.create') || ($routeName == 'organization.edit') ? 'icon-tab' : '' }}"></i>
                <span>Organizations</span>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.managers') || ($routeName == 'admin.manager.create') || ($routeName == 'admin.manager.edit') ? 'active-tab' : '' }}" href="{{ route('admin.managers') }}">
                <i class="bi bi-person-circle {{ ($routeName == 'admin.managers') || ($routeName == 'admin.manager.create') || ($routeName == 'admin.manager.edit') ? 'icon-tab' : '' }}"></i>
                <span>Managers</span>
            </a>
        </li>

         <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.pathologists') || ($routeName == 'admin.pathologist.create') || ($routeName == 'admin.pathologist.edit') ? 'active-tab' : '' }}" href="{{ route('admin.pathologists') }}">
                <i class="fas fa-user-md {{ ($routeName == 'admin.pathologists') || ($routeName == 'admin.pathologist.create') || ($routeName == 'admin.pathologist.edit') ? 'icon-tab' : '' }}"></i>
                <span>Pathologists</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.lab_technician') || ($routeName == 'admin.lab_technician.create') || ($routeName == 'admin.lab_technician.edit') ? 'active-tab' : '' }}" href="{{ route('admin.lab_technician') }}">
                <i class="bi bi-person-fill {{ ($routeName == 'admin.lab_technician') || ($routeName == 'admin.lab_technician.create') || ($routeName == 'admin.lab_technician.edit') ? 'icon-tab' : '' }}"></i>
                <span>Lab Technicians</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.package') || ($routeName == 'admin.package.create') || ($routeName == 'admin.package.edit') ? 'active-tab' : '' }}" href="{{ route('admin.package') }}">
                <i class="bi bi-journal-text {{ ($routeName == 'admin.package') || ($routeName == 'admin.package.create') || ($routeName == 'admin.package.edit') ? 'icon-tab' : '' }}"></i>
                <span>Packages</span>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'device') || ($routeName == 'device.create') || ($routeName == 'device.edit') ? 'active-tab' : '' }}" data-bs-target="#devices-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide {{ ($routeName == 'device') || ($routeName == 'device.create') || ($routeName == 'device.edit') ? 'icon-tab' : '' }}"></i><span>Devices</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            
            <ul id="devices-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'device') || ($routeName == 'device.create') || ($routeName == 'device.edit') || ($routeName == 'device.category') || ($routeName == 'device.category.create') || ($routeName == 'device.category.edit')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('device.category') }}" class="{{ ($routeName == 'device.category') || ($routeName == 'device.category.create') || ($routeName == 'device.category.edit') ? 'active-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Category</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('device') }}" class="{{ ($routeName == 'device') || ($routeName == 'device.create') || ($routeName == 'device.edit') ? 'active-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Devices</span>
                    </a>
                </li>
            </ul>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.camp') || ($routeName == 'admin.camp.create') || ($routeName == 'admin.camp.edit') ? 'active-tab' : '' }}" href="{{ route('admin.camp') }}">
                <i class="bi bi-journal-text {{ ($routeName == 'admin.camp') || ($routeName == 'admin.camp.create') || ($routeName == 'admin.camp.edit') ? 'icon-tab' : '' }}"></i>
                <span>Camps</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'patient') ? 'active-tab' : '' }}" data-bs-target="#patient-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-hospital-user {{ ($routeName == 'patient') ? 'icon-tab' : '' }}"></i><span>Patients</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            
            <ul id="patient-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'admin.patient') || ($routeName == 'admin.patient.report')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.patient') }}" class="{{($routeName == 'admin.patient') ? 'active-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Patients</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.patient.report') }}" class="{{ ($routeName == 'admin.patient.report') ? 'active-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Patients Report</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.revenue') ? 'active-tab' : '' }}" href="{{ route('admin.revenue') }}">
                <i class="bi bi-reception-4 {{ ($routeName == 'admin.revenue') ? 'icon-tab' : '' }}"></i>
                <span>Revenue</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.billing') ? 'active-tab' : '' }}" href="{{ route('admin.billing') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'admin.billing') ? 'icon-tab' : '' }}"></i>
                <span>Billing</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.qc_report') ? 'active-tab' : '' }}" href="{{ route('admin.qc_report') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'admin.qc_report') ? 'icon-tab' : '' }}"></i>
                <span>QC Report</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.test') || ($routeName == 'admin.test.create') || ($routeName == 'admin.department') || ($routeName == 'admin.department.create') || ($routeName == 'admin.test.profile') || ($routeName == 'admin.test.profile.create') || ($routeName == 'admin.test.sub-profile') || ($routeName == 'admin.test.sub-profile.create') ? 'active-tab' : '' }}" href="{{ route('admin.test') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'admin.test') || ($routeName == 'admin.test.create') || ($routeName == 'admin.department') || ($routeName == 'admin.department.create') || ($routeName == 'admin.test.profile') || ($routeName == 'admin.test.profile.create') || ($routeName == 'admin.test.sub-profile') || ($routeName == 'admin.test.sub-profile.create') ? 'icon-tab' : '' }}"></i>
                <span>Tests</span>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'department') ? 'active-tab' : '' }}" data-bs-target="#satelite-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-hospital-user {{ ($routeName == 'department') ? 'icon-tab' : '' }}"></i><span>Satellite Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            
            <ul id="satelite-nav" class="nav-content sidebar-ul collapse {{ ($routeName == 'department') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('department') }}" class="{{($routeName == 'department') ? 'active-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Department</span>
                    </a>
                </li>
                 <li>
                    <a href="{{ route('test.profile') }}" class="{{($routeName == 'test.profile') ? 'active-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('test.sub-profile') }}" class="{{($routeName == 'test.sub-profile') ? 'active-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Sub Profile</span>
                    </a>
                </li>
            </ul>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.satellite_data') || ($routeName == 'admin.satellite_data.show') || ($routeName == 'admin.satellite_data.map') ? 'active-tab' : '' }}" href="{{ route('admin.satellite_data') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'admin.satellite_data') || ($routeName == 'admin.satellite_data.show') || ($routeName == 'admin.satellite_data.map') ? 'icon-tab' : '' }}"></i>
                <span>Satellite Data</span>
            </a>
        </li>
    </ul>
</aside>

@php
    $routeName = Route::currentRouteName();
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'manager.dashboard') ? 'active-tab' : '' }}" href="{{route('manager.dashboard')}}">
                <i class="bi bi-grid {{ ($routeName == 'manager.dashboard') ? 'icon-tab' : '' }}"></i>
                <span>Dashboard</span>
            </a>
        </li>

         <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'manager.pathologists') || ($routeName == 'manager.pathologist.create') || ($routeName == 'manager.pathologist.edit') ? 'active-tab' : '' }}" href="{{ route('manager.pathologists') }}">
                <i class="fas fa-user-md {{ ($routeName == 'manager.pathologists') || ($routeName == 'manager.pathologist.create') || ($routeName == 'manager.pathologist.edit') ? 'icon-tab' : '' }}"></i>
                <span>Pathologists</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'manager.lab_technician') || ($routeName == 'manager.lab_technician.create') || ($routeName == 'manager.lab_technician.edit') ? 'active-tab' : '' }}" href="{{ route('manager.lab_technician') }}">
                <i class="bi bi-person-fill {{ ($routeName == 'manager.lab_technician') || ($routeName == 'manager.lab_technician.create') || ($routeName == 'manager.lab_technician.edit') ? 'icon-tab' : '' }}"></i>
                <span>Lab Technicians</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'manager.package') || ($routeName == 'manager.package.create') || ($routeName == 'manager.package.edit') ? 'active-tab' : '' }}" href="{{ route('manager.package') }}">
                <i class="bi bi-journal-text {{ ($routeName == 'manager.package') || ($routeName == 'manager.package.create') || ($routeName == 'manager.package.edit') ? 'icon-tab' : '' }}"></i>
                <span>Packages</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'manager.camp') || ($routeName == 'manager.camp.create') || ($routeName == 'manager.camp.edit') ? 'active-tab' : '' }}" href="{{ route('manager.camp') }}">
                <i class="bi bi-journal-text {{ ($routeName == 'manager.camp') || ($routeName == 'manager.camp.create') || ($routeName == 'manager.camp.edit') ? 'icon-tab' : '' }}"></i>
                <span>Camps</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'manager.patient') ? 'active-tab' : '' }}" data-bs-target="#patient-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-hospital-user {{ ($routeName == 'manager.patient') ? 'icon-tab' : '' }}"></i><span>Patients</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            
            <ul id="patient-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'manager.patient') || ($routeName == 'manager.patient.report')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('manager.patient') }}" class="{{($routeName == 'manager.patient') ? 'active-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Patients</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('manager.patient.report') }}" class="{{ ($routeName == 'manager.patient.report') ? 'active-link' : '' }}">
                        <i class="bi bi-circle"></i><span>Patients Report</span>
                    </a>
                </li>
            </ul>
        </li>
         <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'manager.revenue') ? 'active-tab' : '' }}" href="{{ route('manager.revenue') }}">
                <i class="bi bi-reception-4 {{ ($routeName == 'manager.revenue') ? 'icon-tab' : '' }}"></i>
                <span>Revenue</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'manager.billing') ? 'active-tab' : '' }}" href="{{ route('manager.billing') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'manager.billing') ? 'icon-tab' : '' }}"></i>
                <span>Billing</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'manager.qc_report') ? 'active-tab' : '' }}" href="{{ route('manager.qc_report') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'manager.qc_report') ? 'icon-tab' : '' }}"></i>
                <span>QC Report</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'manager.test') || ($routeName == 'manager.test.create') || ($routeName == 'manager.department') || ($routeName == 'manager.department.create') || ($routeName == 'manager.test.profile') || ($routeName == 'manager.test.profile.create') || ($routeName == 'manager.test.sub-profile') || ($routeName == 'manager.test.sub-profile.create') ? 'active-tab' : '' }}" href="{{ route('manager.test') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'manager.test') || ($routeName == 'manager.test.create') || ($routeName == 'manager.department') || ($routeName == 'manager.department.create') || ($routeName == 'manager.test.profile') || ($routeName == 'manager.test.profile.create') || ($routeName == 'manager.test.sub-profile') || ($routeName == 'manager.test.sub-profile.create') ? 'icon-tab' : '' }}"></i>
                <span>Tests</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'manager.satellite_data') || ($routeName == 'manager.satellite_data.show') || ($routeName == 'manager.satellite_data.map') ? 'active-tab' : '' }}" href="{{ route('manager.satellite_data') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'manager.satellite_data') || ($routeName == 'manager.satellite_data.show') || ($routeName == 'manager.satellite_data.map') ? 'icon-tab' : '' }}"></i>
                <span>Satellite Data</span>
            </a>
        </li>
    </ul>
</aside>

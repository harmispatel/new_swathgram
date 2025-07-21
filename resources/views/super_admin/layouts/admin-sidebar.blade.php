@php
    $routeName = Route::currentRouteName();
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'super_admin.dashboard') ? 'active-tab' : '' }}" href="{{route('super_admin.dashboard')}}">
                <i class="bi bi-grid {{ ($routeName == 'super_admin.dashboard') ? 'icon-tab' : '' }}"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @can('organization')
                <li class="nav-item">
                    <a class="nav-link {{ ($routeName == 'organization') || ($routeName == 'organization.create') || ($routeName == 'organization.edit') ? 'active-tab' : '' }}" href="{{ route('organization') }}">
                        <i class="bi bi-bank {{ ($routeName == 'organization') || ($routeName == 'organization.create') || ($routeName == 'organization.edit') ? 'icon-tab' : '' }}"></i>
                        <span>Organizations</span>
                    </a>
                </li>
        @endcan

        @can('managers')
            <li class="nav-item">
                <a class="nav-link {{ ($routeName == 'managers') || ($routeName == 'manager.create') || ($routeName == 'manager.edit') ? 'active-tab' : '' }}" href="{{ route('managers') }}">
                    <i class="bi bi-person-circle {{ ($routeName == 'managers') || ($routeName == 'manager.create') || ($routeName == 'manager.edit') ? 'icon-tab' : '' }}"></i>
                    <span>Managers</span>
                </a>
            </li>
        @endcan

        @can('pathologists')
            <li class="nav-item">
                <a class="nav-link {{ ($routeName == 'pathologists') || ($routeName == 'pathologist.create') || ($routeName == 'pathologist.edit') ? 'active-tab' : '' }}" href="{{ route('pathologists') }}">
                    <i class="fas fa-user-md {{ ($routeName == 'pathologists') || ($routeName == 'pathologist.create') || ($routeName == 'pathologist.edit') ? 'icon-tab' : '' }}"></i>
                    <span>Pathologists</span>
                </a>
            </li>
        @endcan    

        @can('lab_technician')    
            <li class="nav-item">
                <a class="nav-link {{ ($routeName == 'lab_technician') || ($routeName == 'lab_technician.create') || ($routeName == 'lab_technician.edit') ? 'active-tab' : '' }}" href="{{ route('lab_technician') }}">
                    <i class="bi bi-person-fill {{ ($routeName == 'lab_technician') || ($routeName == 'lab_technician.create') || ($routeName == 'lab_technician.edit') ? 'icon-tab' : '' }}"></i>
                    <span>Lab Technicians</span>
                </a>
            </li>
        @endcan

         @can('package')    
            <li class="nav-item">
                <a class="nav-link {{ ($routeName == 'package') || ($routeName == 'package.create') || ($routeName == 'package.edit') ? 'active-tab' : '' }}" href="{{ route('package') }}">
                    <i class="bi bi-journal-text {{ ($routeName == 'package') || ($routeName == 'package.create') || ($routeName == 'package.edit') ? 'icon-tab' : '' }}"></i>
                    <span>Packages</span>
                </a>
            </li>
        @endcan

        @can('device')  
            <li class="nav-item">
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
            </li>
        @endcan 

        @can('camp')
            <li class="nav-item">
                <a class="nav-link {{ ($routeName == 'camp') || ($routeName == 'camp.create') || ($routeName == 'camp.edit') ? 'active-tab' : '' }}" href="{{ route('camp') }}">
                    <i class="bi bi-journal-text {{ ($routeName == 'camp') || ($routeName == 'camp.create') || ($routeName == 'camp.edit') ? 'icon-tab' : '' }}"></i>
                    <span>Camps</span>
                </a>
            </li>
         @endcan

        @can('patient')
            <li class="nav-item">
                <a class="nav-link {{ ($routeName == 'patient') || ($routeName == 'patient.create') || ($routeName == 'patient.edit') ? 'active-tab' : '' }}" data-bs-target="#patient-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa-solid fa-hospital-user {{ ($routeName == 'patient') || ($routeName == 'patient.create') || ($routeName == 'patient.edit') ? 'icon-tab' : '' }}"></i><span>Patients</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                
                <ul id="patient-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'patient') || ($routeName == 'patient.report') || ($routeName == 'patient.create') || ($routeName == 'patient.edit')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('patient') }}" class="{{($routeName == 'patient') || ($routeName == 'patient.create') || ($routeName == 'patient.edit') ? 'active-link' : '' }}">
                            <i class="bi bi-circle"></i><span>Patients</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('patient.report') }}" class="{{ ($routeName == 'patient.report') ? 'active-link' : '' }}">
                            <i class="bi bi-circle"></i><span>Patients Report</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan    

        @can('revenue')
            <li class="nav-item">
                <a class="nav-link {{ ($routeName == 'revenue') ? 'active-tab' : '' }}" href="{{ route('revenue') }}">
                    <i class="bi bi-reception-4 {{ ($routeName == 'revenue') ? 'icon-tab' : '' }}"></i>
                    <span>Revenue</span>
                </a>
            </li>
         @endcan
         
        @can('billing')
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'billing') ? 'active-tab' : '' }}" href="{{ route('billing') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'billing') ? 'icon-tab' : '' }}"></i>
                <span>Billing</span>
            </a>
        </li>
        @endcan

        @can('qc_report')
             <li class="nav-item">
                <a class="nav-link {{ ($routeName == 'qc_report') ? 'active-tab' : '' }}" href="{{ route('qc_report') }}">
                    <i class="bi bi-cash-coin {{ ($routeName == 'qc_report') ? 'icon-tab' : '' }}"></i>
                    <span>QC Report</span>
                </a>
            </li>
        @endcan
       
        @can('test')
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'test') || ($routeName == 'test.create') || ($routeName == 'department') || ($routeName == 'department.create') || ($routeName == 'test.profile') || ($routeName == 'test.profile.create') || ($routeName == 'test.sub-profile') || ($routeName == 'test.sub-profile.create') ? 'active-tab' : '' }}" href="{{ route('test') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'test') || ($routeName == 'test.create') || ($routeName == 'department') || ($routeName == 'department.create') || ($routeName == 'test.profile') || ($routeName == 'test.profile.create') || ($routeName == 'test.sub-profile') || ($routeName == 'test.sub-profile.create') ? 'icon-tab' : '' }}"></i>
                <span>Tests</span>
            </a>
        </li>
        @endcan

        @canany(['department', 'test.profile.create', 'test.sub-profile.create'])
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'department') || ($routeName == 'test.profile') || ($routeName == 'test.sub-profile') || ($routeName == 'test.profile.create') ? 'active-tab' : '' }}" data-bs-target="#satelite-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-hospital-user {{ ($routeName == 'department') ? 'icon-tab' : '' }}"></i><span>Satellite Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            
            <ul id="satelite-nav" class="nav-content sidebar-ul collapse {{ ($routeName == 'department') || ($routeName == 'test.profile') || ($routeName == 'test.profile.create') || ($routeName == 'test.sub-profile') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
              
                @can('department')
                    <li>
                        <a href="{{ route('department') }}" class="{{($routeName == 'department') ? 'active-link' : '' }}">
                            <i class="bi bi-circle"></i><span>Department</span>
                        </a>
                    </li>
                @endcan
                
                @can('test.profile.create')
                    <li>
                        <a href="{{ route('test.profile') }}" class="{{($routeName == 'test.profile') || ($routeName == 'test.profile.create') ? 'active-link' : '' }}">
                            <i class="bi bi-circle"></i><span>Add Profile</span>
                        </a>
                    </li>
                @endcan
                
                @can('test.sub-profile.create')
                    <li>
                        <a href="{{ route('test.sub-profile') }}" class="{{($routeName == 'test.sub-profile') ? 'active-link' : '' }}">
                            <i class="bi bi-circle"></i><span>Add Sub Profile</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
        @endcanany

        @can('satellite_data')
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'satellite_data') || ($routeName == 'satellite_data.show') || ($routeName == 'satellite_data.map') ? 'active-tab' : '' }}" href="{{ route('satellite_data') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'satellite_data') || ($routeName == 'satellite_data.show') || ($routeName == 'satellite_data.map') ? 'icon-tab' : '' }}"></i>
                <span>Satellite Data</span>
            </a>
        </li> 
        @endcan

        @can('roles.index')
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'roles.index') ? 'active-tab' : '' }}" href="{{ route('roles.index') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'roles.index') ? 'icon-tab' : '' }}"></i>
                <span>Roles & Permission</span>
            </a>
        </li>
        @endcan

        @can('abha.register_patient')
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'abha.register_patient') ? 'active-tab' : '' }}" href="{{ route('abha.register_patient') }}">
                <i class="bi bi-cash-coin {{ ($routeName == 'abha.register_patient') ? 'icon-tab' : '' }}"></i>
                <span>Create ABHA</span>
            </a>
        </li>
        @endcan
    </ul>
</aside>

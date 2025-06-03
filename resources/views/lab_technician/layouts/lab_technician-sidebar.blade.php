@php
    $routeName = Route::currentRouteName();
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'super_admin.dashboard') ? 'active-tab' : '' }}" href="index.html">
                <i class="bi bi-grid {{ ($routeName == 'super_admin.dashboard') ? 'icon-tab' : '' }}"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'lab_technician.camp') || ($routeName == 'lab_technician.camp.create') || ($routeName == 'lab_technician.camp.edit') ? 'active-tab' : '' }}" href="{{ route('lab_technician.camp') }}">
                <i class="bi bi-journal-text {{ ($routeName == 'lab_technician.camp') || ($routeName == 'lab_technician.camp.create') || ($routeName == 'lab_technician.camp.edit') ? 'icon-tab' : '' }}"></i>
                <span>Camps</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'lab_technician.patient.create') || ($routeName == 'lab_technician.patient') ? 'active-tab' : '' }}" href="{{ route('lab_technician.patient') }}">
                <i class="bi bi-journal-text {{ ($routeName == 'lab_technician.patient.create') || ($routeName == 'lab_technician.patient') ? 'icon-tab' : '' }}"></i>
                <span>Register Patient</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'lab_technician.patient.report') ? 'active-tab' : '' }}" href="{{ route('lab_technician.patient.report') }}">
                <i class="bi bi-journal-text {{ ($routeName == 'lab_technician.patient.report') ? 'icon-tab' : '' }}"></i>
                <span>Patient Report</span>
            </a>
        </li>
        
        
        <!-- 
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'camp') || ($routeName == 'camp.create') || ($routeName == 'camp.edit') ? 'active-tab' : '' }}" href="{{ route('camp') }}">
                <i class="bi bi-journal-text {{ ($routeName == 'camp') || ($routeName == 'camp.create') || ($routeName == 'camp.edit') ? 'icon-tab' : '' }}"></i>
                <span>Camps</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'camp') || ($routeName == 'camp.create') || ($routeName == 'camp.edit') ? 'active-tab' : '' }}" href="{{ route('camp') }}">
                <i class="bi bi-journal-text {{ ($routeName == 'camp') || ($routeName == 'camp.create') || ($routeName == 'camp.edit') ? 'icon-tab' : '' }}"></i>
                <span>Camps</span>
            </a>
        </li> -->
    </ul>
</aside>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>@yield('titulo')</title>

<!-- Favicon -->
<link href="{{ asset('favicon.svg') }}" rel="icon" type="image/svg+xml">
<link href="{{ asset('favicon.png') }}" rel="icon" type="image/png">
<link href="{{ asset('favicon.ico') }}" rel="icon" type="image/x-icon">

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

<!-- Bootstrap -->
<link href="{{ asset('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="{{ asset('NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css">

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Template CSS -->
<link href="{{ asset('NiceAdmin/assets/css/style.css') }}" rel="stylesheet">

<style>
body { overflow-x: hidden; }

/* ── HEADER — Blanco ── */
#header {
    background: #ffffff !important;
    box-shadow: 0 1px 0 #e2e8f0 !important;
    border-bottom: none !important;
    height: 60px !important;
    padding: 0 1.25rem !important;
}

#header .logo {
    display: flex; align-items: center; gap: 10px;
    text-decoration: none; flex-shrink: 0;
}
#header .logo .logo-icon {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #3b82f6, #6366f1);
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.78rem; font-weight: 800;
    color: #fff; letter-spacing: -0.5px; flex-shrink: 0;
}
#header .logo .logo-text {
    font-size: 1rem; font-weight: 700;
    color: #0f172a; letter-spacing: -0.3px; line-height: 1.2;
    display: none;
}
#header .logo .logo-sub {
    font-size: 0.65rem; color: #94a3b8;
    font-weight: 400; margin-top: 1px; display: none;
}
@media (min-width: 768px) {
    #header .logo .logo-text { display: block; }
    #header .logo .logo-sub  { display: block; }
}

.toggle-sidebar-btn {
    color: #64748b !important;
    font-size: 1.4rem !important;
    margin-left: 0; padding: 6px;
    border-radius: 6px; transition: all 0.15s; line-height: 1;
}
.toggle-sidebar-btn:hover { color: #0f172a !important; background: #f1f5f9; }

/* Pills */
.st-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 15px; border-radius: 99px;
    font-size: 0.8rem; font-weight: 600;
    text-decoration: none; transition: all 0.15s ease;
    border: 1px solid; white-space: nowrap;
    position: relative; cursor: pointer;
}
.st-pill.notas  { color: #16a34a; border-color: #bbf7d0; background: #f0fdf4; }
.st-pill.planes { color: #2563eb; border-color: #bfdbfe; background: #eff6ff; }
.st-pill.claves { color: #ea580c; border-color: #fed7aa; background: #fff7ed; }
.st-pill.notas:hover  { background: #16a34a; border-color: #16a34a; color: #fff !important; text-decoration: none; }
.st-pill.planes:hover { background: #2563eb; border-color: #2563eb; color: #fff !important; text-decoration: none; }
.st-pill.claves:hover { background: #ea580c; border-color: #ea580c; color: #fff !important; text-decoration: none; }
.st-pill.disabled { opacity: 0.4; pointer-events: none; }
.st-pill .badge-count {
    position: absolute; top: -5px; right: -5px;
    min-width: 16px; height: 16px; padding: 0 4px;
    border-radius: 99px; background: #ef4444; color: #fff;
    font-size: 0.58rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center; line-height: 1;
}

.st-sep { width: 1px; height: 26px; background: #e2e8f0; flex-shrink: 0; }

/* Empresa chip */
.st-empresa-chip {
    display: inline-flex; align-items: center; justify-content: center; gap: 7px;
    padding: 8px 18px;
    background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 100%);
    border: 2px solid #ffffff; border-radius: 22px; font-size: 0.95rem; font-weight: 700;
    color: #ffffff;
    max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    box-shadow: 0 6px 25px rgba(15, 39, 68, 0.3);
    transition: all 0.3s ease;
    cursor: default;
}
.st-empresa-chip:hover {
    box-shadow: 0 10px 35px rgba(15, 39, 68, 0.4);
    transform: scale(1.05);
    border-color: #f0f4f8;
}
.st-empresa-chip i { color: #ffffff; font-size: 1rem; }

.st-cambiar {
    font-size: 0.76rem; font-weight: 600; padding: 6px 12px;
    border-radius: 99px; color: #b45309;
    background: #fffbeb; border: 1px solid #fde68a;
    text-decoration: none; white-space: nowrap; transition: all 0.15s; cursor: pointer;
}
.st-cambiar:hover { background: #d97706; border-color: #d97706; color: #fff; text-decoration: none; }

/* Avatar */
.st-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border: 2px solid #e0e7ff;
    color: #fff; font-size: 0.75rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; flex-shrink: 0; transition: box-shadow 0.15s;
}
.st-avatar:hover { box-shadow: 0 0 0 3px #c7d2fe; }

.st-user-info { line-height: 1.25; }
.st-user-info .uname { font-size: 0.85rem; font-weight: 600; color: #0f172a; }
.st-user-info .urole { font-size: 0.7rem; color: #94a3b8; }
.st-chevron { font-size: 0.7rem; color: #94a3b8; }

/* Dropdown perfil */
.dropdown-menu.st-profile {
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 8px 24px rgba(15,23,42,0.12) !important;
    border-radius: 12px !important; min-width: 200px; padding: 6px;
}
.dropdown-menu.st-profile .dh { padding: 8px 10px 6px; }
.dropdown-menu.st-profile .dh .dh-name { font-size: 0.83rem; font-weight: 700; color: #0f172a; margin: 0; }
.dropdown-menu.st-profile .dh .dh-email { font-size: 0.7rem; color: #94a3b8; }
.dropdown-menu.st-profile .dropdown-item {
    border-radius: 7px; padding: 7px 10px; font-size: 0.8rem; font-weight: 500;
    color: #334155; display: flex; align-items: center; gap: 8px; transition: background 0.12s;
}
.dropdown-menu.st-profile .dropdown-item:hover { background: #f1f5f9; color: #0f172a; }
.dropdown-menu.st-profile .dropdown-item.text-danger:hover { background: #fef2f2; color: #dc2626; }

/* ── SIDEBAR — Blanco ── */
#sidebar {
    background: #ffffff !important;
    width: 240px !important;
    padding: 0 !important;
    border-right: none !important;
    overflow-y: auto;
    overflow-x: hidden;
    box-shadow: 1px 0 0 #e2e8f0 !important;
}

#sidebar::-webkit-scrollbar { width: 3px; }
#sidebar::-webkit-scrollbar-track { background: transparent; }
#sidebar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

@media (min-width: 1200px) {
    #main, #footer { margin-left: 240px !important; }
    .toggle-sidebar #main, .toggle-sidebar #footer { margin-left: 0 !important; }
    .toggle-sidebar #sidebar { left: -240px !important; }
}

#sidebar .sidebar-nav .nav-heading {
    font-size: 0.66rem !important; font-weight: 700 !important;
    letter-spacing: 0.12em !important; text-transform: uppercase !important;
    color: #94a3b8 !important;
    padding: 16px 18px 6px !important; margin: 0 !important;
}

#sidebar .sidebar-nav > .nav-item { padding: 3px 10px; }

#sidebar .sidebar-nav .nav-link {
    display: flex !important; align-items: center;
    padding: 8px 12px !important; border-radius: 9px !important;
    color: #334155 !important;
    font-size: 0.92rem !important; font-weight: 500;
    transition: all 0.15s ease; background: transparent !important;
    gap: 12px; margin: 0;
}

/* Caja de ícono base */
#sidebar .sidebar-nav .nav-link i:not(.bi-chevron-down) {
    font-size: 1.1rem !important;
    width: 36px; height: 36px;
    display: flex !important; align-items: center; justify-content: center;
    border-radius: 9px;
    flex-shrink: 0; margin: 0 !important;
    transition: all 0.15s;
}

/* Colores individuales por ícono */
#sidebar .sidebar-nav .nav-link .bi-grid-1x2-fill  { background: #eef2ff; color: #6366f1 !important; }
#sidebar .sidebar-nav .nav-link .bi-receipt         { background: #fffbeb; color: #d97706 !important; }
#sidebar .sidebar-nav .nav-link .bi-people-fill     { background: #ecfdf5; color: #059669 !important; }
#sidebar .sidebar-nav .nav-link .bi-building-fill   { background: #eff6ff; color: #2563eb !important; }
#sidebar .sidebar-nav .nav-link .bi-file-medical-fill { background: #fff1f2; color: #e11d48 !important; }
#sidebar .sidebar-nav .nav-link .bi-globe2          { background: #f5f3ff; color: #7c3aed !important; }
#sidebar .sidebar-nav .nav-link .bi-collection-fill { background: #fff7ed; color: #ea580c !important; }
#sidebar .sidebar-nav .nav-link .bi-shield-lock-fill    { background: #f1f5f9; color: #334155 !important; }
#sidebar .sidebar-nav .nav-link .bi-box-arrow-up-right  { background: #f0fdf4; color: #16a34a !important; }

#sidebar .sidebar-nav .nav-link span { flex: 1; line-height: 1.3; color: inherit; }

#sidebar .sidebar-nav .nav-link .bi-chevron-down {
    font-size: 0.6rem !important; color: #94a3b8 !important;
    transition: transform 0.2s, color 0.2s;
    width: auto !important; height: auto !important;
    background: none !important; border-radius: 0 !important;
    flex: 0 !important;
}

/* Hover */
#sidebar .sidebar-nav .nav-link:hover { background: #f8fafc !important; color: #0f172a !important; }
#sidebar .sidebar-nav .nav-link:hover .bi-grid-1x2-fill  { background: #e0e7ff; color: #4f46e5 !important; }
#sidebar .sidebar-nav .nav-link:hover .bi-receipt         { background: #fef3c7; color: #b45309 !important; }
#sidebar .sidebar-nav .nav-link:hover .bi-people-fill     { background: #d1fae5; color: #047857 !important; }
#sidebar .sidebar-nav .nav-link:hover .bi-building-fill   { background: #dbeafe; color: #1d4ed8 !important; }
#sidebar .sidebar-nav .nav-link:hover .bi-file-medical-fill { background: #ffe4e6; color: #be123c !important; }
#sidebar .sidebar-nav .nav-link:hover .bi-globe2          { background: #ede9fe; color: #6d28d9 !important; }
#sidebar .sidebar-nav .nav-link:hover .bi-collection-fill { background: #ffedd5; color: #c2410c !important; }
#sidebar .sidebar-nav .nav-link:hover .bi-shield-lock-fill    { background: #e2e8f0; color: #1e293b !important; }
#sidebar .sidebar-nav .nav-link:hover .bi-box-arrow-up-right  { background: #dcfce7; color: #15803d !important; }

/* Activo / expandido */
#sidebar .sidebar-nav .nav-link:not(.collapsed) { background: #f0f9ff !important; color: #0369a1 !important; }
#sidebar .sidebar-nav .nav-link:not(.collapsed) .bi-grid-1x2-fill  { background: #e0e7ff; color: #4f46e5 !important; }
#sidebar .sidebar-nav .nav-link:not(.collapsed) .bi-receipt         { background: #fef3c7; color: #b45309 !important; }
#sidebar .sidebar-nav .nav-link:not(.collapsed) .bi-people-fill     { background: #d1fae5; color: #047857 !important; }
#sidebar .sidebar-nav .nav-link:not(.collapsed) .bi-building-fill   { background: #dbeafe; color: #1d4ed8 !important; }
#sidebar .sidebar-nav .nav-link:not(.collapsed) .bi-file-medical-fill { background: #ffe4e6; color: #be123c !important; }
#sidebar .sidebar-nav .nav-link:not(.collapsed) .bi-globe2          { background: #ede9fe; color: #6d28d9 !important; }
#sidebar .sidebar-nav .nav-link:not(.collapsed) .bi-collection-fill { background: #ffedd5; color: #c2410c !important; }
#sidebar .sidebar-nav .nav-link:not(.collapsed) .bi-shield-lock-fill    { background: #e2e8f0; color: #1e293b !important; }
#sidebar .sidebar-nav .nav-link:not(.collapsed) .bi-box-arrow-up-right  { background: #dcfce7; color: #15803d !important; }
#sidebar .sidebar-nav .nav-link:not(.collapsed) .bi-chevron-down { transform: rotate(180deg); color: #0369a1 !important; }

/* Submenú */
#sidebar .sidebar-nav .nav-content { background: transparent !important; padding: 2px 0 4px !important; }
#sidebar .sidebar-nav .nav-content li { padding: 1px 10px !important; }
#sidebar .sidebar-nav .nav-content li a {
    display: flex !important; align-items: center; gap: 8px;
    padding: 9px 12px 9px 56px !important;
    font-size: 0.86rem !important; font-weight: 500;
    color: #64748b !important; border-radius: 7px !important;
    margin: 0 !important; transition: all 0.13s ease;
    text-decoration: none !important; background: transparent !important;
}
#sidebar .sidebar-nav .nav-content li a i { display: none !important; }
#sidebar .sidebar-nav .nav-content li a:before {
    content: ''; width: 4px; height: 4px; border-radius: 50%;
    background: #cbd5e1; flex-shrink: 0; transition: background 0.13s;
    margin-left: -12px;
}
#sidebar .sidebar-nav .nav-content li a:hover { color: #0f172a !important; background: #f1f5f9 !important; }
#sidebar .sidebar-nav .nav-content li a:hover:before { background: #3b82f6; }
#sidebar .sidebar-nav .nav-content li a.active { color: #1d4ed8 !important; background: #eff6ff !important; font-weight: 600; }
#sidebar .sidebar-nav .nav-content li a.active:before { background: #3b82f6; }

#sidebar .sidebar-nav .nav-divider { height: 1px; background: #e2e8f0; margin: 6px 16px; }

/* Theme Toggle */
.st-pill.theme-toggle {
    color: #f59e0b; border-color: #fcd34d; background: #fffbeb;
    padding: 7px 10px !important;
}
.st-pill.theme-toggle:hover { background: #f59e0b; border-color: #f59e0b; color: #fff !important; }

/* Dark Mode Styles */
html.dark-mode {
    color-scheme: dark;
}

html.dark-mode body {
    background: #0f172a !important;
    color: #e2e8f0 !important;
}

html.dark-mode #header {
    background: #1e293b !important;
    box-shadow: 0 1px 0 #334155 !important;
}

html.dark-mode #header .logo .logo-text { color: #f1f5f9 !important; }
html.dark-mode #header .logo .logo-sub { color: #64748b !important; }
html.dark-mode .toggle-sidebar-btn { color: #94a3b8 !important; }
html.dark-mode .toggle-sidebar-btn:hover { color: #f1f5f9 !important; background: #334155; }

html.dark-mode .st-pill.notas  { color: #86efac; border-color: #4ade80; background: #064e3b; }
html.dark-mode .st-pill.planes { color: #93c5fd; border-color: #3b82f6; background: #0c2d4b; }
html.dark-mode .st-pill.claves { color: #fed7aa; border-color: #ea580c; background: #3f2415; }
html.dark-mode .st-pill.notas:hover  { background: #22c55e; border-color: #22c55e; color: #000 !important; }
html.dark-mode .st-pill.planes:hover { background: #3b82f6; border-color: #3b82f6; color: #fff !important; }
html.dark-mode .st-pill.claves:hover { background: #ea580c; border-color: #ea580c; color: #fff !important; }

html.dark-mode .st-sep { background: #334155; }

html.dark-mode .st-cambiar { color: #fbbf24; background: #332701; border-color: #b45309; }
html.dark-mode .st-cambiar:hover { background: #d97706; border-color: #d97706; color: #fff; }

html.dark-mode .st-avatar { border-color: #312e81; }
html.dark-mode .st-avatar:hover { box-shadow: 0 0 0 3px #4f46e5; }

html.dark-mode .st-user-info .uname { color: #f1f5f9; }
html.dark-mode .st-user-info .urole { color: #94a3b8; }
html.dark-mode .st-chevron { color: #94a3b8; }

html.dark-mode .dropdown-menu.st-profile {
    border-color: #334155 !important;
    background: #1e293b !important;
    box-shadow: 0 8px 24px rgba(0,0,0,0.5) !important;
}
html.dark-mode .dropdown-menu.st-profile .dh .dh-name { color: #f1f5f9; }
html.dark-mode .dropdown-menu.st-profile .dh .dh-email { color: #94a3b8; }
html.dark-mode .dropdown-menu.st-profile .dropdown-item { color: #cbd5e1; }
html.dark-mode .dropdown-menu.st-profile .dropdown-item:hover { background: #334155; color: #f1f5f9; }
html.dark-mode .dropdown-menu.st-profile .dropdown-item.text-danger { color: #fca5a5; }
html.dark-mode .dropdown-menu.st-profile .dropdown-item.text-danger:hover { background: #7f1d1d; color: #fca5a5; }
html.dark-mode .dropdown-divider { border-color: #334155; }

html.dark-mode #sidebar {
    background: #1e293b !important;
    box-shadow: 1px 0 0 #334155 !important;
}

html.dark-mode #sidebar::-webkit-scrollbar-thumb { background: #475569; }

html.dark-mode #sidebar .sidebar-nav .nav-heading { color: #64748b !important; }

html.dark-mode #sidebar .sidebar-nav .nav-link { color: #cbd5e1 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link:hover { background: #334155 !important; color: #f1f5f9 !important; }

html.dark-mode #sidebar .sidebar-nav .nav-link .bi-grid-1x2-fill  { background: #312e81; color: #a5b4fc !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link .bi-receipt         { background: #78350f; color: #fcd34d !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link .bi-people-fill     { background: #064e3b; color: #86efac !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link .bi-building-fill   { background: #0c2d4b; color: #93c5fd !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link .bi-file-medical-fill { background: #4c0519; color: #fb7185 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link .bi-globe2          { background: #3730a3; color: #d8b4fe !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link .bi-collection-fill { background: #5a2e0c; color: #fdba74 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link .bi-shield-lock-fill    { background: #334155; color: #cbd5e1 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link .bi-box-arrow-up-right  { background: #164e3f; color: #a7f3d0 !important; }

html.dark-mode #sidebar .sidebar-nav .nav-link:hover .bi-grid-1x2-fill  { background: #4f46e5; color: #e0e7ff !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link:hover .bi-receipt         { background: #b45309; color: #fef3c7 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link:hover .bi-people-fill     { background: #047857; color: #d1fae5 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link:hover .bi-building-fill   { background: #1d4ed8; color: #dbeafe !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link:hover .bi-file-medical-fill { background: #be123c; color: #ffe4e6 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link:hover .bi-globe2          { background: #6d28d9; color: #ede9fe !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link:hover .bi-collection-fill { background: #c2410c; color: #ffedd5 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link:hover .bi-shield-lock-fill    { background: #1e293b; color: #e2e8f0 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link:hover .bi-box-arrow-up-right  { background: #15803d; color: #dcfce7 !important; }

html.dark-mode #sidebar .sidebar-nav .nav-link:not(.collapsed) { background: #0c2d4b !important; color: #0ea5e9 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-link:not(.collapsed) .bi-chevron-down { color: #0ea5e9 !important; }

html.dark-mode #sidebar .sidebar-nav .nav-content li a { color: #94a3b8 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-content li a:before { background: #475569; }
html.dark-mode #sidebar .sidebar-nav .nav-content li a:hover { color: #f1f5f9 !important; background: #334155 !important; }
html.dark-mode #sidebar .sidebar-nav .nav-content li a:hover:before { background: #3b82f6; }
html.dark-mode #sidebar .sidebar-nav .nav-content li a.active { color: #0ea5e9 !important; background: #0c2d4b !important; }
html.dark-mode #sidebar .sidebar-nav .nav-content li a.active:before { background: #3b82f6; }

html.dark-mode #sidebar .sidebar-nav .nav-divider { background: #334155; }

html.dark-mode main.main { background: #0f172a; }
html.dark-mode .section { background: #0f172a; }

html.dark-mode .st-pill.theme-toggle { color: #fbbf24; border-color: #fcd34d; background: #78350f; }
html.dark-mode .st-pill.theme-toggle:hover { background: #d97706; border-color: #d97706; color: #fff !important; }
html.dark-mode .st-pill.theme-toggle i::before { content: '\f186'; }

/* Dark Mode - Content Area */
html.dark-mode h1, html.dark-mode h2, html.dark-mode h3, html.dark-mode h4, html.dark-mode h5, html.dark-mode h6 {
    color: #f1f5f9;
}

html.dark-mode .card, html.dark-mode .card-body {
    background: #1e293b;
    border-color: #334155;
}

html.dark-mode .card-header {
    background: #334155;
    border-color: #475569;
}

html.dark-mode .table {
    color: #e2e8f0;
    border-color: #334155;
}

html.dark-mode .table thead {
    background: #334155;
    color: #f1f5f9;
}

html.dark-mode .table thead th {
    border-color: #475569;
    color: #f1f5f9;
}

html.dark-mode .table tbody td {
    border-color: #334155;
}

html.dark-mode .table tbody tr:hover {
    background: #0f2a44;
}

html.dark-mode .dataTables_wrapper { color: #e2e8f0; }
html.dark-mode .dataTables_length, html.dark-mode .dataTables_info { color: #cbd5e1; }
html.dark-mode .dataTables_paginate { color: #cbd5e1; }
html.dark-mode .dataTables_paginate .paginate_button { background: #334155; color: #e2e8f0; border-color: #475569; }
html.dark-mode .dataTables_paginate .paginate_button:hover { background: #475569; }
html.dark-mode .dataTables_paginate .paginate_button.current { background: #3b82f6; }

html.dark-mode .form-control, html.dark-mode .form-select, html.dark-mode .input-group {
    background: #1e293b;
    border-color: #475569;
    color: #f1f5f9;
}

html.dark-mode .form-control:focus, html.dark-mode .form-select:focus {
    background: #1e293b;
    border-color: #3b82f6;
    color: #f1f5f9;
}

html.dark-mode .form-control::placeholder {
    color: #64748b;
}

html.dark-mode .input-group-text {
    background: #334155;
    border-color: #475569;
    color: #cbd5e1;
}

html.dark-mode .btn {
    border-color: #475569;
}

html.dark-mode .btn-primary {
    background: #3b82f6;
    border-color: #3b82f6;
}

html.dark-mode .btn-primary:hover {
    background: #2563eb;
    border-color: #2563eb;
}

html.dark-mode .btn-secondary {
    background: #475569;
    border-color: #475569;
    color: #f1f5f9;
}

html.dark-mode .btn-secondary:hover {
    background: #64748b;
    border-color: #64748b;
}

html.dark-mode .btn-success {
    background: #10b981;
    border-color: #10b981;
}

html.dark-mode .btn-danger {
    background: #ef4444;
    border-color: #ef4444;
}

html.dark-mode .btn-warning {
    background: #f59e0b;
    border-color: #f59e0b;
}

html.dark-mode .badge {
    background: #3b82f6;
    color: #fff;
}

html.dark-mode .badge.bg-success { background: #10b981; }
html.dark-mode .badge.bg-danger { background: #ef4444; }
html.dark-mode .badge.bg-warning { background: #f59e0b; color: #000; }
html.dark-mode .badge.bg-info { background: #06b6d4; }

html.dark-mode .alert {
    border-color: #475569;
}

html.dark-mode .alert-success {
    background: #064e3b;
    border-color: #047857;
    color: #86efac;
}

html.dark-mode .alert-danger {
    background: #7f1d1d;
    border-color: #dc2626;
    color: #fca5a5;
}

html.dark-mode .alert-warning {
    background: #78350f;
    border-color: #b45309;
    color: #fcd34d;
}

html.dark-mode .alert-info {
    background: #0c2d4b;
    border-color: #0284c7;
    color: #93c5fd;
}

html.dark-mode .modal-content {
    background: #1e293b;
    border-color: #334155;
}

html.dark-mode .modal-header {
    background: #334155;
    border-color: #475569;
    color: #f1f5f9;
}

html.dark-mode .modal-footer {
    background: #334155;
    border-color: #475569;
}

html.dark-mode .close, html.dark-mode .btn-close {
    color: #f1f5f9;
}

html.dark-mode .dropdown-menu {
    background: #1e293b;
    border-color: #334155;
}

html.dark-mode .dropdown-item {
    color: #cbd5e1;
}

html.dark-mode .dropdown-item:hover, html.dark-mode .dropdown-item:focus {
    background: #334155;
    color: #f1f5f9;
}

html.dark-mode .select2-container--default .select2-selection--single {
    background: #1e293b;
    border-color: #475569;
}

html.dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #f1f5f9;
}

html.dark-mode .select2-dropdown {
    background: #1e293b;
    border-color: #475569;
}

html.dark-mode .select2-results__option {
    color: #e2e8f0;
}

html.dark-mode .select2-results__option:hover {
    background: #334155;
}

html.dark-mode hr { border-color: #334155; }

html.dark-mode label { color: #e2e8f0; }

html.dark-mode .text-muted { color: #94a3b8 !important; }
html.dark-mode .text-secondary { color: #cbd5e1 !important; }

html.dark-mode .border { border-color: #334155 !important; }
html.dark-mode .border-top { border-top-color: #334155 !important; }
html.dark-mode .border-bottom { border-bottom-color: #334155 !important; }
html.dark-mode .border-start { border-left-color: #334155 !important; }
html.dark-mode .border-end { border-right-color: #334155 !important; }

html.dark-mode .bg-light { background: #334155 !important; }
html.dark-mode .bg-white { background: #1e293b !important; }

/* Dark Mode - Badges en tablas */
html.dark-mode .badge.bg-light {
    background: #475569 !important;
    color: #f1f5f9 !important;
    border-color: #64748b !important;
}

html.dark-mode table .badge {
    background: #475569 !important;
    color: #f1f5f9 !important;
}

html.dark-mode table td .badge.bg-light {
    background: #334155 !important;
    color: #e2e8f0 !important;
    border: 1px solid #475569 !important;
}

/* Dark Mode - Texto en tablas */
html.dark-mode table td {
    color: #e2e8f0 !important;
}

html.dark-mode table td .text-dark {
    color: #f1f5f9 !important;
}

html.dark-mode table .fw-bold {
    color: #f1f5f9 !important;
}

/* Dark Mode - Elemento blanco genérico */
html.dark-mode [style*="background: white"],
html.dark-mode [style*="background-color: white"],
html.dark-mode [style*="background: #fff"],
html.dark-mode [style*="background-color: #fff"],
html.dark-mode [style*="background: #ffffff"],
html.dark-mode [style*="background-color: #ffffff"] {
    background: #1e293b !important;
}

html.dark-mode table tbody tr,
html.dark-mode table tbody tr td {
    background: #1e293b;
    color: #e2e8f0;
}

html.dark-mode table tbody tr:nth-child(odd) {
    background: #1e293b;
}

html.dark-mode table tbody tr:hover {
    background: #334155;
}

html.dark-mode .datatable tbody tr {
    background: #1e293b;
}

html.dark-mode .datatable tbody tr:hover {
    background: #334155;
}

/* Dark Mode - Fondo blanco general */
html.dark-mode .dataTables_wrapper {
    background: #0f172a;
}

html.dark-mode .dataTables_wrapper .dataTables_scroll table {
    background: #1e293b;
}

html.dark-mode .dataTables_scroll {
    background: #1e293b;
}

html.dark-mode tbody {
    background: #1e293b;
}

html.dark-mode thead {
    background: #334155;
}

html.dark-mode thead th {
    background: #334155;
    color: #f1f5f9;
    border-color: #475569;
}

/* Cualquier fondo blanco puro */
html.dark-mode [class*="thead"],
html.dark-mode [class*="header"] {
    background: #334155 !important;
    color: #f1f5f9 !important;
}
</style>

@stack('styles')

</head>

<body>

@include('shared.header')
@include('shared.aside')

<main id="main" class="main">
    <section class="section">
        @yield('contenido')
    </section>
</main>

@include('shared.footer')

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');
</script>

<script src="{{ asset('NiceAdmin/assets/js/main.js') }}"></script>

<script>
$(function(){
    if ($('.datatable').length) {
        $('.datatable').DataTable({
            language: {
                emptyTable: "No hay información",
                info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                infoEmpty: "Mostrando 0 a 0 de 0 entradas",
                lengthMenu: "Mostrar _MENU_ entradas",
                search: "Buscar:",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });
    }

    @if(session('success'))
    Swal.fire({ title:'Éxito', text:@json(session('success')), icon:'success' });
    @endif

    @if(session('error'))
    Swal.fire({ title:'Error', text:@json(session('error')), icon:'error' });
    @endif
});
</script>

@stack('scripts')

<script>
// Dark Mode Toggle
(function () {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;
    const themeKey = 'seguratech_theme';

    // Cargar tema guardado
    const savedTheme = localStorage.getItem(themeKey) || 'light';
    if (savedTheme === 'dark') {
        htmlElement.classList.add('dark-mode');
        updateThemeIcon();
    }

    // Toggle click handler
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            htmlElement.classList.toggle('dark-mode');
            const currentTheme = htmlElement.classList.contains('dark-mode') ? 'dark' : 'light';
            localStorage.setItem(themeKey, currentTheme);
            updateThemeIcon();
        });
    }

    function updateThemeIcon() {
        const icon = themeToggleBtn.querySelector('i');
        if (htmlElement.classList.contains('dark-mode')) {
            icon.className = 'bi bi-sun-fill';
        } else {
            icon.className = 'bi bi-moon-fill';
        }
    }
})();

(function () {
    var key = 'seg_tab_activa';
    @if(session('just_logged_in'))
        sessionStorage.setItem(key, '1');
    @else
        if (!sessionStorage.getItem(key)) {
            window.location.replace('/force-logout');
        }
        sessionStorage.setItem(key, '1');
    @endif
})();
</script>

</body>
</html>
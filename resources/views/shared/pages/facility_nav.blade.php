
<aside class="main-sidebar sidebar-dark-navy elevation-4" style="height: 100vh">

    <!-- System title and logo -->
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
    {{-- <a href="" class="brand-link text-center"> --}}
        {{-- <img src="{{ asset('public/images/pricon_logo2.png') }}" --}}
        <img src=""
            class="brand-image img-circle elevation-3"
            style="opacity: .8">

        <span class="brand-text font-weight-light font-size"><h5>FETLS</h5></span>
    </a> <!-- System title and logo -->

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="{{ url('../RapidX') }}" class="nav-link">
                        <i class="nav-icon fas fa-arrow-left"></i>
                        <p>Return to RapidX</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-gauge-high"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header font-weight-bold mt-4"><i class="fas fa-cogs"></i>&nbsp;FETLS MODULE</li>
                <li class="nav-item has-treeview d-none userList">
                    <a href="{{ route('user_management') }}" class="nav-link">
                        <i class="fa-solid fa-users"></i>
                        <p>User List</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('equipment') }}" class="nav-link">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        <p>Equipment List</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('fetls') }}" class="nav-link">
                        <i class="fa-solid fa-book-bookmark"></i>
                        <p>Trouble Logs</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('export_report') }}" class="nav-link">
                        <i class="fa-solid fa fa-file-excel"></i>
                        <p>Export Report</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div><!-- Sidebar -->
</aside>

@section('js_content')
    <script>
        $(document).ready(function(){    
        
        });
    </script>
@endsection
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="" class="nav-link">Facility Equipment Trouble Logs System</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i> 
            @php
            if(isset($_SESSION['rapidx_user_id'])){
                echo $_SESSION['rapidx_name'];
            }
            @endphp
        
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">            
        </li>
    </ul>
</nav>

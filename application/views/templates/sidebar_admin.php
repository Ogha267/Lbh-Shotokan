        <!-- Sidebar -->
        <ul class="navbar-nav bg-gray-600 sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-paste"></i>
                </div>
                <div class="sidebar-brand-text mx-3">GALERI FILE</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url('admin/index'); ?>">
                    <i class="fas fa-fw fas fa-home"></i>
                    <span>Beranda</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Administrator
            </div>

            <!-- Nav Item - Pages Collapse Menu -->

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('admin/man_user'); ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Manajemen User</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw far fa-clone"></i>
                    <span>View File</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="<?php echo base_url('admin/files'); ?>">Galeri File</a>
                        <a class="collapse-item" href="<?php echo base_url('admin/scan'); ?>">Galeri Berkas Scan</a>
                        <a class="collapse-item" href="<?php echo base_url('admin/input'); ?>">Galeri Berkas Input</a>
                        <a class="collapse-item" href="<?php echo base_url('admin/output'); ?>">Galeri Berkas Output</a>
                    </div>
                </div>
            </li>


            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                END
            </div>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('auth/logout'); ?>" id="tombol-logout">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
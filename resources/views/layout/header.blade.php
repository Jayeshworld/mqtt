<header class="header">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand mb-0 h4">{{ request()->is('dashboard') ? 'Dashboard Overview' : 'Other Page' }}</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-primary">
                <i class="fas fa-bell"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user"></i> Admin User
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#profile">Profile</a></li>
                    <li><a class="dropdown-item" href="#settings">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
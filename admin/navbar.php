<nav class="navbar navbar-expand-lg" style="background-color: #003366;">
    <div class="container-fluid px-4">
        <!-- Logo and Brand -->
        <a class="navbar-brand d-flex align-items-center text-white" href="dashboard.php">
            <img src="logo.png" alt="Logo" width="40" height="40" class="me-2">
            <span class="fw-bold fs-5">HouseWorkHelper Admin</span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar"
            aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Links -->
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto fw-semibold gap-2">
                <!-- gap reduced from large to 3 -->

                <li class="nav-item">
                    <a class="nav-link text-white" href="dashboard.php">
                        <i class="bi bi-speedometer2 text-warning me-1"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="manage_users.php">
                        <i class="bi bi-people-fill text-success me-1"></i> Manage Users
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="manage_requests.php">
                        <i class="bi bi-calendar-check-fill text-info me-1"></i> Manage Requests
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="add_helper.php">
                        <i class="bi bi-person-plus-fill text-light me-1"></i> Add Helper
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="view_feedback.php">
                        <i class="bi bi-chat-left-dots-fill text-warning me-1"></i> View Feedback
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="profile.php">
                        <i class="bi bi-person-circle text-secondary me-1"></i> Profile
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">
                        <i class="bi bi-box-arrow-right text-danger me-1"></i> Logout
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About - HouseWorkHelper | Hackathon Edition</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/about.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card p-4">
                    <div class="card-body">

                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h1 class="hero-title">
                                <i class="bi bi-stars text-primary"></i> HouseWorkHelper
                                <span class="highlight-badge ms-2">Hackathon Project</span>
                            </h1>
                            <p class="text-muted">Smart way to hire house help with trust, tech, and transparency.</p>
                        </div>

                        <hr>

                        <!-- What is it -->
                        <h4 class="section-title">
                            <i class="bi bi-lightbulb-fill text-warning me-2"></i> What is HouseWorkHelper?
                        </h4>
                        <p>
                            <strong>HouseWorkHelper</strong> is a web platform built in a hackathon to help Indian
                            families
                            quickly and safely hire trusted domestic workers — like maids, cooks, babysitters, and
                            cleaners.
                        </p>

                        <!-- Why use -->
                        <h4 class="section-title">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> Why Use It?
                        </h4>
                        <ul class="list-unstyled">
                            <li>Verified worker profiles</li>
                            <li>User/Admin separate dashboards</li>
                            <li>Real-time bookings and status</li>
                            <li>Secure PHP backend + Bootstrap UI</li>
                        </ul>

                        <!-- Tech stack -->
                        <h4 class="section-title">
                            <i class="bi bi-person-fill-gear text-secondary me-2"></i> Built With
                        </h4>
                        <p>
                            <strong>HTML</strong>, <strong>Bootstrap</strong>, <strong>JavaScript</strong>,
                            <strong>PHP</strong>, and <strong>MySQL</strong> — all used to build a clean, full-stack app
                            within hackathon deadlines.
                        </p>

                        <!-- Note -->
                        <div class="mt-4 text-center">
                            <i class="bi bi-trophy-fill text-warning fs-3"></i>
                            <p class="mt-2">Built in a 48-hour hackathon challenge to solve a real urban problem.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.html') ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
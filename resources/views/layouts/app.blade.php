<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Learning</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/seodashlogo.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

  <!-- Bootstrap Icons CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

  {{--
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.html" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/logos/logo-light.svg') }}" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('dashboard.index') }}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
              <span class="hide-menu">Master Data</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('users.index') }}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">User</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route(name: 'dosens.index') }}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:user-id-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Dosen</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route(name: 'mahasiswas.index') }}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:user-rounded-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Mahasiswa</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route(name: 'matakuliahs.index') }}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:book-2-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Matakuliah</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-6" class="fs-6"></iconify-icon>
              <span class="hide-menu">Akademik</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:buildings-2-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Kelas</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./authentication-register.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:clipboard-list-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">KRS</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4" class="fs-6"></iconify-icon>
              <span class="hide-menu">Laporan</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./icon-tabler.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:chart-square-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Laporan Dosen</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:chart-square-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Laporan Mahasiswa</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:chart-square-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Laporan Matakuliah</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:chart-square-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Laporan KRS</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->

      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->

    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <a href="#" target="_blank" class="btn btn-primary me-2"><span class="d-none d-md-block">Check Pro
                  Version</span> <span class="d-block d-md-none">Pro</span></a>
              <a href="#" target="_blank" class="btn btn-success"><span class="d-none d-md-block">Download Free </span>
                <span class="d-block d-md-none">Free</span></a>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35" height="35"
                    class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <a href="{{ route('logout') }}" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->

      <div class="container-fluid d-flex flex-column min-vh-100">

        <div class="page-heading mb-2">
          @yield('page-heading')
        </div>

        <div class="page-content flex-fill">
          @yield('content')
        </div>

        {{-- <div class="row">
          <div class="col-lg-8">
            <div class="card" id="overview">
              <div class="card-body">
                <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                  Traffic Overview
                  <span>
                    <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted"
                      data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success"
                      data-bs-title="Traffic Overview"></iconify-icon>
                  </span>
                </h5>
                <div id="traffic-overview">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body text-center">
                <img src="{{ asset('assets/images/backgrounds/product-tip.png') }}" alt="image" class="img-fluid"
                  width="205">
                <h4 class="mt-7">Productivity Tips!</h4>
                <p class="card-subtitle mt-2 mb-3">Duis at orci justo nulla in libero id leo
                  molestie sodales phasellus justo.</p>
                <button class="btn btn-primary mb-3">View All Tips</button>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">View by page title and screen class</h5>
                <div class="table-responsive">
                  <table class="table text-nowrap align-middle mb-0">
                    <thead>
                      <tr class="border-2 border-bottom border-primary border-0">
                        <th scope="col" class="ps-0">Page Title</th>
                        <th scope="col">Link</th>
                        <th scope="col" class="text-center">Pageviews</th>
                        <th scope="col" class="text-center">Page Value</th>
                      </tr>
                    </thead>
                    <tbody class="table-group-divider">
                      <tr>
                        <th scope="row" class="ps-0 fw-medium">
                          <span class="table-link1 text-truncate d-block">Welcome to our
                            website</span>
                        </th>
                        <td>
                          <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">/index.html</a>
                        </td>
                        <td class="text-center fw-medium">18,456</td>
                        <td class="text-center fw-medium">$2.40</td>
                      </tr>
                      <tr>
                        <th scope="row" class="ps-0 fw-medium">
                          <span class="table-link1 text-truncate d-block">Modern Admin
                            Dashboard Template</span>
                        </th>
                        <td>
                          <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">/dashboard</a>
                        </td>
                        <td class="text-center fw-medium">17,452</td>
                        <td class="text-center fw-medium">$0.97</td>
                      </tr>
                      <tr>
                        <th scope="row" class="ps-0 fw-medium">
                          <span class="table-link1 text-truncate d-block">Explore our
                            product catalog</span>
                        </th>
                        <td>
                          <a href="javascript:void(0)"
                            class="link-primary text-dark fw-medium d-block">/product-checkout</a>
                        </td>
                        <td class="text-center fw-medium">12,180</td>
                        <td class="text-center fw-medium">$7,50</td>
                      </tr>
                      <tr>
                        <th scope="row" class="ps-0 fw-medium">
                          <span class="table-link1 text-truncate d-block">Comprehensive
                            User Guide</span>
                        </th>
                        <td>
                          <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">/docs</a>
                        </td>
                        <td class="text-center fw-medium">800</td>
                        <td class="text-center fw-medium">$5,50</td>
                      </tr>
                      <tr>
                        <th scope="row" class="ps-0 fw-medium border-0">
                          <span class="table-link1 text-truncate d-block">Check out our
                            services</span>
                        </th>
                        <td class="border-0">
                          <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">/services</a>
                        </td>
                        <td class="text-center fw-medium border-0">1300</td>
                        <td class="text-center fw-medium border-0">$2,15</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title d-flex align-items-center gap-2 mb-5 pb-3">Sessions by
                  device<span>
                    <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted"
                      data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success"
                      data-bs-title="Locations"></iconify-icon>
                  </span>
                </h5>
                <div class="row">
                  <div class="col-4">
                    <iconify-icon icon="solar:laptop-minimalistic-line-duotone" class="fs-7 d-flex text-primary">
                    </iconify-icon>
                    <span class="fs-11 mt-2 d-block text-nowrap">Computers</span>
                    <h4 class="mb-0 mt-1">87%</h4>
                  </div>
                  <div class="col-4">
                    <iconify-icon icon="solar:smartphone-line-duotone" class="fs-7 d-flex text-secondary">
                    </iconify-icon>
                    <span class="fs-11 mt-2 d-block text-nowrap">Smartphone</span>
                    <h4 class="mb-0 mt-1">9.2%</h4>
                  </div>
                  <div class="col-4">
                    <iconify-icon icon="solar:tablet-line-duotone" class="fs-7 d-flex text-success"></iconify-icon>
                    <span class="fs-11 mt-2 d-block text-nowrap">Tablets</span>
                    <h4 class="mb-0 mt-1">3.1%</h4>
                  </div>
                </div>

                <div class="vstack gap-4 mt-7 pt-2">
                  <div>
                    <div class="hstack justify-content-between">
                      <span class="fs-3 fw-medium">Computers</span>
                      <h6 class="fs-3 fw-medium text-dark lh-base mb-0">87%</h6>
                    </div>
                    <div class="progress mt-6" role="progressbar" aria-label="Warning example" aria-valuenow="75"
                      aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar bg-primary" style="width: 100%"></div>
                    </div>
                  </div>

                  <div>
                    <div class="hstack justify-content-between">
                      <span class="fs-3 fw-medium">Smartphones</span>
                      <h6 class="fs-3 fw-medium text-dark lh-base mb-0">9.2%</h6>
                    </div>
                    <div class="progress mt-6" role="progressbar" aria-label="Warning example" aria-valuenow="75"
                      aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar bg-secondary" style="width: 50%"></div>
                    </div>
                  </div>

                  <div>
                    <div class="hstack justify-content-between">
                      <span class="fs-3 fw-medium">Tablets</span>
                      <h6 class="fs-3 fw-medium text-dark lh-base mb-0">3.1%</h6>
                    </div>
                    <div class="progress mt-6" role="progressbar" aria-label="Warning example" aria-valuenow="75"
                      aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar bg-success" style="width: 35%"></div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card overflow-hidden hover-img">
              <div class="position-relative">
                <a href="javascript:void(0)">
                  <img src="{{ asset('assets/images/blog/blog-img1.jpg') }}" class="card-img-top" alt="matdash-img">
                </a>
                <span
                  class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">2
                  min Read</span>
                <img src="{{ asset('assets/images/profile/user-3.jpg') }}" alt="matdash-img"
                  class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="40" height="40"
                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Georgeanna Ramero">
              </div>
              <div class="card-body p-4">
                <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3">Social</span>
                <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="">As yen tumbles, gadget-loving
                  Japan goes
                  for secondhand iPhones</a>
                <div class="d-flex align-items-center gap-4">
                  <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-eye text-dark fs-5"></i>9,125
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-message-2 text-dark fs-5"></i>3
                  </div>
                  <div class="d-flex align-items-center fs-2 ms-auto">
                    <i class="ti ti-point text-dark"></i>Mon, Dec 19
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card overflow-hidden hover-img">
              <div class="position-relative">
                <a href="javascript:void(0)">
                  <img src="{{ asset('assets/images/blog/blog-img2.jpg') }}" class="card-img-top" alt="matdash-img">
                </a>
                <span
                  class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">2
                  min Read</span>
                <img src="{{ asset('assets/images/profile/user-2.jpg') }}" alt="matdash-img"
                  class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="40" height="40"
                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Georgeanna Ramero">
              </div>
              <div class="card-body p-4">
                <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3">Gadget</span>
                <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="">Intel loses bid to revive
                  antitrust case
                  against patent foe Fortress</a>
                <div class="d-flex align-items-center gap-4">
                  <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-eye text-dark fs-5"></i>4,150
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-message-2 text-dark fs-5"></i>38
                  </div>
                  <div class="d-flex align-items-center fs-2 ms-auto">
                    <i class="ti ti-point text-dark"></i>Sun, Dec 18
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card overflow-hidden hover-img">
              <div class="position-relative">
                <a href="javascript:void(0)">
                  <img src="{{ asset('assets/images/blog/blog-img3.jpg') }}" class="card-img-top" alt="matdash-img">
                </a>
                <span
                  class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">2
                  min Read</span>
                <img src="{{ asset('assets/images/profile/user-3.jpg') }}" alt="matdash-img"
                  class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="40" height="40"
                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Georgeanna Ramero">
              </div>
              <div class="card-body p-4">
                <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3">Health</span>
                <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="">COVID outbreak deepens as more
                  lockdowns
                  loom in China</a>
                <div class="d-flex align-items-center gap-4">
                  <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-eye text-dark fs-5"></i>9,480
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-message-2 text-dark fs-5"></i>12
                  </div>
                  <div class="d-flex align-items-center fs-2 ms-auto">
                    <i class="ti ti-point text-dark"></i>Sat, Dec 17
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="py-6 px-6 text-center">
            <p class="mb-0 fs-4">Design and Developed by <a href="https://adminmart.com/" target="_blank"
                class="pe-1 text-primary text-decoration-underline">AdminMart.com</a>Distributed by <a
                href="https://themewagon.com/" target="_blank"
                class="pe-1 text-primary text-decoration-underline">ThemeWagon</a></p>
          </div>
        </div> --}}

      </div>
    </div>


    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DATATABLE CORE -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- DATATABLE BOOTSTRAP -->
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')
</body>

</html>
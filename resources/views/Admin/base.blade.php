<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>index</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <div id="app">
      <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm">
        <div class="container">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse text-primary" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto"></ul>
            <ul class="navbar-nav ms-auto">
              @guest
              @if (Route::has('login'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
              @endif
              @if (Route::has('register'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
              @endif
              @else
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </div>
              </li>
              @endguest
            </ul>
          </div>
        </div>
      </nav>
      <div class="container-fluid">
        <div class="row flex-nowrap">
          <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
              <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                <li class="nav-item">
                  <li class="w-100">
                    <a href="front.php" class="nav-link px-0 "> <span class="d-none d-sm-inline">productivity </span>  </a>
                  </li>
                  <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                  <li class="w-100">
                      <a href="{{url('/home/adminhome')}}" class="nav-link px-0 text-white"> <span class="d-none d-sm-inline">Dashboard</span>  </a>
                    </li>
                    <li>
                      <a href="{{url('/home/employeeview')}}" class="nav-link px-0 text-white"> <span class="d-none d-sm-inline">Employee</span></a>
                    </li>
                    <li>
                      <a href="{{url('/home/clientview')}}" class="nav-link px-0 text-white"> <span class="d-none d-sm-inline">Client</span></a>
                    </li>
                    <li>
                      <a href="{{url('/home/projectview')}}" class="nav-link px-0 text-white"> <span class="d-none d-sm-inline">Projects</span></a>
                    </li>
                    <li>
                      <a href="{{url('/taskview')}}" class="nav-link px-0 text-white"> <span class="d-none d-sm-inline">Task Schedule</span></a>
                    </li>
                    <li>
                      <a href="{{url('/adminleaveview/{id}')}}" class="nav-link px-0 text-white"> <span class="d-none d-sm-inline">Leave View</span></a>
                    </li>
                    <li class="nav-item">
    <a class="nav-link px-0 text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="d-none d-sm-inline">Report</span>
    </a>
    <ul class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
        <li class="w-100">
            <a href="{{url('/barchart/view')}}" class="nav-link px-0 text-white">
                <span class="d-none d-sm-inline">project Report </span>
            </a>
        </li>
        <li class="w-100">
            <a href="{{url('/approved-clients/report')}}" class="nav-link px-0 text-white">
                <span class="d-none d-sm-inline">client Report </span>
            </a>
        </li>
        <li class="w-100">
            <a href="{{url('/paymentreport')}}" class="nav-link px-0 text-white">
                <span class="d-none d-sm-inline">Client Payment Report </span>
            </a>
        </li>
        <li class="w-100">
            <a href="{{url('/home/showEmployeeSalaries')}}" class="nav-link px-0 text-white">
                <span class="d-none d-sm-inline">Employee Salary</span>
            </a>
        </li>
        <li class="w-100">
            <a href="{{url('/home/showallmonth')}}" class="nav-link px-0 text-white">
                <span class="d-none d-sm-inline">All Month  Salary</span>
            </a>
        </li>
        <!-- Add more sublist items as needed -->
    </ul>
</li>

                  </ul>
                </li>
              </ul>
              <hr>
            </div>
          </div>
          <main class="col px-0 py-0">
            @yield('base')
          </main>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>

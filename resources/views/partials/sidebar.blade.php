<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('/img/book.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">UniLib</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">ACTIONS</li>
        <li class="nav-item">
          <a href="{{ route('book-loans-create-step1') }}" class="nav-link {{ active_link(request(), 'book-loans/create*') }}">
            <i class="fas fa-arrow-right mx-2"></i>
            <p>
              Issue a book
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('book-loans.return') }}" class="nav-link {{ active_link(request(), 'book-loans/return') }}">
            <i class="fas fa-arrow-left mx-2"></i>
            <p>
              Return a book
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('download.options') }}" class="nav-link {{ active_link(request(), 'download*') }}">
              <i class="nav-icon fas fa-print"></i>
              <p>
                  Print QR codes
              </p>
          </a>
        </li>
        <li class="nav-header mt-2">DATA</li>
        <li class="nav-item">
          <a href="{{ route('books.index') }}" class="nav-link {{ active_link(request(), 'books*') }}">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Books
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('authors.index') }}" class="nav-link {{ active_link(request(), 'authors*') }}">
            <i class="nav-icon fas fa-pen-alt"></i>
            <p>
              Authors
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('publishers.index') }}" class="nav-link {{ active_link(request(), 'publishers*') }}">
            <i class="nav-icon fas fa-print"></i>
            <p>
              Publishers
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('users.index') }}" class="nav-link {{ active_link(request(), 'users*') }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users
            </p>
          </a>
        </li>
{{--  implement in the future - search for books using qr code  --}}
{{--        <li class="nav-item">--}}
{{--          <a href="{{ route('qr-code-scan') }}" class="nav-link {{ active_link(request(), 'qrcode*') }}">--}}
{{--            <i class="nav-icon fas fa-qrcode"></i>--}}
{{--            <p>--}}
{{--              Scan a QR--}}
{{--            </p>--}}
{{--          </a>--}}
{{--        </li>--}}
        </ul>
    </nav>
      <!-- /.sidebar-menu -->
  </div>
    <!-- /.sidebar -->
</aside>

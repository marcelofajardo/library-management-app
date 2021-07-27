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
        <li class="nav-header">OPTIONS</li>
          <li class="nav-item">
            <a href="/books" class="nav-link {{ active_link(request(), 'books*') }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Books
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/authors" class="nav-link {{ active_link(request(), 'authors*') }}">
              <i class="nav-icon fas fa-pen-alt"></i>
              <p>
                Authors
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/publishers" class="nav-link {{ active_link(request(), 'publishers*') }}">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Publishers
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/subjects" class="nav-link {{ active_link(request(), 'subjects*') }}">
              <i class="nav-icon fa fa-border-all"></i>
              <p>
                Subjects
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/genres" class="nav-link {{ active_link(request(), 'genres*') }}">
              <i class="nav-icon fas fa-rocket"></i>
              <p>
                Genres
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/users" class="nav-link {{ active_link(request(), 'users*') }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
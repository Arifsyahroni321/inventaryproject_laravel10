<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ Request::is('') ? '' : 'collapsed' }}" href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link {{ Request::is('user') ? '' : 'collapsed' }}" href="{{ url('user') }}">
          <i class="bi bi-people-fill"></i>
          <span>Users</span>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link {{ Request::is('product') ? '' : 'collapsed' }}" href="{{ url('product') }}">
          <i class="bi bi-menu-button-wide"></i>
          <span>Products</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('categori') ? '' : 'collapsed' }}" href="{{ url('categori') }}">
          <i class="bi bi-bookmarks"></i>
          <span>Categories</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('') ? '' : 'collapsed' }}" href="users-profile.html">
          <i class="bi bi-clock-history"></i>
          <span>Loans Record</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('') ? '' : 'collapsed' }}" href="users-profile.html">
          <i class="bi bi-card-checklist"></i>
          <span>Stock In</span>
        </a>
      </li>
      {{-- <li class="nav-heading">Transaction</li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-card-checklist"></i><span>Stock</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li >
                <a href="components-alerts.html">
                  <i class="bi bi-circle "></i><span>Stock Entries</span>
                </a>
              </li>
              <li >
                <a href="components-accordion.html">
                  <i class="bi bi-circle"></i><span>Stock Exits</span>
                </a>
              </li>
        </ul>
      </li> --}}


    </ul>

  </aside>

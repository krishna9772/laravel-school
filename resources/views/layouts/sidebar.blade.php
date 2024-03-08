<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed h-100">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">School Mangement</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
                <?php
                    echo Auth::user()->user_name;
                ?>
          </a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{route('dashboard')}}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
                </a>
            </li>

            {{-- grades section --}}
            <li class="nav-item {{ Route::is('grades.*') ? 'menu-open'  : '' }}">

                <a href="#" class="nav-link {{ Route::is('grades.*') ? 'active'  : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Grades
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('grades.index')}}" class="nav-link {{ Route::is('grades.index') ? 'active'  : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Grades</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('grades.create')}}" class="nav-link {{ Route::is('grades.create') ? 'active'  : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>New Grade</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('grades.modify')}}" class="nav-link {{ Route::is('grades.modify') ? 'active'  : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Update or Delete</p>
                    </a>
                </li>
                </ul>
            </li>

          {{-- class section --}}
            <li class="nav-item {{ Route::is('classes.*') ? 'menu-open'  : '' }}">
                <a href="#" class="nav-link {{ Route::is('classes.*') ? 'active'  : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Classes
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('classes.index')}}" class="nav-link {{ Route::is('classes.index') ? 'active'  : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Classes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('classes.create')}}" class="nav-link {{ Route::is('classes.create') ? 'active'  : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>New Class</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('classes.modify')}}" class="nav-link {{ Route::is('classes.modify') ? 'active'  : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Update or Delete</p>
                    </a>
                </li>
                </ul>
            </li>

            {{-- registration section --}}
            <li class="nav-item {{ Route::is('users.*') ? 'menu-open'  : '' }}">
                <a href="#" class="nav-link {{ Route::is('users.*') ? 'active'  : '' }}">
                    <i class="nav-icon fa fa-address-card"></i>
                    <p>
                    Registrations
                    <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item activ">
                      <a href="{{route('users.index')}}" class="nav-link {{ Route::is('users.index') ? 'active'  : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>All Registrations</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('users.create')}}" class="nav-link {{ Route::is('users.create') ? 'active'  : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>New Registration</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('users.modify')}}" class="nav-link {{ Route::is('users.modify') ? 'active'  : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Update Or Delete</p>
                      </a>
                    </li>
                </ul>
            </li>

            {{-- curriculum section --}}
            <li class="nav-item {{ Route::is('curricula.*') ? 'menu-open'  : '' }}">
              <a href="#" class="nav-link {{ Route::is('curricula.*') ? 'active'  : '' }}">
                  <i class="nav-icon fa fa-address-card"></i>
                  <p>
                  Curricula
                  <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item activ">
                    <a href="{{route('curricula.index')}}" class="nav-link {{ Route::is('curricula.index') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Curricula</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('curricula.create')}}" class="nav-link {{ Route::is('curricula.create') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Curriculum</p>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a href="{{route('curricula.modify')}}" class="nav-link {{ Route::is('curricula.modify') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Update Or Delete</p>
                    </a>
                  </li> --}}
              </ul>
            </li>

          {{-- classwork section --}}
            <li class="nav-item {{ Route::is('classworks.*') ? 'menu-open'  : '' }}">

                <a href="#" class="nav-link {{ Route::is('classworks.*') ? 'active'  : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Classwork
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('classworks.index')}}" class="nav-link {{ Route::is('classworks.index') ? 'active'  : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Classworks</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('classworks.create')}}" class="nav-link {{ Route::is('classworks.create') ? 'active'  : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>New Classwork</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ Route::is('classworks.edit') ? 'active'  : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Update or Delete</p>
                    </a>
                </li>
              </ul>
            </li>
        </ul>

        <ul class="nav nav-pills nav-sidebar flex-column" style="position: absolute; bottom : 20px">
            <li>
                <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button type="submit" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt "></i>
                        <p>
                            Logout
                        </p>
                    </button>
                </form>
            </li>
        </ul>
    </nav>

      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

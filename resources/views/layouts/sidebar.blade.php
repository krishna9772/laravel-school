<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-blue elevation-4 position-fixed h-100">
    <!-- Brand Logo -->
    {{-- <div class="" style="margin-right: 30px !important"> --}}
        <a href="index3.html" class="nav-link" style="margin-left: 8px; margin-top: 10px">
            <i class="fa fa-university nav-icon" style="color: #d6d6d6; font-size: 30px;"></i>
            {{-- <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
            <span class="brand-text font-weight-light text-white" style="font-size: 18px">School Management</span>
        </a>

    {{-- </div> --}}


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

            {{-- dashboard section --}}
            @can('manage dashboard')
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i><p>Dashboard</p>
                    </a>
                </li>
            @endcan

            {{-- grades section --}}
            @can('manage grades')
                <li class="nav-item {{ Route::is('grades.*') ? 'menu-open'  : '' }}">

                    <a href="#" class="nav-link {{ Route::is('grades.*') ? 'active'  : '' }}">
                    {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                    <img src="{{asset('images/menu_icons/result.png')}}" alt="" width="25px">
                    <p>Grades <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('grades.index')}}" class="nav-link {{ Route::is('grades.index') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">

                        <a href="{{route('grades.create')}}" class="nav-link {{ Route::is('grades.create') ? 'active'  : '' }}">
                        {{-- @if(Route::is('grades.index'))
                        <span class="far fa-circle" style="position: relative;">
                            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 5px; height: 5px; background-color: black; border-radius: 50%;"></span>
                        </span>
                        @else
                            <i class='far fa-circle nav-icon'></i>
                        @endif --}}

                        <i class="far fa-circle nav-icon"></i>

                        <p>New</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('grades.modify')}}" class="nav-link {{ Route::is('grades.modify') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Edit</p>
                        </a>
                    </li>
                    </ul>
                </li>
            @endcan

            @can('manage classes')
                <li class="nav-item {{ Route::is('classes.*') ? 'menu-open'  : '' }}">
                    <a href="#" class="nav-link {{ Route::is('classes.*') ? 'active'  : '' }}">
                    {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                    <img src="{{asset('images/menu_icons/training (8).png')}}" alt="" width="25px">
                    <p>
                        Classes
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('classes.index')}}" class="nav-link {{ Route::is('classes.index') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('classes.createNewClass')}}" class="nav-link {{ Route::is('classes.create') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>New</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('classes.modify')}}" class="nav-link {{ Route::is('classes.modify') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Edit</p>
                        </a>
                    </li>
                    </ul>
                </li>
            @endcan


          {{-- class section --}}


            {{-- registration section --}}
            @can('manage registrations')
                <li class="nav-item {{ Route::is('users.*') ? 'menu-open'  : '' }}">
                    <a href="#" class="nav-link {{ Route::is('users.*') ? 'active'  : '' }}">
                        <i class="nav-icon fa fa-address-card"></i><p>Registrations<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item activ">
                        <a href="{{route('users.index')}}" class="nav-link {{ Route::is('users.index') ? 'active'  : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{route('users.create')}}" class="nav-link {{ Route::is('users.create') ? 'active'  : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>New</p>
                        </a>
                        </li>
                    </ul>
                </li>
            @endcan


            {{-- curriculum section --}}
            @can('manage subjects')
            <li class="nav-item {{ Route::is('curricula.*') ? 'menu-open'  : '' }}">
                <a href="#" class="nav-link {{ Route::is('curricula.*') ? 'active'  : '' }}">
                    {{-- <i class="nav-icon fa fa-address-card"></i> --}}
                    <img src="{{asset('images/menu_icons/curriculum.png')}}" alt="" width="25px">
                    <p>
                    Subjects
                    <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item activ">
                      <a href="{{route('curricula.index')}}" class="nav-link {{ Route::is('curricula.index') ? 'active'  : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>List</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('curricula.create')}}" class="nav-link {{ Route::is('curricula.create') ? 'active'  : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>New</p>
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
            @endcan


          {{-- classwork section --}}
            @can('manage classworks')
                <li class="nav-item {{ Route::is('classworks.*') ? 'menu-open'  : '' }}">

                    <a href="#" class="nav-link {{ Route::is('classworks.*') ? 'active'  : '' }}">
                    {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                    <img src="{{asset('images/menu_icons/homework.png')}}" alt="" width="25px">
                    <p>
                        Classwork
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('classworks.index')}}" class="nav-link {{ Route::is('classworks.index') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('classworks.create')}}" class="nav-link {{ Route::is('classworks.create') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>New</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="#" class="nav-link {{ Route::is('classworks.edit') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Update or Delete</p>
                        </a>
                    </li> --}}
                </ul>
                </li>
            @endcan


            @can('manage promotions')
                <li class="nav-item {{ Route::is('promote.*') ? 'menu-open'  : '' }}">

                    <a href="#" class="nav-link {{ Route::is('promote.*') ? 'active'  : '' }}">
                    {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                    <i class="fa fa-upload mr-2" aria-hidden="true"></i>
                    {{-- <img src="{{asset('images/menu_icons/homework.png')}}" alt="" width="25px"> --}}
                    <p>Promotions<i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('promote.search')}}" class="nav-link {{ Route::is('promote.search') ? 'active'  : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Promote Student</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('manage attendances')

            <li class="nav-item {{ Route::is('attendances.*') ? 'menu-open'  : '' }}">

                <a href="#" class="nav-link {{ Route::is('attendances.*') ? 'active'  : '' }}">
                {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                <img src="{{asset('images/menu_icons/check.png')}}" alt="" width="23px">
                <p>
                    Attendances
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="{{ route('attendances.mark.search') }}" class="nav-link {{ Route::is('attendances.mark.search') ? 'active'  : '' }}">
                            @if(!Route::is('attendances.mark.search'))
                            <i class="fas fa-dot-circle"></i> <!-- First icon when active -->
                            @else
                                <i class="fa fa-solid fa-circle nav-icon"></i> <!-- Second icon when not active -->
                            @endif
                            <p>Mark Attendance</p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{route('attendances.report.search')}}" class="nav-link {{ Route::is('attendances.report.search') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Attendance Report</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="#" class="nav-link {{ Route::is('classworks.edit') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Update or Delete</p>
                        </a>
                    </li> --}}
                </ul>
            </li>

            @endcan

            @can('manage exam marks')

            <li class="nav-item {{ Route::is('exam_marks.*') ? 'menu-open'  : '' }}">

                <a href="#" class="nav-link {{ Route::is('exam_marks.*') ? 'active'  : '' }}">
                {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                <img src="{{asset('images/menu_icons/test-results (1).png')}}" alt="" width="23px">
                <p>
                    Exam Marks
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('classworks.index')}}" class="nav-link {{ Route::is('classworks.index') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>New</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('classworks.create')}}" class="nav-link {{ Route::is('classworks.create') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Edit</p>
                        </a>
                    </li>
                </ul>
            </li>

            @endcan


        </ul>
    </nav>

      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

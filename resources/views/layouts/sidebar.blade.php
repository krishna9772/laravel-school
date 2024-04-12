<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-blue elevation-4 position-fixed h-100">
    <!-- Brand Logo -->
    {{-- <div class="" style="margin-right: 30px !important"> --}}
        <a href="index3.html" class="nav-link" style="margin-left: 8px; margin-top: 10px">
            <i class="fa fa-university nav-icon" style="color: #000; font-size: 30px;"></i>
            {{-- <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
            <span class="brand-text font-weight-light text-white" style="font-size: 18px">School Management</span>
        </a>

    {{-- </div> --}}


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          {{-- <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image"> --}}
          <i class="fas fa-user m-2"></i>
        </div>
        <div class="info">
          <a href="#" class="d-block text-capitalize">
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
                        <i class="nav-icon fas fa-graduation-cap"></i><p>Grade<i class="right fas fa-angle-left"></i></p>
                        {{-- <img src="{{asset('images/menu_icons/result.png')}}" alt="" width="25px"> --}}

                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('grades.index')}}" class="nav-link {{ Route::is('grades.index') ? 'active'  : '' }}">
                        @if(Route::is('grades.index'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif

                        <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">

                        <a href="{{route('grades.create')}}" class="nav-link {{ Route::is('grades.create') ? 'active'  : '' }}">
                       
                            @if(Route::is('grades.create'))
                                <i class="fas fa-dot-circle nav-icon"></i>
                            @else
                                <i class="far fa-circle nav-icon"></i>
                            @endif

                        <p>New</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('grades.modify')}}" class="nav-link {{ Route::is('grades.modify') ? 'active'  : '' }}">
                        @if(Route::is('grades.modify'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif                        
                        <p>Edit</p>
                        </a>
                    </li>
                    </ul>
                </li>
            @endcan

            @can('manage classes')
                <li class="nav-item {{ Route::is('classes.*') ? 'menu-open'  : '' }}">
                    <a href="#" class="nav-link {{ Route::is('classes.*') ? 'active'  : '' }}">
                    <i class="nav-icon fas fa-chalkboard-teacher"></i><p>Class<i class="right fas fa-angle-left"></i>
                    </p>
                    {{-- <img src="{{asset('images/menu_icons/training (8).png')}}" alt="" width="25px"> --}}
                   
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('classes.index')}}" class="nav-link {{ Route::is('classes.index') ? 'active'  : '' }}">
                        @if(Route::is('classes.index'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif  
                        <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('classes.createNewClass')}}" class="nav-link {{ Route::is('classes.create') ? 'active'  : '' }}">
                        @if(Route::is('classes.createNewClass'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif
                        <p>New</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('classes.modify')}}" class="nav-link {{ Route::is('classes.modify') ? 'active'  : '' }}">
                        @if(Route::is('classes.modify'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif
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
                        <i class="nav-icon fa fa-address-card"></i><p>Registration<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item activ">
                        <a href="{{route('users.index')}}" class="nav-link {{ Route::is('users.index') ? 'active'  : '' }}">
                        @if(Route::is('users.index'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif
                        <p>List</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{route('users.create')}}" class="nav-link {{ Route::is('users.create') ? 'active'  : '' }}">
                        @if(Route::is('users.create'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif  
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
                    <i class="nav-icon fas fa-book"></i><p>Subject<i class="right fas fa-angle-left"></i></p>
                    {{-- <img src="{{asset('images/menu_icons/curriculum.png')}}" alt="" width="25px"> --}}
                    
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item activ">
                      <a href="{{route('curricula.index')}}" class="nav-link {{ Route::is('curricula.index') ? 'active'  : '' }}">
                        @if(Route::is('curricula.index'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif 
                        <p>List</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('curricula.create')}}" class="nav-link {{ Route::is('curricula.create') ? 'active'  : '' }}">
                        @if(Route::is('curricula.create'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif
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
                    <i class="nav-icon fas fa-pencil-alt"></i><p>Classwork<i class="right fas fa-angle-left"></i></p>
                    {{-- <img src="{{asset('images/menu_icons/homework.png')}}" alt="" width="25px"> --}}
                    
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('classworks.index')}}" class="nav-link {{ Route::is('classworks.index') ? 'active'  : '' }}">
                        @if(Route::is('classworks.index'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif
                        <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('classworks.create')}}" class="nav-link {{ Route::is('classworks.create') ? 'active'  : '' }}">
                        @if(Route::is('classworks.create'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif
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
                    <i class="nav-icon fa fa-upload" aria-hidden="true"></i><p>Promotion<i class="right fas fa-angle-left"></i>
                    </p>
                    {{-- <img src="{{asset('images/menu_icons/homework.png')}}" alt="" width="25px"> --}}
                    
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('promote.search')}}" class="nav-link {{ Route::is('promote.search') ? 'active'  : '' }}">
                            @if(Route::is('promote.search'))
                                <i class="fas fa-dot-circle nav-icon"></i>
                            @else
                                <i class="far fa-circle nav-icon"></i>
                            @endif
                            <p>Promote Student</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('manage attendances')

            <li class="nav-item {{ Route::is('attendances.*') ? 'menu-open'  : '' }}">

                <a href="#" class="nav-link {{ Route::is('attendances.*') ? 'active'  : '' }}">
                    <i class="nav-icon fas fa-check-circle"></i><p>Attendance<i class="right fas fa-angle-left"></i></p>
                </a>

                {{-- <img src="{{asset('images/menu_icons/check.png')}}" alt="" width="23px"> --}}
               
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('attendances.mark.search')}}" class="nav-link {{ Route::is('attendances.mark.search') ? 'active'  : '' }}">
                    @if(Route::is('attendances.mark.search'))
                        <i class="fas fa-dot-circle nav-icon"></i>
                    @else
                        <i class="far fa-circle nav-icon"></i>
                    @endif
                    <p>Mark Attendance</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('attendances.report.search')}}" class="nav-link {{ Route::is('attendances.report.search') ? 'active'  : '' }}">
                    @if(Route::is('attendances.report.search'))
                        <i class="fas fa-dot-circle nav-icon"></i>
                    @else
                        <i class="far fa-circle nav-icon"></i>
                    @endif
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
                <i class="nav-icon fas fa-chart-bar"></i><p>Exam Mark<i class="right fas fa-angle-left"></i></p>
                {{-- <img src="{{asset('images/menu_icons/test-results (1).png')}}" alt="" width="23px"> --}}
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('classworks.index')}}" class="nav-link {{ Route::is('classworks.index') ? 'active'  : '' }}">
                        @if(Route::is('classworks.index'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif
                        <p>New</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('classworks.index')}}" class="nav-link {{ Route::is('classworks.create') ? 'active'  : '' }}">
                        @if(Route::is('classworks.index'))
                            <i class="fas fa-dot-circle nav-icon"></i>
                        @else
                            <i class="far fa-circle nav-icon"></i>
                        @endif
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

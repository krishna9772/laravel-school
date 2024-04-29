<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-blue elevation-4 position-fixed h-100">
    <!-- Brand Logo -->
    {{-- <div class="" style="margin-right: 30px !important"> --}}
        <a href="{{route('dashboard')}}" class="nav-link" style="margin-left: 8px; margin-top: 10px">
            {{-- <i class="fa fa-university nav-icon" style="color: #000; font-size: 30px;"></i> --}}
            <img src="{{asset('images/school_logo.png')}}" alt="AdminLTE Logo" class="img-circle elevation-3" style="opacity: .8;width:35px;">
            <span class="brand-text font-weight-bold text-secondary" style="font-size: 18px">La Yaung LMS</span>
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
          <a href="#" class="d-block text-capitalize" style="cursor: default !important;">
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

            {{-- acadamic year section --}}
            @can('manage academic year')
                <li class="nav-item {{ Route::is('academic-years.*') || Route::is('holidays.*') ? 'menu-open'  : '' }}">

                    <a href="#" class="nav-link {{ Route::is('academic-years.*') || Route::is('holidays.*') ? 'active'  : '' }}">
                        <i class="nav-icon fas fa-calendar-check"></i><p>Acadamic Year<i class="right fas fa-angle-left"></i></p>
                        {{-- <img src="{{asset('images/menu_icons/result.png')}}" alt="" width="25px"> --}}

                    </a>
                    <ul class="nav nav-treeview">

                    <li class="nav-item">

                        <a href="{{route('academic-years.index')}}" class="nav-link {{ Route::is('academic-years.index') ? 'active'  : '' }}">

                        @if(Route::is('academic-years.index'))
                           <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                        @else
                           <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                        @endif

                        <p>Academic Year</p>
                        </a>
                    </li>
                    <li class="nav-item">

                        <a href="{{route('holidays.index')}}" class="nav-link {{ Route::is('holidays.index') ? 'active'  : '' }}">

                        @if(Route::is('holidays.index'))
                           <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                        @else
                           <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                        @endif

                        <p>Holidays</p>
                        </a>
                    </li>
                    </ul>
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
                                <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                            @else
                                <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                            @endif
                        <p>List</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">

                        <a href="{{route('grades.create')}}" class="nav-link {{ Route::is('grades.create') ? 'active'  : '' }}">

                        @if(Route::is('grades.create'))
                           <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                        @else
                           <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                        @endif

                        <p>New</p>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="{{route('grades.modify')}}" class="nav-link {{ Route::is('grades.modify') ? 'active'  : '' }}">
                            @if(Route::is('grades.modify'))
                                <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                            @else
                                <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
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
                            <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                         @else
                            <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                         @endif
                        <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('classes.createNewClass')}}" class="nav-link {{ Route::is('classes.create') ? 'active'  : '' }}">
                            @if(Route::is('classes.createNewClass'))
                                <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                            @else
                                <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                            @endif
                        <p>New</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('classes.modify')}}" class="nav-link {{ Route::is('classes.modify') ? 'active'  : '' }}">
                            @if(Route::is('classes.modify'))
                                <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                            @else
                                <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
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
                               <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                            @else
                               <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                            @endif
                            <p>List</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{route('users.create')}}" class="nav-link {{ Route::is('users.create') ? 'active'  : '' }}">
                            @if(Route::is('users.create'))
                               <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                            @else
                               <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
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
                                <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                            @else
                                <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                            @endif
                          <p>List</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('curricula.create')}}" class="nav-link {{ Route::is('curricula.create') ? 'active'  : '' }}">
                            @if(Route::is('curricula.create'))
                            <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                            @else
                            <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
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
            @canany(['manage classworks', 'view classworks','edit classworks'])
                <li class="nav-item {{ Route::is('classworks.*') ? 'menu-open'  : '' }}">

                    <a href="#" class="nav-link {{ Route::is('classworks.*') ? 'active'  : '' }}">
                    <i class="nav-icon fas fa-pencil-alt"></i><p>Classwork<i class="right fas fa-angle-left"></i></p>
                    {{-- <img src="{{asset('images/menu_icons/homework.png')}}" alt="" width="25px"> --}}

                    </a>
                    <ul class="nav nav-treeview">
                    @if(Auth::user()->can(['manage classworks']) || Auth::user()->hasRole('subject teacher'))
                        <li class="nav-item">
                            <a href="{{route('classworks.index')}}" class="nav-link {{ Route::is('classworks.index') ? 'active'  : '' }}">
                                @if(Route::is('classworks.index'))
                                    <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                @else
                                    <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                @endif
                            <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('classworks.create')}}" class="nav-link {{ Route::is('classworks.create') ? 'active'  : '' }}">
                                @if(Route::is('classworks.create'))
                                    <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                @else
                                    <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                @endif
                            <p>New</p>
                            </a>
                        </li>
                    @endif
                     

                        {{-- @can('view classworks')
                        <li class="nav-item">
                            <a href="{{route('classworks.student.teacher.list')}}" class="nav-link {{ Route::is('classworks.student.teacher.list') ? 'active'  : '' }}">
                                @if(Route::is('classworks.student.teacher.list'))
                                    <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                @else
                                    <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                @endif
                                <p>List</p>
                            </a>
                        </li>
                        @endcan --}}

                    {{-- <li class="nav-item">
                        <a href="#" class="nav-link {{ Route::is('classworks.edit') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Update or Delete</p>
                        </a>
                    </li> --}}
                </ul>
                </li>
            @endcanany


            @can('manage promotions')
                <li class="nav-item {{ Route::is('promote.*') ? 'menu-open'  : '' }}">

                    <a href="#" class="nav-link {{ Route::is('promote.*') ? 'active'  : '' }}">
                    {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                    <i class="nav-icon fa fa-upload" aria-hidden="true"></i><p>Promotion<i class="right fas fa-angle-left"></i>
                    </p>
                    {{-- <img src="{{asset('images/menu_icons/homework.png')}}" alt="" width="25px"> --}}

                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->hasRole('admin'))
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
                        @endif

                        @if (Auth::user()->hasRole('class teacher'))
                            <li class="nav-item">
                                <a href="{{route('promote.student.class.teacher')}}" class="nav-link {{ Route::is('promote.student.class.teacher') ? 'active'  : '' }}">
                                    @if(Route::is('promote.student.class.teacher'))
                                        <i class="fas fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Promote Student</p>
                                </a>
                            </li>
                        @endif

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

                    @if (Auth::user()->hasRole('admin'))
                        <li class="nav-item">
                            <a href="{{ route('attendances.mark.search') }}" class="nav-link {{ Route::is('attendances.mark.search') || Route::is('attendances.search_results') ? 'active' : '' }}">
                                @if(Route::is('attendances.mark.search') || Route::is('attendances.search_results') )
                                <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                @else
                                <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                @endif
                                <p>Mark Attendance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('attendances.report.search')}}" class="nav-link {{ Route::is('attendances.report.search') ? 'active'  : '' }}">
                                @if(Route::is('attendances.report.search') || Route::is('attendances.get-by-date') || Route::is('attendances.view-report.per.month') )
                                    <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                @else
                                    <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                @endif
                            <p>Attendance Report</p>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->hasRole('class teacher'))
                    <li class="nav-item">
                        <a href="{{ route('attendances.mark.for.class.teacher') }}" class="nav-link {{ Route::is('attendances.mark.for.class.teacher') || Route::is('attendances.search_results') ? 'active' : '' }}">
                            @if(Route::is('attendances.mark.for.class.teacher') || Route::is('attendances.search_results') )
                            <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                            @else
                            <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                            @endif
                            <p>Mark Attendance</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('attendances.view-report.for.class.teacher')}}" class="nav-link {{ Route::is('attendances.view-report.for.class.teacher') ? 'active'  : '' }}">
                            @if(Route::is('attendances.view-report.for.class.teacher') || Route::is('attendances.get-by-date') || Route::is('attendances.view-report.per.month') )
                                <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                            @else
                                <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                            @endif
                        <p>Attendance Report</p>
                        </a>
                    </li>
                    @endif





                    {{-- <li class="nav-item">
                        <a href="#" class="nav-link {{ Route::is('classworks.edit') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Update or Delete</p>
                        </a>
                    </li> --}}
                </ul>
            </li>

            @endcan



            @canany(['manage timetables','view timetables'])

            <li class="nav-item {{ Route::is('timetables.*') ? 'menu-open'  : '' }}">

                <a href="#" class="nav-link {{ Route::is('timetables.*') ? 'active'  : '' }}">
                    <i class="nav-icon far fa-calendar-alt"></i><p>Time Table<i class="right fas fa-angle-left"></i></p>
                    {{-- <img src="{{asset('images/menu_icons/timetable (3).png')}}" alt="" width="23px"> --}}
                </a>
                <ul class="nav nav-treeview">

                    @can('manage timetables')

                        @if (Auth::user()->hasRole('admin'))
                            <li class="nav-item">
                                <a href="{{ route('timetables.list') }}" class="nav-link {{ Route::is('timetables.list') ? 'active'  : '' }}">
                                    @if(Route::is('timetables.list'))
                                    <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                    @else
                                    <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                    @endif
                                    <p>List</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('timetables.new') }}" class="nav-link {{ Route::is('timetables.new') ? 'active'  : '' }}">
                                    @if(Route::is('timetables.new'))
                                    <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                    @else
                                    <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                    @endif
                                    <p>New</p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{route('timetables.edit')}}" class="nav-link {{ Route::is('timetables.edit') ? 'active'  : '' }}">
                                    @if(Route::is('timetables.edit'))
                                        <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                    @else
                                        <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                    @endif
                                <p>Edit</p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->hasRole('class teacher'))

                            <li class="nav-item">
                                <a href="{{ route('timetables.list') }}" class="nav-link {{ Route::is('timetables.list') ? 'active'  : '' }}">
                                    @if(Route::is('timetables.list'))
                                    <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                    @else
                                    <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                    @endif
                                    <p>List</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('timetables.new') }}" class="nav-link {{ Route::is('timetables.new') ? 'active'  : '' }}">
                                    @if(Route::is('timetables.new'))
                                    <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                    @else
                                    <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                    @endif
                                    <p>New</p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{route('timetables.edit')}}" class="nav-link {{ Route::is('timetables.edit') ? 'active'  : '' }}">
                                    @if(Route::is('timetables.edit'))
                                        <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                    @else
                                        <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                    @endif
                                <p>Edit</p>
                                </a>
                            </li>

                        @endif


                    @endcan

                    @can('view timetables')
                        <li class="nav-item">
                            <a href="{{ route('timetables.list') }}" class="nav-link {{ Route::is('timetables.list') ? 'active'  : '' }}">
                                @if(Route::is('timetables.list'))
                                <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                @else
                                <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                @endif
                                <p>List</p>
                            </a>
                        </li>
                    @endcan


                    {{-- <li class="nav-item">
                        <a href="#" class="nav-link {{ Route::is('classworks.edit') ? 'active'  : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Update or Delete</p>
                        </a>
                    </li> --}}
                </ul>
            </li>

            @endcanany

            @canany(['manage exam marks','view exam marks'])

            <li class="nav-item {{ Route::is('exam-marks.*') ? 'menu-open'  : '' }}">

                <a href="#" class="nav-link {{ Route::is('exam-marks.*') ? 'active'  : '' }}">
                <i class="fas fa-clipboard-check nav-icon"></i><p>Exam Mark<i class="right fas fa-angle-left"></i></p></a>
                    {{-- <img src="{{asset('images/menu_icons/test-results (1).png')}}" alt="" width="23px"> --}}

                <ul class="nav nav-treeview">
                    {{-- <li class="nav-item">
                        <a href="{{route('exam-marks.subjects')}}" class="nav-link {{ Route::is('exam-marks.subjects') ? 'active' : (Route::is('exam-marks.search.results') ? 'active' : '' )}}">
                            @if(Route::is('exam-marks.subjects'))
                                <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                            @else
                                <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                            @endif
                        <p>Subject</p>
                        </a>
                    </li> --}}
                    @can(['manage exam marks'])

                        @if (Auth::user()->hasRole('admin'))
                            <li class="nav-item">
                                <a href="{{route('exam-marks.search')}}" class="nav-link {{ Route::is('exam-marks.search') ? 'active' : (Route::is('exam-marks.search.results') ? 'active' : '' )}}">
                                    @if(Route::is('exam-marks.search'))
                                        <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                    @else
                                        <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                    @endif
                                <p>Add Exam Mark</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{route('exam-marks.edit')}}" class="nav-link {{ Route::is('exam-marks.edit') ? 'active'  : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Edit</p>
                                </a>
                            </li> --}}
                        @endif

                        @if (Auth::user()->hasRole('class teacher'))
                            <li class="nav-item">
                                <a href="{{route('exam-marks.class.teacher.search.results')}}" class="nav-link {{ Route::is('exam-marks.class.teacher.search.results') ? 'active' : (Route::is('exam-marks.class.teacher.search.results') ? 'active' : '' )}}">
                                    @if(Route::is('exam-marks.class.teacher.search.results') || Route::is('exam-marks.class.teacher.search.results'))
                                        <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->
                                    @else
                                        <i class="far fa-circle nav-icon"></i> <!-- Second icon when not active -->
                                    @endif
                                <p>Add Exam Mark</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{route('exam-marks.edit')}}" class="nav-link {{ Route::is('exam-marks.edit') ? 'active'  : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Edit</p>
                                </a>
                            </li> --}}
                        @endif
                    @endcan

                    @can(['view exam marks'])
                        <li class="nav-item">
                            <form id="examResults" action="{{route('exam-marks.search.results')}}" method="POST" >
                                @csrf
                                <a href="#" class="nav-link {{ Route::is('exam-marks.edit') ? 'active'  : '' }}" id="examSubmit">
                                    @if(Route::is('exam-marks.search.results'))

                                        <i class="fas fa-dot-circle nav-icon"></i> <!-- First icon when active -->


                                    @else

                                        <i class="far fa-circle nav-icon" id=""></i>


                                    @endif

                                <p>View</p>
                                </a>
                            </form>
                        </li>
                    @endcan


                </ul>
            </li>
            @endcanany
        </ul>
    </nav>

      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

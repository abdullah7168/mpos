<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{url('/')}}"><i class="fa fa-home"></i> <span>Home</span></a></li>
        <li class="{{ Request::is('/inventory') ? 'active' : '' }} "><a href="{{url('/inventory')}}"><i class="fa fa-file-text"></i> <span>Inventory</span></a></li>
        <li class="{{ Request::is('/place-order') ? 'active' : '' }} "><a href="{{url('/place-order')}}"><i class="fa fa-bullhorn"></i> <span>Place Order</span></a></li>
        <li class="{{ Request::is('/orders') ? 'active' : '' }} "><a href="{{url('/orders')}}"><i class="fa fa-level-down"></i> <span>Orders</span></a></li>
        <li class="{{ Request::is('/sales-report') ? 'active' : '' }} "><a href="{{url('/sales-report')}}"><i class="fa fa-archive"></i> <span>Sales Report</span></a></li>

        {{-- <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
          </ul>
        </li> --}}
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="{{route('welcomeAdmin')}}">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <!-- <li class="nav-item active">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">UI Elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse show" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/buttons.html">Buttons</a></li>
                <li class="nav-item"> <a class="nav-link active" href="../../pages/ui-features/dropdowns.html">Dropdowns</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/typography.html">Typography</a></li>
              </ul>
            </div>
          </li> -->
          @can('isAdmin')
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="icon-columns menu-icon"></i>
              <span class="menu-title">Files</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <!-- <li class="nav-item"><a class="nav-link" href="../../pages/forms/basic_elements.html">Basic Elements</a></li> -->
                <li class="nav-item"> <a class="nav-link" href="{{route('selectFile')}}">Select Csv File</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('readCsvFile')}}">Read Csv File</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('lisDataOfCsvFile')}}">List Of Csv File</a></li>
              </ul>
            </div>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
              <i class="icon-bar-graph menu-icon"></i>
              <span class="menu-title">Product</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav flex-column sub-menu"> -->
                <!-- <li class="nav-item"> <a class="nav-link" href="../../pages/charts/chartjs.html">ChartJs</a></li> -->
                <!-- <li class="nav-item"> <a class="nav-link" href="#">Product Add</a></li>
                <li class="nav-item"> <a class="nav-link" href="#">Product List</a></li>
              </ul>
            </div>
          </li> -->
          <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <i class="icon-grid-2 menu-icon"></i>
              <span class="menu-title">Orders</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu"> -->
                <!-- <li class="nav-item"> <a class="nav-link" href="../../pages/tables/basic-table.html">Basic table</a></li> -->
                <!-- <li class="nav-item"> <a class="nav-link" href="#">Order List</a></li>
              </ul>
            </div>
          </li> -->
          @endcan
          @can('isUser')
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#" aria-expanded="false" aria-controls="icons">
              <i class="icon-contract menu-icon"></i>
              <span class="menu-title">Blog List</span>
              <i class="menu-arrow"></i>
            </a>
          @endcan
            <!-- <div class="collapse" id="icons">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../pages/icons/mdi.html">Mdi icons</a></li>
              </ul>
            </div> -->
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register.html"> Register </a></li>
              </ul>
            </div>
          </li> -->
          <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
              <i class="icon-ban menu-icon"></i>
              <span class="menu-title">Error pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-404.html"> 404 </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-500.html"> 500 </a></li>
              </ul>
            </div>
          </li> -->
          <!-- <li class="nav-item">
            <a class="nav-link" href="../../pages/documentation/documentation.html">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Documentation</span>
            </a>
          </li> -->
        </ul>
      </nav>
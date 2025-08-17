
<style>
  .sidebar a.nav-link.active{
    color:#fff !important
  }
</style>
<!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-navy navbar-dark elevation-4 sidebar-no-expand">
        <!-- Brand Logo -->
        <a href="<?php echo base_url ?>admin" class="brand-link bg-navy text-sm">
        <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 1.5rem;height: 1.5rem;max-height: unset">
        <span class="brand-text font-weight-light text-light"><?php echo $_settings->info('short_name') ?></span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
          <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
          </div>
          <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
          </div>
          <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
          <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
              <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                <!-- Sidebar user panel (optional) -->
                <div class="clearfix"></div>
                <!-- Sidebar Menu -->
                <nav class="mt-1">
                   <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item dropdown">
                      <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Home
                        </p>
                      </a>
                    </li> 
                    
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=announcement/index" class="nav-link nav-announcement_index">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                          Announcement
                        </p>
                      </a>
                    </li> 

                   

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=event/index" class="nav-link nav-event_index">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                          Event
                        </p>
                      </a>
                    </li> 

                    <?php if($_settings->userdata('type') != 1): ?>
                    <li class="nav-item dropdown">
                     <a href="<?php echo base_url ?>admin/?page=QRCode/index" class="nav-link nav-QRCode_index">
                        <!-- <a href="#" class="nav-link nav-QRCode_index">-->
                        <i class="nav-icon fas fa-qrcode"></i>
                        <p>
                          My QR Code
                        </p>
                      </a>
                    </li> 
                    <?php endif; ?>

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=skofficials/index" class="nav-link nav-skofficials_index">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                          SK Officials
                        </p>
                      </a>
                    </li> 

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=aboutus/index" class="nav-link nav-aboutus_index">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>
                          About Us
                        </p>
                      </a>
                    </li>

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=devs/index" class="nav-link nav-devs_index">
                        <i class="nav-icon fas fa-code"></i>
                        <p>
                          Developers Information
                        </p>
                      </a>
                    </li>
                    
                    <?php if($_settings->userdata('type') == 1): ?>
                    <li class="nav-header">Admin function</li>
                    <li class="nav-item dropdown">
                     <a href="<?php echo base_url ?>admin/?page=population/index" class="nav-link nav-population_index">
                        <!-- <a href="#" class="nav-link nav-population_index">-->
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                        Population
                        </p>
                      </a>
                    </li> 
                    <li class="nav-item dropdown">
                     <a href="<?php echo base_url ?>admin/?page=activepurok/index" class="nav-link nav-activepurok_index">
                        <!-- <a href="#" class="nav-link nav-activepurok_index">-->
                        <i class="nav-icon fas fa-border-all"></i>
                        <p>
                          Active Purok
                        </p>
                      </a>
                    </li> 
                    
                    <li class="nav-item dropdown">
                      <a href="#" class="nav-link nav-attendance_index nav-is-tree">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                          Attendance List
                          <i class="right fas fa-angle-left"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?php echo base_url ?>admin/?page=attendance/present" class="nav-link nav-attendance_present tree-item">
                            <!--<a href="#" class="nav-link nav-attendance_present tree-item">-->
                            <p>List of Present</p>
                          </a>
                        </li>
                        <li class="nav-item">
                         <a href="<?php echo base_url ?>admin/?page=attendance/absent" class="nav-link nav-attendance_absent tree-item">
                          <!-- <a href="#" class="nav-link nav-attendance_absent tree-item"> --> 
                            <p>List of Absent</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="<?php echo base_url ?>admin/?page=attendance/index" class="nav-link nav-attendance_index tree-item">
                           <!-- <a href="#" class="nav-link nav-attendance_index tree-item">-->
                            <p>All Attendance</p>
                          </a>
                        </li>
                      </ul>
                    </li> 
                   
                    
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                          List of SK
                        </p>
                      </a>
                    </li>
                    
                    <?php endif; ?>
                  </ul>
                </nav>
                <!-- /.sidebar-menu -->
              </div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar-corner"></div>
        </div>
        <!-- /.sidebar -->
      </aside>
      <script>
    $(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      page = page.replace(/\//g,'_');
      if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
        if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).addClass('active')
          $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

      }
      $('.nav-link.active').addClass('bg-gradient-navy')
      $('.main-sidebar .nav-link').each(function(){
        var text = $(this).text()
        $(this).attr('title', text)
      })
    })
  </script>
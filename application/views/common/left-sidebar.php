  <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="<?= base_url('dashboard')?>">
                    <img src="<?= base_url('assets/images/icon/logo.png')?>" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                    
                        <li class="tablinks  <?php if(current_url()==base_url('dashboard')){ echo 'active'; } ?>">
                            <a href="<?= base_url('dashboard')?>">
                                <i class="fas fa-home"></i>Dashboard</a>
                        </li>
                        
                        <li class="tablinks <?php if(current_url()==base_url('user')){ echo 'active'; } ?>">
                            <a href="<?=  base_url('user')?>">
                               <i class="fas fa-user"></i>User Management</a>
                        </li>
                        
                       

                        <li class="tablinks <?php if(current_url()==base_url('doctor')){ echo 'active'; } ?> ">
                            <a href="<?= base_url('doctor') ?>"><i class="fas fa-stethoscope"></i>Doctor Management</a>
                        </li>
                        
                         <li class="tablinks <?php if(current_url()==base_url('speciality')){ echo 'active'; } ?> ">
                            <a href="<?= base_url('speciality') ?>"><i class="fas fa-stethoscope"></i>Doctor Speciality Management</a>
                        </li>
                        
                        
                        
                         <li class="has-sub tablinks  <?php if(current_url()==base_url('homebooking') || current_url()==base_url('callbooking')){ echo 'active'; } ?>">
                             <a href="#" class="js-arrow"><i class="fas fa-child"></i>Booking Management</a>
                             <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li><a href="<?= base_url('homebooking')?>">Home Booking</a></li>
                                 <!--<li><a href="<?= base_url('schedulebooking')?>">Schedule Booking</a></li>-->
                                <li><a href="<?= base_url('callbooking') ?>">Call Booking</a></li>
                            </ul>
                        </li>
                        
                        <li class="has-sub tablinks  <?php if(current_url()==base_url('promocode') || current_url()==base_url('specificpromocode')){ echo 'active'; } ?>">
                             <a href="#" class="js-arrow"><i class="fas fa-child"></i>Promo code Management</a>
                             <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li><a href="<?= base_url('promocode')?>">Manage Promo Code</a></li>
                                <li><a href="<?= base_url('specificpromocode') ?>">Specifc Promo Code</a></li>
                            </ul>
                        </li>
                        
                        
                        
                        <li class="tablinks <?php if(current_url()==base_url('medicine')){ echo 'active'; } ?> ">
                            <a href="<?= base_url('medicine') ?>"><i class="fas fa-thermometer"></i>Medicine Delivery Management</a>
                        </li>
                        
                         
                        <li class="tablinks <?php if(current_url()==base_url('notification')){ echo 'active'; } ?>">
                            <a href="<?= base_url('notification') ?>"><i class="fas fa-bell"></i>Notification Management </a>
                        </li> 
                        
                       
                        
                        
                       <!--  
                        <li class="tablinks">
                            <a href="#"><i class="fas fa-chart-line"></i>Report Management </a>
                        </li>
                          -->
                        <!--<li class="tablinks <?php if(current_url()==base_url('payment')){ echo 'active'; } ?>">-->
                        <!--    <a href="<?= base_url('payment')?>"><i class="fas fa-dollar-sign"></i>Payment Management</a>-->
                        <!--</li>-->
                       
                       
                         <li class="has-sub tablinks  <?php if(current_url()==base_url('payment') || current_url()==base_url('earning')){ echo 'active'; } ?>">
                             <a href="#" class="js-arrow"><i class="fas fa-child"></i>Transaction Management</a>
                             <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li><a href="<?= base_url('payment')?>">Payment Manangement</a></li>
                                <li><a href="<?= base_url('earning') ?>">Doctor Earning</a></li>
                            </ul>
                        </li>
                        <li class="tablinks">
                            <a href="<?= base_url('content')?>"><i class="fas fa-edit"></i>Static content Management </a>
                        </li>
                        
                   
                        
                        <li class="tablinks <?php if(current_url()==base_url('rating')){ echo 'active'; } ?>">
                            <a href="<?= base_url('rating') ?>"><i class="fas fa-star"></i>Ratings Management </a>
                        </li>
                        
                        
                        <li class="tablinks <?php if(current_url()==base_url('qualification')){ echo 'active'; } ?>">
                            <a href="<?= base_url('qualification') ?>"><i class="fas fa-star"></i>Qualification management </a>
                        </li>
                        
                         <li class="tablinks <?php if(current_url()==base_url('rejectreason')){ echo 'active'; } ?>">
                            <a href="<?= base_url('rejectreason') ?>"><i class="fas fa-star"></i>Reject reason management </a>
                        </li>
                        
                         <li class="tablinks <?php if(current_url()==base_url('frees')){ echo 'active'; } ?>">
                            <a href="<?= base_url('frees') ?>"><i class="fas fa-star"></i>Doctor fees management </a>
                        </li>
                        
                         <li class="tablinks <?php if(current_url()==base_url('managecontact')){ echo 'active'; } ?>">
                            <a href="<?= base_url('managecontact') ?>"><i class="fas fa-star"></i>Manage contact no </a>
                        </li>
                        
                           <li class="has-sub tablinks  <?php if(current_url()==base_url('userchat') || current_url()==base_url('doctorchat')){ echo 'active'; } ?>">
                             <a href="#" class="js-arrow"><i class="fas fa-child"></i>Live chat Management</a>
                             <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li><a href="<?= base_url('userchat')?>">Chat With User</a></a></li>
                                <li><a href="<?= base_url('doctorchat') ?>">Chat With Doctor</a></li>
                            </ul>
                        </li>
                        
                          <li class="has-sub tablinks  <?php if(current_url()==base_url('promocode') || current_url()==base_url('specificpromo') || current_url()==base_url('speciality') || current_url()==base_url('changepassword')){ echo 'active';  } ?>">
                             <a href="#" class="js-arrow"><i class="fas fa-child"></i>Settings</a>
                             <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <!--<li><a href="<?= base_url('qualification')?>">Manage Qualification</a></li>-->
                               
                                <!--<li><a href="<?= base_url('rejectreason')?>">Manage Reject Reason</a></li>-->
                                <!--<li><a href="<?= base_url('frees') ?>">Manage Fees</a></li>-->
                                
                              
                                
                <li><a href="<?= base_url('changepassword')?>">Change Password
</a></li>
                            </ul>
                        </li>
                        

                        <!--  <li class="tablinks <?php if(current_url()==base_url('changepassword')){ echo 'active'; } ?>">-->
                        <!--    <a href="<?= base_url('changepassword')?>"><i class="fas fa-star"></i>Change Password </a>-->
                        <!--</li>-->
                    
                    </ul>
                </nav>
            </div>
        </aside>
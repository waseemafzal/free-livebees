 <aside class="main-sidebar">

   <!-- sidebar: style can be found in sidebar.less -->

   <section class="sidebar">



     <ul class="sidebar-menu" data-widget="tree">



       <li>

         <a href="dashboard">

           <i class="fa fa-dashboard"></i> <span>Dashboard</span>



         </a>



       </li>









       <li><a href="<?php echo base_url(); ?>auth/view_users"><i class="fa fa-user"></i> <span>Normal Users</span></a></li>



       <li class="<?= getActive('prousers') ?> hidden"><a href="prousers"><i class="fa fa-user"></i> <span>Pro users</span></a></li>



       <li class="<?= getActive('super-admins') ?>"><a href="super-admins"><i class="fa fa-user"></i> <span>Super admins</span></a></li>



       <li class="<?= getActive('auth/create_user') ?>"><a data-toggle="tooltip" title="Create account for admin, trainer and user " href="auth/create_user"><i class="fa fa-user"></i> <span>Create Account</span></a></li>







       <li style="display: none;" class="<?= getActive('allnests') ?>"><a href="allnests"><i class="fa fa-list"></i> Nests</a></li>
       <!-- users -->
       <li class=""><a href="<?php echo base_url(); ?>auth/view_users/3"><i class="fa fa-list"></i>Référent</a></li>
       <li class=""><a href="<?php echo base_url(); ?>auth/view_users/4"><i class="fa fa-list"></i>Particulier </a></li>
       <li class=""><a href="<?php echo base_url(); ?>auth/view_users/5"><i class="fa fa-list"></i>Institution </a></li>


       <!-- users end -->

       <li class="<?= getActive('cms') ?>"><a href="cms"><i class="fa fa-list"></i>CMS</a></li>

       <li class="<?= getActive('blogpost') ?> hidden"><a href="blogpost"><i class="fa fa-list"></i>Blogpost</a></li>

       <li class="<?= getActive('leprojects') ?> hidden"><a href="leprojects"><i class="fa fa-list"></i>Le projects</a></li>

       





       <li class="treeview hidden">

         <a href="#">

           <i class="fa fa-cog"></i>

           <span>Pages</span>

           <span class="pull-right-container">

             <i class="fa fa-angle-left pull-right"></i>

           </span>

         </a>

         <ul class="treeview-menu">

           <li><a href="cms"><i class="fa fa-circle-o"></i> CMS Pages</a></li>

         </ul>

       </li>

       <li><a href="mainmenu"><i class="fa fa-list"></i> Main menu / Nav</a></li>

       <li class="hidden"><a href="slider"><i class="fa fa-picture-o"></i> Slider</a></li>
       <li class=" "><a href="translation"><i class="fa fa-list"></i>Translation</a></li>



     </ul>





   </section>

   <!-- /.sidebar -->

   </section>

   <!-- /.sidebar -->

 </aside>
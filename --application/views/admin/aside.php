 <aside class="main-sidebar">

   <!-- sidebar: style can be found in sidebar.less -->

   <section class="sidebar">



     <ul class="sidebar-menu" data-widget="tree">



       <li>

         <a href="dashboard">

           <i class="fa fa-dashboard"></i> <span>Dashboard</span>



         </a>



       </li>


<li  class="<?=getActive('setting/edit')?>"><a href="setting/edit"><i class="fa fa-pencil"></i> <span>Setting</span></a></li>
<li class="treeview ">

            <a href="#">

            <i class="fa fa-cog"></i>

            <span>Content Management</span>

            <span class="pull-right-container">

            <i class="fa fa-angle-left pull-right"></i>

            </span>

            </a>

            <ul class="treeview-menu">

               
              <li class="<?=getActive('cms')?>"><a href="cms" ><i class="fa fa-book"></i> Pages</a></li>
<li class="<?=getActive('leprojects')?>"><a href="leprojects" ><i class="fa fa-book"></i> Leprojects</a></li>

               <li ><a data-toggle="tooltip"   title="You can manage which page to show on navigation bar, update icon and text of the link , update link as well" href="mainmenu" ><i class="fa fa-navicon"></i> Nav Menu</a></li>

               

               <li  data-toggle="tooltip"   title="Update Translations , User page filter to see relevant " class="<?=getActive('translation')?> "><a href="translation" ><i class="fa fa-language"></i> Language Translation</a></li>

            </ul>

         </li>



<li class="treeview ">

            <a href="#">

            <i class="fa fa-users"></i>

            <span>User Management</span>

            <span class="pull-right-container">

            <i class="fa fa-angle-left pull-right"></i>

            </span>

            </a>

            <ul class="treeview-menu">

           

 <li class=""><a href="<?php echo base_url(); ?>auth/view_users/3"><i class="fa fa-list"></i>Référent</a></li>
       <li class=""><a href="<?php echo base_url(); ?>auth/view_users/4"><i class="fa fa-list"></i>Particulier </a></li>
       <li class=""><a href="<?php echo base_url(); ?>auth/view_users/5"><i class="fa fa-list"></i>Institution </a></li>



       <li class="<?= getActive('super-admins') ?>"><a href="super-admins"><i class="fa fa-user"></i> <span>Super admins</span></a></li>



       <li class="<?= getActive('auth/create_user') ?>"><a data-toggle="tooltip" title="Create account for admin, trainer and user " href="auth/create_user"><i class="fa fa-user"></i> <span>Create Account</span></a></li>

            </ul>

         </li>


 <li class="treeview ">

            <a href="#">

            <i class="fa fa-list"></i>

            <span>Nests Management</span>

            <span class="pull-right-container">

            <i class="fa fa-angle-left pull-right"></i>

            </span>

            </a>

            <ul class="treeview-menu">

                   <li class="<?=getActive('allnests')?>"><a href="allnests" ><i class="fa fa-list"></i> Nests</a></li>

         


            </ul>

         </li>






       <li style="display: none;" class="<?= getActive('allnests') ?>"><a href="allnests"><i class="fa fa-list"></i> Nests</a></li>
       <!-- users -->
       

       <!-- users end -->

      
       





       



     </ul>





   </section>

   <!-- /.sidebar -->

   </section>

   <!-- /.sidebar -->

 </aside>
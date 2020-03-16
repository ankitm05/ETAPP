<div class="left-sidebar-pro">
   <nav id="sidebar" class="">
      <div class="sidebar-header">
         <a href="http://theetapp.com"><img class="main-logo" src="{{ asset('admin/img/logo/logo.png') }}" alt="" /></a>
         <strong><a href="index.html"><img src="{{ asset('admin/img/logo/logosn.png')}}" alt="" /></a></strong>
      </div>
      <div class="left-custom-menu-adp-wrap comment-scrollbar">
         <nav class="sidebar-nav left-sidebar-menu-pro">
            
            @php $cus = getAuthcheck(); @endphp
            
            <ul class="metismenu" id="menu1">
               <li>
                  <a title="Landing Page" href="{{ route('dashboard') }}" class="active" aria-expanded="false"> 
                  <span class="educate-icon educate-home icon-wrap"></span> 
                  <span class="mini-click-non">Home</span></a>
               </li>
               @if($cus->type == 0)
                  <li>
                     <a title="Landing Page" href="{{ route('user-management') }}" aria-expanded="false"> 
                     <span class="educate-icon educate-professor icon-wrap"></span>
                     <span class="mini-click-non">User Management</span></a>
                  </li>
                  <li>
                     <a title="Landing Page" href="{{ route('subadmin-management') }}" aria-expanded="false"> 
                     <span class="educate-icon educate-professor icon-wrap"></span>
                     <span class="mini-click-non">Subadmin Management</span></a>
                  </li>
                  <li>
                     <a title="Landing Page" href="{{route('event-management')}}" aria-expanded="false"> 
                     <span class="educate-icon educate-department icon-wrap"></span>
                     <span class="mini-click-non">Event Management</span></a>
                  </li>
                  <!--<li>
                     <a class="has-arrow" title="Landing Page" href="events.html" aria-expanded="false"> 
                     <span class="educate-icon educate-charts icon-wrap"></span>
                     <span class="mini-click-non">Reports Management</span></a>
                     <ul class="submenu-angle collapse" aria-expanded="false">
                        <li>
                           <a title="#" href="index.html"><span class="mini-sub-pro">Reports one</span></a>
                        </li>
                     </ul>
                  </li>-->
                  <li>
                     <a title="Landing Page" href="{{ route('static-pages') }}" aria-expanded="false"> 
                     <span class="educate-icon educate-data-table icon-wrap"></span>
                     <span class="mini-click-non">Static Content Management</span></a>
                  </li>
               @else
                  <li>
                     <a title="Landing Page" href="{{route('event-management')}}" aria-expanded="false"> 
                     <span class="educate-icon educate-department icon-wrap"></span>
                     <span class="mini-click-non">Event Management</span></a>
                  </li>
               @endif
            </ul>
         </nav>
      </div>
   </nav>
</div>
<!-- End Left menu area -->
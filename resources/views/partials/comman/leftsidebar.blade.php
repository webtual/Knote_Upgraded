<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
   {{-- <div id="particals"></div> --}}
   <div class="slimscroll-menu">
      <!--- Sidemenu -->
      <div id="sidebar-menu">
         <ul class="metismenu" id="side-menu">
            <li class="menu-title">Navigation</li>
            @if((auth()->user()->roles()->first()->role_name != "Admin") && (auth()->user()->roles()->first()->role_name != "Broker"))
               <li class="">
                  <a href="{{ url('dashboard') }}" aria-expanded="false">
                     <i class="fe-airplay"></i>
                     <span> Dashboard </span>
                  </a>
               </li>
            @endif

            @if(auth()->user()->roles()->first()->role_name == "Broker")

               <li class="">
                  <a href="{{ url('broker/dashboard') }}" aria-expanded="false">
                     <i class="fe-airplay"></i>
                     <span> Dashboard </span>
                  </a>
               </li>

               <li class="">
                  <a href="javascript: void(0);" class="">
                     <i class="fe-box"></i>
                     <span> Loan Applications </span> <span class="menu-arrow"></span>
                  </a>
                  <ul class="nav-second-level" aria-expanded="false">
                     <li class="">
                        <a href="{{ url('broker/loan-applications') }}">Current Applications</a>
                     </li>
                     <li class="">
                        <a href="{{ url('broker/declined-loan-applications') }}">Declined Applications</a>
                     </li>
                     <li class="">
                        <a href="{{ url('broker/archived-loan-applications') }}">Archived Applications</a>
                     </li>
                     <li>
                        <a href="{{ url('broker/settled-loan-applications') }}">Settled Applications</a>
                     </li>
                  </ul>
               </li>

            @endif

            @if(auth()->user()->roles()->first()->role_name == "Admin")
               <li class="">
                  <a href="{{ url('admin/dashboard') }}" aria-expanded="false">
                     <i class="fe-airplay"></i>
                     <span> Dashboard </span>
                  </a>
               </li>

               <li>
                  <a href="{{ url('admin/users') }}">
                     <i class="fe-users"></i>
                     <span> Customers </span>
                  </a>
               </li>

               @if(auth()->user()->roles()->first()->id == 1)
               <li>
                  <a href="{{ route('staff.users.list') }}">
                     <i class="fe-users"></i>
                     <span> Users </span>
                  </a>
               </li>
               @endif

               <li>
                  <a href="{{ url('admin/brokers') }}">
                     <i class="fe-users"></i>
                     <span> Brokers </span>
                  </a>
               </li>

               <li class="">
                  <a href="javascript: void(0);" class="">
                     <i class="fe-box"></i>
                     <span> Loan Applications </span> <span class="menu-arrow"></span>
                  </a>
                  <ul class="nav-second-level" aria-expanded="false">
                     <li class="">
                        <a href="{{ url('admin/loan-applications') }}">Current Applications</a>
                     </li>
                     <li class="">
                        <a href="{{ url('admin/declined-loan-applications') }}">Declined Applications</a>
                     </li>
                     <li class="">
                        <a href="{{ url('admin/archived-loan-applications') }}">Archived Applications</a>
                     </li>
                     <li>
                        <a href="{{ url('admin/settled-loan-applications') }}">Settled Applications</a>
                     </li>
                  </ul>
               </li>

               <li>
                  <a href="{{ url('admin/inquiries') }}">
                     <i class="fe-list"></i>
                     <span> Inquiry </span>
                  </a>
               </li>

               <li>
                  <a href="{{ url('admin/emailtemplates') }}">
                     <i class="fe-mail"></i>
                     <span> Email Templates </span>
                  </a>
               </li>
               <li>
                  <a href="{{ url('admin/approveddocuments') }}">
                     <i class="fe-file-text"></i>
                     <span> Approved Documents </span>
                  </a>
               </li>
               <li>
                  <a href="{{ url('admin/tokenidentifiers') }}">
                     <i class="fe-file-text"></i>
                     <span> Tokens Identifiers </span>
                  </a>
               </li>

               @if(auth()->user()->id == 1)
                  <li>
                     <a href="{{ url('admin/user-logs') }}">
                        <i class="fe-list"></i>
                        <span> Activity Logs </span>
                     </a>
                  </li>
               @endif


            @elseif(auth()->user()->roles()->first()->role_name == "Loan Applicant")
               <li>
                  <a href="{{ route('loan.create') }}">
                     <i class="fe-edit"></i>
                     <span> <small class="font-14"> New Loan Application </small> </span>
                  </a>
               </li>
            @endif
         </ul>
      </div>
      <!-- End Sidebar -->
      <div class="clearfix"></div>
   </div>
   <!-- Sidebar -left -->

   <!--<div id="comp-tag" class="">
      <a href="https://www.webtual.com/" target="blank">Develop By Webtual Technologies PVT. LTD.</a>
   </div>-->

</div>
<!-- Left Sidebar End -->
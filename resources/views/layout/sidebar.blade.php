
 <!-- Sidebar -->
 <nav class="sidebar" id="sidebar">
     <div class="sidebar-header">
         <h4><i class="fas fa-tachometer-alt me-2"></i>AdminPanel</h4>
     </div>
     <ul class="navbar-nav">
         
         <li class="nav-item">
             <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                 <i class="fas fa-users"></i>
                 Users
             </a>
         </li>

         <li class="nav-item">
             <a class="nav-link {{ request()->is('elevators*') ? 'active' : '' }}" href="{{ route('elevators.index') }}">
                 <i class="fas fa-elevator"></i>
                 Elevators
             </a>
         </li>


        
     </ul>
 </nav>
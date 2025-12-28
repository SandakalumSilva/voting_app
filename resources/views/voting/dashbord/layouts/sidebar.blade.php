   <!-- Sidebar (LG+) -->
   <aside class="sidebar d-none d-lg-block" aria-label="Sidebar">
       <nav class="nav flex-column">
           <span class="text-uppercase text-muted small ms-3 mt-2">Overview</span>

           @if (Auth::user()->role == 'admin')
               <a class="nav-link active" href="#"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
               {{-- <a class="nav-link" href="#"><i class="bi bi-megaphone me-2"></i> Elections</a>
               <a class="nav-link" href="#"><i class="bi bi-ui-checks-grid me-2"></i> Polls</a> --}}
               <a class="nav-link" href="{{ route('admin.users') }}"><i class="bi bi-people me-2"></i>Voters</a>
               <a class="nav-link" href="{{ route('admin.enrollment') }}"><i
                       class="bi bi-person-badge me-2"></i>Enrollement</a>
               <a class="nav-link" href="{{ route('auditlog.index') }}"><i class="bi bi-bar-chart-line me-2"></i>Audit
                   Logs</a>
           @elseif (session('login_type') == 'election_officer')
               <a class="nav-link active" href="{{ route('election.officer.index') }}"><i
                       class="bi bi-speedometer2 me-2"></i> Dashboard</a>
               <a class="nav-link" href="{{ route('user.enrollment') }}"><i
                       class="bi bi-person-badge me-2"></i>Enrollement</a>
           @elseif (Auth::user()->role == 'voter' || Auth::user()->role == 'candidate')
               <a class="nav-link active" href="{{ route('voter.index') }}"><i class="bi bi-speedometer2 me-2"></i>
                   Dashboard</a>
               <a class="nav-link" href="{{ route('user.enrollment') }}"><i
                       class="bi bi-person-badge me-2"></i>Enrollement</a>
           @endif
           {{-- <a class="nav-link" href="#"><i class="bi bi-person-badge me-2"></i> Candidates</a>
           <a class="nav-link" href="#"><i class="bi bi-bar-chart-line me-2"></i> Results & Analytics</a>
           <span class="text-uppercase text-muted small ms-3 mt-3">Admin</span>
           <a class="nav-link" href="#"><i class="bi bi-shield-lock me-2"></i> Roles & Permissions</a> --}}

           <a class="nav-link" href="{{ route('user.edit') }}"><i class="bi bi-gear me-2"></i> Profile</a>
       </nav>
   </aside>

   <!-- Sidebar Offcanvas (Mobile) -->
   <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
       <div class="offcanvas-header">
           <h5 class="offcanvas-title" id="sidebarOffcanvasLabel"><i class="bi bi-check2-square me-1 text-primary"></i>
               VoteAdmin</h5>
           <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
       </div>
       <div class="offcanvas-body">
           <nav class="nav flex-column">
               <a class="nav-link active" href="#"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
               <a class="nav-link" href="#"><i class="bi bi-megaphone me-2"></i> Elections</a>
               <a class="nav-link" href="#"><i class="bi bi-ui-checks-grid me-2"></i> Polls</a>
               <a class="nav-link" href="#"><i class="bi bi-people me-2"></i> Voters</a>
               <a class="nav-link" href="#"><i class="bi bi-person-badge me-2"></i> Candidates</a>
               <a class="nav-link" href="#"><i class="bi bi-bar-chart-line me-2"></i> Results & Analytics</a>
               <hr />
               <a class="nav-link" href="#"><i class="bi bi-shield-lock me-2"></i> Roles & Permissions</a>
               <a class="nav-link" href="{{ route('user.edit') }}"><i class="bi bi-gear me-2"></i> Profile</a>
           </nav>
       </div>
   </div>

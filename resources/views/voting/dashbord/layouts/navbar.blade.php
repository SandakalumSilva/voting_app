 <!-- Top Navbar -->
 <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
     <div class="container-fluid">
         <button class="btn btn-outline-primary d-lg-none me-2" data-bs-toggle="offcanvas"
             data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas" aria-label="Toggle navigation">
             <i class="bi bi-list"></i>
         </button>
         <a class="navbar-brand fw-semibold" href="#">
             <img src="{{ asset('storage/images/logo.png') }}" class="img-fluid" alt=""
                 style="max-width:50px; border:2px solid #007bff; border-radius:10px;">
             <i class="bi bi-check2-square me-1 text-primary"></i>
             @if (Auth::user()->role == 'admin')
                 Admin
             @elseif(session('login_type') == 'election_officer')
                 Election Officer
             @elseif(Auth::user()->role == 'voter')
                 Voter
             @endif

             {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
         </a>
         <div class="d-flex align-items-center gap-2">

             <div class="dropdown">
                 <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"
                     aria-expanded="false">
                     <span class="avatar">SS</span>
                 </button>
                 <ul class="dropdown-menu dropdown-menu-end">
                     <li>
                         <h6 class="dropdown-header">Signed in as</h6>
                     </li>
                     <li><span
                             class="dropdown-item-text fw-medium">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                     </li>
                     <li>
                         <hr class="dropdown-divider">
                     </li>
                     <li><a class="dropdown-item" href="{{ route('user.edit') }}">Profile</a></li>
                     <li>
                         <hr class="dropdown-divider">
                     </li>
                     <li><button class="dropdown-item text-danger sign-out">Sign out</button></li>
                 </ul>
             </div>
         </div>
     </div>
 </nav>

@extends('layout.app')
@section('title', 'User Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">User Details</li>
                </ol>
            </nav>
            <h1 class="h3 mb-1 text-gray-800">User Details</h1>
            <p class="text-muted mb-0">View complete user information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit User
            </a>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v me-2"></i>More
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Export Data</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-key me-2"></i>Reset Password</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Send Email</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash me-2"></i>Delete User</a></li>
                </ul>
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Profile Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="user-avatar mb-3">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                 alt="{{ $user->name }}" class="rounded-circle" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 120px; height: 120px;">
                                <span class="text-white fw-bold" style="font-size: 2.5rem;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <h4 class="user-name mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <!-- Role Badge -->
                    @php
                        $roleColors = [
                            'admin' => 'danger',
                            'manager' => 'warning', 
                            'user' => 'primary',
                            'guest' => 'secondary'
                        ];
                        $roleColor = $roleColors[$user->role] ?? 'secondary';
                    @endphp
                    <div class="mb-4">
                        <span class="badge bg-{{ $roleColor }} bg-gradient fs-6 px-3 py-2">
                            <i class="fas fa-user-{{ $user->role == 'admin' ? 'shield' : ($user->role == 'manager' ? 'tie' : 'circle') }} me-2"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        @if($user->email_verified_at)
                            <span class="badge bg-success bg-gradient">
                                <i class="fas fa-check-circle me-1"></i>Active Account
                            </span>
                        @else
                            <span class="badge bg-warning bg-gradient">
                                <i class="fas fa-exclamation-triangle me-1"></i>Pending Verification
                            </span>
                        @endif
                    </div>

                    <!-- Quick Stats -->
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="mb-0 text-primary">{{ $user->elevators->count() }}</h5>
                                <small class="text-muted">Elevators</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-0 text-success">{{ $user->created_at->diffInDays() }}</h5>
                            <small class="text-muted">Days Active</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-address-card me-2 text-primary"></i>Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="contact-item mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-muted me-3"></i>
                            <div>
                                <div class="fw-bold">Email</div>
                                <div class="text-muted">{{ $user->email }}</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($user->mobile)
                        <div class="contact-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-phone text-muted me-3"></i>
                                <div>
                                    <div class="fw-bold">Mobile</div>
                                    <div class="text-muted">{{ $user->mobile }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($user->address || $user->city || $user->state || $user->country)
                        <div class="contact-item">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-map-marker-alt text-muted me-3 mt-1"></i>
                                <div>
                                    <div class="fw-bold">Address</div>
                                    <div class="text-muted">
                                        @if($user->address)
                                            {{ $user->address }}<br>
                                        @endif
                                        {{ collect([$user->city, $user->state, $user->zip])->filter()->implode(', ') }}
                                        @if($user->country)
                                            <br>{{ $user->country }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Account Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2 text-primary"></i>Account Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">User ID</label>
                            <div class="form-control-plaintext">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <div class="form-control-plaintext">{{ $user->name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <div class="form-control-plaintext">
                                {{ $user->email }}
                                @if($user->email_verified_at)
                                    <span class="badge bg-success bg-gradient ms-2">Verified</span>
                                @else
                                    <span class="badge bg-warning bg-gradient ms-2">Unverified</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Role</label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-{{ $roleColor }} bg-gradient">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Account Created</label>
                            <div class="form-control-plaintext">{{ $user->created_at->format('M d, Y g:i A') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Last Updated</label>
                            <div class="form-control-plaintext">{{ $user->updated_at->format('M d, Y g:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Elevators -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-elevator me-2 text-primary"></i>Assigned Elevators ({{ $user->elevators->count() }})
                        </h5>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Assign Elevator
                        </button>
                    </div>
                </div>
                @if($user->elevators->count() > 0)
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Elevator</th>
                                        <th class="border-0">Location</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Assigned Date</th>
                                        <th class="border-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->elevators as $elevator)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-elevator text-white"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $elevator->name }}</div>
                                                        <div class="text-muted small">ID: {{ $elevator->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                                {{ $elevator->location }}
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $elevator->status == 'active' ? 'success' : 'warning' }} bg-gradient">
                                                    {{ ucfirst($elevator->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" 
                                                            type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View Details</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit Elevator</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-unlink me-2"></i>Unassign</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="card-body text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-elevator fa-3x mb-3"></i>
                            <h6>No Elevators Assigned</h6>
                            <p class="mb-0">This user has no elevators assigned yet.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Activity Log -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Account Created</h6>
                                <p class="timeline-text text-muted">User account was created</p>
                                <small class="text-muted">{{ $user->created_at->format('M d, Y g:i A') }}</small>
                            </div>
                        </div>
                        
                        @if($user->email_verified_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Email Verified</h6>
                                    <p class="timeline-text text-muted">User verified their email address</p>
                                    <small class="text-muted">{{ $user->email_verified_at->format('M d, Y g:i A') }}</small>
                                </div>
                            </div>
                        @endif

                        @if($user->elevators->count() > 0)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Elevators Assigned</h6>
                                    <p class="timeline-text text-muted">{{ $user->elevators->count() }} elevator(s) assigned to user</p>
                                </div>
                            </div>
                        @endif

                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Last Updated</h6>
                                <p class="timeline-text text-muted">User information was last updated</p>
                                <small class="text-muted">{{ $user->updated_at->format('M d, Y g:i A') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-item {
    padding-bottom: 1rem;
    border-bottom: 1px solid #e5e7eb;
}

.contact-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.form-control-plaintext {
    padding-left: 0;
    padding-right: 0;
}

.timeline {
    position: relative;
    padding-left: 3rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 2rem;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -2.125rem;
    top: 1.5rem;
    width: 2px;
    height: calc(100% - 1.5rem);
    background: #e5e7eb;
}

.timeline-marker {
    position: absolute;
    left: -2.5rem;
    top: 0.25rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #e5e7eb;
}

.timeline-title {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.timeline-text {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.user-avatar img {
    object-fit: cover;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card-title {
    font-weight: 600;
}

@media (max-width: 992px) {
    .timeline {
        padding-left: 2rem;
    }
    
    .timeline-marker {
        left: -1.5rem;
    }
    
    .timeline-item:not(:last-child)::before {
        left: -1.125rem;
    }
}
</style>
@endsection
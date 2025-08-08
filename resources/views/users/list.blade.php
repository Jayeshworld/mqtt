@extends('layout.app')
@section('title', 'User Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">User Management</h1>
            <p class="text-muted mb-0">Manage users and their elevator assignments</p>
        </div>
        <div class="d-flex gap-2">

            <a type="button" class="btn btn-primary" href="{{ route('users.create') }}">
                <i class="fas fa-plus me-2"></i>Add User
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient rounded-circle p-3">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold text-primary fs-4">{{ $users->total() }}</div>
                            <div class="text-muted small">Total Users</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-circle p-3">
                                <i class="fas fa-elevator text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold text-success fs-4">{{ $users->sum(function($user) { return $user->elevators->count(); }) }}</div>
                            <div class="text-muted small">Total Elevators</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient rounded-circle p-3">
                                <i class="fas fa-user-shield text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold text-warning fs-4">{{ $users->where('role', 'admin')->count() }}</div>
                            <div class="text-muted small">Admin Users</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-gradient rounded-circle p-3">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold text-info fs-4">{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</div>
                            <div class="text-muted small">New This Month</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ request()->url() }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search Users</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Search by name, email..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="role" class="form-label">Filter by Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="city" class="form-label">Filter by City</label>
                        <select class="form-select" id="city" name="city">
                            <option value="">All Cities</option>
                            @foreach($users->pluck('city')->unique()->filter() as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2 text-primary"></i>User List
                </h5>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-columns me-1"></i>Columns
                        </button>
                        <ul class="dropdown-menu">
                            <li><label class="dropdown-item"><input type="checkbox" checked> Name</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" checked> Email</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" checked> Role</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" checked> Location</label></li>
                            <li><label class="dropdown-item"><input type="checkbox" checked> Elevators</label></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                            </div>
                        </th>
                        <th class="border-0">User</th>
                        <th class="border-0">Contact</th>
                        <th class="border-0">Role</th>
                        <th class="border-0">Location</th>
                        <th class="border-0">Elevators</th>
                        <th class="border-0">Status</th>
                        <th class="border-0">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $user->id }}">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    @if($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                        alt="{{ $user->name }}" class="rounded-circle" width="45" height="45">
                                    @else
                                    <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        <span class="text-white fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    <div class="text-muted small">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="text-dark">{{ $user->email }}</div>
                                @if($user->mobile)
                                <div class="text-muted small">
                                    <i class="fas fa-phone me-1"></i>{{ $user->mobile }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            @php
                            $roleColors = [
                            'admin' => 'danger',
                            'manager' => 'warning',
                            'user' => 'primary',
                            'guest' => 'secondary'
                            ];
                            $roleColor = $roleColors[$user->role] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $roleColor }} bg-gradient">
                                <i class="fas fa-user-{{ $user->role == 'admin' ? 'shield' : ($user->role == 'manager' ? 'tie' : 'circle') }} me-1"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->city || $user->state || $user->country)
                            <div class="text-dark">
                                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                {{ collect([$user->city, $user->state, $user->country])->filter()->implode(', ') }}
                            </div>
                            @if($user->zip)
                            <div class="text-muted small">ZIP: {{ $user->zip }}</div>
                            @endif
                            @else
                            <span class="text-muted">Not specified</span>
                            @endif
                        </td>
                        <td>
                            @if($user->elevators->count() > 0)
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success bg-gradient me-2">{{ $user->elevators->count() }}</span>
                                <div class="dropdown">
                                    <button class="btn btn-link btn-sm text-decoration-none p-0"
                                        type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-eye text-primary"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" style="min-width: 300px;">
                                        <h6 class="dropdown-header">Assigned Elevators</h6>
                                        @foreach ($user->elevators as $elevator)
                                        <div class="dropdown-item-text">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="fw-bold">{{ $elevator->name }}</div>
                                                    <small class="text-muted">
                                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $elevator->location }}
                                                    </small>
                                                </div>
                                                <span class="badge bg-{{ $elevator->status == 'active' ? 'success' : 'warning' }} bg-gradient">
                                                    {{ ucfirst($elevator->status) }}
                                                </span>
                                            </div>
                                            @if(!$loop->last)
                                            <hr class="my-2">@endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="text-muted">
                                <i class="fas fa-minus-circle me-1"></i>No elevators
                            </span>
                            @endif
                        </td>
                        <td>
                            @if($user->email_verified_at)
                            <span class="badge bg-success bg-gradient">
                                <i class="fas fa-check-circle me-1"></i>Active
                            </span>
                            @else
                            <span class="badge bg-warning bg-gradient">
                                <i class="fas fa-exclamation-triangle me-1"></i>Pending
                            </span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                    type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('users.show', $user->id) }}">
                                            <i class="fas fa-eye me-2"></i>View Details
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
                                            <i class="fas fa-edit me-2"></i>Edit User
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('elevators.index', $user->id) }}">
                                            <i class="fas fa-elevator me-2"></i>Manage Elevators
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('users.destroy', $user->id) }}"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash me-2"></i>Delete User
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-users fa-3x mb-3"></i>
                                <h5>No users found</h5>
                                <p>No users match your current filters.</p>
                                <a href="{{ route('users.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add First User
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                </div>
                <div>
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Additional custom styles */
    .table th {
        font-weight: 600;
        color: #374151;
        background-color: #f8fafc !important;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(99, 102, 241, 0.05);
    }

    .dropdown-toggle::after {
        margin-left: 0.5em;
    }

    .card {
        transition: all 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.4em 0.6em;
    }

    .btn-sm {
        font-size: 0.8rem;
    }

    .form-check-input:checked {
        background-color: #6366f1;
        border-color: #6366f1;
    }

    .dropdown-item:hover {
        background-color: rgba(99, 102, 241, 0.1);
    }

    .text-gray-800 {
        color: #374151 !important;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }

        .d-flex.gap-2 {
            flex-direction: column;
        }

        .btn {
            white-space: nowrap;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all checkbox functionality
        const selectAllCheckbox = document.getElementById('selectAll');
        const individualCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');

        selectAllCheckbox?.addEventListener('change', function() {
            individualCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Update select all checkbox based on individual selections
        individualCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('tbody input[type="checkbox"]:checked').length;
                selectAllCheckbox.checked = checkedCount === individualCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < individualCheckboxes.length;
            });
        });
    });
</script>
@endsection
@extends('layout.app')
@section('title', 'Elevators')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Elevators</h1>
            <p class="text-muted mb-0">Manage elevator inventory and assignments</p>
        </div>
        <div>
            <a href="{{ route('elevators.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Elevator
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('elevators.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" class="form-control" name="search"
                            value="{{ request('search') }}"
                            placeholder="Search by name, MAAC ID, or location...">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                            <option value="out_of_order" {{ request('status') == 'out_of_order' ? 'selected' : '' }}>Out of Order</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Assigned User</label>
                        <select class="form-select" name="user_id">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                    </div>
                </div>
                @if(request()->hasAny(['search', 'status', 'user_id']))
                <div class="text-end">
                    <a href="{{ route('elevators.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times me-1"></i>Clear Filters
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Elevators Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($elevators->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>MAAC ID</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Assigned User</th>
                            <th>Created Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($elevators as $elevator)
                        <tr>
                            <td>
                                <span class="fw-bold">{{ $elevator->maac_id }}</span>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-semibold">{{ $elevator->name }}</div>
                                    @if($elevator->remarks)
                                    <small class="text-muted">{{ Str::limit($elevator->remarks, 50) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">{{ Str::limit($elevator->location, 40) }}</small>
                            </td>
                            <td>
                                @if($elevator->capacity)
                                {{ number_format($elevator->capacity) }} kg
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $elevator->status_badge['color'] }}">
                                    {{ $elevator->status_badge['text'] }}
                                </span>
                            </td>
                            <td>
                                @if($elevator->user)
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $elevator->user->name }}</div>
                                        <small class="text-muted">{{ $elevator->user->email }}</small>
                                    </div>
                                </div>
                                @else
                                <span class="text-muted">Not assigned</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $elevator->created_at->format('M d, Y') }}</small>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('elevators.show', $elevator->id) }}"
                                        class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('elevators.edit', $elevator->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete({{ $elevator->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            
            @if($elevators->hasPages())
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $elevators->firstItem() }} to {{ $elevators->lastItem() }} of {{ $elevators->total() }} results
                    </div>
                    <div>
                        {{ $elevators->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            @endif
            @else
            <div class="text-center py-5">
                <i class="fas fa-elevator text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-3 text-muted">No elevators found</h5>
                <p class="text-muted">Get started by adding your first elevator to the system.</p>
                <a href="{{ route('elevators.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Elevator
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this elevator? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(elevatorId) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/elevators/${elevatorId}`;

        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>

<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #374151;
    }
</style>
@endsection
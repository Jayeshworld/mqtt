@extends('layout.app')
@section('title', 'Elevator Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('elevators.index') }}">Elevators</a></li>
                    <li class="breadcrumb-item active">{{ $elevator->name }}</li>
                </ol>
            </nav>
            <h1 class="h3 mb-1 text-gray-800">{{ $elevator->name }}</h1>
            <p class="text-muted mb-0">MAAC ID: {{ $elevator->maac_id }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('elevators.edit', $elevator->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit Elevator
            </a>
            <a href="{{ route('elevators.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Information -->
        <div class="col-lg-8">
            <!-- Basic Information Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-elevator me-2 text-primary"></i>Basic Information
                        </h5>
                        <span class="badge bg-{{ $elevator->status_badge['color'] }} fs-6">
                            {{ $elevator->status_badge['text'] }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">MAAC ID</label>
                            <p class="fw-bold mb-0">{{ $elevator->maac_id }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Elevator Name</label>
                            <p class="fw-bold mb-0">{{ $elevator->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Capacity</label>
                            <p class="mb-0">
                                @if($elevator->capacity)
                                    <span class="fw-semibold">{{ number_format($elevator->capacity) }}</span> kg
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Status</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $elevator->status_badge['color'] }}">
                                    {{ $elevator->status_badge['text'] }}
                                </span>
                            </p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small">Location</label>
                            <p class="mb-0">{{ $elevator->location }}</p>
                        </div>
                        @if($elevator->remarks)
                            <div class="col-12">
                                <label class="form-label text-muted small">Remarks</label>
                                <p class="mb-0">{{ $elevator->remarks }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Assignment Information Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2 text-primary"></i>Assignment Information
                    </h5>
                </div>
                <div class="card-body">
                    @if($elevator->user)
                        <div class="d-flex align-items-center">
                            <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-user text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">{{ $elevator->user->name }}</h6>
                                <p class="text-muted mb-1">{{ $elevator->user->email }}</p>
                                <small class="text-muted">Assigned User</small>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-slash text-muted" style="font-size: 3rem;"></i>
                            <h6 class="mt-3 text-muted">No User Assigned</h6>
                            <p class="text-muted mb-3">This elevator is not currently assigned to any user.</p>
                            <a href="{{ route('elevators.edit', $elevator->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-user-plus me-2"></i>Assign User
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- System Information Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>System Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Created Date</label>
                            <p class="mb-0">{{ $elevator->created_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Last Updated</label>
                            <p class="mb-0">{{ $elevator->updated_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                        @if($elevator->creator)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Created By</label>
                                <p class="mb-0">{{ $elevator->creator->name }}</p>
                            </div>
                        @endif
                        @if($elevator->updater && $elevator->updater->id !== $elevator->creator?->id)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Last Updated By</label>
                                <p class="mb-0">{{ $elevator->updater->name }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('elevators.edit', $elevator->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Elevator
                        </a>
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Delete Elevator
                        </button>
                    </div>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>Summary
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="elevator-icon mb-3">
                            <div class="bg-{{ $elevator->status_badge['color'] }} bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-elevator text-white" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h5>{{ $elevator->name }}</h5>
                        <p class="text-muted mb-3">{{ $elevator->maac_id }}</p>
                        
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h6 class="text-muted small mb-1">CAPACITY</h6>
                                    <p class="mb-0 fw-bold">
                                        {{ $elevator->capacity ? number_format($elevator->capacity) . ' kg' : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-muted small mb-1">STATUS</h6>
                                <span class="badge bg-{{ $elevator->status_badge['color'] }}">
                                    {{ $elevator->status_badge['text'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-clock me-2 text-primary"></i>Recent Activity
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <p class="mb-1 small">Elevator created</p>
                                <small class="text-muted">{{ $elevator->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @if($elevator->updated_at != $elevator->created_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <p class="mb-1 small">Elevator updated</p>
                                    <small class="text-muted">{{ $elevator->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
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
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Delete Elevator</h5>
                    <p>Are you sure you want to delete <strong>{{ $elevator->name }}</strong>?</p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('elevators.destroy', $elevator->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>

<style>
.avatar-lg {
    width: 64px;
    height: 64px;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -22px;
    top: 20px;
    width: 2px;
    height: calc(100% + 10px);
    background-color: #e5e7eb;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    top: 4px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-label {
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.75rem;
}

.card-title {
    font-weight: 600;
}
</style>
@endsection
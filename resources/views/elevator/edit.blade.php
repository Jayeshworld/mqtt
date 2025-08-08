@extends('layout.app')
@section('title', 'Edit Elevator')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('elevators.index') }}">Elevators</a></li>
                    <li class="breadcrumb-item active">Edit Elevator</li>
                </ol>
            </nav>
            <h1 class="h3 mb-1 text-gray-800">Edit Elevator</h1>
            <p class="text-muted mb-0">Update elevator information</p>
        </div>
        <div>
            <a href="{{ route('elevators.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Elevators
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Form -->
        <div class="col-lg-8">
            <form action="{{ route('elevators.update', $elevator->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Elevator Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-elevator me-2 text-primary"></i>Elevator Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- MAAC ID -->
                            <div class="col-md-6 mb-3">
                                <label for="maac_id" class="form-label">MAAC ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('maac_id') is-invalid @enderror"
                                    id="maac_id" name="maac_id" value="{{ old('maac_id', $elevator->maac_id) }}" required
                                    placeholder="e.g., MAAC001">
                                @error('maac_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Elevator Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $elevator->name) }}" required
                                    placeholder="e.g., Building A - Main Elevator">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Capacity -->
                            <div class="col-md-6 mb-3">
                                <label for="capacity" class="form-label">Capacity (kg)</label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror"
                                    id="capacity" name="capacity" value="{{ old('capacity', $elevator->capacity) }}"
                                    placeholder="e.g., 1000">
                                @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Weight capacity in kilograms</div>
                            </div>
                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status', $elevator->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $elevator->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="maintenance" {{ old('status', $elevator->status) == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                    <option value="out_of_order" {{ old('status', $elevator->status) == 'out_of_order' ? 'selected' : '' }}>Out of Order</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Location -->
                            <div class="col-12 mb-3">
                                <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('location') is-invalid @enderror"
                                    id="location" name="location" rows="3" required
                                    placeholder="Complete address or location details">{{ old('location', $elevator->location) }}</textarea>
                                @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Remarks -->
                            <div class="col-12 mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control @error('remarks') is-invalid @enderror"
                                    id="remarks" name="remarks" rows="3"
                                    placeholder="Additional notes or comments">{{ old('remarks', $elevator->remarks) }}</textarea>
                                @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Assignment Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2 text-primary"></i>User Assignment
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Assign to User</label>
                            <select class="form-select @error('user_id') is-invalid @enderror"
                                id="user_id" name="user_id">
                                <option value="">Select User (Optional)</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $elevator->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Select a single user to assign this elevator to</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('elevators.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Elevator
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Column: Preview & History -->
        <div class="col-lg-4">
            <!-- Preview Card -->
            <div class="card border-0 shadow-sm sticky-top">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-eye me-2 text-primary"></i>Preview
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="preview-icon mb-3">
                        <div class="bg-success bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-elevator text-white fa-2x"></i>
                        </div>
                    </div>
                    <h6 class="preview-name text-muted">{{ $elevator->name }}</h6>
                    <p class="preview-maac small text-muted mb-2">{{ $elevator->maac_id }}</p>
                    <div class="preview-status mb-3">
                        <span class="badge bg-{{ $elevator->status_badge['color'] }}">{{ $elevator->status_badge['text'] }}</span>
                    </div>
                    <hr>
                    <div class="text-start small">
                        <div class="preview-location mb-2">
                            <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                            <span class="text-muted">{{ Str::limit($elevator->location, 30) }}</span>
                        </div>
                        <div class="preview-capacity mb-2">
                            <i class="fas fa-weight me-2 text-muted"></i>
                            <span class="text-muted">{{ $elevator->capacity ? $elevator->capacity . ' kg capacity' : 'Capacity not set' }}</span>
                        </div>
                        <div class="preview-user">
                            <i class="fas fa-user me-2 text-muted"></i>
                            <span class="text-muted">{{ $elevator->user ? $elevator->user->name : 'No user assigned' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>History
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Created:</span>
                            <span>{{ $elevator->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($elevator->creator)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Created by:</span>
                            <span>{{ $elevator->creator->name }}</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Last Updated:</span>
                            <span>{{ $elevator->updated_at->format('M d, Y') }}</span>
                        </div>
                        @if($elevator->updater)
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Updated by:</span>
                            <span>{{ $elevator->updater->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Your existing script and styles remain here -->
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form fields
        const maacIdField = document.getElementById('maac_id');
        const nameField = document.getElementById('name');
        const statusField = document.getElementById('status');
        const locationField = document.getElementById('location');
        const capacityField = document.getElementById('capacity');
        const userField = document.getElementById('user_id');

        // Preview elements
        const namePreview = document.querySelector('.preview-name');
        const maacPreview = document.querySelector('.preview-maac');
        const statusPreview = document.querySelector('.preview-status span');
        const locationPreview = document.querySelector('.preview-location span');
        const capacityPreview = document.querySelector('.preview-capacity span');
        const userPreview = document.querySelector('.preview-user span');

        // Status colors
        const statusColors = {
            'active': 'success',
            'inactive': 'secondary',
            'maintenance': 'warning',
            'out_of_order': 'danger'
        };

        // Update preview functions
        function updateNamePreview() {
            namePreview.textContent = nameField.value || 'Elevator Name';
        }

        function updateMaacPreview() {
            maacPreview.textContent = maacIdField.value || 'MAAC ID not set';
        }

        function updateStatusPreview() {
            const status = statusField.value;
            if (status) {
                statusPreview.textContent = status.replace('_', ' ').split(' ').map(word =>
                    word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                statusPreview.className = `badge bg-${statusColors[status] || 'secondary'}`;
            } else {
                statusPreview.textContent = 'Status';
                statusPreview.className = 'badge bg-secondary';
            }
        }

        function updateLocationPreview() {
            const location = locationField.value;
            locationPreview.textContent = location ? location.substring(0, 30) + (location.length > 30 ? '...' : '') : 'Location not set';
        }

        function updateCapacityPreview() {
            const capacity = capacityField.value;
            capacityPreview.textContent = capacity ? `${capacity} kg capacity` : 'Capacity not set';
        }

        function updateUserPreview() {
            const selectedOption = userField.options[userField.selectedIndex];
            userPreview.textContent = selectedOption && selectedOption.value ?
                selectedOption.text.split(' (')[0] : 'No user assigned';
        }

        // Attach event listeners
        maacIdField.addEventListener('input', updateMaacPreview);
        nameField.addEventListener('input', updateNamePreview);
        statusField.addEventListener('change', updateStatusPreview);
        locationField.addEventListener('input', updateLocationPreview);
        capacityField.addEventListener('input', updateCapacityPreview);
        userField.addEventListener('change', updateUserPreview);
    });
</script>
@endsection
@section('styles')

<style>
    .sticky-top {
        top: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
    }

    .card-title {
        font-weight: 600;
    }

    .preview-icon .fa-elevator {
        font-size: 2rem;
    }

    @media (max-width: 992px) {
        .sticky-top {
            position: relative !important;
            top: auto !important;
        }
    }
</style>
@endsection
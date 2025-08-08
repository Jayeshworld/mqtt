@extends('layout.app')
@section('title', 'Create Elevator')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('elevators.index') }}">Elevators</a></li>
                    <li class="breadcrumb-item active">Create Elevator</li>
                </ol>
            </nav>
            <h1 class="h3 mb-1 text-gray-800">Add New Elevator</h1>
            <p class="text-muted mb-0">Register a new elevator in the system</p>
        </div>
        <div>
            <a href="{{ route('elevators.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Elevators
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('elevators.store') }}" method="POST">
                @csrf
                
                <!-- Elevator Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-elevator me-2 text-primary"></i>Elevator Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="maac_id" class="form-label">MAAC ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('maac_id') is-invalid @enderror" 
                                       id="maac_id" name="maac_id" value="{{ old('maac_id') }}" required 
                                       placeholder="e.g., MAAC001">
                                @error('maac_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Elevator Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required 
                                       placeholder="e.g., Building A - Main Elevator">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="capacity" class="form-label">Capacity (kg)</label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                       id="capacity" name="capacity" value="{{ old('capacity') }}" 
                                       placeholder="e.g., 1000">
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Weight capacity in kilograms</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                    <option value="out_of_order" {{ old('status') == 'out_of_order' ? 'selected' : '' }}>Out of Order</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('location') is-invalid @enderror" 
                                          id="location" name="location" rows="3" required
                                          placeholder="Complete address or location details">{{ old('location') }}</textarea>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                          id="remarks" name="remarks" rows="3" 
                                          placeholder="Additional notes or comments">{{ old('remarks') }}</textarea>
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
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('elevators.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Elevator
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Preview Card -->
        <div class="col-lg-4">
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
                    <h6 class="preview-name text-muted">Elevator Name</h6>
                    <p class="preview-maac small text-muted mb-2">MAAC ID not set</p>
                    <div class="preview-status mb-3">
                        <span class="badge bg-secondary">Status</span>
                    </div>
                    <hr>
                    <div class="text-start small">
                        <div class="preview-location mb-2">
                            <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                            <span class="text-muted">Location not set</span>
                        </div>
                        <div class="preview-capacity mb-2">
                            <i class="fas fa-weight me-2 text-muted"></i>
                            <span class="text-muted">Capacity not set</span>
                        </div>
                        <div class="preview-user">
                            <i class="fas fa-user me-2 text-muted"></i>
                            <span class="text-muted">No user assigned</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
        locationPreview.textContent = locationField.value || 'Location not set';
    }
    
    function updateCapacityPreview() {
        const capacity = capacityField.value;
        capacityPreview.textContent = capacity ? `${capacity} kg capacity` : 'Capacity not set';
    }
    
    function updateUserPreview() {
        const selectedOption = userField.options[userField.selectedIndex];
        userPreview.textContent = selectedOption && selectedOption.value ? 
            selectedOption.text : 'No user assigned';
    }
    
    // Attach event listeners
    maacIdField.addEventListener('input', updateMaacPreview);
    nameField.addEventListener('input', updateNamePreview);
    statusField.addEventListener('change', updateStatusPreview);
    locationField.addEventListener('input', updateLocationPreview);
    capacityField.addEventListener('input', updateCapacityPreview);
    userField.addEventListener('change', updateUserPreview);
    
    // Initialize preview
    updateMaacPreview();
    updateNamePreview();
    updateStatusPreview();
    updateLocationPreview();
    updateCapacityPreview();
    updateUserPreview();
});
</script>

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
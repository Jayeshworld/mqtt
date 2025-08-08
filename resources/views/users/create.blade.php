@extends('layout.app')
@section('title', 'Create User')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Create User</li>
                </ol>
            </nav>
            <h1 class="h3 mb-1 text-gray-800">Create New User</h1>
            <p class="text-muted mb-0">Add a new user to the system</p>
        </div>
        <div>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Personal Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2 text-primary"></i>Personal Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" 
                                       id="mobile" name="mobile" value="{{ old('mobile') }}">
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" 
                                       id="profile_picture" name="profile_picture" accept="image/*">
                                @error('profile_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Accepted formats: JPG, PNG, GIF. Max size: 2MB</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>Address Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Street Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                               id="city" name="city" value="{{ old('city') }}">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                               id="state" name="state" value="{{ old('state') }}">
                                        @error('state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="zip" class="form-label">ZIP Code</label>
                                        <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                                               id="zip" name="zip" value="{{ old('zip') }}">
                                        @error('zip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                               id="country" name="country" value="{{ old('country') }}">
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lock me-2 text-primary"></i>Security Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Minimum 8 characters with letters and numbers</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="send_welcome_email" 
                                   name="send_welcome_email" value="1" {{ old('send_welcome_email') ? 'checked' : '' }}>
                            <label class="form-check-label" for="send_welcome_email">
                                Send welcome email with login credentials
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create User
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
                    <div class="preview-avatar mb-3">
                        <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                             style="width: 80px; height: 80px;" id="avatar-preview">
                            <span class="text-white fw-bold fs-4">?</span>
                        </div>
                    </div>
                    <h6 class="preview-name text-muted">User Name</h6>
                    <p class="preview-email small text-muted mb-2">email@example.com</p>
                    <div class="preview-role">
                        <span class="badge bg-secondary">Role</span>
                    </div>
                    <hr>
                    <div class="text-start small text-muted">
                        <div class="preview-location mb-1">
                            <i class="fas fa-map-marker-alt me-2"></i>Location not set
                        </div>
                        <div class="preview-mobile">
                            <i class="fas fa-phone me-2"></i>Mobile not set
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
    const nameField = document.getElementById('name');
    const emailField = document.getElementById('email');
    const mobileField = document.getElementById('mobile');
    const roleField = document.getElementById('role');
    const cityField = document.getElementById('city');
    const stateField = document.getElementById('state');
    const countryField = document.getElementById('country');
    const profilePictureField = document.getElementById('profile_picture');
    
    // Preview elements
    const avatarPreview = document.getElementById('avatar-preview');
    const namePreview = document.querySelector('.preview-name');
    const emailPreview = document.querySelector('.preview-email');
    const rolePreview = document.querySelector('.preview-role span');
    const locationPreview = document.querySelector('.preview-location');
    const mobilePreview = document.querySelector('.preview-mobile');
    
    // Role colors
    const roleColors = {
        'admin': 'danger',
        'manager': 'warning',
        'user': 'primary'
    };
    
    // Update preview functions
    function updateAvatarPreview() {
        const name = nameField.value;
        if (name) {
            avatarPreview.innerHTML = `<span class="text-white fw-bold fs-4">${name.charAt(0).toUpperCase()}</span>`;
        } else {
            avatarPreview.innerHTML = `<span class="text-white fw-bold fs-4">?</span>`;
        }
    }
    
    function updateNamePreview() {
        namePreview.textContent = nameField.value || 'User Name';
    }
    
    function updateEmailPreview() {
        emailPreview.textContent = emailField.value || 'email@example.com';
    }
    
    function updateRolePreview() {
        const role = roleField.value;
        if (role) {
            rolePreview.textContent = role.charAt(0).toUpperCase() + role.slice(1);
            rolePreview.className = `badge bg-${roleColors[role] || 'secondary'}`;
        } else {
            rolePreview.textContent = 'Role';
            rolePreview.className = 'badge bg-secondary';
        }
    }
    
    function updateLocationPreview() {
        const location = [cityField.value, stateField.value, countryField.value]
            .filter(val => val)
            .join(', ');
        locationPreview.innerHTML = `<i class="fas fa-map-marker-alt me-2"></i>${location || 'Location not set'}`;
    }
    
    function updateMobilePreview() {
        mobilePreview.innerHTML = `<i class="fas fa-phone me-2"></i>${mobileField.value || 'Mobile not set'}`;
    }
    
    // Attach event listeners
    nameField.addEventListener('input', () => {
        updateNamePreview();
        updateAvatarPreview();
    });
    
    emailField.addEventListener('input', updateEmailPreview);
    roleField.addEventListener('change', updateRolePreview);
    mobileField.addEventListener('input', updateMobilePreview);
    cityField.addEventListener('input', updateLocationPreview);
    stateField.addEventListener('input', updateLocationPreview);
    countryField.addEventListener('input', updateLocationPreview);
    
    // Profile picture preview
    profilePictureField.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.innerHTML = `<img src="${e.target.result}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">`;
            };
            reader.readAsDataURL(file);
        } else {
            updateAvatarPreview();
        }
    });
    
    // Initialize preview
    updateNamePreview();
    updateEmailPreview();
    updateRolePreview();
    updateLocationPreview();
    updateMobilePreview();
    updateAvatarPreview();
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

.preview-avatar img {
    object-fit: cover;
}

@media (max-width: 992px) {
    .sticky-top {
        position: relative !important;
        top: auto !important;
    }
}
</style>
@endsection
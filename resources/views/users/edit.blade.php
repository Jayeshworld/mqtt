@extends('layout.app')
@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
            </nav>
            <h1 class="h3 mb-1 text-gray-800">Edit User</h1>
            <p class="text-muted mb-0">Update user information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-2"></i>View Details
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
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
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" 
                                       id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}">
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                @if($user->profile_picture)
                                    <div class="current-image mb-2">
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                             alt="Current profile picture" class="rounded" style="max-width: 100px; max-height: 100px;">
                                        <div class="form-text">Current profile picture</div>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" 
                                       id="profile_picture" name="profile_picture" accept="image/*">
                                @error('profile_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave empty to keep current image. Accepted formats: JPG, PNG, GIF. Max size: 2MB</div>
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
                                          id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                               id="city" name="city" value="{{ old('city', $user->city) }}">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                               id="state" name="state" value="{{ old('state', $user->state) }}">
                                        @error('state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="zip" class="form-label">ZIP Code</label>
                                        <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                                               id="zip" name="zip" value="{{ old('zip', $user->zip) }}">
                                        @error('zip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                               id="country" name="country" value="{{ old('country', $user->country) }}">
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Update Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lock me-2 text-primary"></i>Update Password
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Leave password fields empty to keep current password
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Minimum 8 characters with letters and numbers</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Status Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-toggle-on me-2 text-primary"></i>Account Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="email_verified" 
                                           name="email_verified" value="1" 
                                           {{ $user->email_verified_at ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email_verified">
                                        Email Verified
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small">
                                    @if($user->email_verified_at)
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        Verified on {{ $user->email_verified_at->format('M d, Y') }}
                                    @else
                                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                        Not verified yet
                                    @endif
                                </div>
                            </div>
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
                                <i class="fas fa-save me-2"></i>Update User
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- User Info Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>User Information
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="user-avatar mb-3">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                 alt="{{ $user->name }}" class="rounded-circle" 
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 80px; height: 80px;">
                                <span class="text-white fw-bold fs-4">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <h6 class="user-name">{{ $user->name }}</h6>
                    <p class="user-email small text-muted mb-2">{{ $user->email }}</p>
                    <div class="user-role mb-3">
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
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <hr>
                    <div class="text-start small">
                        <div class="mb-2">
                            <strong>User ID:</strong> #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="mb-2">
                            <strong>Created:</strong> {{ $user->created_at->format('M d, Y') }}
                        </div>
                        <div class="mb-2">
                            <strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y') }}
                        </div>
                        @if($user->elevators->count() > 0)
                            <div class="mb-2">
                                <strong>Elevators:</strong> {{ $user->elevators->count() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Elevators Card -->
            @if($user->elevators->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-elevator me-2 text-primary"></i>Assigned Elevators
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($user->elevators as $elevator)
                            <div class="d-flex align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="flex-shrink-0">
                                    <div class="bg-success bg-gradient rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <i class="fas fa-elevator text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-bold">{{ $elevator->name }}</div>
                                    <div class="text-muted small">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $elevator->location }}
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-{{ $elevator->status == 'active' ? 'success' : 'warning' }} bg-gradient">
                                        {{ ucfirst($elevator->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer bg-white border-top text-center">
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-cog me-1"></i>Manage Elevators
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

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

.current-image img {
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
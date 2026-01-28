@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>AC Management</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('acs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New AC
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('acs.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by Name, MAC ID, Location" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="out_of_order" {{ request('status') == 'out_of_order' ? 'selected' : '' }}>Out of Order</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="user_id" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- AC Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>MAC ID</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Capacity (BTU)</th>
                            <th>Status</th>
                            <th>Assigned User</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($acs as $ac)
                            <tr>
                                <td>{{ $ac->id }}</td>
                                <td><code>{{ $ac->maac_id }}</code></td>
                                <td>{{ $ac->name }}</td>
                                <td>{{ $ac->location }}</td>
                                <td>{{ $ac->capacity ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $ac->status_badge['color'] }}">
                                        {{ $ac->status_badge['text'] }}
                                    </span>
                                </td>
                                <td>{{ $ac->user->name ?? 'Unassigned' }}</td>
                                <td>
                                    <a href="{{ route('acs.show', $ac->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('acs.edit', $ac->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('acs.destroy', $ac->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No ACs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $acs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
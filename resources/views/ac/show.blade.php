@extends('layout.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>AC Details</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('acs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('acs.edit', $ac->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>MAC ID:</strong>
                    <p><code>{{ $ac->maac_id }}</code></p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Name:</strong>
                    <p>{{ $ac->name }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Location:</strong>
                    <p>{{ $ac->location }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Capacity:</strong>
                    <p>{{ $ac->capacity ?? 'N/A' }} BTU</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong>
                    <p>
                        <span class="badge bg-{{ $ac->status_badge['color'] }}">
                            {{ $ac->status_badge['text'] }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Assigned User:</strong>
                    <p>{{ $ac->user->name ?? 'Unassigned' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <strong>Remarks:</strong>
                    <p>{{ $ac->remarks ?? 'No remarks' }}</p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Created By:</strong>
                    <p>{{ $ac->creator->name ?? 'N/A' }}</p>
                    <small class="text-muted">{{ $ac->created_at->format('d M Y, h:i A') }}</small>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Updated By:</strong>
                    <p>{{ $ac->updater->name ?? 'N/A' }}</p>
                    <small class="text-muted">{{ $ac->updated_at->format('d M Y, h:i A') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
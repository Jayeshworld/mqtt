@extends('layout.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Display Details</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('displays.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('displays.edit', $display->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>MAC ID:</strong>
                    <p><code>{{ $display->maac_id }}</code></p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Name:</strong>
                    <p>{{ $display->name }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Location:</strong>
                    <p>{{ $display->location }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Resolution:</strong>
                    <p>{{ $display->resolution ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong>
                    <p>
                        <span class="badge bg-{{ $display->status_badge['color'] }}">
                            {{ $display->status_badge['text'] }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Assigned User:</strong>
                    <p>{{ $display->user->name ?? 'Unassigned' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <strong>Remarks:</strong>
                    <p>{{ $display->remarks ?? 'No remarks' }}</p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Created By:</strong>
                    <p>{{ $display->creator->name ?? 'N/A' }}</p>
                    <small class="text-muted">{{ $display->created_at->format('d M Y, h:i A') }}</small>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Updated By:</strong>
                    <p>{{ $display->updater->name ?? 'N/A' }}</p>
                    <small class="text-muted">{{ $display->updated_at->format('d M Y, h:i A') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
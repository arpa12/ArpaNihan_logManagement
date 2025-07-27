@extends('layout.admin')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm rounded">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">My Activity Logs</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center mb-0">
                        <thead class="bg-light text-dark fw-semibold" style="font-size: 15px;">
                        <tr>
                            <th style="min-width: 60px;">Serial</th>
{{--                            <th style="min-width: 80px;">User ID</th>--}}
                            <th style="min-width: 120px;">User Name</th>
                            <th style="min-width: 120px;">Role</th>
                            <th style="min-width: 120px;">Module</th>
                            <th style="min-width: 100px;">Action</th>
                            <th style="min-width: 250px;">Message</th>
                            <th style="min-width: 220px;">URL</th>
                            <th style="min-width: 120px;">IP Address</th>
                            <th style="min-width: 200px;">Date & Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($activityLogs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
{{--                                <td>{{ $log->user_id }}</td>--}}
                                <td>{{ $log->user_name ?? 'N/A' }}</td>
                                <td>{{ $log->user_role ?? 'N/A' }}</td>
                                <td>{{ $log->module ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-secondary text-uppercase px-3 py-1">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td>
                                    <div class="text-wrap text-start" title="{{ $log->message }}">
                                        <span>{{ Str::limit($log->message, 100) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-wrap text-start" title="{{ $log->url }}">
                                        <a href="{{ $log->url }}" target="_blank" class="text-decoration-none">
                                            {{ Str::limit($log->url, 60) }}
                                        </a>
                                    </div>
                                </td>
                                <td><code>{{ $log->ip_address }}</code></td>
                                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('M j, Y – g:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-muted text-center py-4">
                                    <i class="fas fa-file-alt fa-2x mb-2 text-muted"></i><br>
                                    No logs available.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .badge {
            font-size: 0.75em;
        }

        .table th {
            background-color: #f8f9fa !important;
            border-color: #dee2e6;
            font-weight: 600;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
@endsection

@extends('layout.admin')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm rounded">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Action Logs</h4>
            </div>

            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('actionlogs.index') }}" class="mb-4 p-3 bg-light rounded shadow-sm">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="user_name" class="form-label">Username</label>
                            <input type="text" name="user_name" id="user_name" class="form-control"
                                   placeholder="Enter username" value="{{ request('user_name') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="module" class="form-label">Module</label>
                            <input type="text" name="module" id="module" class="form-control"
                                   placeholder="Enter module name" value="{{ request('module') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="action" class="form-label">Action</label>
                            <input type="text" name="action" id="action" class="form-control"
                                   placeholder="Enter action type" value="{{ request('action') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="from_date" class="form-label">From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"
                                   value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"
                                   value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="w-100">
                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <a href="{{ route('actionlogs.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-times me-1"></i> Clear
                                </a>
                            </div>
                        </div>
                    </div>

                    @if(request()->hasAny(['user_name', 'module', 'action', 'from_date', 'to_date']))
                        <div class="mt-3">
                            <small class="text-muted">Active filters:</small>
                            <div class="d-flex flex-wrap gap-2 mt-1">
                                @if(request('user_name'))
                                    <span class="badge bg-info">Username: {{ request('user_name') }}</span>
                                @endif
                                @if(request('module'))
                                    <span class="badge bg-info">Module: {{ request('module') }}</span>
                                @endif
                                @if(request('action'))
                                    <span class="badge bg-info">Action: {{ request('action') }}</span>
                                @endif
                                @if(request('from_date'))
                                    <span class="badge bg-info">From: {{ request('from_date') }}</span>
                                @endif
                                @if(request('to_date'))
                                    <span class="badge bg-info">To: {{ request('to_date') }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </form>

                <!-- DataTable -->
                <div class="table-responsive">
                    <table id="actionLogTable" class="table table-bordered table-hover align-middle text-center mb-0 w-100">
                        <thead class="bg-light text-dark fw-semibold" style="font-size: 15px;">
                        <tr>
                            <th>Serial</th>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Role</th>
                            <th>Module</th>
                            <th>Action</th>
                            <th>Message</th>
                            <th>URL</th>
                            <th>IP Address</th>
                            <th>Date & Time</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(function () {
                const table = $('#actionLogTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('actionlogs.index') }}',
                        data: function (d) {
                            d.user_name = $('#user_name').val();
                            d.module = $('#module').val();
                            d.action = $('#action').val();
                            d.from_date = $('#from_date').val();
                            d.to_date = $('#to_date').val();
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'user_id', name: 'user_id' },
                        { data: 'user_name', name: 'user_name' },
                        { data: 'user_role', name: 'user_role' },
                        { data: 'module', name: 'module' },
                        { data: 'action', name: 'action' },
                        { data: 'message', name: 'message' },
                        { data: 'url', name: 'url' },
                        { data: 'ip_address', name: 'ip_address' },
                        { data: 'created_at', name: 'created_at' },
                    ],
                    order: [[9, 'desc']],
                    language: {
                        emptyTable: `<div class="text-center p-3 text-muted">
                                <i class="fas fa-file-alt fa-2x mb-2"></i><br>
                                No logs available or matching your filters.
                             </div>`
                    }
                });

                // Redraw table on filter form submit
                $('form').on('submit', function (e) {
                    e.preventDefault();
                    table.draw();
                });
            });
        </script>
    @endpush

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

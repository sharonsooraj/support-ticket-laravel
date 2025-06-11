@extends('admin.layouts.app')

@section('content')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row task">
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <div class="task-summary">
                                        <div class="d-flex align-items-baseline">
                                            <h2 class="text-primary count">{{ $typeCounts['Technical Issues'] ?? 0 }}</h2>
                                            <span class="ms-2">Technical</span>
                                        </div>
                                        <p>Tickets</p>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-sm-4 col-6">
                                    <div class="task-summary task-sven">
                                        <div class="d-flex align-items-baseline">
                                            <h2 class="text-purple count">{{ $typeCounts['Account & Billing'] ?? 0 }}</h2>
                                            <span class="ms-2">Billing</span>
                                        </div>
                                        <p>Tickets</p>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-sm-4 col-6">
                                    <div class="task-summary task-odd">
                                        <div class="d-flex align-items-baseline">
                                            <h2 class="text-warning count">{{ $typeCounts['Product & Service'] ?? 0 }}</h2>
                                            <span class="ms-2">Product</span>
                                        </div>
                                        <p>Tickets</p>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-sm-4 col-6">
                                    <div class="task-summary task-eleven">
                                        <div class="d-flex align-items-baseline">
                                            <h2 class="text-danger count">{{ $typeCounts['General Inquiry'] ?? 0 }}</h2>
                                            <span class="ms-2">Inquiry</span>
                                        </div>
                                        <p>Tickets</p>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-sm-4 col-6">
                                    <div class="task-summary">
                                        <div class="d-flex align-items-baseline">
                                            <h2 class="text-success count">{{ $typeCounts['Feedback & Suggestions'] ?? 0 }}
                                            </h2>
                                            <span class="ms-2">Feedback</span>
                                        </div>
                                        <p>Tickets</p>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-sm-4 col-6">
                                    <div class="task-summary">
                                        <div class="d-flex align-items-baseline">
                                            <h2 class="text-success count">0</h2>
                                            <span class="ms-2">Other's</span>
                                        </div>
                                        <p>Tickets</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="tbl-caption">
                                    <h4 class="heading mb-0">Tickets</h4>
                                </div>
                                <table id="ticketsTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Message</th>
                                            <th>Subject</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Submitted At</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $index => $ticket)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ Str::limit($ticket->message, 50) }}</td>
                                                <td>{{ $ticket->subject }}</td>
                                                <td>{{ $ticket->email }}</td>
                                                <td>{{ $ticket->type }}</td>
                                                @php
                                                    $status = $ticket->status ?? 'pending';
                                                    $statusClass = match ($status) {
                                                        'Pending' => 'bg-info',
                                                        'noted' => 'bg-success',
                                                        default => 'bg-muted',
                                                    };
                                                @endphp


                                                <td>
                                                    <span
                                                        class="badge {{ $statusClass }} text-dark">{{ ucfirst($status) }}</span>
                                                </td>
                                                <td>{{ $ticket->created_at->format('d M Y h:i A') }}</td>
                                                <td class="text-end">

                                                    <form action="{{ route('admin.tickets.show') }}" method="POST"
                                                        class="d-inline">
                                                        @csrf

                                                        <input type="hidden" name="id" value="{{ $ticket->id }}">
                                                        <input type="hidden" name="type" value="{{ $ticket->type }}">
                                                        <button class="btn btn-sm btn-warning" type="submit">View</button>
                                                    </form>
                                                    <form action="{{ route('admin.tickets.destroy') }}" method="POST"
                                                        class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value="{{ $ticket->id }}">
                                                        <input type="hidden" name="type" value="{{ $ticket->type }}">
                                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#ticketsTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search tickets..."
                },
                pagingType: "numbers", // This shows only page numbers
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                initComplete: function() {
                    $('.dataTables_wrapper .page-link').addClass('btn btn-sm btn-primary');
                }
            });
            // SweetAlert for delete confirmation
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>

    <style>
        /* Optional: Style for page numbers */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.25rem 0.5rem;
            margin: 0 0.15rem;
            border-radius: 0.25rem;
            border: 1px solid #dee2e6;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #0d6efd;
            color: white !important;
            border: 1px solid #0d6efd;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e9ecef;
        }
    </style>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection

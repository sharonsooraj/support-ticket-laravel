@extends('admin.layouts.app')

@section('content')
    <div class="container" style="margin-left: 300px">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Ticket Details</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $ticket->name }}</p>
                <p><strong>Email:</strong> {{ $ticket->email }}</p>
                <p><strong>Type:</strong> {{ $ticket->type }}</p>
                <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
                <p><strong>Message:</strong></p>
                <div class="border p-2 rounded bg-light">
                    {{ $ticket->message }}
                </div>
                @php
                    $status = $ticket->status ?? 'pending';
                    $statusClass = match ($status) {
                        'Pending' => 'text-warning',
                        'noted' => 'text-success',
                        default => 'text-muted',
                    };
                @endphp

                <p class="mt-3">
                    <strong>Status:</strong>
                    <span class="{{ $statusClass }}">{{ ucfirst($status) }}</span>
                </p>

                <p><strong>Submitted At:</strong> {{ $ticket->created_at->format('d M Y h:i A') }}</p>
            </div>
        </div>

        <!-- Admin Note Form -->
        <div class="card mt-4 shadow">
            <div class="card-header">
                <h5 class="mb-0">Admin Note</h5>
            </div>
            <div class="card-body">
                <form id="updateTicketForm" action="{{ route('admin.tickets.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id" value="{{ $ticket->id }}">
                    <input type="hidden" name="type" value="{{ $ticket->type }}">
                    <div class="mb-3">
                        <textarea name="admin_note" id="admin_note" class="form-control" rows="6">{{ $ticket->note ?? '' }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save me-1"></i> Update Note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('admin_note');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#updateTicketForm').on('submit', function(e) {

                if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.admin_note) {
                    const noteHtml = CKEDITOR.instances.admin_note.getData();


                    const noteText = $('<div>').html(noteHtml).text().trim();

                    if (noteText === '') {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validation Error',
                            text: 'Admin note cannot be empty.',
                        });

                    }
                } else {
                    
                    const note = $('#admin_note').val().trim();
                    if (note === '') {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validation Error',
                            text: 'Admin note cannot be empty.',
                        });
                        $('#admin_note').focus();
                    }
                }
            });
        });
    </script>
@endsection

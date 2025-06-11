<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Support Ticket</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        body {
            background: url('https://images.unsplash.com/photo-1551836022-4c4c79ecde62?auto=format&fit=crop&w=1600&q=80') no-repeat center center fixed;
            background-size: cover;
        }

        .ticket-form-wrapper {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="ticket-form-wrapper w-100" style="max-width: 600px;">
            <h3 class="text-center mb-4 text-primary"><i class="fa-solid fa-ticket-alt me-2"></i>Generate Support Ticket
            </h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops! Something went wrong:</strong>
                    {{-- <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul> --}}
                </div>
            @endif

            <form action="{{ route('ticket.store') }}" method="POST" novalidate>
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required
                        placeholder="Enter your name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required
                        placeholder="Enter your email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ticket Type -->
                <div class="mb-3">
                    <label for="type" class="form-label">Ticket Type</label>
                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror"
                        required>
                        <option value="">-- Select Type --</option>
                        <option value="Technical Issues" {{ old('type') == 'Technical Issues' ? 'selected' : '' }}>
                            Technical Issues</option>
                        <option value="Account & Billing" {{ old('type') == 'Account & Billing' ? 'selected' : '' }}>
                            Account & Billing</option>
                        <option value="Product & Service" {{ old('type') == 'Product & Service' ? 'selected' : '' }}>
                            Product & Service</option>
                        <option value="General Inquiry" {{ old('type') == 'General Inquiry' ? 'selected' : '' }}>General
                            Inquiry</option>
                        <option value="Feedback & Suggestions"
                            {{ old('type') == 'Feedback & Suggestions' ? 'selected' : '' }}>Feedback & Suggestions
                        </option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Subject -->
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" name="subject" id="subject"
                        class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}"
                        required placeholder="Enter subject">
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Message -->
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" id="message" rows="5" class="form-control @error('message') is-invalid @enderror"
                        required placeholder="Describe your issue">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane me-2"></i>Submit Ticket
                    </button>
                </div>
            </form>


        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

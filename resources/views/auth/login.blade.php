<x-guest-layout>
    <div class="container d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="card shadow border-0" style="width: 100%; max-width: 420px; border-radius: 16px;">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Login Icon" width="64"
                        class="mb-3">
                   
                    <h4 class="fw-bold">Welcome Back Admin!</h4>
                    <p class="text-muted small">Please log in to continue</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">Remember me</label>
                    </div>

                    <!-- Forgot Password + Submit -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none small">Forgot
                                password?</a>
                        @endif
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block">
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

<x-guest-layout>
    <div class="container">
        <h1>Two Factor Authentication Setup</h1>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <div class="mt-3">
            <h2>Scan this QR code with your Google Authenticator app</h2>
            <img src="{{ session('two_factor_qr') }}" alt="QR Code">
        </div>
        <form action="{{ route('two-factor.verify') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="two_factor_code" class="form-label">Enter your 2FA code</label>
                <input type="text" class="form-control" id="two_factor_code" name="two_factor_code" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify</button>
        </form>
    </div>
</x-guest-layout>
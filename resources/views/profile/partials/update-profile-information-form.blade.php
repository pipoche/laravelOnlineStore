<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Update Profile Information</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-muted">Your email address is unverified.</p>
                        <button form="send-verification" class="btn btn-link">Click here to re-send the verification email.</button>
                        @if (session('status') === 'verification-link-sent')
                            <p class="text-success">A new verification link has been sent to your email address.</p>
                        @endif
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

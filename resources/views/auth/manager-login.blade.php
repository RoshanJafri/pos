@extends('layouts.app')

@push('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header">Manager Access</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('manager.login.submit') }}">
                            @csrf

                            <input type="password" name="password" class="form-control mb-2" placeholder="Enter password"
                                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                                data-lpignore="true" {{-- LastPass --}} data-form-type="password" {{-- 1Password --}}
                                aria-autocomplete="none" inputmode="none" />

                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror

                            <button class="btn btn-primary w-100">
                                Unlock
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const pwd = document.getElementById('manager-password');

    if (!pwd) return;

    // 1️⃣ Clear any value set by browser on load
    pwd.value = '';

    // 2️⃣ Re-clear shortly after load (Chrome autofills late)
    setTimeout(() => pwd.value = '', 50);
    setTimeout(() => pwd.value = '', 200);
    setTimeout(() => pwd.value = '', 500);

    // 3️⃣ Detect autofill via CSS animation hack
    pwd.addEventListener('animationstart', e => {
        if (e.animationName === 'onAutoFillStart') {
            pwd.value = '';
        }
    });

    // 4️⃣ Block programmatic value injection
    let lastValue = '';
    setInterval(() => {
        if (pwd.value !== lastValue && !pwd.matches(':focus')) {
            pwd.value = '';
        }
        lastValue = pwd.value;
    }, 300);

    // 5️⃣ Force user interaction
    pwd.addEventListener('focus', () => {
        pwd.value = '';
    });

});
</script>
@endpush
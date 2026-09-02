<x-auth-layout>
    <style>
    /* Custom Auth Card Container */
    .auth-card-container {
        width: 100% !important;
        max-width: 440px !important;
        margin: 0 auto !important;
        padding: 32px 28px !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease !important;
        box-sizing: border-box !important;
    }
    html:not(.dark) .auth-card-container {
        background-color: #ffffff !important;
        border: 1px solid #e5e7eb !important;
    }
    html.dark .auth-card-container {
        background-color: #10201b !important;
        border: 1px solid #1c382f !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
    }

    /* Titles & Subtitles */
    html:not(.dark) .auth-title { color: #111827 !important; }
    html:not(.dark) .auth-subtitle { color: #6b7280 !important; }
    html.dark .auth-title { color: #ffffff !important; }
    html.dark .auth-subtitle { color: #9ca3af !important; }

    /* Form Labels */
    .auth-card-container label {
        display: block !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        margin-bottom: 8px !important;
    }
    html:not(.dark) .auth-card-container label { color: #374151 !important; }
    html.dark .auth-card-container label { color: #e5e7eb !important; }

    /* Input Fields */
    .auth-card-container input[type="email"] {
        width: 100% !important;
        padding: 12px 16px !important;
        border-radius: 12px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        box-sizing: border-box !important;
        transition: all 0.2s ease !important;
    }
    html:not(.dark) .auth-card-container input[type="email"] {
        background-color: #f9fafb !important;
        border: 1.5px solid #d1d5db !important;
        color: #111827 !important;
    }
    html:not(.dark) .auth-card-container input[type="email"]::placeholder {
        color: #9ca3af !important;
    }
    html.dark .auth-card-container input[type="email"] {
        background-color: #152922 !important;
        border: 1.5px solid #204035 !important;
        color: #ffffff !important;
    }
    html.dark .auth-card-container input[type="email"]::placeholder {
        color: #6b7280 !important;
    }
    .auth-card-container input[type="email"]:focus {
        border-color: #00b692 !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(0, 182, 146, 0.25) !important;
    }

    /* Primary Submit Button */
    .auth-submit-btn {
        background-color: #00b692 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 16px !important;
        padding: 14px 20px !important;
        border-radius: 12px !important;
        border: none !important;
        width: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        box-shadow: 0 4px 16px rgba(0, 182, 146, 0.35) !important;
        transition: all 0.2s ease !important;
    }
    .auth-submit-btn:hover {
        background-color: #009c7d !important;
        box-shadow: 0 6px 20px rgba(0, 182, 146, 0.45) !important;
        transform: translateY(-1px) !important;
    }
    </style>

    <div class="auth-card-container">
        <!-- Title & Subtitle -->
        <div style="margin-bottom: 24px; text-align: left;">
            <h2 class="auth-title" style="font-size: 28px; font-weight: 800; letter-spacing: -0.5px; margin: 0 0 6px 0; line-height: 1.2;">
                Forgot Password?
            </h2>
            <p class="auth-subtitle" style="font-size: 14px; font-weight: 500; margin: 0; line-height: 1.5;">
                {{ __('app.forgotPasswordMessage') }}
            </p>
        </div>

        <x-validation-errors class="mb-4"/>

        @session('status')
        <div style="margin-bottom: 16px; font-size: 14px; font-weight: 500; color: #00b692; background: rgba(0,182,146,0.1); padding: 12px 16px; border-radius: 10px; border: 1px solid rgba(0,182,146,0.2);">
            {{ $value }}
        </div>
        @endsession

        <form method="POST" action="{{ route('password.email') }}" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf

            <!-- Email Field -->
            <div style="text-align: left;">
                <label for="email" class="auth-label">
                    {{ __('app.email') }}
                </label>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       autocomplete="username" 
                       placeholder="admin@example.com" />
            </div>

            <!-- Submit Button -->
            <div style="margin-top: 8px;">
                <button type="submit" class="auth-submit-btn button">
                    <svg aria-hidden="true" class="hidden animate-spin" style="width: 20px; height: 20px; margin-right: 8px; color: #ffffff; fill: #ffffff;" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span>{{ __('app.sendPasswordResetLink') }}</span>
                </button>
            </div>

            <!-- Footer Links -->
            <div style="text-align: center; margin-top: 12px; display: flex; flex-direction: column; gap: 10px;">
                <div class="auth-subtitle" style="font-size: 14px; font-weight: 500;">
                    Remember your password? 
                    <a href="{{ route('login') }}" style="color: #00b692; font-weight: 700; text-decoration: none; margin-left: 4px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                        Log in
                    </a>
                </div>
            </div>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.querySelector('.button');
            if (button) {
                button.addEventListener('click', function() {
                    const emailField = document.getElementById('email');
                    if (emailField && emailField.checkValidity() && emailField.value) {
                        button.classList.add('opacity-75', 'cursor-not-allowed');
                        const spinner = button.querySelector('svg');
                        if (spinner) spinner.classList.remove('hidden');
                    }
                });
            }
        });
    </script>
</x-auth-layout>

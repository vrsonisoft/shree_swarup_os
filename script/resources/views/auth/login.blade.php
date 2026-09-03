<x-auth-layout>
    <style>
    /* Custom Auth Card & Inputs */
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
    html:not(.dark) .auth-title { color: #111827 !important; }
    html:not(.dark) .auth-subtitle { color: #6b7280 !important; }
    html:not(.dark) .auth-label { color: #374151 !important; }
    html:not(.dark) .auth-input {
        background-color: #f9fafb !important;
        border: 1.5px solid #d1d5db !important;
        color: #111827 !important;
    }
    html:not(.dark) .auth-input::placeholder { color: #9ca3af !important; }
    html:not(.dark) .auth-input:focus {
        border-color: #00b692 !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(0, 182, 146, 0.2) !important;
    }
    html:not(.dark) .auth-text { color: #4b5563 !important; }

    html.dark .auth-card-container {
        background-color: #10201b !important;
        border: 1px solid #1c382f !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
    }
    html.dark .auth-title { color: #ffffff !important; }
    html.dark .auth-subtitle { color: #9ca3af !important; }
    html.dark .auth-label { color: #e5e7eb !important; }
    html.dark .auth-input {
        background-color: #152922 !important;
        border: 1.5px solid #204035 !important;
        color: #ffffff !important;
    }
    html.dark .auth-input::placeholder { color: #6b7280 !important; }
    html.dark .auth-input:focus {
        border-color: #00b692 !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(0, 182, 146, 0.25) !important;
    }
    html.dark .auth-text { color: #d1d5db !important; }

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
    .auth-submit-btn:active {
        transform: translateY(0) !important;
    }

    .eye-toggle-btn {
        background: transparent !important;
        border: none !important;
        cursor: pointer !important;
        padding: 0 14px !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        position: absolute !important;
        right: 0 !important;
        top: 0 !important;
    }
    html:not(.dark) .eye-toggle-btn { color: #6b7280 !important; }
    html:not(.dark) .eye-toggle-btn:hover { color: #111827 !important; }
    html.dark .eye-toggle-btn { color: #9ca3af !important; }
    html.dark .eye-toggle-btn:hover { color: #ffffff !important; }
    </style>

    <div class="auth-card-container">

        <!-- Title & Subtitle -->
        <div style="margin-bottom: 24px; text-align: left;">
            <h2 class="auth-title" style="font-size: 28px; font-weight: 800; letter-spacing: -0.5px; margin: 0 0 6px 0; line-height: 1.2;">
                Welcome back
            </h2>
            <p class="auth-subtitle" style="font-size: 14px; font-weight: 500; margin: 0;">
                Sign in to access your account.
            </p>
        </div>

        <x-validation-errors class="mb-4"/>

        @session('status')
        <div style="margin-bottom: 16px; font-size: 14px; font-weight: 500; color: #00b692; background: rgba(0,182,146,0.1); padding: 12px 16px; border-radius: 10px; border: 1px solid rgba(0,182,146,0.2);">
            {{ $value }}
        </div>
        @endsession

        <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf

            <!-- Email Field -->
            <div style="text-align: left;">
                <label for="email" class="auth-label" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">
                    Email
                </label>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       autocomplete="username" 
                       placeholder="admin@example.com"
                       class="auth-input"
                       style="width: 100%; padding: 12px 16px; border-radius: 12px; font-size: 14px; font-weight: 500; box-sizing: border-box; transition: all 0.2s;" />
            </div>

            <!-- Password Field -->
            <div style="text-align: left;">
                <label for="password" class="auth-label" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">
                    Password
                </label>
                <div style="position: relative; width: 100%;">
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password" 
                           placeholder="Enter your password"
                           class="auth-input password"
                           style="width: 100%; padding: 12px 44px 12px 16px; border-radius: 12px; font-size: 14px; font-weight: 500; box-sizing: border-box; transition: all 0.2s;" />
                    <button type="button" class="eye-toggle-btn toggle-password">
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-slash-icon hidden" style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.27-2.944-9.543-7a10.033 10.033 0 012.957-4.558m2.556-2.557A10.05 10.05 0 0112 5c4.478 0 8.27 2.944 9.543 7-.275.877-.681 1.693-1.2 2.422m-2.058 2.065A10.05 10.05 0 0112 19a10.05 10.05 0 01-6.473-2.464M3 3l18 18"/></svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 4px;">
                <label for="remember_me" style="display: inline-flex; align-items: center; cursor: pointer; user-select: none;">
                    <input id="remember_me" type="checkbox" name="remember" style="width: 16px; height: 16px; accent-color: #00b692; cursor: pointer; border-radius: 4px;" />
                    <span class="auth-text" style="margin-left: 8px; font-size: 14px; font-weight: 500;">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" style="font-size: 14px; font-weight: 600; color: #d97706; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                    Forgot your password?
                </a>
            </div>

            <!-- Submit Button -->
            <div style="margin-top: 8px;">
                <button type="submit" class="auth-submit-btn button">
                    <svg aria-hidden="true" class="hidden animate-spin" style="width: 20px; height: 20px; margin-right: 8px; color: #ffffff; fill: #ffffff;" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span>Log in</span>
                </button>
            </div>

            <!-- Footer Links -->
            <div style="text-align: center; margin-top: 12px; display: flex; flex-direction: column; gap: 10px;">
                @if(!module_enabled('Subdomain'))
                <div class="auth-subtitle" style="font-size: 14px; font-weight: 500;">
                    New to ShreeSwarupOS? 
                    <a href="{{ route('restaurant_signup') }}" style="color: #00b692; font-weight: 700; text-decoration: none; margin-left: 4px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                        Create an account
                    </a>
                </div>
                @endif

                @if(!module_enabled('Subdomain') && !global_setting()->disable_landing_site)
                <div>
                    <a href="{{ route('home') }}" class="auth-subtitle" style="font-size: 13px; font-weight: 500; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                        Go to home
                    </a>
                </div>
                @endif
            </div>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePasswordBtn = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');
            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const eyeIcon = togglePasswordBtn.querySelector('.eye-icon');
                    const eyeSlashIcon = togglePasswordBtn.querySelector('.eye-slash-icon');
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeIcon?.classList.add('hidden');
                        eyeSlashIcon?.classList.remove('hidden');
                    } else {
                        passwordInput.type = 'password';
                        eyeSlashIcon?.classList.add('hidden');
                        eyeIcon?.classList.remove('hidden');
                    }
                });
            }

            const form = document.querySelector('form');
            const button = document.querySelector('.button');
            if (form && button) {
                form.addEventListener('submit', function() {
                    button.classList.add('opacity-75', 'cursor-not-allowed');
                    const spinner = button.querySelector('svg');
                    if (spinner) spinner.classList.remove('hidden');
                });
            }
        });
    </script>
</x-auth-layout>

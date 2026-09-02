<x-auth-layout>
    <style>
    /* Custom Auth Card Container */
    .auth-card-container {
        width: 100% !important;
        max-width: 680px !important;
        margin: 0 auto !important;
        padding: 36px 32px !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease !important;
        box-sizing: border-box !important;
    }
    @media (max-width: 640px) {
        .auth-card-container {
            max-width: 100% !important;
            padding: 24px 20px !important;
            border-radius: 20px !important;
        }
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

    /* Form Labels Matching Login Page */
    .auth-card-container label,
    .auth-card-container .block.text-sm {
        display: block !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        margin-bottom: 6px !important;
    }
    html:not(.dark) .auth-card-container label,
    html:not(.dark) .auth-card-container .block.text-sm { color: #374151 !important; }
    html.dark .auth-card-container label,
    html.dark .auth-card-container .block.text-sm { color: #e5e7eb !important; }

    /* All Input Fields & Selects Matching Login Page */
    .auth-card-container input[type="text"],
    .auth-card-container input[type="email"],
    .auth-card-container input[type="tel"],
    .auth-card-container input[type="password"],
    .auth-card-container select,
    .auth-card-container textarea {
        width: 100% !important;
        padding: 12px 16px !important;
        border-radius: 12px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        box-sizing: border-box !important;
        transition: all 0.2s ease !important;
    }

    /* Light Mode Inputs */
    html:not(.dark) .auth-card-container input[type="text"],
    html:not(.dark) .auth-card-container input[type="email"],
    html:not(.dark) .auth-card-container input[type="tel"],
    html:not(.dark) .auth-card-container input[type="password"],
    html:not(.dark) .auth-card-container select,
    html:not(.dark) .auth-card-container textarea,
    html:not(.dark) .auth-card-container [x-data] > div:first-child {
        background-color: #f9fafb !important;
        border: 1.5px solid #d1d5db !important;
        color: #111827 !important;
    }
    html:not(.dark) .auth-card-container input::placeholder {
        color: #9ca3af !important;
    }

    /* Dark Mode Inputs (Reference Image #152922) */
    html.dark .auth-card-container input[type="text"],
    html.dark .auth-card-container input[type="email"],
    html.dark .auth-card-container input[type="tel"],
    html.dark .auth-card-container input[type="password"],
    html.dark .auth-card-container select,
    html.dark .auth-card-container textarea,
    html.dark .auth-card-container [x-data] > div:first-child {
        background-color: #152922 !important;
        border: 1.5px solid #204035 !important;
        color: #ffffff !important;
    }
    html.dark .auth-card-container input::placeholder {
        color: #6b7280 !important;
    }

    /* Focus States */
    .auth-card-container input:focus,
    .auth-card-container select:focus,
    .auth-card-container textarea:focus {
        border-color: #00b692 !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(0, 182, 146, 0.25) !important;
    }

    /* Primary Buttons */
    .auth-card-container button[type="submit"],
    .auth-card-container button.button {
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
        margin-top: 16px !important;
    }
    .auth-card-container button[type="submit"]:hover,
    .auth-card-container button.button:hover {
        background-color: #009c7d !important;
        box-shadow: 0 6px 20px rgba(0, 182, 146, 0.45) !important;
    }

    /* Checkboxes & Inline Text */
    .auth-card-container input[type="checkbox"] {
        width: 16px !important;
        height: 16px !important;
        accent-color: #00b692 !important;
        cursor: pointer !important;
        border-radius: 4px !important;
    }
    html:not(.dark) .auth-card-container span.text-sm { color: #4b5563 !important; }
    html.dark .auth-card-container span.text-sm { color: #d1d5db !important; }
    </style>

    <div class="auth-card-container">
        <!-- Header -->
        <div style="margin-bottom: 24px; text-align: left;">
            <h2 class="auth-title" style="font-size: 28px; font-weight: 800; letter-spacing: -0.5px; margin: 0 0 6px 0; line-height: 1.2;">
                Create an account
            </h2>
            <p class="auth-subtitle" style="font-size: 14px; font-weight: 500; margin: 0;">
                Get started with ShreeSwarupOS today.
            </p>
        </div>

        <x-validation-errors class="mb-4"/>

        @session('status')
        <div style="margin-bottom: 16px; font-size: 14px; font-weight: 500; color: #00b692; background: rgba(0,182,146,0.1); padding: 12px 16px; border-radius: 10px; border: 1px solid rgba(0,182,146,0.2);">
            {{ $value }}
        </div>
        @endsession

        @livewire('forms.restaurantSignup')

        <!-- Footer Link -->
        <div style="text-align: center; margin-top: 24px; display: flex; flex-direction: column; gap: 10px;">
            <div class="auth-subtitle" style="font-size: 14px; font-weight: 500;">
                Already have an account? 
                <a href="{{ route('login') }}" style="color: #00b692; font-weight: 700; text-decoration: none; margin-left: 4px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                    Log in
                </a>
            </div>
            <div>
                <a href="{{ route('home') }}" class="auth-subtitle" style="font-size: 13px; font-weight: 500; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                    Go to home
                </a>
            </div>
        </div>
    </div>
</x-auth-layout>

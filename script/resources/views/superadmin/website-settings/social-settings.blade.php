@extends('layouts.app')

@section('content')
<style>
    /* Card Container */
    .social-settings-card {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 28px !important;
        padding: 2.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }
    .dark .social-settings-card {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
    }

    /* Labels */
    .social-settings-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.625rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .dark .social-settings-label {
        color: #e2e8f0 !important;
    }

    /* Input Textfields */
    .social-settings-input {
        width: 100%;
        height: 3rem;
        padding-left: 1rem;
        padding-right: 1rem;
        border-radius: 0.875rem;
        border: 1px solid #cbd5e1;
        background-color: #ffffff !important;
        color: #0f172a !important;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
    }
    .social-settings-input::placeholder {
        color: #94a3b8;
    }
    .social-settings-input:focus {
        border-color: var(--color-base, #00b692) !important;
        box-shadow: 0 0 0 3px rgba(0, 182, 146, 0.15) !important;
    }

    /* Dark mode inputs */
    .dark .social-settings-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }
    .dark .social-settings-input::placeholder {
        color: #64748b !important;
    }
    .dark .social-settings-input:focus {
        border-color: var(--color-base, #00b692) !important;
        box-shadow: 0 0 0 3px rgba(0, 182, 146, 0.25) !important;
    }

    /* Grid & Center Gap */
    .social-settings-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        row-gap: 2rem;
        column-gap: 3.5rem;
    }
    @media (min-width: 768px) {
        .social-settings-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>

<div x-data="{
    loading: false,

    submitForm() {
        this.loading = true;
        const form = this.$refs.socialForm;
        const formData = new FormData(form);

        fetch('{{ route('superadmin.website-settings.social-settings.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            this.loading = false;
            if (data.success) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message || 'Social handles updated successfully.',
                        timer: 2500,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-3xl shadow-2xl'
                        }
                    });
                } else {
                    alert(data.message || 'Social handles updated successfully.');
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to update social settings.'
                    });
                } else {
                    alert(data.message || 'Failed to update social settings.');
                }
            }
        })
        .catch(err => {
            this.loading = false;
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update social settings.'
                });
            } else {
                alert('Failed to update social settings.');
            }
        });
    }
}" class="p-6 md:p-10 max-w-6xl mx-auto">

    <!-- Header Section -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
            Social Handles & Links
        </h2>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 font-medium">
            Configure company WhatsApp and social handles shown on headers and footers.
        </p>
    </div>

    <!-- Card Container -->
    <div class="social-settings-card">
        <form x-ref="socialForm" @submit.prevent="submitForm()">
            @csrf

            <div class="social-settings-grid">
                
                <!-- WhatsApp Number -->
                <div>
                    <label for="whatsapp_number" class="social-settings-label">
                        WhatsApp Number (Format: 919876543210)
                    </label>
                    <input type="text"
                           name="whatsapp_number"
                           id="whatsapp_number"
                           value="{{ old('whatsapp_number', $settings->whatsapp_number ?? '') }}"
                           placeholder="919257915113"
                           class="social-settings-input">
                </div>

                <!-- Instagram Handle URL -->
                <div>
                    <label for="instagram_link" class="social-settings-label">
                        Instagram Handle URL
                    </label>
                    <input type="text"
                           name="instagram_link"
                           id="instagram_link"
                           value="{{ old('instagram_link', $settings->instagram_link ?? '') }}"
                           placeholder="https://instagram.com/your_handle"
                           class="social-settings-input">
                </div>

                <!-- Facebook Handle URL -->
                <div>
                    <label for="facebook_link" class="social-settings-label">
                        Facebook Handle URL
                    </label>
                    <input type="text"
                           name="facebook_link"
                           id="facebook_link"
                           value="{{ old('facebook_link', $settings->facebook_link ?? '') }}"
                           placeholder="https://facebook.com/your_page"
                           class="social-settings-input">
                </div>

                <!-- LinkedIn Handle URL -->
                <div>
                    <label for="linkedin_link" class="social-settings-label">
                        LinkedIn Handle URL
                    </label>
                    <input type="text"
                           name="linkedin_link"
                           id="linkedin_link"
                           value="{{ old('linkedin_link', $settings->linkedin_link ?? '') }}"
                           placeholder="https://linkedin.com/company/your_company"
                           class="social-settings-input">
                </div>

                <!-- GitHub Handle URL -->
                <div>
                    <label for="github_link" class="social-settings-label">
                        GitHub Handle URL
                    </label>
                    <input type="text"
                           name="github_link"
                           id="github_link"
                           value="{{ old('github_link', $settings->github_link ?? '') }}"
                           placeholder="https://github.com/your_profile"
                           class="social-settings-input">
                </div>

                <!-- Twitter / X URL -->
                <div>
                    <label for="twitter_link" class="social-settings-label">
                        Twitter / X URL
                    </label>
                    <input type="text"
                           name="twitter_link"
                           id="twitter_link"
                           value="{{ old('twitter_link', $settings->twitter_link ?? '') }}"
                           placeholder="https://x.com/your_handle"
                           class="social-settings-input">
                </div>

                <!-- Phone Number 1 -->
                <div>
                    <label for="phone_number_1" class="social-settings-label">
                        <svg class="w-5 h-3.5 rounded-[2px] shadow-xs shrink-0 inline-block overflow-hidden" viewBox="0 0 640 480">
                            <path fill="#f93" d="M0 0h640v160H0z"/>
                            <path fill="#fff" d="M0 160h640v160H0z"/>
                            <path fill="#128807" d="M0 320h640v160H0z"/>
                            <circle cx="320" cy="240" r="60" fill="none" stroke="#000080" stroke-width="12"/>
                        </svg>
                        <span>Phone Number 1</span>
                    </label>
                    <input type="text"
                           name="phone_number_1"
                           id="phone_number_1"
                           value="{{ old('phone_number_1', $settings->phone_number_1 ?? '') }}"
                           placeholder="+91-98765-43210"
                           class="social-settings-input">
                </div>

                <!-- Phone Number 2 -->
                <div>
                    <label for="phone_number_2" class="social-settings-label">
                        <svg class="w-5 h-3.5 rounded-[2px] shadow-xs shrink-0 inline-block overflow-hidden" viewBox="0 0 640 480">
                            <path fill="#f93" d="M0 0h640v160H0z"/>
                            <path fill="#fff" d="M0 160h640v160H0z"/>
                            <path fill="#128807" d="M0 320h640v160H0z"/>
                            <circle cx="320" cy="240" r="60" fill="none" stroke="#000080" stroke-width="12"/>
                        </svg>
                        <span>Phone Number 2</span>
                    </label>
                    <input type="text"
                           name="phone_number_2"
                           id="phone_number_2"
                           value="{{ old('phone_number_2', $settings->phone_number_2 ?? '') }}"
                           placeholder="+91-98765-43211"
                           class="social-settings-input">
                </div>

                <!-- Primary Email Address -->
                <div>
                    <label for="primary_email" class="social-settings-label">
                        Primary Email Address
                    </label>
                    <input type="email"
                           name="primary_email"
                           id="primary_email"
                           value="{{ old('primary_email', $settings->primary_email ?? '') }}"
                           placeholder="info@yourdomain.com"
                           class="social-settings-input">
                </div>

                <!-- Secondary Email Address -->
                <div>
                    <label for="secondary_email" class="social-settings-label">
                        Secondary Email Address
                    </label>
                    <input type="email"
                           name="secondary_email"
                           id="secondary_email"
                           value="{{ old('secondary_email', $settings->secondary_email ?? '') }}"
                           placeholder="support@yourdomain.com"
                           class="social-settings-input">
                </div>

            </div>

            <!-- Save Button -->
            <div class="mt-10 flex justify-center">
                <button type="submit"
                        :disabled="loading"
                        class="w-full h-12 bg-skin-base hover:opacity-90 active:scale-[0.99] text-white font-bold text-sm rounded-full shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2.5 cursor-pointer disabled:opacity-50">
                    <svg x-show="!loading" class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    <svg x-show="loading" class="animate-spin w-5 h-5 text-white shrink-0" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="loading ? 'Saving Changes...' : 'Save Social Handles'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

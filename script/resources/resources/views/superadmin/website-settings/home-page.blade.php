@extends('layouts.app')

@section('content')
<style>
    /* Top Navigation Tab Container */
    .hp-tab-container {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem;
        background-color: #e2e8f0;
        border: 1px solid #cbd5e1;
        border-radius: 9999px;
        overflow-x: auto;
    }
    .dark .hp-tab-container {
        background-color: #0b0f19 !important;
        border-color: #1e293b !important;
    }

    .hp-tab-btn {
        padding: 0.65rem 1.35rem;
        font-size: 0.875rem;
        border-radius: 9999px;
        transition: all 0.2s ease;
        cursor: pointer;
        white-space: nowrap;
        user-select: none;
        outline: none;
    }

    /* Active Tab */
    .hp-tab-active {
        background-color: #ffffff !important;
        color: #00b591 !important;
        font-weight: 800 !important;
        box-shadow: 0 2px 8px rgba(0, 181, 145, 0.15) !important;
        border: 1.5px solid #00b591 !important;
    }
    .dark .hp-tab-active {
        background-color: #0d1424 !important;
        color: #00b591 !important;
        border: 1.5px solid #00b591 !important;
        box-shadow: 0 2px 10px rgba(0, 181, 145, 0.25) !important;
    }

    /* Inactive Tab */
    .hp-tab-inactive {
        background-color: transparent !important;
        color: #475569 !important;
        font-weight: 600 !important;
        border: 1.5px solid transparent !important;
    }
    .hp-tab-inactive:hover {
        background-color: #cbd5e1 !important;
        color: #0f172a !important;
    }
    .dark .hp-tab-inactive {
        color: #94a3b8 !important;
    }
    .dark .hp-tab-inactive:hover {
        background-color: #1e293b !important;
        color: #f8fafc !important;
    }

    /* Card Container */
    .hp-card {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 28px !important;
        padding: 2rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03);
        overflow: hidden;
        margin-top: 1.5rem;
    }
    .dark .hp-card {
        background-color: #060a14 !important;
        border-color: #161f33 !important;
    }

    /* Sub-section Headings (High Contrast in Light & Dark Mode) */
    .hp-subheading {
        font-size: 0.75rem !important;
        font-weight: 800 !important;
        color: #00b591 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.06em !important;
        margin-bottom: 1rem !important;
        display: block !important;
    }
    .dark .hp-subheading {
        color: #34d399 !important; /* Bright high-contrast emerald green for Dark Mode */
    }

    /* Form Input & Textarea */
    .hp-input, .hp-textarea, .hp-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        border: 1px solid #cbd5e1;
        background-color: #ffffff !important;
        color: #0f172a !important;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s ease;
    }
    .dark .hp-input, .dark .hp-textarea, .dark .hp-select {
        background-color: #111827 !important;
        border-color: #1f2937 !important;
        color: #f8fafc !important;
    }
    .hp-input:focus, .hp-textarea:focus, .hp-select:focus {
        border-color: #00b591 !important;
        box-shadow: 0 0 0 3px rgba(0, 181, 145, 0.15) !important;
    }
    .dark .hp-select option {
        background-color: #111827 !important;
        color: #f8fafc !important;
    }

    /* Table Styling */
    .hp-table-head {
        background-color: #edf2f7;
        border-radius: 12px;
    }
    .dark .hp-table-head {
        background-color: #0d1424 !important;
    }
    .hp-th {
        padding: 1.125rem 1.25rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #334155;
    }
    .dark .hp-th {
        color: #94a3b8 !important;
    }

    .hp-row {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .dark .hp-row {
        border-bottom-color: #11192e !important;
    }
    .hp-row:last-child {
        border-bottom: none;
    }

    .hp-img-thumb {
        width: 3.5rem;
        height: 3.5rem;
        object-fit: cover;
        border-radius: 0.75rem;
        padding: 0.25rem;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
    }
    .dark .hp-img-thumb {
        background-color: #111827;
        border-color: #334155;
    }

    /* Action Buttons */
    .hp-action-btn-edit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.5rem;
        background-color: #e0f2fe;
        color: #0284c7;
        transition: all 0.15s ease;
        border: none;
        cursor: pointer;
    }
    .hp-action-btn-edit:hover {
        background-color: #bae6fd;
        color: #0369a1;
    }
    .dark .hp-action-btn-edit {
        background-color: rgba(12, 74, 110, 0.4) !important;
        color: #38bdf8 !important;
    }

    .hp-action-btn-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.5rem;
        background-color: #fee2e2;
        color: #ef4444;
        transition: all 0.15s ease;
        border: none;
        cursor: pointer;
    }
    .hp-action-btn-delete:hover {
        background-color: #fca5a5;
        color: #dc2626;
    }
    .dark .hp-action-btn-delete {
        background-color: rgba(153, 27, 27, 0.35) !important;
        color: #f87171 !important;
    }

    /* Sequence Control Buttons (Up / Down) */
    .hp-seq-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 0.375rem;
        background-color: #e2e8f0;
        color: #475569;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .hp-seq-btn:hover:not(:disabled) {
        background-color: #cbd5e1;
        color: #0f172a;
    }
    .hp-seq-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    .dark .hp-seq-btn {
        background-color: #1e293b;
        color: #94a3b8;
    }
    .dark .hp-seq-btn:hover:not(:disabled) {
        background-color: #334155;
        color: #f8fafc;
    }

    /* Drag Handle */
    .hp-drag-handle {
        cursor: grab;
        color: #94a3b8;
        padding: 0.35rem;
        display: inline-flex;
        align-items: center;
    }
    .dark .hp-drag-handle {
        color: #475569;
    }
    .hp-drag-handle:hover {
        color: #334155;
    }
    .dark .hp-drag-handle:hover {
        color: #94a3b8;
    }
</style>

<div x-data="homePageComponent()" x-init="initSortables()" class="p-6 md:p-10 max-w-6xl mx-auto">

    <!-- Top Header -->
    <div class="mb-8">
        <div class="mb-6">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                Home Page Settings
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 font-medium">
                Manage Hero Section, Video Section, Why Choose Us, and Landing Templates.
            </p>
        </div>

        <!-- 4 Home Page Navigation Tabs -->
        <div class="hp-tab-container">
            <button @click="switchTab('hero')"
                    type="button"
                    :class="activeTab === 'hero' ? 'hp-tab-active' : 'hp-tab-inactive'"
                    class="hp-tab-btn">
                Hero Section
            </button>

            <button @click="switchTab('video')"
                    type="button"
                    :class="activeTab === 'video' ? 'hp-tab-active' : 'hp-tab-inactive'"
                    class="hp-tab-btn">
                Video Section
            </button>

            <button @click="switchTab('why-choose-us')"
                    type="button"
                    :class="activeTab === 'why-choose-us' ? 'hp-tab-active' : 'hp-tab-inactive'"
                    class="hp-tab-btn">
                Why Choose Us (<span x-text="whyChooseUs.length"></span>)
            </button>

            <button @click="switchTab('templates')"
                    type="button"
                    :class="activeTab === 'templates' ? 'hp-tab-active' : 'hp-tab-inactive'"
                    class="hp-tab-btn">
                Templates (<span x-text="templates.length"></span>)
            </button>
        </div>
    </div>

    <!-- TAB 1: HERO SECTION -->
    <div x-show="activeTab === 'hero'">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                Hero Section Settings
            </h3>
            <button @click="saveHeroSettings()" type="button" class="px-6 py-2.5 bg-skin-base text-white font-bold text-xs rounded-full shadow-md hover:opacity-90 transition cursor-pointer">
                Save Hero Settings
            </button>
        </div>

        <div class="hp-card space-y-8">
            <!-- 1. Header & Badge -->
            <div class="border-b border-gray-200 dark:border-gray-800/80 pb-6">
                <h4 class="hp-subheading">1. Header & Badge Settings</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Top Pill Badge Text</label>
                        <input type="text" x-model="hero.top_pill_badge" placeholder="e.g. • Trusted by 7,000+ Restaurants Worldwide" class="hp-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Main Headline (H1)</label>
                        <input type="text" x-model="hero.main_headline" placeholder="e.g. Restaurant POS software made simple!" class="hp-input font-bold">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Sub-headline / Description</label>
                    <textarea x-model="hero.sub_headline" rows="3" placeholder="Enter sub-headline description..." class="hp-textarea"></textarea>
                </div>
            </div>

            <!-- 2. CTA Action Buttons -->
            <div class="border-b border-gray-200 dark:border-gray-800/80 pb-6">
                <h4 class="hp-subheading">2. Action Buttons (CTAs)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Primary Button Text</label>
                        <input type="text" x-model="hero.primary_btn_text" placeholder="e.g. Get Started for FREE ->" class="hp-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Primary Button Link</label>
                        <input type="text" x-model="hero.primary_btn_link" placeholder="e.g. /restaurant-signup" class="hp-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Secondary Button Text</label>
                        <input type="text" x-model="hero.secondary_btn_text" placeholder="e.g. See Reviews" class="hp-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Secondary Button Link</label>
                        <input type="text" x-model="hero.secondary_btn_link" placeholder="e.g. #reviews" class="hp-input">
                    </div>
                </div>
            </div>

            <!-- 3. Key Statistics Grid -->
            <div class="border-b border-gray-200 dark:border-gray-800/80 pb-6">
                <h4 class="hp-subheading">3. Counter Statistics (4 Points)</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-3.5 bg-white dark:bg-[#111827] rounded-xl border border-gray-200 dark:border-gray-800 space-y-2">
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Stat 1 Value</label>
                        <input type="text" x-model="hero.stat_1_val" placeholder="20M+" class="hp-input text-sm font-bold">
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Stat 1 Label</label>
                        <input type="text" x-model="hero.stat_1_lbl" placeholder="Active Users" class="hp-input text-xs">
                    </div>
                    <div class="p-3.5 bg-white dark:bg-[#111827] rounded-xl border border-gray-200 dark:border-gray-800 space-y-2">
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Stat 2 Value</label>
                        <input type="text" x-model="hero.stat_2_val" placeholder="7K+" class="hp-input text-sm font-bold">
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Stat 2 Label</label>
                        <input type="text" x-model="hero.stat_2_lbl" placeholder="Restaurants" class="hp-input text-xs">
                    </div>
                    <div class="p-3.5 bg-white dark:bg-[#111827] rounded-xl border border-gray-200 dark:border-gray-800 space-y-2">
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Stat 3 Value</label>
                        <input type="text" x-model="hero.stat_3_val" placeholder="100M+" class="hp-input text-sm font-bold">
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Stat 3 Label</label>
                        <input type="text" x-model="hero.stat_3_lbl" placeholder="Orders Processed" class="hp-input text-xs">
                    </div>
                    <div class="p-3.5 bg-white dark:bg-[#111827] rounded-xl border border-gray-200 dark:border-gray-800 space-y-2">
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Stat 4 Value</label>
                        <input type="text" x-model="hero.stat_4_val" placeholder="4.9★" class="hp-input text-sm font-bold">
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Stat 4 Label</label>
                        <input type="text" x-model="hero.stat_4_lbl" placeholder="Average Rating" class="hp-input text-xs">
                    </div>
                </div>
            </div>

            <!-- 4. Hero Dashboard Image & Floating Cards -->
            <div class="border-b border-gray-200 dark:border-gray-800/80 pb-6">
                <h4 class="hp-subheading">4. Hero Dashboard Image & Floating Cards</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Main Dashboard Image</label>
                        <input type="file" accept="image/*" @change="handleHeroDashboardUpload($event)" class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-skin-base/15 file:text-skin-base cursor-pointer">
                        <template x-if="hero.dashboard_image">
                            <img :src="hero.dashboard_image" class="mt-3 h-28 w-full object-cover rounded-xl border border-gray-300 dark:border-gray-700 shadow-sm">
                        </template>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Floating Card 1 (Top Right Badge)</label>
                        <input type="text" x-model="hero.floating_card_1" placeholder="✔ Revenue +257%" class="hp-input mb-3">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Floating badge shown over top right of dashboard image.</span>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Floating Card 2 (Bottom Left Badge)</label>
                        <input type="text" x-model="hero.floating_card_2_title" placeholder="Order #2,048" class="hp-input mb-2">
                        <input type="text" x-model="hero.floating_card_2_subtitle" placeholder="✔ Delivered successfully" class="hp-input">
                    </div>
                </div>
            </div>

            <!-- 5. Trusted By Brand Logos Bar -->
            <div>
                <h4 class="hp-subheading">5. Trusted By Brand Logos Section</h4>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Trusted By Title Text</label>
                        <input type="text" x-model="hero.trusted_by_title" placeholder="e.g. TRUSTED BY LEADING HOTELS AND RESTAURANT CHAINS WORLDWIDE" class="hp-input">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Add Brand Logo File</label>
                        <div class="flex items-center gap-3">
                            <input type="file" accept="image/*" @change="handleBrandLogoUpload($event)" class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-skin-base/15 file:text-skin-base cursor-pointer">
                        </div>
                    </div>
                    <!-- Brand Logos Grid Preview -->
                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 pt-2">
                        <template x-for="(logo, lIdx) in hero.trusted_by_logos" :key="lIdx">
                            <div class="relative group p-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center justify-center h-16">
                                <img :src="logo" class="max-h-12 max-w-full object-contain">
                                <button @click="removeBrandLogo(lIdx)" type="button" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition shadow-md">✕</button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: VIDEO SECTION -->
    <div x-show="activeTab === 'video'">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                Video Section Settings
            </h3>
            <button @click="saveVideoSettings()" type="button" class="px-6 py-2.5 bg-skin-base text-white font-bold text-xs rounded-full shadow-md hover:opacity-90 transition cursor-pointer">
                Save Video Settings
            </button>
        </div>

        <div class="hp-card space-y-8">
            <!-- 1. Walkthrough Video -->
            <div class="border-b border-gray-200 dark:border-gray-800/80 pb-6">
                <h4 class="hp-subheading">1. Walkthrough Video Settings</h4>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Walkthrough Video Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" x-model="video.walkthrough_title" placeholder="e.g. TableTrack Complete Platform Walkthrough & Feature Demo" class="hp-input font-bold">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Walkthrough Video Short Description
                        </label>
                        <textarea x-model="video.walkthrough_desc" rows="3" placeholder="Enter brief walkthrough description..." class="hp-textarea"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Walkthrough Video Link (YouTube / Vimeo / MP4) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" x-model="video.walkthrough_link" placeholder="e.g. https://www.youtube.com/embed/dQw4w9WgXcQ" class="hp-input">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Walkthrough Video Thumbnail Image
                            </label>
                            <input type="file" accept="image/*" @change="handleVideoThumbUpload($event)" class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-skin-base/15 file:text-skin-base cursor-pointer">
                            <template x-if="video.walkthrough_thumb">
                                <img :src="video.walkthrough_thumb" class="mt-2 h-20 w-36 object-cover rounded-lg border border-gray-300 dark:border-gray-700">
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Simplified Video -->
            <div>
                <h4 class="hp-subheading">2. Simplified Video Settings (Link Only)</h4>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Simplified Video Link <span class="text-red-500">*</span>
                    </label>
                    <input type="text" x-model="video.simplified_link" placeholder="e.g. https://www.youtube.com/embed/3JZ_D3ELwOQ" class="hp-input">
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: WHY CHOOSE US -->
    <div x-show="activeTab === 'why-choose-us'">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                Why Choose Us Features List
            </h3>
            <button @click="openAdd('why_choose_us')" type="button" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-skin-base hover:opacity-90 text-white font-bold text-sm rounded-full shadow-md transition cursor-pointer">
                <span>+ Add Feature</span>
            </button>
        </div>

        <div class="hp-card">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="hp-table-head">
                            <th class="hp-th w-32 text-center rounded-l-xl">SEQUENCE</th>
                            <th class="hp-th">IMAGE</th>
                            <th class="hp-th">CATEGORY BADGE</th>
                            <th class="hp-th">FEATURE TITLE</th>
                            <th class="hp-th">DESCRIPTION</th>
                            <th class="hp-th text-right rounded-r-xl">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="why-choose-us-table-body">
                        <template x-for="(item, idx) in whyChooseUs" :key="item.id">
                            <tr class="hp-row" :data-id="idx">
                                <td class="py-4 px-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="hp-drag-handle" title="Drag to reorder sequence">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M7 2a2 2 0 10.001 4.001A2 2 0 007 2zm0 6a2 2 0 10.001 4.001A2 2 0 007 8zm0 6a2 2 0 10.001 4.001A2 2 0 007 14zm6-12a2 2 0 10.001 4.001A2 2 0 0013 2zm0 6a2 2 0 10.001 4.001A2 2 0 0013 8zm0 6a2 2 0 10.001 4.001A2 2 0 0013 14z"/>
                                            </svg>
                                        </span>
                                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-800 px-2.5 py-1 rounded-md" x-text="idx + 1"></span>

                                        <div class="flex flex-col gap-0.5">
                                            <button @click="moveUpWhy(idx)" :disabled="idx === 0" type="button" class="hp-seq-btn" title="Move Up">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>
                                            </button>
                                            <button @click="moveDownWhy(idx)" :disabled="idx === whyChooseUs.length - 1" type="button" class="hp-seq-btn" title="Move Down">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <template x-if="item.image">
                                        <img :src="item.image" class="hp-img-thumb">
                                    </template>
                                    <template x-if="!item.image">
                                        <span class="text-xs text-gray-400 font-semibold">— No Image —</span>
                                    </template>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 text-xs font-extrabold uppercase rounded-full" x-text="item.badge || 'FEATURE'"></span>
                                </td>
                                <td class="py-4 px-4 font-bold text-gray-900 dark:text-gray-100" x-text="item.title"></td>
                                <td class="py-4 px-4 text-xs text-gray-600 dark:text-gray-400 max-w-xs" x-text="item.description"></td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="openEdit('why_choose_us', idx)" type="button" class="hp-action-btn-edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <button @click="deleteWhy(idx)" type="button" class="hp-action-btn-delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-if="whyChooseUs.length === 0">
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-500 dark:text-gray-400 font-medium">
                                    No features found. Click "+ Add Feature" to create one.
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB 4: TEMPLATES -->
    <div x-show="activeTab === 'templates'">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                Templates Listing & Settings
            </h3>
            <button @click="openAdd('templates')" type="button" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-skin-base hover:opacity-90 text-white font-bold text-sm rounded-full shadow-md transition cursor-pointer">
                <span>+ Add Template</span>
            </button>
        </div>

        <div class="hp-card">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="hp-table-head">
                            <th class="hp-th w-32 text-center rounded-l-xl">SEQUENCE</th>
                            <th class="hp-th">ICON / PREVIEW</th>
                            <th class="hp-th">BADGE TAG</th>
                            <th class="hp-th">TEMPLATE TITLE</th>
                            <th class="hp-th">SUBTITLE / DETAILS</th>
                            <th class="hp-th text-right rounded-r-xl">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="templates-table-body">
                        <template x-for="(item, idx) in templates" :key="item.id">
                            <tr class="hp-row" :data-id="idx">
                                <td class="py-4 px-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="hp-drag-handle" title="Drag to reorder sequence">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M7 2a2 2 0 10.001 4.001A2 2 0 007 2zm0 6a2 2 0 10.001 4.001A2 2 0 007 8zm0 6a2 2 0 10.001 4.001A2 2 0 007 14zm6-12a2 2 0 10.001 4.001A2 2 0 0013 2zm0 6a2 2 0 10.001 4.001A2 2 0 0013 8zm0 6a2 2 0 10.001 4.001A2 2 0 0013 14z"/>
                                            </svg>
                                        </span>
                                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-800 px-2.5 py-1 rounded-md" x-text="idx + 1"></span>

                                        <div class="flex flex-col gap-0.5">
                                            <button @click="moveUpTemplate(idx)" :disabled="idx === 0" type="button" class="hp-seq-btn" title="Move Up">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>
                                            </button>
                                            <button @click="moveDownTemplate(idx)" :disabled="idx === templates.length - 1" type="button" class="hp-seq-btn" title="Move Down">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <template x-if="item.icon">
                                        <img :src="item.icon" class="w-10 h-10 object-cover rounded-lg border border-gray-300 dark:border-gray-700">
                                    </template>
                                    <template x-if="!item.icon">
                                        <span class="text-2xl">📋</span>
                                    </template>
                                </td>
                                <td class="py-4 px-4">
                                    <span :class="item.badge === 'PRO' ? 'bg-cyan-100 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 border-cyan-300 dark:border-cyan-800' : 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border-emerald-300 dark:border-emerald-800'" class="px-3 py-1 text-xs font-extrabold uppercase rounded-md border" x-text="item.badge || 'FREE'"></span>
                                </td>
                                <td class="py-4 px-4 font-bold text-gray-900 dark:text-gray-100" x-text="item.title"></td>
                                <td class="py-4 px-4 text-xs text-gray-600 dark:text-gray-400" x-text="item.subtitle"></td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="openEdit('templates', idx)" type="button" class="hp-action-btn-edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <button @click="deleteTemplate(idx)" type="button" class="hp-action-btn-delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-if="templates.length === 0">
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-500 dark:text-gray-400 font-medium">
                                    No templates found. Click "+ Add Template" to create one.
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Side Modal Drawer (FOR WHY CHOOSE US & TEMPLATES) -->
    <div x-show="openDrawer" x-cloak class="fixed inset-0 z-50 overflow-hidden" role="dialog" aria-modal="true">
        <div x-show="openDrawer" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="openDrawer = false" class="fixed inset-0 bg-gray-900/60 dark:bg-black/80 backdrop-blur-xs transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <div x-show="openDrawer" x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-md bg-white dark:bg-[#0B0F19] text-gray-900 dark:text-gray-100 shadow-2xl border-l border-gray-200 dark:border-gray-800 flex flex-col justify-between">
                
                <!-- Drawer Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                        <span x-text="isEdit ? 'Update Item' : 'Add New Item'"></span>
                    </h3>
                    <button @click="openDrawer = false" type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Drawer Body Form Fields -->
                <div class="p-6 space-y-5 flex-1 overflow-y-auto">
                    <!-- Badge Tag Selection (for Templates / Features) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Badge Tag (e.g. FREE, PRO, CONTACTLESS)</label>
                        <input type="text" x-model="formBadge" placeholder="e.g. PRO" class="hp-input font-bold uppercase">
                    </div>

                    <!-- Title / Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Title / Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" x-model="formTitle" placeholder="Enter title or name..." class="hp-input font-bold">
                    </div>

                    <!-- Subtitle / Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Subtitle / Description <span class="text-red-500">*</span>
                        </label>
                        <textarea x-model="formDesc" rows="3" placeholder="Enter description details..." class="hp-textarea"></textarea>
                    </div>

                    <!-- Icon / Image Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Image / Logo File
                        </label>
                        <div class="flex items-center gap-4">
                            <template x-if="formImageData">
                                <img :src="formImageData" class="w-14 h-14 rounded-xl object-contain border-2 border-skin-base shadow-sm shrink-0">
                            </template>
                            <template x-if="!formImageData">
                                <div class="w-14 h-14 rounded-xl bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </template>

                            <input type="file" accept="image/*" @change="handleFormImageUpload($event)" class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-skin-base/15 file:text-skin-base cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer Action Buttons -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-[#070A14] flex items-center justify-end gap-3">
                    <button @click="openDrawer = false" type="button" class="px-5 py-2.5 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold text-xs rounded-xl transition cursor-pointer">
                        Cancel
                    </button>
                    <button @click="saveDrawerItem()" type="button" class="px-5 py-2.5 bg-skin-base text-white font-bold text-xs rounded-xl shadow-md hover:opacity-90 transition cursor-pointer">
                        <span x-text="isEdit ? 'Update Item' : 'Save Item'"></span>
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- SortableJS library for smooth drag-and-drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    function homePageComponent() {
        return {
            activeTab: 'hero',
            openDrawer: false,
            drawerType: '', // 'why_choose_us' | 'templates'
            isEdit: false,
            editIndex: null,

            // Drawer Form State
            formBadge: '',
            formTitle: '',
            formDesc: '',
            formImageData: '',

            // Hero Section State
            hero: Object.assign({
                top_pill_badge: '',
                main_headline: '',
                sub_headline: '',
                primary_btn_text: '',
                primary_btn_link: '',
                secondary_btn_text: '',
                secondary_btn_link: '',
                stat_1_val: '',
                stat_1_lbl: '',
                stat_2_val: '',
                stat_2_lbl: '',
                stat_3_val: '',
                stat_3_lbl: '',
                stat_4_val: '',
                stat_4_lbl: '',
                dashboard_image: '',
                floating_card_1: '',
                floating_card_2_title: '',
                floating_card_2_subtitle: '',
                trusted_by_title: '',
                trusted_by_logos: []
            }, @json($heroSettings)),

            // Video Section State
            video: Object.assign({
                walkthrough_title: '',
                walkthrough_desc: '',
                walkthrough_link: '',
                walkthrough_thumb: '',
                simplified_link: ''
            }, @json($videoSettings)),

            // List Tables Data
            whyChooseUs: @json($whyChooseUs),
            templates: @json($templates),

            switchTab(tab) {
                this.activeTab = tab;
                this.initSortables();
            },

            initSortables() {
                this.$nextTick(() => {
                    const tbodyWhy = document.getElementById('why-choose-us-table-body');
                    if (tbodyWhy && typeof Sortable !== 'undefined') {
                        const self = this;
                        if (self.sortableWhyInstance) self.sortableWhyInstance.destroy();
                        self.sortableWhyInstance = new Sortable(tbodyWhy, {
                            handle: '.hp-drag-handle',
                            animation: 150,
                            onEnd(evt) {
                                if (evt.oldIndex !== undefined && evt.newIndex !== undefined && evt.oldIndex !== evt.newIndex) {
                                    const moved = self.whyChooseUs.splice(evt.oldIndex, 1)[0];
                                    self.whyChooseUs.splice(evt.newIndex, 0, moved);
                                    self.syncDb('why_choose_us', 'reordered');
                                }
                            }
                        });
                    }

                    const tbodyTemplates = document.getElementById('templates-table-body');
                    if (tbodyTemplates && typeof Sortable !== 'undefined') {
                        const self = this;
                        if (self.sortableTemplatesInstance) self.sortableTemplatesInstance.destroy();
                        self.sortableTemplatesInstance = new Sortable(tbodyTemplates, {
                            handle: '.hp-drag-handle',
                            animation: 150,
                            onEnd(evt) {
                                if (evt.oldIndex !== undefined && evt.newIndex !== undefined && evt.oldIndex !== evt.newIndex) {
                                    const moved = self.templates.splice(evt.oldIndex, 1)[0];
                                    self.templates.splice(evt.newIndex, 0, moved);
                                    self.syncDb('templates', 'reordered');
                                }
                            }
                        });
                    }
                });
            },

            /* HERO FILE UPLOADS */
            handleHeroDashboardUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => { this.hero.dashboard_image = e.target.result; };
                    reader.readAsDataURL(file);
                }
            },
            handleBrandLogoUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        if (!Array.isArray(this.hero.trusted_by_logos)) this.hero.trusted_by_logos = [];
                        this.hero.trusted_by_logos.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            },
            removeBrandLogo(idx) {
                this.hero.trusted_by_logos.splice(idx, 1);
            },
            saveHeroSettings() {
                this.syncDb('hero_settings', 'saved');
            },

            /* VIDEO FILE UPLOADS */
            handleVideoThumbUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => { this.video.walkthrough_thumb = e.target.result; };
                    reader.readAsDataURL(file);
                }
            },
            saveVideoSettings() {
                this.syncDb('video_settings', 'saved');
            },

            /* DRAWER CRUD LOGIC FOR LISTS */
            handleFormImageUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => { this.formImageData = e.target.result; };
                    reader.readAsDataURL(file);
                }
            },

            openAdd(type) {
                this.drawerType = type;
                this.isEdit = false;
                this.editIndex = null;
                this.formBadge = (type === 'templates') ? 'FREE' : 'CONTACTLESS';
                this.formTitle = '';
                this.formDesc = '';
                this.formImageData = '';
                this.openDrawer = true;
            },

            openEdit(type, idx) {
                this.drawerType = type;
                this.isEdit = true;
                this.editIndex = idx;
                let item = null;
                if (type === 'why_choose_us') item = this.whyChooseUs[idx];
                if (type === 'templates') item = this.templates[idx];

                if (item) {
                    this.formBadge = item.badge || '';
                    this.formTitle = item.title || '';
                    this.formDesc = item.description || item.subtitle || '';
                    this.formImageData = item.image || item.icon || '';
                    this.openDrawer = true;
                }
            },

            saveDrawerItem() {
                if (!this.formTitle.trim()) {
                    if (typeof Swal !== 'undefined') Swal.fire('Validation Error', 'Title / Name is required.', 'warning');
                    return;
                }

                const now = new Date().toLocaleString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });

                if (this.drawerType === 'why_choose_us') {
                    const itemObj = {
                        id: (this.isEdit && this.editIndex !== null && this.whyChooseUs[this.editIndex]) ? this.whyChooseUs[this.editIndex].id : Date.now(),
                        badge: this.formBadge,
                        title: this.formTitle,
                        description: this.formDesc,
                        image: this.formImageData,
                        updated_at: now
                    };
                    if (this.isEdit && this.editIndex !== null) this.whyChooseUs[this.editIndex] = itemObj;
                    else this.whyChooseUs.push(itemObj);
                    this.syncDb('why_choose_us', 'saved');
                }
                else if (this.drawerType === 'templates') {
                    const itemObj = {
                        id: (this.isEdit && this.editIndex !== null && this.templates[this.editIndex]) ? this.templates[this.editIndex].id : Date.now(),
                        badge: this.formBadge,
                        title: this.formTitle,
                        subtitle: this.formDesc,
                        icon: this.formImageData,
                        updated_at: now
                    };
                    if (this.isEdit && this.editIndex !== null) this.templates[this.editIndex] = itemObj;
                    else this.templates.push(itemObj);
                    this.syncDb('templates', 'saved');
                }

                this.openDrawer = false;
            },

            /* DELETE LOGIC */
            deleteWhy(idx) {
                this.confirmDelete('Why Choose Us feature', () => {
                    this.whyChooseUs.splice(idx, 1);
                    this.syncDb('why_choose_us', 'deleted');
                });
            },
            deleteTemplate(idx) {
                this.confirmDelete('Template', () => {
                    this.templates.splice(idx, 1);
                    this.syncDb('templates', 'deleted');
                });
            },
            confirmDelete(label, callback) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: `Delete ${label}?`,
                        text: `Are you sure you want to delete this item?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel',
                        customClass: { popup: 'rounded-3xl shadow-2xl' }
                    }).then((result) => {
                        if (result.isConfirmed) callback();
                    });
                } else {
                    if (confirm(`Are you sure you want to delete this ${label}?`)) callback();
                }
            },

            /* MOVE SEQUENCER UP/DOWN */
            moveUpWhy(idx) {
                if (idx > 0) {
                    const temp = this.whyChooseUs[idx];
                    this.whyChooseUs[idx] = this.whyChooseUs[idx - 1];
                    this.whyChooseUs[idx - 1] = temp;
                    this.whyChooseUs = [...this.whyChooseUs];
                    this.syncDb('why_choose_us', 'reordered');
                }
            },
            moveDownWhy(idx) {
                if (idx < this.whyChooseUs.length - 1) {
                    const temp = this.whyChooseUs[idx];
                    this.whyChooseUs[idx] = this.whyChooseUs[idx + 1];
                    this.whyChooseUs[idx + 1] = temp;
                    this.whyChooseUs = [...this.whyChooseUs];
                    this.syncDb('why_choose_us', 'reordered');
                }
            },

            moveUpTemplate(idx) {
                if (idx > 0) {
                    const temp = this.templates[idx];
                    this.templates[idx] = this.templates[idx - 1];
                    this.templates[idx - 1] = temp;
                    this.templates = [...this.templates];
                    this.syncDb('templates', 'reordered');
                }
            },
            moveDownTemplate(idx) {
                if (idx < this.templates.length - 1) {
                    const temp = this.templates[idx];
                    this.templates[idx] = this.templates[idx + 1];
                    this.templates[idx + 1] = temp;
                    this.templates = [...this.templates];
                    this.syncDb('templates', 'reordered');
                }
            },

            /* AJAX DB SYNC */
            syncDb(key, actionType = 'saved') {
                const payload = {};
                if (key === 'hero_settings') payload['hero_settings'] = this.hero;
                else if (key === 'video_settings') payload['video_settings'] = this.video;
                else if (key === 'why_choose_us') payload['why_choose_us'] = this.whyChooseUs;
                else if (key === 'templates') payload['templates'] = this.templates;
                else payload[key] = this[key];

                fetch('{{ route('superadmin.website-settings.home-page.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            let msg = 'Home Page settings saved successfully.';
                            if (actionType === 'deleted') msg = 'Item deleted successfully.';
                            if (actionType === 'reordered') msg = 'Sequence reordered successfully.';

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: msg,
                                timer: 1800,
                                showConfirmButton: false,
                                customClass: { popup: 'rounded-3xl shadow-2xl' }
                            });
                        }
                    } else {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Error', data.message || 'Failed to save Home Page settings.', 'error');
                        }
                    }
                })
                .catch(err => {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error', 'Failed to sync Home Page settings with database.', 'error');
                    }
                });
            }
        };
    }
</script>
@endsection

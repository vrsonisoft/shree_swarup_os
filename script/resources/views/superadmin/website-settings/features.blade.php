@extends('layouts.app')

@section('content')
<style>
    /* Tab Pill Container */
    .feature-tab-container {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem;
        background-color: #e2e8f0;
        border: 1px solid #cbd5e1;
        border-radius: 9999px;
    }
    .dark .feature-tab-container {
        background-color: #0b0f19 !important;
        border-color: #1e293b !important;
    }

    /* Tab Buttons Base */
    .feature-tab-btn {
        padding: 0.65rem 1.35rem;
        font-size: 0.875rem;
        border-radius: 9999px;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        user-select: none;
        outline: none;
    }

    /* Active Tab */
    .feature-tab-active {
        background-color: #ffffff !important;
        color: #00b591 !important;
        font-weight: 800 !important;
        box-shadow: 0 2px 8px rgba(0, 181, 145, 0.15) !important;
        border: 1.5px solid #00b591 !important;
    }
    .dark .feature-tab-active {
        background-color: #0d1424 !important;
        color: #00b591 !important;
        border: 1.5px solid #00b591 !important;
        box-shadow: 0 2px 10px rgba(0, 181, 145, 0.25) !important;
    }
    .feature-tab-active svg {
        color: #00b591 !important;
    }

    /* Inactive Tab */
    .feature-tab-inactive {
        background-color: transparent !important;
        color: #475569 !important;
        font-weight: 600 !important;
        border: 1.5px solid transparent !important;
        box-shadow: none !important;
    }
    .feature-tab-inactive:hover {
        background-color: #cbd5e1 !important;
        color: #0f172a !important;
    }
    .dark .feature-tab-inactive {
        color: #94a3b8 !important;
    }
    .dark .feature-tab-inactive:hover {
        background-color: #1e293b !important;
        color: #f8fafc !important;
    }
    .feature-tab-inactive svg {
        color: #64748b !important;
    }
    .dark .feature-tab-inactive svg {
        color: #94a3b8 !important;
    }

    /* Card Container */
    .feature-card {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 28px !important;
        padding: 1.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03);
        overflow: hidden;
        margin-top: 1.5rem;
    }
    .dark .feature-card {
        background-color: #060a14 !important;
        border-color: #161f33 !important;
    }

    /* Table Header */
    .feature-table-head {
        background-color: #edf2f7;
        border-radius: 12px;
    }
    .dark .feature-table-head {
        background-color: #0d1424 !important;
    }
    .feature-th {
        padding: 1.125rem 1.25rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #334155;
    }
    .dark .feature-th {
        color: #94a3b8 !important;
    }

    /* Table Rows */
    .feature-row {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .dark .feature-row {
        border-bottom-color: #11192e !important;
    }
    .feature-row:last-child {
        border-bottom: none;
    }

    .feature-title-text {
        font-size: 0.875rem;
        font-weight: 700;
        color: #1e293b;
    }
    .dark .feature-title-text {
        color: #f8fafc !important;
    }

    .feature-desc-text {
        font-size: 0.8125rem;
        color: #475569;
    }
    .dark .feature-desc-text {
        color: #cbd5e1 !important;
    }

    /* Badge Pill for Core Feature Heading */
    .feature-badge-heading {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.65rem;
        border-radius: 0.375rem;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        background-color: #d1fae5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }
    .dark .feature-badge-heading {
        background-color: rgba(6, 78, 59, 0.6) !important;
        color: #6ee7b7 !important;
        border-color: rgba(16, 185, 129, 0.4) !important;
    }

    /* Image Preview Thumb */
    .feature-img-thumb {
        width: 5rem;
        height: 3.25rem;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1.5px solid #cbd5e1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .dark .feature-img-thumb {
        border-color: #334155;
    }

    /* Icon Upload Thumb */
    .feature-icon-thumb {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.75rem;
        object-fit: cover;
        border: 1.5px solid #cbd5e1;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .dark .feature-icon-thumb {
        border-color: #334155;
    }

    /* Action Buttons */
    .feature-action-btn-edit {
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
    .feature-action-btn-edit:hover {
        background-color: #bae6fd;
        color: #0369a1;
    }
    .dark .feature-action-btn-edit {
        background-color: rgba(12, 74, 110, 0.4) !important;
        color: #38bdf8 !important;
    }

    .feature-action-btn-delete {
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
    .feature-action-btn-delete:hover {
        background-color: #fca5a5;
        color: #dc2626;
    }
    .dark .feature-action-btn-delete {
        background-color: rgba(153, 27, 27, 0.35) !important;
        color: #f87171 !important;
    }

    /* Sequence Control Buttons (Up / Down) */
    .feature-seq-btn {
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
    .feature-seq-btn:hover:not(:disabled) {
        background-color: #cbd5e1;
        color: #0f172a;
    }
    .feature-seq-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    .dark .feature-seq-btn {
        background-color: #1e293b;
        color: #94a3b8;
    }
    .dark .feature-seq-btn:hover:not(:disabled) {
        background-color: #334155;
        color: #f8fafc;
    }

    /* Drag Handle */
    .feature-drag-handle {
        cursor: grab;
        color: #94a3b8;
        padding: 0.35rem;
        display: inline-flex;
        align-items: center;
    }
    .dark .feature-drag-handle {
        color: #475569;
    }
    .feature-drag-handle:hover {
        color: #334155;
    }
    .dark .feature-drag-handle:hover {
        color: #94a3b8;
    }

    /* Modal Inputs */
    .feature-modal-input, .feature-modal-textarea, .feature-modal-select {
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
    .dark .feature-modal-input, .dark .feature-modal-textarea, .dark .feature-modal-select {
        background-color: #111827 !important;
        border-color: #1f2937 !important;
        color: #f8fafc !important;
    }
    .dark .feature-modal-select option {
        background-color: #111827 !important;
        color: #f8fafc !important;
    }
</style>

<div x-data="featureComponent()" x-init="initSortable()" class="p-6 md:p-10 max-w-6xl mx-auto">

    <!-- Header Section + Navigation Tabs -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                Website Features
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 font-medium">
                Manage Core Feature showcases and More Feature cards displayed on the website.
            </p>
        </div>

        <!-- 2 Navigation Tabs Container -->
        <div class="feature-tab-container self-start md:self-auto">
            <button @click="switchTab('core')"
                    type="button"
                    :class="activeTab === 'core' ? 'feature-tab-active' : 'feature-tab-inactive'"
                    class="feature-tab-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                <span>Core Features (<span x-text="coreFeatures.length"></span>)</span>
            </button>

            <button @click="switchTab('more')"
                    type="button"
                    :class="activeTab === 'more' ? 'feature-tab-active' : 'feature-tab-inactive'"
                    class="feature-tab-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                <span>More Features (<span x-text="moreFeatures.length"></span>)</span>
            </button>
        </div>
    </div>


    <!-- TAB 1: CORE FEATURES SECTION -->
    <div x-show="activeTab === 'core'">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Core Feature Showcase List</h3>
            <button @click="openCreateCore()"
                    type="button"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-skin-base hover:opacity-90 active:scale-[0.99] text-white font-bold text-sm rounded-full shadow-md transition cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Add Core Feature</span>
            </button>
        </div>

        <div class="feature-card">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="feature-table-head">
                            <th class="feature-th w-32 text-center rounded-l-xl">SEQUENCE</th>
                            <th class="feature-th">HEADING & TITLE</th>
                            <th class="feature-th">SHORT DESCRIPTION</th>
                            <th class="feature-th">FEATURE IMAGE</th>
                            <th class="feature-th text-right rounded-r-xl">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="core-feature-table-body">
                        <template x-for="(item, idx) in coreFeatures" :key="item.id">
                            <tr class="feature-row" :data-id="idx">
                                <td class="py-4 px-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="feature-drag-handle" title="Drag to reorder sequence">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M7 2a2 2 0 10.001 4.001A2 2 0 007 2zm0 6a2 2 0 10.001 4.001A2 2 0 007 8zm0 6a2 2 0 10.001 4.001A2 2 0 007 14zm6-12a2 2 0 10.001 4.001A2 2 0 0013 2zm0 6a2 2 0 10.001 4.001A2 2 0 0013 8zm0 6a2 2 0 10.001 4.001A2 2 0 0013 14z"/>
                                            </svg>
                                        </span>
                                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-800 px-2.5 py-1 rounded-md" x-text="idx + 1"></span>

                                        <div class="flex flex-col gap-0.5">
                                            <button @click="moveUpCore(idx)"
                                                    :disabled="idx === 0"
                                                    type="button"
                                                    class="feature-seq-btn"
                                                    title="Move Up">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                                                </svg>
                                            </button>
                                            <button @click="moveDownCore(idx)"
                                                    :disabled="idx === coreFeatures.length - 1"
                                                    type="button"
                                                    class="feature-seq-btn"
                                                    title="Move Down">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="mb-1.5"><span class="feature-badge-heading" x-text="item.heading || 'CORE FEATURE'"></span></div>
                                    <div class="feature-title-text" x-text="item.title"></div>
                                </td>
                                <td class="py-4 px-4 feature-desc-text max-w-sm" x-text="item.short_desc"></td>
                                <td class="py-4 px-4">
                                    <template x-if="item.image">
                                        <img :src="item.image" alt="Feature Image" class="feature-img-thumb">
                                    </template>
                                    <template x-if="!item.image">
                                        <span class="text-xs text-gray-400 font-semibold">— No Image —</span>
                                    </template>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="openEditCore(idx)"
                                                type="button"
                                                class="feature-action-btn-edit"
                                                title="Edit Core Feature">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button @click="deleteCore(idx)"
                                                type="button"
                                                class="feature-action-btn-delete"
                                                title="Delete Core Feature">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-if="coreFeatures.length === 0">
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-500 dark:text-gray-400 font-medium">
                                    No core features found. Click "+ Add Core Feature" to create one.
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- TAB 2: MORE FEATURES SECTION -->
    <div x-show="activeTab === 'more'">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">More Features Grid List</h3>
            <button @click="openCreateMore()"
                    type="button"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-skin-base hover:opacity-90 active:scale-[0.99] text-white font-bold text-sm rounded-full shadow-md transition cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Add More Feature</span>
            </button>
        </div>

        <div class="feature-card">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="feature-table-head">
                            <th class="feature-th w-32 text-center rounded-l-xl">SEQUENCE</th>
                            <th class="feature-th">FEATURE ICON</th>
                            <th class="feature-th">TITLE</th>
                            <th class="feature-th">DESCRIPTION</th>
                            <th class="feature-th text-right rounded-r-xl">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="more-feature-table-body">
                        <template x-for="(item, idx) in moreFeatures" :key="item.id">
                            <tr class="feature-row" :data-id="idx">
                                <td class="py-4 px-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="feature-drag-handle" title="Drag to reorder sequence">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M7 2a2 2 0 10.001 4.001A2 2 0 007 2zm0 6a2 2 0 10.001 4.001A2 2 0 007 8zm0 6a2 2 0 10.001 4.001A2 2 0 007 14zm6-12a2 2 0 10.001 4.001A2 2 0 0013 2zm0 6a2 2 0 10.001 4.001A2 2 0 0013 8zm0 6a2 2 0 10.001 4.001A2 2 0 0013 14z"/>
                                            </svg>
                                        </span>
                                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-800 px-2.5 py-1 rounded-md" x-text="idx + 1"></span>

                                        <div class="flex flex-col gap-0.5">
                                            <button @click="moveUpMore(idx)"
                                                    :disabled="idx === 0"
                                                    type="button"
                                                    class="feature-seq-btn"
                                                    title="Move Up">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                                                </svg>
                                            </button>
                                            <button @click="moveDownMore(idx)"
                                                    :disabled="idx === moreFeatures.length - 1"
                                                    type="button"
                                                    class="feature-seq-btn"
                                                    title="Move Down">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <template x-if="item.icon">
                                        <img :src="item.icon" alt="Feature Icon" class="feature-icon-thumb">
                                    </template>
                                    <template x-if="!item.icon">
                                        <div class="w-11 h-11 rounded-xl bg-skin-base/20 text-skin-base flex items-center justify-center font-bold text-base shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    </template>
                                </td>
                                <td class="py-4 px-4 feature-title-text" x-text="item.title"></td>
                                <td class="py-4 px-4 feature-desc-text max-w-md" x-text="item.description"></td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="openEditMore(idx)"
                                                type="button"
                                                class="feature-action-btn-edit"
                                                title="Edit More Feature">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button @click="deleteMore(idx)"
                                                type="button"
                                                class="feature-action-btn-delete"
                                                title="Delete More Feature">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-if="moreFeatures.length === 0">
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-500 dark:text-gray-400 font-medium">
                                    No more features found. Click "+ Add More Feature" to create one.
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- RIGHT SIDE MODAL DRAWER (FOR CORE FEATURES) -->
    <div x-show="openCoreModal" x-cloak class="fixed inset-0 z-50 overflow-hidden" role="dialog" aria-modal="true">
        <div x-show="openCoreModal" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="openCoreModal = false" class="fixed inset-0 bg-gray-900/60 dark:bg-black/80 backdrop-blur-xs transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <div x-show="openCoreModal" x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-lg bg-white dark:bg-[#0B0F19] text-gray-900 dark:text-gray-100 shadow-2xl border-l border-gray-200 dark:border-gray-800 flex flex-col justify-between">
                
                <div class="p-6 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100" x-text="isCoreEdit ? 'Update Core Feature' : 'Add Core Feature'"></h3>
                    <button @click="openCoreModal = false" type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-5 flex-1 overflow-y-auto">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Heading Badge Tag <span class="text-red-500">*</span></label>
                        <input type="text" x-model="coreHeading" placeholder="e.g. QR MENU SYSTEM" class="feature-modal-input">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Title <span class="text-red-500">*</span></label>
                        <input type="text" x-model="coreTitle" placeholder="e.g. Instant Digital Menus via QR Code Scan" class="feature-modal-input">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Short Description <span class="text-red-500">*</span></label>
                        <textarea x-model="coreShortDesc" rows="3" placeholder="Enter brief overview description..." class="feature-modal-textarea"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Feature Bullet Points (Comma Separated) <span class="text-red-500">*</span>
                        </label>
                        <textarea x-model="coreBullets" rows="3" placeholder="e.g. Customizable QR code design, Real-time menu updates, Multi-language support" class="feature-modal-textarea"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Feature Showcase Image File
                        </label>
                        <div class="flex items-center gap-4">
                            <template x-if="coreImageData">
                                <img :src="coreImageData" alt="Preview" class="w-20 h-14 rounded-lg object-cover border-2 border-skin-base shadow-sm shrink-0">
                            </template>
                            <template x-if="!coreImageData">
                                <div class="w-20 h-14 rounded-lg bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </template>

                            <input type="file"
                                   accept="image/*"
                                   @change="handleCoreImageUpload($event)"
                                   class="w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-skin-base/15 file:text-skin-base hover:file:bg-skin-base/25 cursor-pointer">
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-[#070A14] flex items-center justify-end gap-3">
                    <button @click="openCoreModal = false" type="button" class="px-5 py-2.5 bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold text-xs rounded-xl transition cursor-pointer">Cancel</button>
                    <button @click="saveCore()" type="button" class="px-5 py-2.5 bg-skin-base text-white font-bold text-xs rounded-xl shadow-md hover:opacity-90 transition cursor-pointer">
                        <span x-text="isCoreEdit ? 'Update Core Feature' : 'Save Core Feature'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- RIGHT SIDE MODAL DRAWER (FOR MORE FEATURES WITH DIRECT ICON FILE UPLOAD) -->
    <div x-show="openMoreModal" x-cloak class="fixed inset-0 z-50 overflow-hidden" role="dialog" aria-modal="true">
        <div x-show="openMoreModal" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="openMoreModal = false" class="fixed inset-0 bg-gray-900/60 dark:bg-black/80 backdrop-blur-xs transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <div x-show="openMoreModal" x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-md bg-white dark:bg-[#0B0F19] text-gray-900 dark:text-gray-100 shadow-2xl border-l border-gray-200 dark:border-gray-800 flex flex-col justify-between">
                
                <div class="p-6 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100" x-text="isMoreEdit ? 'Update More Feature' : 'Add More Feature'"></h3>
                    <button @click="openMoreModal = false" type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-5 flex-1 overflow-y-auto">
                    <!-- Feature Icon File Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Feature Icon File <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-4">
                            <template x-if="moreIconData">
                                <img :src="moreIconData" alt="Icon Preview" class="w-14 h-14 rounded-xl object-cover border-2 border-skin-base shadow-sm shrink-0">
                            </template>
                            <template x-if="!moreIconData">
                                <div class="w-14 h-14 rounded-xl bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </template>

                            <input type="file"
                                   accept="image/*"
                                   @change="handleMoreIconUpload($event)"
                                   class="w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-skin-base/15 file:text-skin-base hover:file:bg-skin-base/25 cursor-pointer">
                        </div>
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Feature Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" x-model="moreTitle" placeholder="e.g. Table Booking & Reservations" class="feature-modal-input">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Feature Description <span class="text-red-500">*</span>
                        </label>
                        <textarea x-model="moreDesc" rows="4" placeholder="Enter detailed feature description..." class="feature-modal-textarea"></textarea>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-[#070A14] flex items-center justify-end gap-3">
                    <button @click="openMoreModal = false" type="button" class="px-5 py-2.5 bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold text-xs rounded-xl transition cursor-pointer">Cancel</button>
                    <button @click="saveMore()" type="button" class="px-5 py-2.5 bg-skin-base text-white font-bold text-xs rounded-xl shadow-md hover:opacity-90 transition cursor-pointer">
                        <span x-text="isMoreEdit ? 'Update More Feature' : 'Save More Feature'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- SortableJS library for smooth drag-and-drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    function featureComponent() {
        return {
            activeTab: 'core',
            openCoreModal: false,
            openMoreModal: false,
            isCoreEdit: false,
            isMoreEdit: false,

            // Core State
            editCoreIdx: null,
            coreHeading: '',
            coreTitle: '',
            coreShortDesc: '',
            coreBullets: '',
            coreImageData: '',
            coreFeatures: @json($coreFeatures),

            // More State
            editMoreIdx: null,
            moreIconData: '',
            moreTitle: '',
            moreDesc: '',
            moreFeatures: @json($moreFeatures),

            switchTab(tab) {
                this.activeTab = tab;
                this.initSortable();
            },

            initSortable() {
                this.$nextTick(() => {
                    const tbodyCore = document.getElementById('core-feature-table-body');
                    if (tbodyCore && typeof Sortable !== 'undefined') {
                        const self = this;
                        if (self.sortableCoreInstance) self.sortableCoreInstance.destroy();
                        self.sortableCoreInstance = new Sortable(tbodyCore, {
                            handle: '.feature-drag-handle',
                            animation: 150,
                            onEnd(evt) {
                                if (evt.oldIndex !== undefined && evt.newIndex !== undefined && evt.oldIndex !== evt.newIndex) {
                                    const movedItem = self.coreFeatures.splice(evt.oldIndex, 1)[0];
                                    self.coreFeatures.splice(evt.newIndex, 0, movedItem);
                                    self.syncCoreDb('reordered');
                                }
                            }
                        });
                    }

                    const tbodyMore = document.getElementById('more-feature-table-body');
                    if (tbodyMore && typeof Sortable !== 'undefined') {
                        const self = this;
                        if (self.sortableMoreInstance) self.sortableMoreInstance.destroy();
                        self.sortableMoreInstance = new Sortable(tbodyMore, {
                            handle: '.feature-drag-handle',
                            animation: 150,
                            onEnd(evt) {
                                if (evt.oldIndex !== undefined && evt.newIndex !== undefined && evt.oldIndex !== evt.newIndex) {
                                    const movedItem = self.moreFeatures.splice(evt.oldIndex, 1)[0];
                                    self.moreFeatures.splice(evt.newIndex, 0, movedItem);
                                    self.syncMoreDb('reordered');
                                }
                            }
                        });
                    }
                });
            },

            handleCoreImageUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.coreImageData = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            handleMoreIconUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.moreIconData = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            /* CORE FEATURES LOGIC */
            openCreateCore() {
                this.isCoreEdit = false;
                this.editCoreIdx = null;
                this.coreHeading = '';
                this.coreTitle = '';
                this.coreShortDesc = '';
                this.coreBullets = '';
                this.coreImageData = '';
                this.openCoreModal = true;
            },

            openEditCore(idx) {
                this.isCoreEdit = true;
                this.editCoreIdx = idx;
                const item = this.coreFeatures[idx];
                if (item) {
                    this.coreHeading = item.heading || '';
                    this.coreTitle = item.title || '';
                    this.coreShortDesc = item.short_desc || '';
                    this.coreBullets = item.bullets || '';
                    this.coreImageData = item.image || '';
                    this.openCoreModal = true;
                }
            },

            saveCore() {
                if (!this.coreHeading.trim() || !this.coreTitle.trim() || !this.coreShortDesc.trim()) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Validation Error', 'Heading Tag, Title and Short Description are required.', 'warning');
                    } else {
                        alert('Heading Tag, Title and Short Description are required.');
                    }
                    return;
                }

                const now = new Date().toLocaleString('en-US', { month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });

                const itemObj = {
                    id: (this.isCoreEdit && this.editCoreIdx !== null && this.coreFeatures[this.editCoreIdx]) ? this.coreFeatures[this.editCoreIdx].id : Date.now(),
                    heading: this.coreHeading,
                    title: this.coreTitle,
                    short_desc: this.coreShortDesc,
                    bullets: this.coreBullets,
                    image: this.coreImageData || '',
                    created_at: now,
                    updated_at: now
                };

                if (this.isCoreEdit && this.editCoreIdx !== null && this.coreFeatures[this.editCoreIdx]) {
                    this.coreFeatures[this.editCoreIdx] = itemObj;
                } else {
                    this.coreFeatures.push(itemObj);
                }

                this.openCoreModal = false;
                this.syncCoreDb('saved');
            },

            deleteCore(idx) {
                const self = this;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Delete Core Feature?',
                        text: 'Are you sure you want to delete this core feature?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel',
                        customClass: { popup: 'rounded-3xl shadow-2xl' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            self.coreFeatures.splice(idx, 1);
                            self.syncCoreDb('deleted');
                        }
                    });
                } else {
                    if (confirm('Are you sure you want to delete this core feature?')) {
                        self.coreFeatures.splice(idx, 1);
                        self.syncCoreDb('deleted');
                    }
                }
            },

            moveUpCore(idx) {
                if (idx > 0) {
                    const temp = this.coreFeatures[idx];
                    this.coreFeatures[idx] = this.coreFeatures[idx - 1];
                    this.coreFeatures[idx - 1] = temp;
                    this.coreFeatures = [...this.coreFeatures];
                    this.syncCoreDb('reordered');
                }
            },

            moveDownCore(idx) {
                if (idx < this.coreFeatures.length - 1) {
                    const temp = this.coreFeatures[idx];
                    this.coreFeatures[idx] = this.coreFeatures[idx + 1];
                    this.coreFeatures[idx + 1] = temp;
                    this.coreFeatures = [...this.coreFeatures];
                    this.syncCoreDb('reordered');
                }
            },

            syncCoreDb(actionType = 'saved') {
                fetch('{{ route('superadmin.website-settings.features.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ core_features: this.coreFeatures })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            let msg = 'Core Feature saved successfully.';
                            if (actionType === 'deleted') msg = 'Core Feature deleted successfully.';
                            if (actionType === 'reordered') msg = 'Core Feature sequence updated successfully.';

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
                            Swal.fire('Error', data.message || 'Failed to update Core Features.', 'error');
                        }
                    }
                })
                .catch(err => {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error', 'Failed to sync Core Features with database.', 'error');
                    }
                });
            },

            /* MORE FEATURES LOGIC */
            openCreateMore() {
                this.isMoreEdit = false;
                this.editMoreIdx = null;
                this.moreIconData = '';
                this.moreTitle = '';
                this.moreDesc = '';
                this.openMoreModal = true;
            },

            openEditMore(idx) {
                this.isMoreEdit = true;
                this.editMoreIdx = idx;
                const item = this.moreFeatures[idx];
                if (item) {
                    this.moreIconData = item.icon || '';
                    this.moreTitle = item.title || '';
                    this.moreDesc = item.description || '';
                    this.openMoreModal = true;
                }
            },

            saveMore() {
                if (!this.moreTitle.trim() || !this.moreDesc.trim()) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Validation Error', 'Feature Title and Description are required.', 'warning');
                    } else {
                        alert('Feature Title and Description are required.');
                    }
                    return;
                }

                const now = new Date().toLocaleString('en-US', { month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });

                const itemObj = {
                    id: (this.isMoreEdit && this.editMoreIdx !== null && this.moreFeatures[this.editMoreIdx]) ? this.moreFeatures[this.editMoreIdx].id : Date.now(),
                    icon: this.moreIconData || '',
                    title: this.moreTitle,
                    description: this.moreDesc,
                    created_at: now,
                    updated_at: now
                };

                if (this.isMoreEdit && this.editMoreIdx !== null && this.moreFeatures[this.editMoreIdx]) {
                    this.moreFeatures[this.editMoreIdx] = itemObj;
                } else {
                    this.moreFeatures.push(itemObj);
                }

                this.openMoreModal = false;
                this.syncMoreDb('saved');
            },

            deleteMore(idx) {
                const self = this;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Delete More Feature?',
                        text: 'Are you sure you want to delete this feature card?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel',
                        customClass: { popup: 'rounded-3xl shadow-2xl' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            self.moreFeatures.splice(idx, 1);
                            self.syncMoreDb('deleted');
                        }
                    });
                } else {
                    if (confirm('Are you sure you want to delete this feature card?')) {
                        self.moreFeatures.splice(idx, 1);
                        self.syncMoreDb('deleted');
                    }
                }
            },

            moveUpMore(idx) {
                if (idx > 0) {
                    const temp = this.moreFeatures[idx];
                    this.moreFeatures[idx] = this.moreFeatures[idx - 1];
                    this.moreFeatures[idx - 1] = temp;
                    this.moreFeatures = [...this.moreFeatures];
                    this.syncMoreDb('reordered');
                }
            },

            moveDownMore(idx) {
                if (idx < this.moreFeatures.length - 1) {
                    const temp = this.moreFeatures[idx];
                    this.moreFeatures[idx] = this.moreFeatures[idx + 1];
                    this.moreFeatures[idx + 1] = temp;
                    this.moreFeatures = [...this.moreFeatures];
                    this.syncMoreDb('reordered');
                }
            },

            syncMoreDb(actionType = 'saved') {
                fetch('{{ route('superadmin.website-settings.features.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ more_features: this.moreFeatures })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            let msg = 'More Feature saved successfully.';
                            if (actionType === 'deleted') msg = 'More Feature deleted successfully.';
                            if (actionType === 'reordered') msg = 'More Feature sequence updated successfully.';

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
                            Swal.fire('Error', data.message || 'Failed to update More Features.', 'error');
                        }
                    }
                })
                .catch(err => {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error', 'Failed to sync More Features with database.', 'error');
                    }
                });
            }
        };
    }
</script>
@endsection

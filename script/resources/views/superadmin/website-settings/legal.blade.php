@extends('layouts.app')

@section('content')
<style>
    /* Top Policy Tab Container */
    .legal-tab-container {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem;
        background-color: #e2e8f0;
        border: 1px solid #cbd5e1;
        border-radius: 9999px;
        overflow-x: auto;
    }
    .dark .legal-tab-container {
        background-color: #0b0f19 !important;
        border-color: #1e293b !important;
    }

    .legal-tab-btn {
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
    .legal-tab-active {
        background-color: #ffffff !important;
        color: #00b591 !important;
        font-weight: 800 !important;
        box-shadow: 0 2px 8px rgba(0, 181, 145, 0.15) !important;
        border: 1.5px solid #00b591 !important;
    }
    .dark .legal-tab-active {
        background-color: #0d1424 !important;
        color: #00b591 !important;
        border: 1.5px solid #00b591 !important;
        box-shadow: 0 2px 10px rgba(0, 181, 145, 0.25) !important;
    }

    /* Inactive Tab */
    .legal-tab-inactive {
        background-color: transparent !important;
        color: #475569 !important;
        font-weight: 600 !important;
        border: 1.5px solid transparent !important;
    }
    .legal-tab-inactive:hover {
        background-color: #cbd5e1 !important;
        color: #0f172a !important;
    }
    .dark .legal-tab-inactive {
        color: #94a3b8 !important;
    }
    .dark .legal-tab-inactive:hover {
        background-color: #1e293b !important;
        color: #f8fafc !important;
    }

    /* Card Container */
    .legal-card {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 28px !important;
        padding: 1.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03);
        overflow: hidden;
        margin-top: 1.5rem;
    }
    .dark .legal-card {
        background-color: #060a14 !important;
        border-color: #161f33 !important;
    }

    /* Table Header */
    .legal-table-head {
        background-color: #edf2f7;
        border-radius: 12px;
    }
    .dark .legal-table-head {
        background-color: #0d1424 !important;
    }
    .legal-th {
        padding: 1.125rem 1.25rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #334155;
    }
    .dark .legal-th {
        color: #94a3b8 !important;
    }

    /* Table Rows */
    .legal-row {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .dark .legal-row {
        border-bottom-color: #11192e !important;
    }
    .legal-row:last-child {
        border-bottom: none;
    }

    .legal-title-text {
        font-size: 0.875rem;
        font-weight: 700;
        color: #1e293b;
    }
    .dark .legal-title-text {
        color: #f8fafc !important;
    }

    .legal-desc-text {
        font-size: 0.8125rem;
        color: #475569;
        line-height: 1.5;
    }
    .dark .legal-desc-text {
        color: #cbd5e1 !important;
    }

    /* Image Preview Thumb */
    .legal-img-thumb {
        width: 3.5rem;
        height: 2.5rem;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1px solid #cbd5e1;
    }
    .dark .legal-img-thumb {
        border-color: #334155;
    }

    /* Action Buttons */
    .legal-action-btn-edit {
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
    .legal-action-btn-edit:hover {
        background-color: #bae6fd;
        color: #0369a1;
    }
    .dark .legal-action-btn-edit {
        background-color: rgba(12, 74, 110, 0.4) !important;
        color: #38bdf8 !important;
    }

    .legal-action-btn-delete {
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
    .legal-action-btn-delete:hover {
        background-color: #fca5a5;
        color: #dc2626;
    }
    .dark .legal-action-btn-delete {
        background-color: rgba(153, 27, 27, 0.35) !important;
        color: #f87171 !important;
    }

    /* Sequence Control Buttons (Up / Down) */
    .legal-seq-btn {
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
    .legal-seq-btn:hover:not(:disabled) {
        background-color: #cbd5e1;
        color: #0f172a;
    }
    .legal-seq-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    .dark .legal-seq-btn {
        background-color: #1e293b;
        color: #94a3b8;
    }
    .dark .legal-seq-btn:hover:not(:disabled) {
        background-color: #334155;
        color: #f8fafc;
    }

    /* Drag Handle */
    .legal-drag-handle {
        cursor: grab;
        color: #94a3b8;
        padding: 0.35rem;
        display: inline-flex;
        align-items: center;
    }
    .dark .legal-drag-handle {
        color: #475569;
    }
    .legal-drag-handle:hover {
        color: #334155;
    }
    .dark .legal-drag-handle:hover {
        color: #94a3b8;
    }

    /* Modal Drawer Inputs */
    .legal-modal-input, .legal-modal-select {
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
    .dark .legal-modal-input, .dark .legal-modal-select {
        background-color: #111827 !important;
        border-color: #1f2937 !important;
        color: #f8fafc !important;
    }
    .dark .legal-modal-select option {
        background-color: #111827 !important;
        color: #f8fafc !important;
    }

    /* Real WYSIWYG Wrapper */
    .legal-wysiwyg-wrapper {
        border: 1px solid #cbd5e1;
        border-radius: 0.875rem;
        overflow: hidden;
        background-color: #ffffff;
    }
    .dark .legal-wysiwyg-wrapper {
        border-color: #1f2937 !important;
        background-color: #111827 !important;
    }
    .legal-wysiwyg-wrapper:focus-within {
        border-color: #00b591 !important;
        box-shadow: 0 0 0 3px rgba(0, 181, 145, 0.15) !important;
    }

    /* Toolbar */
    .legal-wysiwyg-toolbar {
        padding: 0.5rem 0.75rem;
        background-color: #f1f5f9;
        border-bottom: 1px solid #cbd5e1;
    }
    .dark .legal-wysiwyg-toolbar {
        background-color: #0d1424 !important;
        border-bottom-color: #1f2937 !important;
    }

    .wysiwyg-btn {
        padding: 0.35rem 0.55rem;
        font-size: 0.8125rem;
        border-radius: 0.375rem;
        color: #334155;
        background-color: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .wysiwyg-btn:hover {
        background-color: #e2e8f0;
        color: #00b591;
    }
    .dark .wysiwyg-btn {
        color: #94a3b8 !important;
    }
    .dark .wysiwyg-btn:hover {
        background-color: #1e293b !important;
        color: #00b591 !important;
    }

    .wysiwyg-divider {
        width: 1px;
        height: 1.125rem;
        background-color: #cbd5e1;
        margin: 0 0.25rem;
    }
    .dark .wysiwyg-divider {
        background-color: #334155 !important;
    }

    /* ContentEditable Visual Area */
    .legal-wysiwyg-content {
        padding: 1rem;
        color: #0f172a !important;
        font-size: 0.875rem;
        line-height: 1.6;
        outline: none;
        max-height: 360px;
        overflow-y: auto;
    }
    .dark .legal-wysiwyg-content {
        color: #f8fafc !important;
    }

    /* Formatted HTML Live Preview Area */
    .legal-wysiwyg-preview {
        padding: 1rem;
        background-color: #f8fafc;
        color: #0f172a !important;
        font-size: 0.875rem;
        line-height: 1.6;
        max-height: 360px;
        overflow-y: auto;
    }
    .dark .legal-wysiwyg-preview {
        background-color: #060a14 !important;
        color: #f8fafc !important;
    }
</style>

<div x-data="legalComponent()" x-init="initSortable()" class="p-6 md:p-10 max-w-6xl mx-auto">

    <!-- Top Header -->
    <div class="mb-8">
        <div class="mb-6">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                Legal Documentation & Policies
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 font-medium">
                Manage Privacy Policy, Cookie Policy, Terms & Conditions, Refund Policy, and GDPR sections in a single unified table.
            </p>
        </div>

        <!-- 5 Policy Navigation Tabs -->
        <div class="legal-tab-container">
            <template x-for="(label, key) in tabNames" :key="key">
                <button @click="switchTab(key)"
                        type="button"
                        :class="activeTab === key ? 'legal-tab-active' : 'legal-tab-inactive'"
                        class="legal-tab-btn"
                        x-text="label">
                </button>
            </template>
        </div>
    </div>

    <!-- Active Tab Header & Add Section Button -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">
            <span x-text="tabNames[activeTab]"></span> Sections List (<span x-text="getTabItems().length"></span>)
        </h3>
        <button @click="openCreate()"
                type="button"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-skin-base hover:opacity-90 active:scale-[0.99] text-white font-bold text-sm rounded-full shadow-md transition cursor-pointer">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>+ Add Section</span>
        </button>
    </div>

    <!-- Policy Sections Listing Card & Single Table -->
    <div class="legal-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="legal-table-head">
                        <th class="legal-th w-32 text-center rounded-l-xl">SEQUENCE</th>
                        <th class="legal-th">TYPE</th>
                        <th class="legal-th">TITLE</th>
                        <th class="legal-th">DESCRIPTION</th>
                        <th class="legal-th">IMAGE</th>
                        <th class="legal-th text-right rounded-r-xl">ACTIONS</th>
                    </tr>
                </thead>

                <tbody id="legal-table-body">
                    <template x-for="(item, subIdx) in getTabItems()" :key="item.id">
                        <tr class="legal-row" :data-id="item.realIdx">
                            <td class="py-4 px-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="legal-drag-handle" title="Drag to reorder sequence">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7 2a2 2 0 10.001 4.001A2 2 0 007 2zm0 6a2 2 0 10.001 4.001A2 2 0 007 8zm0 6a2 2 0 10.001 4.001A2 2 0 007 14zm6-12a2 2 0 10.001 4.001A2 2 0 0013 2zm0 6a2 2 0 10.001 4.001A2 2 0 0013 8zm0 6a2 2 0 10.001 4.001A2 2 0 0013 14z"/>
                                        </svg>
                                    </span>
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-800 px-2.5 py-1 rounded-md" x-text="subIdx + 1"></span>

                                    <div class="flex flex-col gap-0.5">
                                        <button @click="moveUp(item.realIdx)"
                                                :disabled="subIdx === 0"
                                                type="button"
                                                class="legal-seq-btn"
                                                title="Move Up">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                                            </svg>
                                        </button>
                                        <button @click="moveDown(item.realIdx)"
                                                :disabled="subIdx === getTabItems().length - 1"
                                                type="button"
                                                class="legal-seq-btn"
                                                title="Move Down">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800/40" x-text="tabNames[item.type] || item.type"></span>
                            </td>
                            <td class="py-4 px-4 legal-title-text" x-text="item.title"></td>
                            <td class="py-4 px-4 legal-desc-text max-w-md" x-html="truncateHtml(item.description)"></td>
                            <td class="py-4 px-4">
                                <template x-if="item.image">
                                    <img :src="item.image" alt="Preview" class="legal-img-thumb">
                                </template>
                                <template x-if="!item.image">
                                    <span class="text-xs text-gray-400 font-semibold">— No Image —</span>
                                </template>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="openEdit(item.realIdx)"
                                            type="button" class="legal-action-btn-edit" title="Update Section">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button @click="deleteSection(item.realIdx)"
                                            type="button" class="legal-action-btn-delete" title="Delete Section">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template x-if="getTabItems().length === 0">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500 dark:text-gray-400 font-medium">
                                No sections found for <span class="font-bold text-gray-700 dark:text-gray-300" x-text="tabNames[activeTab]"></span>. Click "+ Add Section" to create one.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right Side Modal Drawer (WYSIWYG Editor with Live Preview Mode) -->
    <div x-show="openDrawer"
         x-cloak
         class="fixed inset-0 z-50 overflow-hidden"
         role="dialog"
         aria-modal="true">
        
        <!-- Backdrop Overlay -->
        <div x-show="openDrawer"
             x-transition:enter="ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="openDrawer = false"
             class="fixed inset-0 bg-gray-900/60 dark:bg-black/80 backdrop-blur-xs transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <div x-show="openDrawer"
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-lg bg-white dark:bg-[#0B0F19] text-gray-900 dark:text-gray-100 shadow-2xl border-l border-gray-200 dark:border-gray-800 flex flex-col justify-between">
                
                <!-- Drawer Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                        <span x-text="isEdit ? 'Update Policy Section' : 'Add New Policy Section'"></span>
                    </h3>
                    <button @click="openDrawer = false" type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Drawer Body Form Fields -->
                <div class="p-6 space-y-5 flex-1 overflow-y-auto">
                    <!-- Type Selector -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Policy Category Type <span class="text-red-500">*</span>
                        </label>
                        <select x-model="selectedType" class="legal-modal-select">
                            <option value="privacy-policy">Privacy Policy</option>
                            <option value="cookie-policy">Cookie Policy</option>
                            <option value="terms-conditions">Terms & Conditions</option>
                            <option value="refund-policy">Refund Policy</option>
                            <option value="gdpr-compliance">GDPR Compliance</option>
                        </select>
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Section Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               x-model="sectionTitle"
                               placeholder="e.g. Information We Collect"
                               class="legal-modal-input">
                    </div>

                    <!-- Modern WYSIWYG Rich Text Editor -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Section Content <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="legal-wysiwyg-wrapper">
                            <!-- Toolbar + Mode Switcher -->
                            <div class="legal-wysiwyg-toolbar flex items-center justify-between">
                                <div class="flex items-center gap-1 flex-wrap">
                                    <button @click="executeCmd('bold')" type="button" class="wysiwyg-btn font-bold" title="Bold">B</button>
                                    <button @click="executeCmd('italic')" type="button" class="wysiwyg-btn italic" title="Italic">I</button>
                                    <button @click="executeCmd('underline')" type="button" class="wysiwyg-btn underline" title="Underline">U</button>
                                    <button @click="executeCmd('strikeThrough')" type="button" class="wysiwyg-btn line-through" title="Strikethrough">S</button>
                                    <span class="wysiwyg-divider"></span>
                                    <button @click="executeCmd('formatBlock', '<h2>')" type="button" class="wysiwyg-btn font-extrabold text-xs" title="Heading 2">H2</button>
                                    <button @click="executeCmd('formatBlock', '<h3>')" type="button" class="wysiwyg-btn font-extrabold text-xs" title="Heading 3">H3</button>
                                    <button @click="executeCmd('formatBlock', '<p>')" type="button" class="wysiwyg-btn text-xs" title="Paragraph">P</button>
                                    <span class="wysiwyg-divider"></span>
                                    <button @click="executeCmd('insertUnorderedList')" type="button" class="wysiwyg-btn" title="Bullet List">• List</button>
                                    <button @click="executeCmd('insertOrderedList')" type="button" class="wysiwyg-btn" title="Numbered List">1. List</button>
                                    <span class="wysiwyg-divider"></span>
                                    <button @click="insertLink()" type="button" class="wysiwyg-btn" title="Insert Link">🔗 Link</button>
                                    <button @click="executeCmd('removeFormat')" type="button" class="wysiwyg-btn" title="Clear Formatting">🧹 Clear</button>
                                </div>

                                <div class="flex items-center gap-1 bg-gray-200 dark:bg-gray-800 p-1 rounded-lg shrink-0">
                                    <button @click="editorMode = 'visual'" type="button" :class="editorMode === 'visual' ? 'bg-white dark:bg-[#1E293B] text-[#00b591] font-bold shadow-xs' : 'text-gray-500 dark:text-gray-400'" class="px-2.5 py-1 rounded-md text-xs transition">
                                        Editor
                                    </button>
                                    <button @click="editorMode = 'preview'; syncContent();" type="button" :class="editorMode === 'preview' ? 'bg-white dark:bg-[#1E293B] text-[#00b591] font-bold shadow-xs' : 'text-gray-500 dark:text-gray-400'" class="px-2.5 py-1 rounded-md text-xs transition">
                                        Preview
                                    </button>
                                </div>
                            </div>

                            <!-- ContentEditable Visual Editor Area -->
                            <div x-show="editorMode === 'visual'"
                                 x-ref="wysiwygBody"
                                 contenteditable="true"
                                 @input="syncContent()"
                                 @blur="syncContent()"
                                 class="legal-wysiwyg-content min-h-[200px]"></div>

                            <!-- Live Formatted HTML Preview Area -->
                            <div x-show="editorMode === 'preview'"
                                 x-html="sectionDesc || '<p class=\'text-gray-400 italic\'>No content to preview...</p>'"
                                 class="legal-wysiwyg-preview min-h-[200px]"></div>
                        </div>
                    </div>

                    <!-- Feature Image Direct Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Feature Image (Optional File Upload)
                        </label>
                        <div class="flex items-center gap-4">
                            <template x-if="imageData">
                                <img :src="imageData" alt="Preview" class="w-16 h-12 rounded-lg object-cover border border-skin-base shadow-sm shrink-0">
                            </template>
                            <input type="file"
                                   accept="image/*"
                                   @change="handleImageUpload($event)"
                                   class="w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-skin-base/15 file:text-skin-base hover:file:bg-skin-base/25 cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer Action Buttons -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-[#070A14] flex items-center justify-end gap-3">
                    <button @click="openDrawer = false" type="button" class="px-5 py-2.5 bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold text-xs rounded-xl transition cursor-pointer">
                        Cancel
                    </button>
                    <button @click="saveSection()" type="button" class="px-5 py-2.5 bg-skin-base text-white font-bold text-xs rounded-xl shadow-md hover:opacity-90 transition cursor-pointer">
                        <span x-text="isEdit ? 'Update Section' : 'Save Section'"></span>
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- SortableJS library for smooth drag-and-drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    function legalComponent() {
        return {
            activeTab: '{{ $activeTab ?? "privacy-policy" }}',
            openDrawer: false,
            isEdit: false,
            editRealIdx: null,
            selectedType: 'privacy-policy',
            sectionTitle: '',
            sectionDesc: '',
            imageData: '',
            editorMode: 'visual',
            legals: @json($legals),

            tabNames: {
                'privacy-policy': 'Privacy Policy',
                'cookie-policy': 'Cookie Policy',
                'terms-conditions': 'Terms & Conditions',
                'refund-policy': 'Refund Policy',
                'gdpr-compliance': 'GDPR Compliance'
            },

            switchTab(key) {
                this.activeTab = key;
                this.initSortable();
            },

            getTabItems() {
                const self = this;
                const items = [];
                this.legals.forEach((item, index) => {
                    if (item.type === self.activeTab) {
                        items.push({ ...item, realIdx: index });
                    }
                });
                return items;
            },

            initSortable() {
                this.$nextTick(() => {
                    const tbody = document.getElementById('legal-table-body');
                    if (tbody && typeof Sortable !== 'undefined') {
                        const self = this;
                        if (self.sortableInstance) {
                            self.sortableInstance.destroy();
                        }
                        self.sortableInstance = new Sortable(tbody, {
                            handle: '.legal-drag-handle',
                            animation: 150,
                            onEnd(evt) {
                                if (evt.oldIndex !== undefined && evt.newIndex !== undefined && evt.oldIndex !== evt.newIndex) {
                                    const tabItems = self.getTabItems();
                                    const sourceRealIdx = tabItems[evt.oldIndex].realIdx;
                                    const targetRealIdx = tabItems[evt.newIndex].realIdx;

                                    const movedItem = self.legals.splice(sourceRealIdx, 1)[0];
                                    self.legals.splice(targetRealIdx, 0, movedItem);
                                    self.syncDb('reordered');
                                }
                            }
                        });
                    }
                });
            },

            handleImageUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageData = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            openCreate() {
                this.isEdit = false;
                this.editRealIdx = null;
                this.selectedType = this.activeTab;
                this.sectionTitle = '';
                this.sectionDesc = '';
                this.imageData = '';
                this.editorMode = 'visual';
                this.openDrawer = true;
                setTimeout(() => this.loadContentToEditor(), 100);
            },

            openEdit(realIdx) {
                this.isEdit = true;
                this.editRealIdx = realIdx;
                const item = this.legals[realIdx];
                if (item) {
                    this.selectedType = item.type || this.activeTab;
                    this.sectionTitle = item.title || '';
                    this.sectionDesc = item.description || '';
                    this.imageData = item.image || '';
                    this.editorMode = 'visual';
                    this.openDrawer = true;
                    setTimeout(() => this.loadContentToEditor(), 100);
                }
            },

            executeCmd(cmd, value = null) {
                document.execCommand(cmd, false, value);
                this.syncContent();
            },

            insertLink() {
                const url = prompt('Enter link URL:', 'https://');
                if (url) {
                    document.execCommand('createLink', false, url);
                    this.syncContent();
                }
            },

            syncContent() {
                const editor = this.$refs.wysiwygBody;
                if (editor) {
                    this.sectionDesc = editor.innerHTML;
                }
            },

            loadContentToEditor() {
                const editor = this.$refs.wysiwygBody;
                if (editor) {
                    editor.innerHTML = this.sectionDesc || '';
                }
            },

            truncateHtml(htmlStr) {
                if (!htmlStr) return '<span class="text-gray-400 italic">No content</span>';
                const tmp = document.createElement('div');
                tmp.innerHTML = htmlStr;
                const text = tmp.textContent || tmp.innerText || '';
                return text.length > 90 ? text.substring(0, 90) + '...' : text;
            },

            saveSection() {
                this.syncContent();

                if (!this.sectionTitle.trim() || !this.sectionDesc.trim()) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Validation Error', 'Please fill in Section Title and Description.', 'warning');
                    } else {
                        alert('Please fill in Section Title and Description.');
                    }
                    return;
                }

                const now = new Date().toLocaleString('en-US', { month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });

                const sectionObj = {
                    id: (this.isEdit && this.editRealIdx !== null && this.legals[this.editRealIdx]) ? this.legals[this.editRealIdx].id : Date.now(),
                    type: this.selectedType,
                    title: this.sectionTitle,
                    description: this.sectionDesc,
                    image: this.imageData || '',
                    created_at: now,
                    updated_at: now
                };

                if (this.isEdit && this.editRealIdx !== null && this.legals[this.editRealIdx]) {
                    this.legals[this.editRealIdx] = sectionObj;
                } else {
                    this.legals.push(sectionObj);
                }

                this.openDrawer = false;
                this.syncDb('saved');
            },

            deleteSection(realIdx) {
                const self = this;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Delete Section?',
                        text: 'Are you sure you want to delete this policy section?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel',
                        customClass: { popup: 'rounded-3xl shadow-2xl' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            self.legals.splice(realIdx, 1);
                            self.syncDb('deleted');
                        }
                    });
                } else {
                    if (confirm('Are you sure you want to delete this policy section?')) {
                        self.legals.splice(realIdx, 1);
                        self.syncDb('deleted');
                    }
                }
            },

            moveUp(realIdx) {
                if (realIdx > 0) {
                    const temp = this.legals[realIdx];
                    this.legals[realIdx] = this.legals[realIdx - 1];
                    this.legals[realIdx - 1] = temp;
                    this.legals = [...this.legals];
                    this.syncDb('reordered');
                }
            },

            moveDown(realIdx) {
                if (realIdx < this.legals.length - 1) {
                    const temp = this.legals[realIdx];
                    this.legals[realIdx] = this.legals[realIdx + 1];
                    this.legals[realIdx + 1] = temp;
                    this.legals = [...this.legals];
                    this.syncDb('reordered');
                }
            },

            syncDb(actionType = 'saved') {
                fetch('{{ route('superadmin.website-settings.legal.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ legals: this.legals })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            let msg = 'Legal policy section saved successfully.';
                            if (actionType === 'deleted') msg = 'Policy section deleted successfully.';
                            if (actionType === 'reordered') msg = 'Policy section sequence updated successfully.';

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
                            Swal.fire('Error', data.message || 'Failed to update legal policies.', 'error');
                        }
                    }
                })
                .catch(err => {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error', 'Failed to sync legal policies with database.', 'error');
                    }
                });
            }
        };
    }
</script>
@endsection

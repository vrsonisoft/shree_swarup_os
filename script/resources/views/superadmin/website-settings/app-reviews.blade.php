@extends('layouts.app')

@section('content')
<style>
    /* Card Container */
    .review-card {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 28px !important;
        padding: 1.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }
    .dark .review-card {
        background-color: #060a14 !important;
        border-color: #161f33 !important;
    }

    /* Table Header */
    .review-table-head {
        background-color: #edf2f7;
        border-radius: 12px;
    }
    .dark .review-table-head {
        background-color: #0d1424 !important;
    }
    .review-th {
        padding: 1.125rem 1.25rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #334155;
    }
    .dark .review-th {
        color: #94a3b8 !important;
    }

    /* Table Rows */
    .review-row {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .dark .review-row {
        border-bottom-color: #11192e !important;
    }
    .review-row:last-child {
        border-bottom: none;
    }

    .review-customer-name {
        font-size: 0.875rem;
        font-weight: 700;
        color: #1e293b;
    }
    .dark .review-customer-name {
        color: #f8fafc !important;
    }

    .review-post-text {
        font-size: 0.8125rem;
        color: #64748b;
    }
    .dark .review-post-text {
        color: #94a3b8 !important;
    }

    .review-full-text {
        font-size: 0.8125rem;
        color: #475569;
    }
    .dark .review-full-text {
        color: #cbd5e1 !important;
    }

    /* Avatar Thumb */
    .review-avatar-thumb {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 9999px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .dark .review-avatar-thumb {
        border-color: #334155;
    }

    /* Star Rating Badge */
    .review-star-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.65rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        background-color: #fef3c7;
        color: #d97706;
        border: 1px solid #fde68a;
    }
    .dark .review-star-badge {
        background-color: rgba(120, 53, 15, 0.4) !important;
        color: #fbbf24 !important;
        border-color: rgba(245, 158, 11, 0.3) !important;
    }

    /* Action Buttons */
    .review-action-btn-edit {
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
    .review-action-btn-edit:hover {
        background-color: #bae6fd;
        color: #0369a1;
    }
    .dark .review-action-btn-edit {
        background-color: rgba(12, 74, 110, 0.4) !important;
        color: #38bdf8 !important;
    }

    .review-action-btn-delete {
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
    .review-action-btn-delete:hover {
        background-color: #fca5a5;
        color: #dc2626;
    }
    .dark .review-action-btn-delete {
        background-color: rgba(153, 27, 27, 0.35) !important;
        color: #f87171 !important;
    }

    /* Sequence Control Buttons (Up / Down) */
    .review-seq-btn {
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
    .review-seq-btn:hover:not(:disabled) {
        background-color: #cbd5e1;
        color: #0f172a;
    }
    .review-seq-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    .dark .review-seq-btn {
        background-color: #1e293b;
        color: #94a3b8;
    }
    .dark .review-seq-btn:hover:not(:disabled) {
        background-color: #334155;
        color: #f8fafc;
    }

    /* Drag Handle */
    .review-drag-handle {
        cursor: grab;
        color: #94a3b8;
        padding: 0.35rem;
        display: inline-flex;
        align-items: center;
    }
    .dark .review-drag-handle {
        color: #475569;
    }
    .review-drag-handle:hover {
        color: #334155;
    }
    .dark .review-drag-handle:hover {
        color: #94a3b8;
    }

    /* Modal Drawer Inputs */
    .review-modal-input, .review-modal-textarea, .review-modal-select {
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
    .dark .review-modal-input, .dark .review-modal-textarea, .dark .review-modal-select {
        background-color: #111827 !important;
        border-color: #1f2937 !important;
        color: #f8fafc !important;
    }
    .dark .review-modal-select option {
        background-color: #111827 !important;
        color: #f8fafc !important;
    }
</style>

<div x-data="appReviewComponent()" x-init="initSortable()" class="p-6 md:p-10 max-w-6xl mx-auto">

    <!-- Header Section + Add New Review Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                App Reviews & Testimonials (<span x-text="reviews.length"></span>)
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 font-medium">
                Manage customer reviews and restaurant testimonials displayed on website.
            </p>
        </div>

        <button @click="openCreate()"
                type="button"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-skin-base hover:opacity-90 active:scale-[0.99] text-white font-bold text-sm rounded-full shadow-md transition cursor-pointer self-start sm:self-auto">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>+ Add New Review</span>
        </button>
    </div>

    <!-- Review Table Card -->
    <div class="review-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="review-table-head">
                        <th class="review-th w-32 text-center rounded-l-xl">SEQUENCE</th>
                        <th class="review-th">CUSTOMER</th>
                        <th class="review-th">RESTAURANT / POST</th>
                        <th class="review-th">RATING</th>
                        <th class="review-th">FULL REVIEW</th>
                        <th class="review-th text-right rounded-r-xl">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="review-table-body">
                    <template x-for="(item, idx) in reviews" :key="idx">
                        <tr class="review-row" :data-id="idx">
                            <td class="py-4 px-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="review-drag-handle" title="Drag to reorder sequence">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7 2a2 2 0 10.001 4.001A2 2 0 007 2zm0 6a2 2 0 10.001 4.001A2 2 0 007 8zm0 6a2 2 0 10.001 4.001A2 2 0 007 14zm6-12a2 2 0 10.001 4.001A2 2 0 0013 2zm0 6a2 2 0 10.001 4.001A2 2 0 0013 8zm0 6a2 2 0 10.001 4.001A2 2 0 0013 14z"/>
                                        </svg>
                                    </span>
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-800 px-2.5 py-1 rounded-md" x-text="idx + 1"></span>

                                    <div class="flex flex-col gap-0.5">
                                        <button @click="moveUp(idx)"
                                                :disabled="idx === 0"
                                                type="button"
                                                class="review-seq-btn"
                                                title="Move Up">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                                            </svg>
                                        </button>
                                        <button @click="moveDown(idx)"
                                                :disabled="idx === reviews.length - 1"
                                                type="button"
                                                class="review-seq-btn"
                                                title="Move Down">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <template x-if="item.avatar">
                                        <img :src="item.avatar" alt="Customer Avatar" class="review-avatar-thumb">
                                    </template>
                                    <template x-if="!item.avatar">
                                        <div class="w-11 h-11 rounded-full bg-skin-base/20 text-skin-base flex items-center justify-center font-bold text-base shrink-0">
                                            <span x-text="item.customer_name ? item.customer_name.charAt(0).toUpperCase() : 'C'"></span>
                                        </div>
                                    </template>
                                    <div class="review-customer-name" x-text="item.customer_name"></div>
                                </div>
                            </td>
                            <td class="py-4 px-4 review-post-text" x-text="item.restaurant_post"></td>
                            <td class="py-4 px-4">
                                <span class="review-star-badge" x-text="'★ ' + item.stars + '.0 Rating'"></span>
                            </td>
                            <td class="py-4 px-4 review-full-text max-w-sm" x-text="item.full_review"></td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="openEdit(idx)"
                                            type="button"
                                            class="review-action-btn-edit"
                                            title="Update Review">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button @click="deleteReview(idx)"
                                            type="button"
                                            class="review-action-btn-delete"
                                            title="Delete Review">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template x-if="reviews.length === 0">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500 dark:text-gray-400 font-medium">
                                No customer reviews found. Click "+ Add New Review" to create one.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right Side Modal Drawer -->
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
            <!-- Drawer Panel Container -->
            <div x-show="openDrawer"
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-md bg-white dark:bg-[#0B0F19] text-gray-900 dark:text-gray-100 shadow-2xl border-l border-gray-200 dark:border-gray-800 flex flex-col justify-between">
                
                <!-- Drawer Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100" x-text="isEdit ? 'Update App Review' : 'Add New Review'"></h3>
                    <button @click="openDrawer = false" type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Drawer Body Form Fields -->
                <div class="p-6 space-y-5 flex-1 overflow-y-auto">
                    <!-- Customer Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Customer Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               x-model="customerName"
                               placeholder="e.g. Ananya Sharma"
                               class="review-modal-input">
                    </div>

                    <!-- Direct Customer Image Upload Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Customer Photo / Image File
                        </label>
                        <div class="flex items-center gap-4">
                            <!-- Image Preview -->
                            <template x-if="avatarData">
                                <img :src="avatarData" alt="Preview" class="w-14 h-14 rounded-full object-cover border-2 border-skin-base shadow-sm shrink-0">
                            </template>
                            <template x-if="!avatarData">
                                <div class="w-14 h-14 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            </template>

                            <input type="file"
                                   accept="image/*"
                                   @change="handleImageUpload($event)"
                                   class="w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-skin-base/15 file:text-skin-base hover:file:bg-skin-base/25 cursor-pointer">
                        </div>
                    </div>

                    <!-- Restaurant Name / Post -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Restaurant Name / Post <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               x-model="restaurantPost"
                               placeholder="e.g. Owner, Royal Spice Fine Dine"
                               class="review-modal-input">
                    </div>

                    <!-- Review Star Rating -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Review Star Rating <span class="text-red-500">*</span>
                        </label>
                        <select x-model="stars" class="review-modal-select">
                            <option value="5">★★★★★ (5 Stars)</option>
                            <option value="4">★★★★☆ (4 Stars)</option>
                            <option value="3">★★★☆☆ (3 Stars)</option>
                            <option value="2">★★☆☆☆ (2 Stars)</option>
                            <option value="1">★☆☆☆☆ (1 Star)</option>
                        </select>
                    </div>

                    <!-- Full Review Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Full Review <span class="text-red-500">*</span>
                        </label>
                        <textarea x-model="fullReview"
                                  rows="4"
                                  placeholder="Enter complete customer review..."
                                  class="review-modal-textarea"></textarea>
                    </div>
                </div>

                <!-- Drawer Footer Action Buttons -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-[#070A14] flex items-center justify-end gap-3">
                    <button @click="openDrawer = false" type="button" class="px-5 py-2.5 bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold text-xs rounded-xl transition cursor-pointer">
                        Cancel
                    </button>
                    <button @click="saveReview()" type="button" class="px-5 py-2.5 bg-skin-base text-white font-bold text-xs rounded-xl shadow-md hover:opacity-90 transition cursor-pointer">
                        <span x-text="isEdit ? 'Update Review' : 'Save Review'"></span>
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- SortableJS library for smooth drag-and-drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    function appReviewComponent() {
        return {
            openDrawer: false,
            isEdit: false,
            editIndex: null,
            customerName: '',
            avatarData: '',
            restaurantPost: '',
            stars: 5,
            fullReview: '',
            reviews: @json($reviews),

            initSortable() {
                this.$nextTick(() => {
                    const tbody = document.getElementById('review-table-body');
                    if (tbody && typeof Sortable !== 'undefined') {
                        const self = this;
                        new Sortable(tbody, {
                            handle: '.review-drag-handle',
                            animation: 150,
                            onEnd(evt) {
                                if (evt.oldIndex !== undefined && evt.newIndex !== undefined && evt.oldIndex !== evt.newIndex) {
                                    const movedItem = self.reviews.splice(evt.oldIndex, 1)[0];
                                    self.reviews.splice(evt.newIndex, 0, movedItem);
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
                        this.avatarData = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            openCreate() {
                this.isEdit = false;
                this.editIndex = null;
                this.customerName = '';
                this.avatarData = '';
                this.restaurantPost = '';
                this.stars = 5;
                this.fullReview = '';
                this.openDrawer = true;
            },

            openEdit(idx) {
                this.isEdit = true;
                this.editIndex = idx;
                const item = this.reviews[idx];
                if (item) {
                    this.customerName = item.customer_name || '';
                    this.avatarData = item.avatar || '';
                    this.restaurantPost = item.restaurant_post || '';
                    this.stars = item.stars || 5;
                    this.fullReview = item.full_review || '';
                    this.openDrawer = true;
                }
            },

            saveReview() {
                if (!this.customerName.trim() || !this.restaurantPost.trim() || !this.fullReview.trim()) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Validation Error', 'Customer Name, Restaurant/Post and Full Review fields are required.', 'warning');
                    } else {
                        alert('Customer Name, Restaurant/Post and Full Review fields are required.');
                    }
                    return;
                }

                const now = new Date().toLocaleString('en-US', { month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });

                const reviewObj = {
                    id: (this.isEdit && this.editIndex !== null && this.reviews[this.editIndex]) ? this.reviews[this.editIndex].id : Date.now(),
                    customer_name: this.customerName,
                    avatar: this.avatarData || '',
                    restaurant_post: this.restaurantPost,
                    stars: parseInt(this.stars) || 5,
                    full_review: this.fullReview,
                    created_at: now,
                    updated_at: now
                };

                if (this.isEdit && this.editIndex !== null && this.reviews[this.editIndex]) {
                    this.reviews[this.editIndex] = reviewObj;
                } else {
                    this.reviews.push(reviewObj);
                }

                this.openDrawer = false;
                this.syncDb('saved');
            },

            deleteReview(idx) {
                const self = this;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Delete Review?',
                        text: 'Are you sure you want to delete this customer review?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel',
                        customClass: { popup: 'rounded-3xl shadow-2xl' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            self.reviews.splice(idx, 1);
                            self.syncDb('deleted');
                        }
                    });
                } else {
                    if (confirm('Are you sure you want to delete this customer review?')) {
                        self.reviews.splice(idx, 1);
                        self.syncDb('deleted');
                    }
                }
            },

            /* Move Sequence Up */
            moveUp(idx) {
                if (idx > 0) {
                    const temp = this.reviews[idx];
                    this.reviews[idx] = this.reviews[idx - 1];
                    this.reviews[idx - 1] = temp;
                    this.reviews = [...this.reviews];
                    this.syncDb('reordered');
                }
            },

            /* Move Sequence Down */
            moveDown(idx) {
                if (idx < this.reviews.length - 1) {
                    const temp = this.reviews[idx];
                    this.reviews[idx] = this.reviews[idx + 1];
                    this.reviews[idx + 1] = temp;
                    this.reviews = [...this.reviews];
                    this.syncDb('reordered');
                }
            },

            syncDb(actionType = 'saved') {
                fetch('{{ route('superadmin.website-settings.app-reviews.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ reviews: this.reviews })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            let msg = 'App Review saved successfully.';
                            if (actionType === 'deleted') msg = 'App Review deleted successfully.';
                            if (actionType === 'reordered') msg = 'Review sequence updated successfully.';

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
                            Swal.fire('Error', data.message || 'Failed to update App Reviews.', 'error');
                        }
                    }
                })
                .catch(err => {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error', 'Failed to sync App Reviews with database.', 'error');
                    }
                });
            }
        };
    }
</script>
@endsection

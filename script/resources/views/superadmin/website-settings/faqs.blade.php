@extends('layouts.app')

@section('content')
<style>
    /* Card Container */
    .faq-card {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 28px !important;
        padding: 1.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }
    .dark .faq-card {
        background-color: #060a14 !important;
        border-color: #161f33 !important;
    }

    /* Table Header */
    .faq-table-head {
        background-color: #edf2f7;
        border-radius: 12px;
    }
    .dark .faq-table-head {
        background-color: #0d1424 !important;
    }
    .faq-th {
        padding: 1.125rem 1.25rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #334155;
    }
    .dark .faq-th {
        color: #94a3b8 !important;
    }

    /* Table Rows */
    .faq-row {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .dark .faq-row {
        border-bottom-color: #11192e !important;
    }
    .faq-row:last-child {
        border-bottom: none;
    }

    .faq-question-text {
        font-size: 0.875rem;
        font-weight: 700;
        color: #1e293b;
    }
    .dark .faq-question-text {
        color: #f8fafc !important;
    }

    .faq-date-text {
        font-size: 0.8125rem;
        color: #64748b;
    }
    .dark .faq-date-text {
        color: #94a3b8 !important;
    }

    /* Status Badge */
    .faq-status-badge-active {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        background-color: #d1fae5;
        color: #059669;
        cursor: pointer;
        border: none;
    }
    .dark .faq-status-badge-active {
        background-color: rgba(6, 78, 59, 0.4) !important;
        color: #34d399 !important;
        border: 1px solid rgba(16, 185, 129, 0.3) !important;
    }

    .faq-status-badge-inactive {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        background-color: #f3f4f6;
        color: #6b7280;
        cursor: pointer;
        border: none;
    }
    .dark .faq-status-badge-inactive {
        background-color: rgba(31, 41, 55, 0.6) !important;
        color: #9ca3af !important;
        border: 1px solid rgba(75, 85, 99, 0.3) !important;
    }

    /* Action Buttons */
    .faq-action-btn-edit {
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
    .faq-action-btn-edit:hover {
        background-color: #bae6fd;
        color: #0369a1;
    }
    .dark .faq-action-btn-edit {
        background-color: rgba(12, 74, 110, 0.4) !important;
        color: #38bdf8 !important;
    }

    .faq-action-btn-delete {
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
    .faq-action-btn-delete:hover {
        background-color: #fca5a5;
        color: #dc2626;
    }
    .dark .faq-action-btn-delete {
        background-color: rgba(153, 27, 27, 0.35) !important;
        color: #f87171 !important;
    }

    /* Sequence Control Buttons (Up / Down) */
    .faq-seq-btn {
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
    .faq-seq-btn:hover:not(:disabled) {
        background-color: #cbd5e1;
        color: #0f172a;
    }
    .faq-seq-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    .dark .faq-seq-btn {
        background-color: #1e293b;
        color: #94a3b8;
    }
    .dark .faq-seq-btn:hover:not(:disabled) {
        background-color: #334155;
        color: #f8fafc;
    }

    /* Drag Handle */
    .faq-drag-handle {
        cursor: grab;
        color: #94a3b8;
        padding: 0.35rem;
        display: inline-flex;
        align-items: center;
    }
    .dark .faq-drag-handle {
        color: #475569;
    }
    .faq-drag-handle:hover {
        color: #334155;
    }
    .dark .faq-drag-handle:hover {
        color: #94a3b8;
    }

    /* Modal Drawer Inputs */
    .faq-modal-input, .faq-modal-textarea, .faq-modal-select {
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
    .dark .faq-modal-input, .dark .faq-modal-textarea, .dark .faq-modal-select {
        background-color: #111827 !important;
        border-color: #1f2937 !important;
        color: #f8fafc !important;
    }
    .dark .faq-modal-select option {
        background-color: #111827 !important;
        color: #f8fafc !important;
    }
</style>

<div x-data="faqComponent()" x-init="initSortable()" class="p-6 md:p-10 max-w-6xl mx-auto">

    <!-- Header Section + Add New FAQ Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                General FAQs (<span x-text="faqs.length"></span>)
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 font-medium">
                Manage frequently asked questions. Use ▲ ▼ buttons or Drag Handle to adjust sequence order.
            </p>
        </div>

        <button @click="openCreate()"
                type="button"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-skin-base hover:opacity-90 active:scale-[0.99] text-white font-bold text-sm rounded-full shadow-md transition cursor-pointer self-start sm:self-auto">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>+ Add New FAQ</span>
        </button>
    </div>

    <!-- FAQ Table Card -->
    <div class="faq-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="faq-table-head">
                        <th class="faq-th w-32 text-center rounded-l-xl">SEQUENCE</th>
                        <th class="faq-th">QUESTION</th>
                        <th class="faq-th">CREATED DATE</th>
                        <th class="faq-th">UPDATED DATE</th>
                        <th class="faq-th text-center">STATUS</th>
                        <th class="faq-th text-right rounded-r-xl">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="faq-table-body">
                    <template x-for="(item, idx) in faqs" :key="idx">
                        <tr class="faq-row" :data-id="idx">
                            <td class="py-4 px-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Drag Handle -->
                                    <span class="faq-drag-handle" title="Drag to reorder sequence">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7 2a2 2 0 10.001 4.001A2 2 0 007 2zm0 6a2 2 0 10.001 4.001A2 2 0 007 8zm0 6a2 2 0 10.001 4.001A2 2 0 007 14zm6-12a2 2 0 10.001 4.001A2 2 0 0013 2zm0 6a2 2 0 10.001 4.001A2 2 0 0013 8zm0 6a2 2 0 10.001 4.001A2 2 0 0013 14z"/>
                                        </svg>
                                    </span>

                                    <!-- Sequence Number -->
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-800 px-2.5 py-1 rounded-md" x-text="idx + 1"></span>

                                    <!-- Up / Down Arrow Sequencer Buttons -->
                                    <div class="flex flex-col gap-0.5">
                                        <button @click="moveUp(idx)"
                                                :disabled="idx === 0"
                                                type="button"
                                                class="faq-seq-btn"
                                                title="Move Up">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                                            </svg>
                                        </button>
                                        <button @click="moveDown(idx)"
                                                :disabled="idx === faqs.length - 1"
                                                type="button"
                                                class="faq-seq-btn"
                                                title="Move Down">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 faq-question-text" x-text="item.question"></td>
                            <td class="py-4 px-4 faq-date-text" x-text="item.created_at || 'N/A'"></td>
                            <td class="py-4 px-4 faq-date-text" x-text="item.updated_at || 'N/A'"></td>
                            <td class="py-4 px-4 text-center">
                                <button @click="toggleStatus(idx)"
                                        type="button"
                                        :class="item.status === 'active' ? 'faq-status-badge-active' : 'faq-status-badge-inactive'"
                                        x-text="item.status === 'active' ? 'Active' : 'Inactive'">
                                </button>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Update / Edit Icon -->
                                    <button @click="openEdit(idx)"
                                            type="button"
                                            class="faq-action-btn-edit"
                                            title="Update FAQ">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <!-- Delete Icon -->
                                    <button @click="deleteFaq(idx)"
                                            type="button"
                                            class="faq-action-btn-delete"
                                            title="Delete FAQ">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template x-if="faqs.length === 0">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500 dark:text-gray-400 font-medium">
                                No FAQs found. Click "+ Add New FAQ" to create one.
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
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100" x-text="isEdit ? 'Update FAQ' : 'Add New FAQ'"></h3>
                    <button @click="openDrawer = false" type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Drawer Body Form Fields -->
                <div class="p-6 space-y-6 flex-1 overflow-y-auto">
                    <!-- Question -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Question <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               x-model="question"
                               placeholder="e.g. How does the 14-day free trial work?"
                               class="faq-modal-input">
                    </div>

                    <!-- Answer -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Answer <span class="text-red-500">*</span>
                        </label>
                        <textarea x-model="answer"
                                  rows="5"
                                  placeholder="Enter detailed answer..."
                                  class="faq-modal-textarea"></textarea>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select x-model="status" class="faq-modal-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Drawer Footer Action Buttons -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-[#070A14] flex items-center justify-end gap-3">
                    <button @click="openDrawer = false" type="button" class="px-5 py-2.5 bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold text-xs rounded-xl transition cursor-pointer">
                        Cancel
                    </button>
                    <button @click="saveFaq()" type="button" class="px-5 py-2.5 bg-skin-base text-white font-bold text-xs rounded-xl shadow-md hover:opacity-90 transition cursor-pointer">
                        <span x-text="isEdit ? 'Update FAQ' : 'Save FAQ'"></span>
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- SortableJS library for smooth drag-and-drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    function faqComponent() {
        return {
            openDrawer: false,
            isEdit: false,
            editIndex: null,
            question: '',
            answer: '',
            status: 'active',
            faqs: @json($faqs),

            initSortable() {
                this.$nextTick(() => {
                    const tbody = document.getElementById('faq-table-body');
                    if (tbody && typeof Sortable !== 'undefined') {
                        const self = this;
                        new Sortable(tbody, {
                            handle: '.faq-drag-handle',
                            animation: 150,
                            onEnd(evt) {
                                if (evt.oldIndex !== undefined && evt.newIndex !== undefined && evt.oldIndex !== evt.newIndex) {
                                    const movedItem = self.faqs.splice(evt.oldIndex, 1)[0];
                                    self.faqs.splice(evt.newIndex, 0, movedItem);
                                    self.syncDb('reordered');
                                }
                            }
                        });
                    }
                });
            },

            openCreate() {
                this.isEdit = false;
                this.editIndex = null;
                this.question = '';
                this.answer = '';
                this.status = 'active';
                this.openDrawer = true;
            },

            openEdit(idx) {
                this.isEdit = true;
                this.editIndex = idx;
                const item = this.faqs[idx];
                if (item) {
                    this.question = item.question || '';
                    this.answer = item.answer || '';
                    this.status = item.status || 'active';
                    this.openDrawer = true;
                }
            },

            saveFaq() {
                if (!this.question.trim() || !this.answer.trim()) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Validation Error', 'Please enter both Question and Answer.', 'warning');
                    } else {
                        alert('Please enter both Question and Answer.');
                    }
                    return;
                }

                const now = new Date().toLocaleString('en-US', { month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });

                if (this.isEdit && this.editIndex !== null && this.faqs[this.editIndex]) {
                    this.faqs[this.editIndex].question = this.question;
                    this.faqs[this.editIndex].answer = this.answer;
                    this.faqs[this.editIndex].status = this.status;
                    this.faqs[this.editIndex].updated_at = now;
                } else {
                    this.faqs.push({
                        id: Date.now(),
                        question: this.question,
                        answer: this.answer,
                        status: this.status,
                        created_at: now,
                        updated_at: now
                    });
                }

                this.openDrawer = false;
                this.syncDb('saved');
            },

            deleteFaq(idx) {
                const self = this;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Delete FAQ?',
                        text: 'Are you sure you want to delete this FAQ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel',
                        customClass: { popup: 'rounded-3xl shadow-2xl' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            self.faqs.splice(idx, 1);
                            self.syncDb('deleted');
                        }
                    });
                } else {
                    if (confirm('Are you sure you want to delete this FAQ?')) {
                        self.faqs.splice(idx, 1);
                        self.syncDb('deleted');
                    }
                }
            },

            toggleStatus(idx) {
                if (this.faqs[idx]) {
                    this.faqs[idx].status = this.faqs[idx].status === 'active' ? 'inactive' : 'active';
                    this.syncDb('status');
                }
            },

            /* Move Sequence Up */
            moveUp(idx) {
                if (idx > 0) {
                    const temp = this.faqs[idx];
                    this.faqs[idx] = this.faqs[idx - 1];
                    this.faqs[idx - 1] = temp;
                    this.faqs = [...this.faqs];
                    this.syncDb('reordered');
                }
            },

            /* Move Sequence Down */
            moveDown(idx) {
                if (idx < this.faqs.length - 1) {
                    const temp = this.faqs[idx];
                    this.faqs[idx] = this.faqs[idx + 1];
                    this.faqs[idx + 1] = temp;
                    this.faqs = [...this.faqs];
                    this.syncDb('reordered');
                }
            },

            syncDb(actionType = 'saved') {
                fetch('{{ route('superadmin.website-settings.faqs.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ faqs: this.faqs })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            let msg = 'FAQ saved successfully.';
                            if (actionType === 'deleted') msg = 'FAQ deleted successfully.';
                            if (actionType === 'status') msg = 'FAQ status updated successfully.';
                            if (actionType === 'reordered') msg = 'FAQ sequence updated successfully.';

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
                            Swal.fire('Error', data.message || 'Failed to update FAQs.', 'error');
                        }
                    }
                })
                .catch(err => {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error', 'Failed to sync FAQs with database.', 'error');
                    }
                });
            }
        };
    }
</script>
@endsection

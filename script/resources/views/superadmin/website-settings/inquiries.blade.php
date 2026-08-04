@extends('layouts.app')

@section('content')
<style>
    /* Search Bar & Dropdown Container */
    .inquiry-controls-grid {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        width: 100%;
        margin-bottom: 1.5rem;
    }
    @media (min-width: 640px) {
        .inquiry-controls-grid {
            flex-direction: row;
            align-items: center;
        }
    }

    .inquiry-search-wrapper {
        position: relative;
        flex: 1;
    }
    .inquiry-search-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        width: 1.125rem;
        height: 1.125rem;
        color: #94a3b8;
        pointer-events: none;
    }
    .dark .inquiry-search-icon {
        color: #64748b;
    }
    .inquiry-search-input {
        width: 100%;
        height: 3.25rem;
        padding-left: 3rem;
        padding-right: 1.25rem;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc !important;
        color: #0f172a !important;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02);
    }
    .inquiry-search-input::placeholder {
        color: #94a3b8;
    }
    .inquiry-search-input:focus {
        border-color: var(--color-base, #00b692) !important;
        box-shadow: 0 0 0 3px rgba(0, 182, 146, 0.15) !important;
    }
    .dark .inquiry-search-input {
        background-color: #080d1a !important;
        border-color: #1e293b !important;
        color: #f8fafc !important;
    }
    .dark .inquiry-search-input::placeholder {
        color: #64748b !important;
    }

    /* Category Dropdown Select */
    .inquiry-category-select {
        height: 3.25rem;
        padding-left: 1.25rem;
        padding-right: 2.5rem;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc !important;
        color: #0f172a !important;
        font-size: 0.875rem;
        font-weight: 500;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
        min-width: 14rem;
    }
    .inquiry-category-select:focus {
        border-color: var(--color-base, #00b692) !important;
        box-shadow: 0 0 0 3px rgba(0, 182, 146, 0.15) !important;
    }
    .dark .inquiry-category-select {
        background-color: #080d1a !important;
        border-color: #1e293b !important;
        color: #f8fafc !important;
    }
    .dark .inquiry-category-select option {
        background-color: #0d1424 !important;
        color: #f8fafc !important;
    }

    /* Card Container */
    .inquiry-card {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 28px !important;
        padding: 1.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }
    .dark .inquiry-card {
        background-color: #060a14 !important;
        border-color: #161f33 !important;
    }

    /* Table Header */
    .inquiry-table-head {
        background-color: #edf2f7;
        border-radius: 12px;
    }
    .dark .inquiry-table-head {
        background-color: #0d1424 !important;
    }
    .inquiry-th {
        padding: 1.125rem 1.25rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #334155;
    }
    .dark .inquiry-th {
        color: #94a3b8 !important;
    }

    /* Table Rows */
    .inquiry-row {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .dark .inquiry-row {
        border-bottom-color: #11192e !important;
    }
    .inquiry-row:last-child {
        border-bottom: none;
    }

    .inquiry-client-name {
        font-size: 0.875rem;
        font-weight: 700;
        color: #1e293b;
    }
    .dark .inquiry-client-name {
        color: #f8fafc !important;
    }

    .inquiry-text {
        font-size: 0.875rem;
        color: #64748b;
    }
    .dark .inquiry-text {
        color: #94a3b8 !important;
    }

    /* Category Pill Badge */
    .inquiry-category-pill {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        background-color: #e2e8f0;
        color: #334155;
    }
    .dark .inquiry-category-pill {
        background-color: rgba(30, 41, 59, 0.8) !important;
        color: #cbd5e1 !important;
        border: 1px solid #334155 !important;
    }

    /* Action Delete Button Badge */
    .inquiry-delete-btn {
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
    .inquiry-delete-btn:hover {
        background-color: #fca5a5;
        color: #dc2626;
    }
    .dark .inquiry-delete-btn {
        background-color: rgba(153, 27, 27, 0.35) !important;
        color: #f87171 !important;
    }
    .dark .inquiry-delete-btn:hover {
        background-color: rgba(185, 28, 28, 0.55) !important;
        color: #fca5a5 !important;
    }
</style>

<div class="p-6 md:p-10 max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                Project Inquiries (<span id="inquiry-count-display">{{ $inquiriesCount }}</span>)
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 font-medium">
                Review submissions from potential business clients.
            </p>
        </div>
    </div>

    <!-- Controls Row (Search Box + Category Dropdown) -->
    <div class="inquiry-controls-grid">
        <!-- Search Box -->
        <div class="inquiry-search-wrapper">
            <svg class="inquiry-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text"
                   id="inquiry-search-box"
                   class="inquiry-search-input"
                   placeholder="Search by client name, email, or message...">
        </div>

        <!-- Category Dropdown Select -->
        <div>
            <select id="inquiry-category-filter" class="inquiry-category-select">
                <option value="">All Categories</option>
                <option value="Digital QR Menu System">Digital QR Menu System</option>
                <option value="POS & Order Billing">POS & Order Billing</option>
                <option value="Table Booking & Tracking">Table Booking & Tracking</option>
                <option value="General Inquiry">General Inquiry</option>
                <option value="AI / ML Solution">AI / ML Solution</option>
                <option value="Mobile Application">Mobile Application</option>
                <option value="Web Application">Web Application</option>
            </select>
        </div>
    </div>

    <!-- Inquiries Table Card -->
    <div class="inquiry-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="inquiry-table-head">
                        <th class="inquiry-th rounded-l-xl">CLIENT NAME</th>
                        <th class="inquiry-th">EMAIL ADDRESS</th>
                        <th class="inquiry-th">PHONE NUMBER</th>
                        <th class="inquiry-th">CATEGORY</th>
                        <th class="inquiry-th">SUBMITTED DATE</th>
                        <th class="inquiry-th text-right rounded-r-xl">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="inquiry-table-body">
                    @forelse($inquiries as $inquiry)
                        <tr class="inquiry-row" id="inquiry-row-{{ $inquiry->id }}" data-category="{{ $inquiry->category }}">
                            <td class="py-4 px-5 inquiry-client-name">{{ $inquiry->name ?? 'Client' }}</td>
                            <td class="py-4 px-5 inquiry-text">{{ $inquiry->email }}</td>
                            <td class="py-4 px-5 inquiry-text">{{ $inquiry->phone ?? 'N/A' }}</td>
                            <td class="py-4 px-5">
                                <span class="inquiry-category-pill">{{ $inquiry->category ?? 'General Inquiry' }}</span>
                            </td>
                            <td class="py-4 px-5 inquiry-text">{{ $inquiry->created_at ? $inquiry->created_at->format('M d, Y h:i A') : 'N/A' }}</td>
                            <td class="py-4 px-5 text-right">
                                <button onclick="deleteInquiry({{ $inquiry->id }})" type="button" class="inquiry-delete-btn" title="Delete inquiry">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-inquiry-row">
                            <td colspan="6" class="py-12 text-center text-gray-500 dark:text-gray-400 font-medium">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3 stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <span>No project inquiries found in the system.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function filterInquiries() {
        const query = document.getElementById('inquiry-search-box')?.value.toLowerCase() || '';
        const selectedCategory = document.getElementById('inquiry-category-filter')?.value.toLowerCase() || '';
        const rows = document.querySelectorAll('#inquiry-table-body tr.inquiry-row');

        rows.forEach(row => {
            const name = row.querySelector('.inquiry-client-name')?.textContent.toLowerCase() || '';
            const email = row.querySelector('.inquiry-text')?.textContent.toLowerCase() || '';
            const category = row.getAttribute('data-category')?.toLowerCase() || '';

            const matchesSearch = name.includes(query) || email.includes(query);
            const matchesCategory = !selectedCategory || category === selectedCategory;

            if (matchesSearch && matchesCategory) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById('inquiry-search-box')?.addEventListener('input', filterInquiries);
    document.getElementById('inquiry-category-filter')?.addEventListener('change', filterInquiries);

    function deleteInquiry(id) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Delete Inquiry?',
                text: 'Are you sure you want to delete this inquiry record?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-3xl shadow-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    executeInquiryDelete(id);
                }
            });
        } else {
            if (confirm('Are you sure you want to delete this inquiry record?')) {
                executeInquiryDelete(id);
            }
        }
    }

    function executeInquiryDelete(id) {
        fetch(`{{ url('website-settings/inquiries') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById(`inquiry-row-${id}`);
                if (row) row.remove();
                
                const countElem = document.getElementById('inquiry-count-display');
                if (countElem) {
                    const current = parseInt(countElem.textContent) || 0;
                    countElem.textContent = Math.max(0, current - 1);
                }

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Project inquiry record deleted successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Error', data.message || 'Error deleting inquiry.', 'error');
                } else {
                    alert(data.message || 'Error deleting inquiry.');
                }
            }
        })
        .catch(err => {
            if (typeof Swal !== 'undefined') {
                Swal.fire('Error', 'Failed to delete inquiry record.', 'error');
            } else {
                alert('Failed to delete inquiry record.');
            }
        });
    }
</script>
@endsection

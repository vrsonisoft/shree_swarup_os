@extends('layouts.app')

@section('content')
<style>
    /* Search Bar Input */
    .subscriber-search-wrapper {
        position: relative;
        width: 100%;
    }
    .subscriber-search-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        width: 1.125rem;
        height: 1.125rem;
        color: #94a3b8;
        pointer-events: none;
    }
    .dark .subscriber-search-icon {
        color: #64748b;
    }
    .subscriber-search-input {
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
    .subscriber-search-input::placeholder {
        color: #94a3b8;
    }
    .subscriber-search-input:focus {
        border-color: var(--color-base, #00b692) !important;
        box-shadow: 0 0 0 3px rgba(0, 182, 146, 0.15) !important;
    }
    .dark .subscriber-search-input {
        background-color: #080d1a !important;
        border-color: #1e293b !important;
        color: #f8fafc !important;
    }
    .dark .subscriber-search-input::placeholder {
        color: #64748b !important;
    }

    /* Card Container */
    .subscriber-card {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 28px !important;
        padding: 1.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03);
        margin-top: 1.5rem;
        overflow: hidden;
    }
    .dark .subscriber-card {
        background-color: #060a14 !important;
        border-color: #161f33 !important;
    }

    /* Table Header */
    .subscriber-table-head {
        background-color: #edf2f7;
        border-radius: 12px;
    }
    .dark .subscriber-table-head {
        background-color: #0d1424 !important;
    }
    .subscriber-th {
        padding: 1.125rem 1.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #334155;
    }
    .dark .subscriber-th {
        color: #94a3b8 !important;
    }

    /* Table Rows */
    .subscriber-row {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .dark .subscriber-row {
        border-bottom-color: #11192e !important;
    }
    .subscriber-row:last-child {
        border-bottom: none;
    }

    .subscriber-email {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1e293b;
    }
    .dark .subscriber-email {
        color: #f8fafc !important;
    }

    .subscriber-date {
        font-size: 0.875rem;
        color: #64748b;
    }
    .dark .subscriber-date {
        color: #94a3b8 !important;
    }

    /* Delete Button Badge */
    .subscriber-delete-btn {
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
    .subscriber-delete-btn:hover {
        background-color: #fca5a5;
        color: #dc2626;
    }
    .dark .subscriber-delete-btn {
        background-color: rgba(153, 27, 27, 0.35) !important;
        color: #f87171 !important;
    }
    .dark .subscriber-delete-btn:hover {
        background-color: rgba(185, 28, 28, 0.55) !important;
        color: #fca5a5 !important;
    }
</style>

<div class="p-6 md:p-10 max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                Newsletter Subscribers (<span id="subscriber-count-display">{{ $subscribesCount }}</span>)
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 font-medium">
                Email contacts registered to receive technology bulletins.
            </p>
        </div>
    </div>

    <!-- Search Input Box -->
    <div class="subscriber-search-wrapper">
        <svg class="subscriber-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text"
               id="subscriber-search-box"
               class="subscriber-search-input"
               placeholder="Search subscribers by email address...">
    </div>

    <!-- Subscriber Table Card -->
    <div class="subscriber-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="subscriber-table-head">
                        <th class="subscriber-th rounded-l-xl">EMAIL ADDRESS</th>
                        <th class="subscriber-th">SUBSCRIBED DATE</th>
                        <th class="subscriber-th text-right rounded-r-xl">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="subscriber-table-body">
                    @forelse($subscribers as $sub)
                        <tr class="subscriber-row" id="subscriber-row-{{ $sub->id }}">
                            <td class="py-4 px-6 subscriber-email">{{ $sub->email }}</td>
                            <td class="py-4 px-6 subscriber-date">{{ $sub->created_at ? \Carbon\Carbon::parse($sub->created_at)->format('M d, Y h:i A') : 'N/A' }}</td>
                            <td class="py-4 px-6 text-right">
                                <button onclick="deleteSubscriber({{ $sub->id }})" type="button" class="subscriber-delete-btn" title="Delete subscriber">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-subscriber-row">
                            <td colspan="3" class="py-12 text-center text-gray-500 dark:text-gray-400 font-medium">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3 stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span>No newsletter subscribers found.</span>
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
    document.getElementById('subscriber-search-box')?.addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#subscriber-table-body tr.subscriber-row');
        rows.forEach(row => {
            const email = row.querySelector('.subscriber-email')?.textContent.toLowerCase() || '';
            if (email.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    function deleteSubscriber(id) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Remove Subscriber?',
                text: 'Are you sure you want to remove this email address?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Remove',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-3xl shadow-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    executeSubscriberDelete(id);
                }
            });
        } else {
            if (confirm('Are you sure you want to remove this subscriber?')) {
                executeSubscriberDelete(id);
            }
        }
    }

    function executeSubscriberDelete(id) {
        fetch(`{{ url('website-settings/subscribes') }}/${id}`, {
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
                const row = document.getElementById(`subscriber-row-${id}`);
                if (row) row.remove();

                const countElem = document.getElementById('subscriber-count-display');
                if (countElem) {
                    const current = parseInt(countElem.textContent) || 0;
                    countElem.textContent = Math.max(0, current - 1);
                }

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Removed!',
                        text: 'Subscriber removed successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Error', data.message || 'Error removing subscriber.', 'error');
                } else {
                    alert(data.message || 'Error removing subscriber.');
                }
            }
        })
        .catch(err => {
            if (typeof Swal !== 'undefined') {
                Swal.fire('Error', 'Failed to remove subscriber record.', 'error');
            } else {
                alert('Failed to remove subscriber record.');
            }
        });
    }
</script>
@endsection

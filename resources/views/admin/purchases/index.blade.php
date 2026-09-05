@extends('layouts.admin')

@section('header_title', 'Purchases Management')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full mx-auto">
    <div class="flex items-center justify-between mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-purple-600/10 to-transparent p-4 border-l-4 border-purple-500">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Report Purchases</h2>
            <p class="text-gray-400 text-sm mt-1">View and manage customer report purchase logs.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-4 rounded-xl flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search Form -->
    <div class="mb-6 flex justify-end">
        <form method="GET" action="{{ route('admin.purchases.index') }}" class="relative w-full max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." class="w-full bg-gray-900/50 border border-gray-700/50 text-white pl-4 pr-10 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors shadow-inner">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto bg-gray-900/50 rounded-2xl border border-gray-800 shadow-inner">
        <table class="w-full text-left text-sm text-gray-400">
            <thead class="text-[10px] text-gray-400 uppercase font-bold tracking-wider bg-[#1B2230] border-b border-gray-700/50">
                <tr>
                    <th scope="col" class="px-5 py-4">SR</th>
                    <th scope="col" class="px-5 py-4 min-w-[200px]">CUSTOMER</th>
                    <th scope="col" class="px-5 py-4 min-w-[200px]">REPORT</th>
                    <th scope="col" class="px-5 py-4">LICENSE</th>
                    <th scope="col" class="px-5 py-4">STATUS</th>
                    <th scope="col" class="px-5 py-4">DATE</th>
                    <th scope="col" class="px-5 py-4 text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchases as $index => $purchase)
                <tr class="border-b border-gray-700/50 last:border-0 hover:bg-[#1B2230]/50 transition-colors bg-[#151B26]">
                    <td class="px-5 py-4 text-gray-300 font-medium whitespace-nowrap">{{ $purchases->firstItem() + $index }}</td>
                    <td class="px-5 py-4">
                        <div class="font-medium text-gray-200">{{ $purchase->customer_name }}</div>
                        <div class="text-[11px] text-purple-400 mt-0.5">{{ $purchase->email }}</div>
                    </td>
                    <td class="px-5 py-4 text-gray-300">
                        {{ $purchase->reportDetail->title ?? 'Unknown Report' }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="font-semibold text-gray-300 uppercase text-[11px]">{{ $purchase->pricing->title ?? 'Unknown' }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">${{ number_format($purchase->pricing->cost ?? 0, 2) }}</div>
                    </td>
                    <td class="px-5 py-4">
                        @if(strtolower($purchase->payment_status) === 'completed' || strtolower($purchase->payment_status) === 'success')
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-[11px] font-bold bg-[#044c3c] text-emerald-400 border border-emerald-500/20 shadow-inner uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                Completed
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-[11px] font-bold bg-[#4c3f0c] text-amber-400 border border-amber-500/20 shadow-inner uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                {{ $purchase->payment_status ?? 'Pending' }}
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-400 whitespace-nowrap">
                        {{ $purchase->created_at->format('M d, Y h:i A') }}
                    </td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" class="flex items-center justify-center w-8 h-8 rounded bg-[#4c1d1a]/50 hover:bg-[#4c1d1a] text-rose-400 transition-colors border border-rose-900/30 shadow-sm" title="Delete" onclick="openDeleteModal('{{ $purchase->id }}', '{{ htmlspecialchars($purchase->customer_name, ENT_QUOTES) }}')">
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">No purchases found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-end">
        {{ $purchases->links('pagination::tailwind') }}
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm transition-opacity" style="opacity: 0;">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden transform scale-95 transition-all duration-200" id="deleteModalPanel">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-rose-500/10 rounded-full mb-4 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            <h3 class="text-lg font-medium text-gray-100 text-center mb-2">Delete Purchase Log</h3>
            <p class="text-sm text-gray-400 text-center" id="deleteModalMessage">Are you sure you want to remove the purchase record for <span id="deleteModalCustomer" class="text-gray-300 font-semibold break-all"></span>?</p>
        </div>
        
        <form id="deleteModalForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex border-t border-gray-700 bg-gray-800/50">
                <button 
                    type="button"
                    onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-3.5 text-sm font-medium text-gray-400 hover:text-gray-200 hover:bg-gray-700/50 transition-colors border-r border-gray-700 outline-none"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="flex-1 px-4 py-3.5 text-sm font-medium text-rose-500 hover:bg-rose-500/10 hover:text-rose-400 transition-colors outline-none"
                >
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(id, customer) {
        const modal = document.getElementById('deleteModal');
        const modalPanel = document.getElementById('deleteModalPanel');
        
        document.getElementById('deleteModalCustomer').innerText = customer;
        document.getElementById('deleteModalForm').action = `{{ route('admin.purchases.destroy', ':id') }}`.replace(':id', id);
        
        modal.classList.remove('hidden');
        void modal.offsetWidth; // Trigger reflow
        modal.style.opacity = '1';
        modalPanel.classList.remove('scale-95');
        modalPanel.classList.add('scale-100');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const modalPanel = document.getElementById('deleteModalPanel');
        
        modal.style.opacity = '0';
        modalPanel.classList.remove('scale-100');
        modalPanel.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
</script>
@endsection

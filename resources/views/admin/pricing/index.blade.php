@extends('layouts.admin')

@section('header_title', 'Global Pricing Setup')

@section('content')
<div class="h-full relative flex flex-col min-h-0 w-full overflow-y-auto overflow-x-hidden">
    <div class="flex justify-between items-center mb-6 shrink-0">
        <h2 class="text-2xl font-medium text-white tracking-tight">Global Pricing Setup</h2>
        @if($pricings->count() < 3)
            <button onclick="openModal('create')" class="bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-400 hover:to-emerald-500 text-white font-medium py-2 px-6 rounded-xl shadow-lg transition-all">
                Add New Pricing
            </button>
        @else
            <span class="text-sm text-gray-400 bg-gray-800/50 px-4 py-2 rounded-lg border border-gray-700">Maximum limit (3) reached</span>
        @endif
    </div>

    <!-- Pricing Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 shrink-0 pb-10">
        @forelse($pricings as $pricing)
            <div class="bg-gray-800/40 rounded-3xl p-6 shadow-2xl border flex flex-col relative
                        {{ $pricing->status === 'Active' ? 'border-teal-500/30 shadow-teal-500/5' : 'border-gray-700/50' }}">
                <div class="absolute top-4 right-4">
                    @if($pricing->status === 'Active')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-emerald-500/10 text-emerald-400 border-emerald-500/20">Active</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-gray-500/10 text-gray-400 border-gray-500/20">Inactive</span>
                    @endif
                </div>

                <h3 class="text-xl font-semibold text-white mb-2 pr-16">{{ $pricing->title }}</h3>
                <div class="mb-4">
                    <span class="text-3xl font-bold text-gray-100">${{ number_format($pricing->cost, 2) }}</span>
                    @if($pricing->discount_cost)
                        <span class="text-sm font-medium text-rose-400 line-through ml-2">${{ number_format($pricing->discount_cost, 2) }}</span>
                    @endif
                </div>

                <div class="text-gray-400 text-sm whitespace-pre-line flex-grow mb-6">
                    {{ $pricing->details ?: 'No details provided.' }}
                </div>

                <div class="flex items-center gap-3 mt-auto pt-4 border-t border-gray-700/50">
                    <button type="button" 
                            data-id="{{ $pricing->id }}"
                            data-title="{{ $pricing->title }}"
                            data-cost="{{ $pricing->cost }}"
                            data-discount="{{ $pricing->discount_cost }}"
                            data-details="{{ $pricing->details }}"
                            data-status="{{ $pricing->status }}"
                            onclick="openEditModal(this)"
                            class="flex-1 bg-gray-700/50 hover:bg-gray-700 text-white font-medium py-2 rounded-xl transition-colors">
                        Edit
                    </button>
                    <button type="button" 
                            data-id="{{ $pricing->id }}"
                            data-title="{{ $pricing->title }}"
                            onclick="openDeleteModal(this)"
                            class="flex-1 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-medium py-2 rounded-xl transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center p-12 bg-gray-800/40 rounded-3xl border border-gray-700/50 text-gray-400">
                <svg class="w-16 h-16 mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-lg">No pricing options configured yet.</p>
                <p class="text-sm mt-1">Add your standard, single-user, or enterprise licenses.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Add / Edit Modal -->
<div id="pricingModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm transition-opacity" style="opacity: 0;">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl max-w-lg w-full flex flex-col max-h-[90vh] overflow-hidden transform scale-95 transition-all duration-200" id="pricingModalPanel">
        <div class="flex justify-between items-center p-6 border-b border-gray-700 shrink-0">
            <h3 class="text-lg font-medium text-gray-200" id="pricingModalTitle">Add New Pricing</h3>
            <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form id="pricingForm" method="POST" action="" class="flex flex-col overflow-hidden min-h-0">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="p-6 space-y-5 overflow-y-auto flex-1 custom-scrollbar">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Plan Title</label>
                    <input type="text" name="title" id="titleInput" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Main Cost (Actual Price in USD)</label>
                    <input type="number" step="0.01" name="cost" id="costInput" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Crossed Out Text (Inflated Price in USD) - Optional</label>
                    <input type="number" step="0.01" name="discount_cost" id="discountInput" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Pricing Details (One feature per line)</label>
                    <textarea name="details" id="detailsInput" rows="5" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 resize-y"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select name="status" id="statusInput" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 appearance-none">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-900/50 border-t border-gray-700 flex justify-end gap-4 shrink-0">
                <button type="button" onclick="closeModal()" class="px-6 py-2.5 text-sm font-medium text-gray-300 hover:text-white transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-lg transition-colors">
                    Save Options
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm transition-opacity" style="opacity: 0;">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden transform scale-95 transition-all duration-200" id="deleteModalPanel">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-rose-500/10 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            <h3 class="text-lg font-medium text-gray-200 text-center mb-2">Delete Pricing Option</h3>
            <p class="text-sm text-gray-400 text-center" id="deleteModalMessage">Are you sure you want to delete this pricing option?</p>
        </div>
        
        <form id="deleteModalForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex border-t border-gray-700">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-3 text-sm font-medium text-gray-400 hover:text-gray-200 hover:bg-gray-700/50 transition-colors border-r border-gray-700 outline-none">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-3 text-sm font-medium text-rose-500 hover:bg-rose-500/10 transition-colors outline-none">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(mode) {
        const modal = document.getElementById('pricingModal');
        const modalPanel = document.getElementById('pricingModalPanel');
        const title = document.getElementById('pricingModalTitle');
        const form = document.getElementById('pricingForm');
        const method = document.getElementById('formMethod');
        
        if (mode === 'create') {
            title.innerText = 'Add New Pricing';
            form.action = "{{ route('admin.pricing.store') }}";
            method.value = 'POST';
            form.reset();
        }
        
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.style.opacity = '1';
        modalPanel.classList.remove('scale-95');
        modalPanel.classList.add('scale-100');
    }

    function openEditModal(button) {
        openModal('edit');
        const title = document.getElementById('pricingModalTitle');
        const form = document.getElementById('pricingForm');
        const method = document.getElementById('formMethod');
        
        const id = button.getAttribute('data-id');
        const titleText = button.getAttribute('data-title');
        const cost = button.getAttribute('data-cost');
        const discount = button.getAttribute('data-discount');
        const details = button.getAttribute('data-details');
        const status = button.getAttribute('data-status');
        
        title.innerText = 'Edit Pricing';
        form.action = `{{ url('/admin/pricing-setup') }}/${id}`;
        method.value = 'PUT';
        
        document.getElementById('titleInput').value = titleText;
        document.getElementById('costInput').value = cost;
        document.getElementById('discountInput').value = discount === '' ? '' : discount;
        document.getElementById('statusInput').value = status;
        document.getElementById('detailsInput').value = details;
    }

    function closeModal() {
        const modal = document.getElementById('pricingModal');
        const modalPanel = document.getElementById('pricingModalPanel');
        
        modal.style.opacity = '0';
        modalPanel.classList.remove('scale-100');
        modalPanel.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function openDeleteModal(button) {
        const modal = document.getElementById('deleteModal');
        const modalPanel = document.getElementById('deleteModalPanel');
        const message = document.getElementById('deleteModalMessage');
        const form = document.getElementById('deleteModalForm');
        
        const id = button.getAttribute('data-id');
        const titleText = button.getAttribute('data-title');
        
        message.innerText = `Are you sure you want to delete '${titleText}'?`;
        form.action = `{{ url('/admin/pricing-setup') }}/${id}`;
        
        modal.classList.remove('hidden');
        void modal.offsetWidth;
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

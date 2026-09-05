@extends('layouts.admin')

@section('header_title', 'Contact Us Submissions')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full mx-auto">
    <!-- Decorative Blob -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 relative z-10 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Contact Us Data</h2>
            <p class="text-gray-400 text-sm mt-1">Manage and view messages submitted from the Contact Us page.</p>
        </div>

        <!-- Search Form -->
        <div class="w-full md:max-w-sm">
            <form method="GET" action="{{ route('admin.contact_us.index') }}" class="relative w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search submissions..." class="w-full bg-gray-900/50 border border-gray-700 text-white pl-4 pr-10 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors shadow-inner">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto bg-gray-900/50 rounded-2xl border border-gray-800 shadow-inner relative z-10">
        <table class="w-full text-left text-sm text-gray-400">
            <thead class="text-xs text-gray-500 uppercase bg-gray-800/50 border-b border-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium">Full Name</th>
                    <th scope="col" class="px-6 py-4 font-medium">Business EmailId</th>
                    <th scope="col" class="px-6 py-4 font-medium">Contact No.</th>
                    <th scope="col" class="px-6 py-4 font-medium">Country</th>
                    <th scope="col" class="px-6 py-4 font-medium">Company Name</th>
                    <th scope="col" class="px-6 py-4 font-medium">Message</th>
                    <th scope="col" class="px-6 py-4 font-medium">Submitted At</th>
                    <th scope="col" class="px-6 py-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                <tr class="border-b border-gray-800 last:border-0 hover:bg-gray-800/20 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">{{ $contact->full_name ?? '—' }}</td>
                    <td class="px-6 py-4">{{ $contact->email ?? '—' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $contact->phone ?? '—' }}</td>
                    <td class="px-6 py-4">{{ $contact->country ?? '—' }}</td>
                    <td class="px-6 py-4">{{ Str::limit($contact->company_name ?? '—', 20) }}</td>
                    <td class="px-6 py-4">
                        <div class="max-w-xs truncate text-sky-200" title="{{ $contact->specific_research_requirement }}">
                            {{ Str::limit($contact->specific_research_requirement, 40) ?? '—' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $contact->created_at->format('M d, Y, h:i A') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end">
                            <button type="button" class="text-sky-400 hover:text-sky-300 transition-colors bg-sky-500/10 hover:bg-sky-500/20 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-2" title="View Details" onclick="viewContact({{ json_encode($contact) }})">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Read
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">No contact submissions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-end relative z-10">
        {{ $contacts->links('pagination::tailwind') }}
    </div>

</div>

<!-- View Details Modal -->
<div id="viewContactModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity" style="opacity: 0;">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden transform scale-95 transition-all duration-200 flex flex-col max-h-[90vh]" id="viewContactPanel">
        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center bg-gray-900/50">
            <h3 class="text-lg font-bold text-gray-200">Contact Us Submission</h3>
            <button onclick="closeContactModal()" class="text-gray-400 hover:text-gray-200 transition-colors cursor-pointer p-1 rounded-md hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-800">
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Full Name</p>
                    <p class="text-gray-200 font-medium" id="c-name">—</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Business Email</p>
                    <p class="text-gray-200 font-medium">
                        <a href="#" id="c-email-link" class="text-sky-400 hover:underline">
                            <span id="c-email">—</span>
                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Contact No.</p>
                    <p class="text-gray-200 font-medium">
                        <a href="#" id="c-phone-link" class="text-sky-400 hover:underline">
                            <span id="c-phone">—</span>
                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Country</p>
                    <p class="text-gray-200 font-medium" id="c-country">—</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Company Name</p>
                    <p class="text-gray-200 font-medium" id="c-company">—</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Submitted At</p>
                    <p class="text-gray-400 text-sm" id="c-date">—</p>
                </div>
                
                <div class="md:col-span-2">
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-2">Detailed Message / Research Requirement</p>
                    <div class="bg-gray-900/50 p-5 rounded-xl border border-gray-700/50">
                        <p class="text-gray-300 text-sm leading-relaxed whitespace-pre-wrap" id="c-message">—</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-700 flex justify-end bg-gray-900/50">
            <button onclick="closeContactModal()" class="px-6 py-2.5 text-sm font-bold text-gray-300 bg-gray-700 hover:bg-gray-600 rounded-xl transition-colors border border-gray-600 shadow-sm">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    function viewContact(contact) {
        document.getElementById('c-name').innerText = contact.full_name || '—';
        
        let emailEl = document.getElementById('c-email');
        let emailLink = document.getElementById('c-email-link');
        emailEl.innerText = contact.email || '—';
        if(contact.email) {
            emailLink.href = 'mailto:' + contact.email;
            emailLink.classList.remove('pointer-events-none', 'text-gray-200');
            emailLink.classList.add('text-sky-400');
        } else {
            emailLink.href = '#';
            emailLink.classList.remove('text-sky-400');
            emailLink.classList.add('pointer-events-none', 'text-gray-200');
        }
        
        let phoneEl = document.getElementById('c-phone');
        let phoneLink = document.getElementById('c-phone-link');
        phoneEl.innerText = contact.phone || '—';
        if(contact.phone) {
            phoneLink.href = 'tel:' + contact.phone;
            phoneLink.classList.remove('pointer-events-none', 'text-gray-200');
            phoneLink.classList.add('text-sky-400');
        } else {
            phoneLink.href = '#';
            phoneLink.classList.remove('text-sky-400');
            phoneLink.classList.add('pointer-events-none', 'text-gray-200');
        }

        document.getElementById('c-company').innerText = contact.company_name || '—';
        document.getElementById('c-country').innerText = contact.country || '—';
        document.getElementById('c-message').innerText = contact.specific_research_requirement || 'No message provided.';
        
        let d = new Date(contact.created_at);
        document.getElementById('c-date').innerText = !isNaN(d.getTime()) ? d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }) : '—';
        
        const modal = document.getElementById('viewContactModal');
        const modalPanel = document.getElementById('viewContactPanel');
        
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.style.opacity = '1';
        modalPanel.classList.remove('scale-95');
        modalPanel.classList.add('scale-100');
    }
    
    function closeContactModal() {
        const modal = document.getElementById('viewContactModal');
        const modalPanel = document.getElementById('viewContactPanel');
        
        modal.style.opacity = '0';
        modalPanel.classList.remove('scale-100');
        modalPanel.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }
</script>
@endsection

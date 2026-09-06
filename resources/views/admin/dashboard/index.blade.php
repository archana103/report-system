@extends('layouts.admin')

@section('header_title', 'Dashboard Overview')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto">
    <!-- Decorative Blob -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative z-10 max-w-5xl mx-auto space-y-8">
      
      <!-- Header -->
      <h1 class="text-4xl font-medium pb-2 bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-rose-500 tracking-tight drop-shadow-sm">
        Dashboard Overview
      </h1>

      @if($errors->any())
          <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 p-4 rounded-xl flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div class="flex flex-col">
              @foreach ($errors->all() as $error)
                <span class="font-medium">{{ $error }}</span>
              @endforeach
            </div>
          </div>
      @endif

      <!-- Stats Row -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner flex flex-col justify-center">
          <h3 class="text-gray-400 font-medium mb-2">Total Categories</h3>
          <p class="text-4xl font-medium text-white">{{ $stats['categories'] ?? 0 }}</p>
        </div>
        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner flex flex-col justify-center">
          <h3 class="text-gray-400 font-medium mb-2">Active Reports</h3>
          <p class="text-4xl font-medium text-white">{{ $stats['reports'] ?? 0 }}</p>
        </div>
        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner flex flex-col justify-center">
          <h3 class="text-gray-400 font-medium mb-2">Blogs</h3>
          <p class="text-4xl font-medium text-white">{{ $stats['blogs'] ?? 0 }}</p>
        </div>
        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner flex flex-col justify-center">
          <h3 class="text-gray-400 font-medium mb-2">Press Releases</h3>
          <p class="text-4xl font-medium text-white">{{ $stats['pressReleases'] ?? 0 }}</p>
        </div>
      </div>

      <!-- Update Profile Section -->
      <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner">
        <h2 class="text-xl font-medium text-white mb-4">Profile Information</h2>
        <p class="text-sm text-gray-400 mb-6">Update your account's profile information.</p>
        
        <form action="{{ route('admin.dashboard.update_profile') }}" method="POST" class="max-w-md space-y-4">
          @csrf
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Name</label>
            <input 
              name="name"
              type="text" 
              value="{{ old('name', auth()->user()->name) }}"
              required
              class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-colors"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Email</label>
            <input 
              name="email"
              type="email" 
              value="{{ old('email', auth()->user()->email) }}"
              required
              class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-colors"
            />
          </div>
          
          <div class="flex items-center gap-4 mt-2">
            <button 
              type="submit" 
              class="bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg border border-gray-700 transition-colors"
            >
              Save
            </button>
          </div>
        </form>
      </div>

      <!-- Login Sessions Section -->
      <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
          <div>
            <h2 class="text-xl font-medium text-white mb-1">Login Sessions</h2>
            <p class="text-sm text-gray-400">Places where you're logged into admin.</p>
          </div>
          <form action="{{ route('admin.dashboard.logout_other_sessions') }}" method="POST" onsubmit="return confirm('Are you sure you want to log out all other active sessions across all devices?');">
            @csrf
            @method('DELETE')
            <button 
              type="submit"
              class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-500 border border-rose-500/30 font-medium py-2 px-4 rounded-lg transition-colors whitespace-nowrap text-sm"
            >
              Sign out all other sessions
            </button>
          </form>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm text-gray-400">
            <thead class="text-xs text-gray-500 uppercase bg-gray-800/50 border-b border-gray-700">
              <tr>
                <th scope="col" class="px-4 py-3">Device & Browser</th>
                <th scope="col" class="px-4 py-3">IP Address</th>
                <th scope="col" class="px-4 py-3">Last Active</th>
                <th scope="col" class="px-4 py-3 text-right">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($sessions as $session)
              <tr class="border-b border-gray-800 last:border-0 hover:bg-gray-800/20 transition-colors">
                <td class="px-4 py-4 font-medium text-gray-300">
                  <div class="flex items-center gap-2">
                    @if(in_array($session->os, ['macOS', 'Windows', 'Linux']))
                      <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    @else
                      <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    @endif
                    <span>{{ $session->os }} - {{ $session->browser }}</span>
                  </div>
                </td>
                <td class="px-4 py-4">{{ $session->ip_address }}</td>
                <td class="px-4 py-4">
                  @if($session->is_current_device)
                    <span class="text-emerald-400 font-medium">This device (Current Session)</span>
                  @else
                    <span>{{ $session->last_active }}</span>
                  @endif
                </td>
                <td class="px-4 py-4 text-right">
                  @if(!$session->is_current_device)
                    <form action="{{ route('admin.dashboard.logout_session', $session->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to log out this session?');">
                      @csrf
                      @method('DELETE')
                      <button 
                        type="submit"
                        class="text-gray-400 hover:text-rose-400 transition-colors"
                        title="Sign out this session"
                      >
                        <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                      </button>
                    </form>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="px-4 py-6 text-center text-gray-500">No active sessions found.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seo['title'] ?? 'Admin Login | Epignosis Insights' }}</title>
    
    <!-- Using Tailwind CSS as per original layout -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-[#0b1121] text-white font-sans relative overflow-hidden selection:bg-teal-500 selection:text-white">

    <!-- Background Image with Opacity -->
    <div
      class="absolute inset-0 bg-cover bg-center opacity-30 pointer-events-none"
      style="background-image: url('{{ env('AWS_URL') }}/assets/images/loginpageimage.jpg?v=1.1')">
    </div>

    <!-- Decorative Gradients -->
    <div
      class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-teal-600/20 rounded-full blur-[120px] pointer-events-none">
    </div>
    <div
      class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-emerald-600/20 rounded-full blur-[120px] pointer-events-none">
    </div>

    <div
      class="w-full max-w-md bg-gray-800/40 p-8 rounded-3xl shadow-2xl border border-gray-700/50 backdrop-blur-sm relative z-10 mx-auto" style="width: 90%;">
      <div class="text-center mb-8">
        <h2
          class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-500 tracking-wide uppercase">
          Admin Login
        </h2>
        <p class="text-gray-400 mt-2 text-sm">Sign in to access the control panel</p>
      </div>

      <form action="{{ url('/admin/login') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-300 text-left">Email Address</label>
          <div class="relative">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required
              class="w-full bg-gray-900/50 border border-gray-700 text-white px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all placeholder-gray-600" />
          </div>
          @error('email')
          <p class="text-rose-400 text-xs mt-1.5 font-medium text-left">
            {{ $message }}
          </p>
          @enderror
        </div>

        <!-- Password -->
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-300 text-left">Password</label>
          <div class="relative flex items-center">
            <input type="password" name="password" id="password" placeholder="••••••••" required
              class="w-full bg-gray-900/50 border border-gray-700 text-white pl-4 pr-11 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all placeholder-gray-600" />
            <button 
              type="button"
              onclick="togglePassword()"
              class="absolute right-4 text-gray-500 hover:text-gray-300 focus:outline-none"
            >
              <svg id="eyeShow" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
              <svg id="eyeHide" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </button>
          </div>
          @error('password')
          <p class="text-rose-400 text-xs mt-1.5 font-medium text-left">
            {{ $message }}
          </p>
          @enderror
        </div>

        <button type="submit"
          class="w-full bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-400 hover:to-emerald-500 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-teal-500/25 transition-all duration-200 mt-6 active:scale-[0.98]">
          Sign In
        </button>

        @if (session('error'))
        <div class="p-3 bg-rose-500/10 border border-rose-500/20 rounded-xl mt-4">
          <p class="text-rose-400 text-sm text-center font-medium">
            {{ session('error') }}
          </p>
        </div>
        @endif

      </form>
    </div>

    <script>
      function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeShow = document.getElementById('eyeShow');
        const eyeHide = document.getElementById('eyeHide');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeShow.style.display = 'block';
            eyeHide.style.display = 'none';
        } else {
            passwordInput.type = 'password';
            eyeShow.style.display = 'none';
            eyeHide.style.display = 'block';
        }
      }
    </script>
</body>
</html>

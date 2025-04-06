<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <title>Studio Lens</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-white shadow-xl rounded-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-base-100 p-6 text-center">
          <h1 class="text-3xl font-bold text-black">Welcome Back</h1>
          <p class="text-black-100 mt-2">Sign in to your account</p>
        </div>
        
        <div class="card-body p-8">
          @if($errors->any())
            <!-- Alert error tetap sama -->
          @endif
    
          <form class="space-y-6" method="POST" action="/login">
            @csrf
            
            <!-- Email/Username Input -->
            <div class="form-control">
              <label class="label" for="login">
                <span class="label-text text-gray-600 font-medium">Email or Username</span>
              </label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                </span>
                <input 
                  type="text" 
                  id="login"
                  placeholder="Your email or username" 
                  class="input input-bordered w-full pl-10 bg-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('login') input-error @enderror"
                  name="login"
                  value="{{ old('login') }}"
                  autocomplete="username"
                  required>
              </div>
              @error('login')
                <label class="label">
                  <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
              @enderror
            </div>
        
        <!-- Password Input -->
        <div class="form-control">
          <label class="label" for="password">
            <span class="label-text text-gray-600 font-medium">Password</span>
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
              </svg>
            </span>
            <input 
              type="password" 
              id="password"
              placeholder="••••••••" 
              class="input input-bordered w-full pl-10 bg-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('password') input-error @enderror"
              name="password"
              autocomplete="current-password"
              required
              minlength="8">
            <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600" onclick="togglePasswordVisibility()">
              <!-- Icon toggle password -->
            </button>
          </div>
          @error('password')
            <label class="label">
              <span class="label-text-alt text-error">{{ $message }}</span>
            </label>
          @enderror
          <label class="label">
            <a href="/forgot-password" class="label-text-alt link link-hover text-primary">Forgot password?</a>
          </label>
          <label class="label">
            <a href="{{ route('register') }}" class="label-text-alt link link-hover text-primary">Don't have an account?</a>
        </div>
        
        <!-- Remember Me & Login Button -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
          <label class="flex items-center space-x-2 cursor-pointer">
            <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-sm">
            <span class="text-gray-600 text-sm">Remember me</span>
          </label>
          <button type="submit" class="btn btn-primary px-8 py-3 w-full sm:w-auto bg-primary border-none text-white font-medium transition-all duration-300">
            Sign In
          </button>
        </div>
      </form>
      
      <!-- Bagian social login dan register link tetap sama -->
    </div>
  </div>

  <script>
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('password');
      const showPasswordIcon = document.getElementById('show-password');
      const hidePasswordIcon = document.getElementById('hide-password');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showPasswordIcon.classList.add('hidden');
        hidePasswordIcon.classList.remove('hidden');
      } else {
        passwordInput.type = 'password';
        showPasswordIcon.classList.remove('hidden');
        hidePasswordIcon.classList.add('hidden');
      }
    }

    // Auto-hide error after 5 seconds
    setTimeout(() => {
      const errorAlert = document.querySelector('.alert-error');
      if (errorAlert) {
        errorAlert.classList.add('opacity-0');
        setTimeout(() => errorAlert.remove(), 300);
      }
    }, 5000);
  </script>

  <style>
    .animate-fade-in {
      animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</body>
</html>
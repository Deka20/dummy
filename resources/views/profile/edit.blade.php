<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  @vite('resources/js/app.css')
  <title>Studio Lens</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="flex h-screen">
    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="bg-base-100 shadow-sm">
        <div class="flex justify-between items-center p-4">
          <a href="/" class="btn btn-ghost text-sm md:text-base">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="hidden sm:inline">Back to Home</span>
          </a>
          <div class="dropdown dropdown-end z-50">
            <label for="" tabindex="0" class="btn btn-ghost btn-circle avatar">
              <div class="w-10 md:w-12 rounded-full overflow-hidden">
                <img src="{{ asset('storage/public/avatars/' . Auth::user()->avatar) }}" 
                     alt="Current Avatar" class="w-full h-full object-cover"/>
              </div>
            </label>
            <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
              <li>
                <a href="{{ route('profile.edit') }}" class="justify-between">
                  Profile
                </a>
              </li>
              <li><a href="{{ route('settings.security') }}">Settings</a></li>
              <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </header>
      
      <!-- Navigation Card -->
      <div class="flex-1 flex bg-base-200 justify-center items-start py-4 md:py-8">
        <div class="w-full max-w-3xl bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row">
          <!-- Mobile Menu Button -->
          <div class="md:hidden p-4 border-b border-gray-200">
            <button id="mobileMenuButton" class="btn btn-ghost w-full justify-start">
              <i class="fas fa-bars mr-2"></i>
              Menu
            </button>
          </div>
          
          <!-- Sidebar Navigation - Hidden on mobile by default -->
<div id="sidebar" class="w-full md:w-64 border-r border-gray-200 flex-shrink-0 hidden md:block">
  <nav class="flex flex-col h-full">
    <!-- Profile Link -->
    <a href="{{ route('profile.edit') }}" 
       class="px-4 md:px-6 py-3 text-sm font-medium hover:bg-gray-50 flex items-center transition-colors duration-200 border-b border-gray-100 bg-gray-50">
      <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
      </svg>
      <span class="text-gray-800 hover:text-blue-600">Profile</span>
    </a>

    <!-- Security & Privacy Link -->
    <a href="{{ route('settings.security') }}" 
       class="px-4 md:px-6 py-3 text-sm font-medium hover:bg-gray-50 flex items-center transition-colors duration-200 border-b border-gray-100">
      <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
      </svg>
      <span class="text-gray-800 hover:text-blue-600">Keamanan & Privasi</span>
    </a>

    <!-- Preferences Link -->
    <a href="{{ route('settings.preferences') }}" 
       class="px-4 md:px-6 py-3 text-sm font-medium hover:bg-gray-50 flex items-center transition-colors duration-200 border-b border-gray-100">
      <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
      <span class="text-gray-800 hover:text-blue-600">Preferensi & Tampilan</span>
    </a>

    <!-- Purchase History Link -->
    <a href="{{ route('purchase.history') }}" 
       class="px-4 md:px-6 py-3 text-sm font-medium hover:bg-gray-50 flex items-center transition-colors duration-200 border-b border-gray-100">
       <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-600" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
         <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
         <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/>
       </svg>
      <span class="text-gray-800 hover:text-blue-600">Purchase History</span>
    </a>

    <!-- Notifications Link -->
    <a href="{{ route('settings.notifications') }}" 
       class="px-4 md:px-6 py-3 text-sm font-medium hover:bg-gray-50 flex items-center transition-colors duration-200 border-b border-gray-100">
      <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      <span class="text-gray-800 hover:text-blue-600">Notifikasi</span>
    </a>

    <!-- Illustration Card with Logout - UPDATED WITH PROFILE THEME -->
    <div class="p-4">
      <div class="bg-gray-50 rounded-lg p-4">
        <!-- Updated Profile-themed Illustration -->
        <div class="text-center mb-4">
          <svg class="w-full h-auto max-h-32 mx-auto" viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Background shape -->
            <rect x="10" y="10" width="180" height="140" rx="10" fill="#EEF2FF" />
            
            <!-- Profile card -->
            <rect x="40" y="30" width="120" height="90" rx="8" fill="white" stroke="#E5E7EB" stroke-width="2" />
            
            <!-- Profile picture circle -->
            <circle cx="100" cy="55" r="18" fill="#DBEAFE" stroke="#3B82F6" stroke-width="2" />
            
            <!-- Profile icon -->
            <path d="M100 48C97.8 48 96 49.8 96 52C96 54.2 97.8 56 100 56C102.2 56 104 54.2 104 52C104 49.8 102.2 48 100 48Z" fill="#3B82F6" />
            <path d="M100 60C96.7 60 94 62.2 94 65V66C94 66.6 94.4 67 95 67H105C105.6 67 106 66.6 106 66V65C106 62.2 103.3 60 100 60Z" fill="#3B82F6" />
            
            <!-- Profile info lines -->
            <rect x="55" y="80" width="90" height="4" rx="2" fill="#E5E7EB" />
            <rect x="55" y="90" width="70" height="4" rx="2" fill="#E5E7EB" />
            <rect x="55" y="100" width="50" height="4" rx="2" fill="#E5E7EB" />
            
            <!-- Security badges -->
            <circle cx="60" cy="115" r="6" fill="#DBEAFE" />
            <path d="M60 113V115.5L61.5 117" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            
            <circle cx="80" cy="115" r="6" fill="#DBEAFE" />
            <path d="M80 112V115H83" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            
            <circle cx="100" cy="115" r="6" fill="#DBEAFE" />
            <path d="M97 115L99 117L103 113" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />

            <!-- Decorative elements -->
            <circle cx="30" cy="40" r="5" fill="#BFDBFE" />
            <circle cx="170" cy="40" r="5" fill="#BFDBFE" />
            <circle cx="30" cy="120" r="5" fill="#BFDBFE" />
            <circle cx="170" cy="120" r="5" fill="#BFDBFE" />
          </svg>
          <p class="text-xs text-gray-500 mt-2">Keep your profile secure and up to date</p>
        </div>
      </div>
    </div>

    <div class="mt-auto">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-white hover:bg-red-500 rounded-lg transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/>
          </svg>
          Logout
        </button>
      </form>
  </div>
  </nav>
</div>
          
          <!-- Content Area -->
          <div class="flex-1 p-4 md:p-6">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Profile</h1>
            
            <!-- Profile Update Section -->
            <div class="border-b border-gray-200 pb-4 md:pb-6">
              <h2 class="text-base md:text-lg font-medium text-gray-800 mb-3 md:mb-4">Edit Profile</h2>
              
              @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-3 md:mb-4 text-sm">
                  {{ session('success') }}
                </div>
              @endif
              
              @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-3 md:mb-4 text-sm">
                  {{ session('error') }}
                </div>
              @endif

              <!-- Form -->
              <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-3 md:gap-4 mb-4 md:mb-6">
                  <!-- Name Field -->
                  <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                           class="input bg-gray-100 dark:text-gray-800 rounded-2xl input-bordered w-full text-sm md:text-base @error('name') input-error @enderror" required />
                    @error('name')
                      <p class="mt-1 text-sm text-error">{{ $message }}</p>
                    @enderror
                  </div>
                  
                  <!-- Email Field -->
                  <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="input bg-gray-100 dark:text-gray-800 rounded-2xl input-bordered w-full text-sm md:text-base @error('email') input-error @enderror" required />
                    @error('email')
                      <p class="mt-1 text-sm text-error">{{ $message }}</p>
                    @enderror
                  </div>

                  <!-- Avatar Field -->
                  <div>
                    <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                    <input type="file" id="avatar" name="avatar" 
                           class="file-input bg-gray-100 dark:text-gray-800 rounded-2xl file-input-bordered w-full text-sm md:text-base @error('avatar') file-input-error @enderror" />
                    @error('avatar')
                      <p class="mt-1 text-sm text-error">{{ $message }}</p>
                    @enderror
                    
                    @if($user->avatar)
                      <div class="mt-3 flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        <div class="avatar">
                          <div class="w-16 sm:w-20 rounded-full">
                            <img src="{{ asset('storage/public/avatars/' . Auth::user()->avatar) }}" 
                                 alt="Current Avatar" class="w-full h-full object-cover"/>
                          </div>
                        </div>
                        <input type="hidden" name="remove_avatar" value="0">
                        <label class="label cursor-pointer flex items-center gap-2">
                          <input type="checkbox" name="remove_avatar" class="checkbox checkbox-error" value="1" {{ old('remove_avatar', $user->avatar ? 0 : 1) ? 'checked' : '' }}/>
                          <span class="label-text dark:text-gray-800 text-sm">Remove current avatar</span>
                        </label>
                      </div>
                    @endif
                  </div>
                </div>
                
                <!-- Submit Button -->
                <div class="flex justify-end gap-3 md:gap-4 pt-4 md:pt-6">
                  <a href="/" class="btn rounded-3xl btn-ghost text-red-500 text-sm md:text-base">Cancel</a>
                  <button type="submit" class="btn rounded-3xl btn-primary text-sm md:text-base">
                    <span class="check" id="spinner"></span>
                    Save Changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Mobile menu toggle
      const mobileMenuButton = document.getElementById('mobileMenuButton');
      const sidebar = document.getElementById('sidebar');
      
      mobileMenuButton.addEventListener('click', function() {
        sidebar.classList.toggle('hidden');
      });

      // Theme switcher functionality
      const htmlElement = document.documentElement;
      
      // Load saved theme
      const savedTheme = localStorage.getItem('theme') || 'light';
      htmlElement.setAttribute('data-theme', savedTheme);
      
      // If you have a theme switcher dropdown elsewhere in your app
      if (document.getElementById('themeSwitcher')) {
        document.getElementById('themeSwitcher').value = savedTheme;
      }
      if (document.getElementById('currentThemeText')) {
        document.getElementById('currentThemeText').innerText = savedTheme;
      }
    </script>
</body>
</html>
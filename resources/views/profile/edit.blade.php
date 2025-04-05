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
          <a href="/" class="btn btn-ghost">Back to Home</a>
          <div class="dropdown dropdown-end z-50">
            <label for="" tabindex="0" class="btn btn-ghost btn-circle avatar">
              <div class="w-20 rounded-full overflow-hidden">
                <img src="{{ asset('storage/public/avatars/' . Auth::user()->avatar) }}" 
                     alt="Current Avatar" />
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
      <div class="flex-1 flex bg-base-200 justify-center items-start py-8">
        <div class="w-full max-w-3xl bg-white rounded-lg shadow-md overflow-hidden flex">
          <!-- Sidebar Navigation -->
          <div class="w-64 border-r border-gray-200 flex-shrink-0">
            <nav class="flex flex-col h-full">
              <a href="{{ route('profile.edit') }}" 
                 class="px-6 py-4 text-sm font-medium hover:bg-gray-50 flex items-center transition-colors duration-200 border-b border-gray-100 h-full">
                <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-gray-800 hover:text-blue-600">Profile</span>
              </a>
              <a href="{{ route('settings.security') }}" 
                 class="px-6 py-4 text-sm font-medium hover:bg-gray-50 flex items-center transition-colors duration-200 border-b border-gray-100 h-full">
                <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span class="text-gray-800 hover:text-blue-600">Keamanan & Privasi</span>
              </a>
              <a href="{{ route('settings.preferences') }}" 
                 class="px-6 py-4 text-sm font-medium hover:bg-gray-50 flex items-center transition-colors duration-200 border-b border-gray-100 h-full">
                <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-gray-800 hover:text-blue-600">Preferensi & Tampilan</span>
              </a>
              <a href="{{ route('settings.notifications') }}" 
                 class="px-6 py-4 text-sm font-medium hover:bg-gray-50 flex items-center transition-colors duration-200 h-full">
                 <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-600" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/></svg>
                <span class="text-gray-800 hover:text-blue-600">Purchase History</span>
              </a>
              <a href="{{ route('settings.notifications') }}" 
                 class="px-6 py-4 text-sm font-medium hover:bg-gray-50 flex items-center transition-colors duration-200 h-full">
                <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="text-gray-800 hover:text-blue-600">Notifikasi</span>
              </a>
              <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit" class="btn btn-ghost text-gray-800 rounded-2xl hover:bg-red-500 w-full">
                    <svg class="w-5 h-5 mr-3 text-gray-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/></svg>
                    Logout</button>
              </form>
            </nav>
          </div>
          
          <!-- Content Area -->
          <div class="flex-1 p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Profile</h1>
            
            <!-- Password Update Section -->
            <div class="border-b border-gray-200 pb-6">
              <h2 class="text-lg font-medium text-gray-800 mb-4">Edit Profile</h2>
              
              @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                  {{ session('success') }}
                </div>
              @endif
              
              @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                  {{ session('error') }}
                </div>
              @endif

              <!-- Form -->
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-6">
            <!-- Name Field -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
              <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                     class="input bg-gray-100 dark:text-gray-800 rounded-2xl input-bordered w-full @error('name') input-error @enderror" required />
              @error('name')
                <p class="mt-1 text-sm text-error">{{ $message }}</p>
              @enderror
            </div>
            
            <!-- Email Field -->
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                     class="input bg-gray-100 dark:text-gray-800 rounded-2xl input-bordered w-full @error('email') input-error @enderror" required />
              @error('email')
                <p class="mt-1 text-sm text-error">{{ $message }}</p>
              @enderror
            </div>

            <!-- Avatar Field -->
            <div class="md:col-span-2">
              <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
              <input type="file" id="avatar" name="avatar" 
                     class="file-input bg-gray-100 dark:text-gray-800 rounded-2xl file-input-bordered w-full @error('avatar') file-input-error @enderror" />
              @error('avatar')
                <p class="mt-1 text-sm text-error">{{ $message }}</p>
              @enderror
              
              @if($user->avatar)
                <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                  <div class="avatar">
                    <div class="w-24 rounded-full">
                      <img src="{{ asset('storage/public/avatars/' . Auth::user()->avatar) }}" 
                           alt="Current Avatar" />
                    </div>
                  </div>
                  <input type="hidden" name="remove_avatar" value="0">
                  <label class="label cursor-pointer flex items-center gap-2">
                    <input type="checkbox" name="remove_avatar" class="checkbox checkbox-error" value="1" {{ old('remove_avatar', $user->avatar ? 0 : 1) ? 'checked' : '' }}/>
                    <span class="label-text dark:text-gray-800">Remove current avatar</span>
                  </label>
                </div>
              @endif
            </div>
          </div>
          
          <!-- Submit Button -->
          <div class="flex justify-end gap-4 pt-6">
            <a href="/" class="btn rounded-2xl btn-ghost">Cancel</a>
            <button type="submit" class="btn rounded-2xl btn-primary">
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
      const themeSelect = document.getElementById('themeSwitcher');
      const currentThemeText = document.getElementById('currentThemeText');
  
      // Load saved theme
      const savedTheme = localStorage.getItem('theme') || 'light';
      document.documentElement.setAttribute('data-theme', savedTheme);
      themeSelect.value = savedTheme;
      currentThemeText.innerText = savedTheme;
  
      // Change theme
      themeSelect.addEventListener('change', function () {
        const selected = this.value;
        document.documentElement.setAttribute('data-theme', selected);
        localStorage.setItem('theme', selected);
        currentThemeText.innerText = selected;
      });
    </script>
</body>
</html>
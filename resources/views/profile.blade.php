<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>Edit Profile - StudioLens</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body class="flex h-screen bg-gray-50">
  <!-- Sidebar -->
  <div class="w-64 bg-slate-800 text-white flex flex-col">
    <div class="p-4 flex items-center space-x-4 border-b border-slate-700">
      <div class="avatar">
        <div class="w-10 h-10 rounded-full">
          @if (Auth::user()->avatar)
            <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
          @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="{{ Auth::user()->name }}">
          @endif
        </div>
      </div>
      <div>
        <p class="font-medium">{{ Auth::user()->name }}</p>
        <p class="text-xs text-slate-300">{{ Auth::user()->email }}</p>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white shadow-sm">
      <div class="flex justify-between items-center p-4">
        <h1 class="text-xl font-semibold">Edit Profile</h1>
      </div>
    </header>

    <main class="flex-1 overflow-y-auto p-6">
      <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
              <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" 
                     class="input input-bordered w-full" required />
            </div>
            
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                     class="input input-bordered w-full" required />
            </div>

            <div>
              <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
              <input type="file" id="avatar" name="avatar" 
                     class="file-input file-input-bordered w-full" />
              @if(Auth::user()->avatar)
                <div class="mt-2">
                  <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" 
                       alt="Current Avatar" class="w-24 h-24 rounded-full object-cover">
                  <label class="label cursor-pointer mt-2">
                    <input type="checkbox" name="remove_avatar" class="checkbox checkbox-sm" />
                    <span class="label-text ml-2">Remove current avatar</span>
                  </label>
                </div>
              @endif
            </div>
          </div>
          
          <div class="flex justify-end space-x-3">
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>
</html>

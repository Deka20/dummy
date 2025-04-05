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
  <!-- Main Content -->
  <div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white shadow-sm">
      <div class="flex justify-between items-center p-4">
        <a href="/">Back to Home Page</a>
        <h1 class="text-xl font-semibold">Edit Profile</h1>
      </div>
    </header>

    <main class="flex-1 overflow-y-auto p-6">
      <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        
        <!-- Error Messages -->
        @if ($errors->any())
          <div class="mb-6">
            <ul class="text-sm text-red-600">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- Success Message -->
        @if(session('success'))
          <div class="mb-6 text-green-600">
            {{ session('success') }}
          </div>
        @endif
        
        <!-- Edit Profile Form -->
        <form action="{{ route('customer.update', $user->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
              <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                     class="input input-bordered w-full @error('name') input-error @enderror" required />
              @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                     class="input input-bordered w-full @error('email') input-error @enderror" required />
              @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
              <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" 
                     class="input input-bordered w-full @error('username') input-error @enderror" required />
              @error('username')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
              <input type="file" id="avatar" name="avatar" class="file-input file-input-bordered w-full" />
              @if($user->avatar)
                <div class="mt-2">
                  <img src="{{ asset('storage/public/avatars/' . $user->avatar) }}" alt="Current Avatar" 
                       class="w-24 h-24 rounded-full object-cover">
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

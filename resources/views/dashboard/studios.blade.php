<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>StudioLens Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-gray-100">
  <!-- Sidebar -->
  <div class="w-64 bg-slate-800 text-white flex flex-col">
    <div class="p-4 border-b border-slate-700">
      <div class="flex items-center">
        <div class="bg-blue-500 p-1 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        <span class="ml-2 text-lg font-semibold">StudioLens</span>
      </div>
    </div>
    
    <nav class="flex-1 mt-4">
      <a href="{{ route('dashboard.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
        </svg>
        Dashboard
      </a>
      <a href="{{ route('dashboard.studios') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Studios
      </a>
      <a href="{{route('dashboard.customers')}}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        Customers
      </a>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col overflow-hidden">
    <!-- Top Navbar -->
    <header class="bg-white shadow-sm">
      <div class="flex justify-end items-center p-4">
        <div class="avatar">
          <div class="w-10 h-10 rounded-full">
            <img src="/api/placeholder/40/40" alt="Profile" />
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">All Studios</h2>
        <a href="{{ route('dashboard.create') }}" class="btn btn-primary">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
          </svg>
          Add Studio
        </a>
      </div>

      @if(session('success'))
        <div class="alert alert-success mb-6">
          <div class="flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4" />
            </svg>
            <span>{{ session('success') }}</span>
          </div>
        </div>
      @endif

      <div class="overflow-x-auto shadow-md rounded-lg bg-white">
        <table class="table w-full">
          <thead>
            <tr>
              <th>No</th>
              <th>Studio Name</th>
              <th>Description</th>
              <th>Capacity</th>
              <th>Price per Hour</th>
              <th>Created_at</th>
              <th>Updated_at</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($studios as $studio)
            <tr>
                <td>{{ $studio->id }}</td>
                <td>{{ $studio->nama }}</td>
                <td>{{ $studio->deskripsi }}</td>
                <td>{{ $studio->kapasitas }}</td>
                <td>{{ $studio->harga_per_jam }}</td>
                <td>{{ $studio->created_at }}</td>
                <td>{{ $studio->updated_at }}</td>
                <td>
                    <a href="{{ route('dashboard.edit', $studio->id) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('dashboard.destroy', $studio->id) }}" method="POST" class="inline-block">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-error" onclick="return confirm('Are you sure you want to delete this studio?')">Delete</button>
                  </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>

@php
    use App\Models\User;
    $user = User::all();
@endphp

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>StudioLens Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
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
      <a href="{{ route('dashboard.index') }}" class="flex items-center justify-between px-4 py-3 text-slate-300 hover:bg-slate-700 group">
        <div class="flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
          </svg>
          Dashboard
        </div>
        <div class="relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
          
          @if($newOrdersCount > 0)
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-semibold rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
              {{ $newOrdersCount > 9 ? '9+' : $newOrdersCount }}
            </span>
          @endif
        </div>
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
    
    <div class="overflow-x-auto shadow-md rounded-lg bg-white">
        <table class="table w-full">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Avatar</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($user->avatar)
                                <div class="avatar">
                                    <div class="w-12 rounded-full">
                                        <img src="{{ asset('storage/public/avatars/' . $user->avatar) }}" alt="User Avatar" />
                                    </div>
                                </div>
                            @else
                                <div class="avatar placeholder">
                                    <div class="bg-neutral text-neutral-content rounded-full w-12">
                                        <span class="text-xl">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $user->updated_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('dashboard.customers.edit', $user->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('dashboard.customers.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-error">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
  </div>
</body>
</html>

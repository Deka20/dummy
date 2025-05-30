@php
use App\Models\Booking;
if(!isset($recentBookings)) {
    $recentBookings = Booking::with('user')
                    ->orderBy('tanggal_reservasi', 'desc')
                    ->take(10)
                    ->get();
}
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
      <a href="{{route('dashboard.settings')}}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        Settings
      </a>
      <a href="{{ route('dashboard.payments') }}" class="flex items-center justify-between px-4 py-3  text-slate-300 hover:bg-slate-700">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Bukti Pembayaran</span>
        </div>
        
        @if($unverifiedPaymentsCount > 0)
        <span class="bg-red-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full animate-pulse">
            {{ $unverifiedPaymentsCount > 9 ? '9+' : $unverifiedPaymentsCount }}
        </span>
        @endif
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

    <!-- Content Area -->
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Revenue Card -->
<div class="card bg-white shadow-sm">
  <div class="card-body p-4">
    <div class="flex items-center">
      <div class="rounded-full bg-blue-100 p-3 mr-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <p class="text-sm text-gray-500">Total Revenue</p>
        <h2 class="text-2xl font-bold">
            @php
                $totalRevenue = App\Models\Booking::where('status', '!=', 'cancelled')->sum('total_harga');
                $totalBookings = App\Models\Booking::where('status', '!=', 'cancelled')->count();
            @endphp
            Rp{{ number_format($totalRevenue, 0) }}
        </h2>
        <p class="text-sm text-gray-400">{{ $totalBookings }} successful bookings</p>
    </div>
    </div>
  </div>
</div>

        <!-- Reservations Card -->
        <div class="card bg-white shadow-sm">
          <div class="card-body p-4">
            <div class="flex items-center">
              <div class="rounded-full bg-green-100 p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3"/><circle cx="12" cy="10" r="3"/><circle cx="12" cy="12" r="10"/>
                </svg>
              </div>
              <div>
                <h1>Total Customer</h1>
                <p>{{ number_format($totalCustomer) }}</p>            
              </div>
            </div>
          </div>
        </div>

        <!-- Completed Sessions Card -->
        <div class="card bg-white shadow-sm">
          <div class="card-body p-4">
            <div class="flex items-center">
              <div class="rounded-full bg-purple-100 p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <p class="text-sm text-gray-500">Completed Sessions</p>
                <h2 class="text-sm font-normal text-gray-500">{{ $totalBookings }} bookings</h2>
              </div>
            </div>
          </div>
        </div>

        @php
// Mengambil semua rating dari semua booking
$allRatings = App\Models\Booking::whereNotNull('rating')
  ->pluck('rating');

// Menghitung total ulasan
$totalReviews = $allRatings->count();

// Menghitung rata-rata rating
$averageRating = $totalReviews > 0 ? $allRatings->avg() : 0;

// Menghitung distribusi rating
$ratingsDistribution = [];
foreach(range(1, 5) as $star) {
  $ratingsDistribution[$star] = $allRatings->filter(function($rating) use ($star) {
    return $rating == $star;
  })->count();
}
@endphp

        <!-- Rating Card -->
        <div class="card bg-white shadow-sm">
          <div class="card-body p-4">
            <div class="flex items-center">
              <div class="rounded-full bg-yellow-100 p-3 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
              </div>
              <div>
                <p class="text-sm text-gray-500">Average Rating</p>
                <h2 class="text-2xl font-bold">{{ number_format($averageRating, 1) }}</h2>
              </div>
            </div>
          </div>
        </div>
      </div>

<!-- Recent Reservations Section -->
<div class="bg-white rounded-lg shadow-sm mb-6">
  <div class="p-6 border-b border-gray-200">
      <h2 class="text-lg font-bold">Recent Reservations</h2>
  </div>
  
  <div class="overflow-x-auto">
      <table class="table w-full">
          <thead>
              <tr>
                  <th class="bg-white text-gray-500 font-medium text-left pl-6">Customer</th>
                  <th class="bg-white text-gray-500 font-medium text-left">Date</th>
                  <th class="bg-white text-gray-500 font-medium text-left">Time</th>
                  <th class="bg-white text-gray-500 font-medium text-left">Guests</th>
                  <th class="bg-white text-gray-500 font-medium text-left">Total Price</th>
                  <th class="bg-white text-gray-500 font-medium text-left">Status</th>
                  <th class="bg-white text-gray-500 font-medium text-left">Payment Proof</th>
                  <th class="bg-white text-gray-500 font-medium text-left pr-6">Actions</th>
              </tr>
          </thead>
          <tbody>
              @foreach($recentBookings as $booking)
              <tr class="border-b">
                  <td class="py-3 pl-6">
                      <div class="flex items-center">
                          <div class="avatar mr-3">
                              <div class="w-8 h-8 rounded-full">
                                  <img src="{{ asset('storage/public/avatars/' . $booking->user->avatar) }}" alt="{{ $booking->user->name }}" />
                              </div>
                          </div>
                          <span>{{ $booking->user->name }}</span>
                      </div>
                  </td>
                  <td>{{ $booking->tanggal_reservasi->format('M d, Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($booking->waktu_reservasi)->format('g:i A') }}</td>
                  <td>{{ $booking->jumlah_pelanggan }}</td>
                  <td>Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                  <td>
                      <span class="px-2 py-1 rounded-full text-xs font-medium {{ 
                          match(strtolower($booking->status)) {
                              'pending' => 'bg-yellow-100 text-yellow-800',
                              'confirmed' => 'bg-green-100 text-green-800',
                              'cancelled' => 'bg-red-100 text-red-800',
                              'completed' => 'bg-blue-100 text-blue-800',
                              'request_cancel' => 'bg-purple-100 text-purple-800',
                              default => 'bg-gray-100 text-gray-800'
                          }
                      }}">
                          {{ ucfirst($booking->status) }}
                      </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @if($booking->payment_proof)
                        <button onclick="openPaymentProofModal('{{ asset('storage/' . $booking->payment_proof) }}')" class="text-indigo-600 hover:text-indigo-900">
                            Lihat Bukti
                        </button>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                  <td class="pr-6">
                    <div x-data="{
                        open: false,
                        currentStatus: '{{ $booking->status }}',
                        toggle() {
                            this.open = !this.open;
                        },
                        close() {
                            this.open = false;
                        },
                        async changeStatus(newStatus) {
                            try {
                                const response = await fetch(`/bookings/{{ $booking->id }}/status`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ status: newStatus })
                                });
                                
                                if (response.ok) {
                                    this.currentStatus = newStatus;
                                    this.close();
                                    location.reload();
                                }
                            } catch (error) {
                                console.error('Error:', error);
                            }
                        }
                    }" class="relative inline-block text-left">
                      <!-- Change Status Button -->
                      <button @click="toggle" type="button" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium rounded-md shadow-sm focus:outline-none"
                              :class="{
                                  'bg-yellow-100 text-yellow-800': currentStatus === 'pending',
                                  'bg-green-100 text-green-800': currentStatus === 'confirmed',
                                  'bg-red-100 text-red-800': currentStatus === 'cancelled',
                                  'bg-blue-100 text-blue-800': currentStatus === 'completed'
                              }">
                          Change Status
                          <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                          </svg>
                      </button>

                      <!-- Dropdown Menu -->
                      <div x-show="open" 
                           @click.away="close"
                           x-transition:enter="transition ease-out duration-100"
                           x-transition:enter-start="transform opacity-0 scale-95"
                           x-transition:enter-end="transform opacity-100 scale-100"
                           x-transition:leave="transition ease-in duration-75"
                           x-transition:leave-start="transform opacity-100 scale-100"
                           x-transition:leave-end="transform opacity-0 scale-95"
                           class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                          <div class="py-1" role="menu" aria-orientation="vertical">
                              <!-- Pending -->
                              <button @click="changeStatus('pending')" 
                                      class="block w-full text-left px-4 py-2 text-sm hover:bg-yellow-50"
                                      :class="{'bg-yellow-50': currentStatus === 'pending'}"
                                      role="menuitem">
                                  <span class="flex items-center">
                                      <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                                      Pending
                                  </span>
                              </button>
                              
                              <!-- Confirmed -->
                              <button @click="changeStatus('confirmed')" 
                                      class="block w-full text-left px-4 py-2 text-sm hover:bg-green-50"
                                      :class="{'bg-green-50': currentStatus === 'confirmed'}"
                                      role="menuitem">
                                  <span class="flex items-center">
                                      <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                      Confirmed
                                  </span>
                              </button>
                              
                              <!-- Cancelled -->
                              <button @click="changeStatus('cancelled')" 
                                      class="block w-full text-left px-4 py-2 text-sm hover:bg-red-50"
                                      :class="{'bg-red-50': currentStatus === 'cancelled'}"
                                      role="menuitem">
                                  <span class="flex items-center">
                                      <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                                      Cancelled
                                  </span>
                              </button>
                              
                              <!-- Completed -->
                              <button @click="changeStatus('completed')" 
                                      class="block w-full text-left px-4 py-2 text-sm hover:bg-blue-50"
                                      :class="{'bg-blue-50': currentStatus === 'completed'}"
                                      role="menuitem">
                                  <span class="flex items-center">
                                      <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                                      Completed
                                  </span>
                              </button>
                          </div>
                      </div>
                    </div>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
      <div class="p-6 border-t border-gray-200 bg-gray-50"> <!-- atau bg-blue-50, etc -->
        {{ $recentBookings->links() }}
    </div>
  </div>
</div>

<!-- Modal untuk menampilkan bukti pembayaran -->
<div id="paymentProofModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Bukti Pembayaran</h3>
            <div class="mt-2">
              <img id="modalPaymentProofImage" src="" alt="Bukti Pembayaran" class="w-full">
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="button" onclick="closePaymentProofModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function openPaymentProofModal(imageUrl) {
    document.getElementById('modalPaymentProofImage').src = imageUrl;
    document.getElementById('paymentProofModal').classList.remove('hidden');
  }

  function closePaymentProofModal() {
    document.getElementById('paymentProofModal').classList.add('hidden');
  }
</script>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    // Fungsi helper untuk format waktu
    Alpine.magic('formatTime', () => {
        return (timeString) => {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        };
    });
});
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    // Fungsi helper untuk format waktu
    Alpine.magic('formatTime', () => {
        return (timeString) => {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        };
    });

    // Fungsi untuk status class
    Alpine.magic('statusClass', () => {
        return (status) => {
            status = status.toLowerCase();
            if (status === 'pending') return 'bg-yellow-100 text-yellow-800';
            if (status === 'confirmed') return 'bg-green-100 text-green-800';
            if (status === 'cancelled') return 'bg-red-100 text-red-800';
            if (status === 'completed') return 'bg-blue-100 text-blue-800';
            return 'bg-gray-100 text-gray-800';
        };
    });

    // Komponen dropdown status
    Alpine.data('statusDropdown', () => ({
        open: false,
        currentStatus: '{{ $booking->status }}',
        
        toggle() {
            this.open = !this.open;
        },
        
        close() {
            this.open = false;
        },
        
        async changeStatus(newStatus) {
            try {
                const response = await fetch(`/bookings/{{ $booking->id }}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: newStatus })
                });
                
                if (response.ok) {
                    this.currentStatus = newStatus;
                    this.close();
                    location.reload(); // Refresh untuk update tampilan
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }));
});
</script>
@endpush

  <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
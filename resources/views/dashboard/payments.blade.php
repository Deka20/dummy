@php
    use App\Models\Booking;
    $customersWithPayment = Booking::whereNotNull('payment_proof')
                                ->with('user')
                                ->latest()
                                ->paginate(10);
@endphp

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>Customer dengan Bukti Pembayaran | StudioLens</title>
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
      <a href="{{ route('dashboard.customers') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        Customers
      </a>
      <a href="{{ route('dashboard.payments') }}" class="flex items-center justify-between px-4 py-3 bg-slate-700 text-white group">
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
      <div class="flex justify-between items-center p-4">
        <h1 class="text-xl font-semibold">Customer dengan Bukti Pembayaran</h1>
        <div class="avatar">
          <div class="w-10 h-10 rounded-full">
            <img src="/api/placeholder/40/40" alt="Profile" />
          </div>
        </div>
      </div>
    </header>
    
    <!-- Content -->
    <main class="flex-1 overflow-y-auto p-6">
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Studio</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Transfer</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Pembayaran</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($customersWithPayment as $index => $booking)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10">
                        @if($booking->user->avatar)
                          <img class="h-10 w-10 rounded-full" src="{{ asset('storage/public/avatars/' . Auth::user()->avatar) }}" alt="">
                        @else
                          <div class="bg-gray-200 h-10 w-10 rounded-full flex items-center justify-center">
                            <span class="text-gray-600">{{ substr($booking->user->name, 0, 1) }}</span>
                          </div>
                        @endif
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                      </div>
                    </div>
                  </td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $booking->booking_id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ $booking->studio->nama }}</div>
                  <div class="text-sm text-gray-500">{{ $booking->studio->lokasi }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $booking->payment_date ? \Carbon\Carbon::parse($booking->payment_date)->format('d M Y') : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <button onclick="openPaymentProofModal('{{ asset('storage/' . $booking->payment_proof) }}')" class="text-indigo-600 hover:text-indigo-900">
                    Lihat Bukti
                  </button>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  @if($booking->status === 'waiting_verification')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                      Menunggu Verifikasi
                    </span>
                  @elseif($booking->status === 'confirmed')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                      Terverifikasi
                    </span>
                  @else
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                      {{ ucfirst($booking->status) }}
                    </span>
                  @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    @if($booking->status === 'waiting_verification')
                      <form action="{{ route('dashboard.payments.verify', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-green-600 hover:text-green-900">Verifikasi</button>
                      </form>
                    @endif
                    <form action="{{ route('dashboard.payments.reject', $booking->id) }}" method="POST">
                      @csrf
                      <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="px-4 py-3 bg-gray-50 sm:px-6">
          {{ $customersWithPayment->links() }}
        </div>
      </div>
    </main>
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
</body>
</html>
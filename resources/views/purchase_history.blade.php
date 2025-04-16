<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite('resources/css/app.css')
  <title>Studio Lens</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    .animate-fade-out {
        animation: fadeOut 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(10px); }
    }
    /* Custom styles for mobile cards */
    .booking-card {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background-color: white;
    }
    .booking-card-header {
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .booking-detail {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    .booking-detail-label {
        font-weight: 500;
        color: #4b5563;
    }
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    @media (min-width: 1024px) {
        .booking-card {
            display: none;
        }
    }
    @media (max-width: 1023px) {
        .table-container {
            display: none;
        }
    }
</style>
</head>
<body>
    {{-- Navbar Section --}}
<div class="navbar bg-base-100 shadow-sm flex items-center justify-between p-4">
    <div class="flex-none flex items-center gap-2">
      <img src="https://i.pinimg.com/736x/e0/4c/92/e04c9263fa971bf01fd1ed73f0574b3e.jpg" alt="Studio Lens Logo" class="w-8 h-8 rounded-full object-cover">
      <a class="text-xl font-medium leading-none">Studio Lens</a>
    </div>
    
    {{-- Mobile menu button --}}
    <div class="flex-none lg:hidden">
      <button id="mobile-menu-button" class="btn btn-square btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>
    
    {{-- Desktop Menu --}}
    <div class="hidden lg:flex flex-grow justify-center">
      <nav>
        <ul class="flex space-x-6">
          <li><a href="#" class=" hover:text-gray-500">Home</a></li>
          <li><a href="#" class=" hover:text-gray-500">Studios</a></li>
          <li><a href="#" class=" hover:text-gray-500">Services</a></li>
          <li><a href="#" class=" hover:text-gray-500">Portofolio</a></li>
          <li><a href="#" class=" hover:text-gray-500">Contact</a></li>
        </ul>
      </nav>
    </div>
  
    <div class="hidden lg:flex flex-none gap-5 items-center">
      <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto focus:outline-none focus:ring-0 focus:border-opacity-50 rounded-3xl"/>
      
      <select id="themeSwitcher" class="select rounded-2xl select-sm">
        <option value="light">Light</option>
        <option value="dark">Dark</option>
        <option value="cupcake">Cupcake</option>
        <option value="forest">Forest</option>
      </select>
  
      @auth
        {{-- Tampilkan avatar dan dropdown jika user sudah login --}}
        <div class="dropdown dropdown-end z-50">
          <label tabindex="0" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 h-10 rounded-full overflow-hidden">
              @if (Auth::user()->avatar)
              <!-- Tampilkan avatar pengguna jika ada -->
              <img src="{{ asset('storage/public/avatars/' . Auth::user()->avatar) }}" 
                   alt="{{ Auth::user()->name }}"
                   class="w-full h-full object-cover">
          @else
              <!-- Tampilkan avatar default jika tidak ada avatar -->
              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" 
                   alt="{{ Auth::user()->name }}"
                   class="w-full h-full object-cover">
          @endif        
  </div>
          </label>
          <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
            <li>
              <a href="{{ route('profile.edit') }}" class="justify-between">
                Profile
              </a>
            </li>
            <li><a href="{{ route('settings.security') }}">Settings</a></li>
            <li><a href="{{ route('purchase.history') }}">Purchase  History</a></li>
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
      @else
        {{-- Tampilkan tombol login dan register jika user belum login --}}
        <a href="{{ route('register') }}" class="text-primary font-medium hover:underline">
          Sign up
        </a>
        <a href="{{ route('login') }}"><button class="btn bg-primary text-white rounded-md">Login</button></a>
      @endauth
    </div>
  </div>
  
  {{-- Mobile Menu Dropdown (akan muncul ketika mobile-menu-button diklik) --}}
  <div id="mobile-menu" class="lg:hidden hidden p-4 bg-base-100 shadow-md">
    <ul class="space-y-2 ">
      <li><a href="#" class="block py-2 hover:text-gray-500">Home</a></li>
      <li><a href="#" class="block py-2 hover:text-gray-500">Studios</a></li>
      <li><a href="#" class="block py-2 hover:text-gray-500">Services</a></li>
      <li><a href="#" class="block py-2 hover:text-gray-500">Portofolio</a></li>
      <li><a href="#" class="block py-2 hover:text-gray-500">Contact</a></li>
      
      <div class="pt-4">
        <input type="text" placeholder="Search" class="input input-bordered w-full focus:outline-none focus:ring-0 focus:border-opacity-50 rounded-3xl mb-3"/>
  
        <select id="themeSwitcher" class="select select-sm rounded-2xl">
          <option value="light">Light</option>
          <option value="dark">Dark</option>
          <option value="cupcake">Cupcake</option>
          <option value="forest">Forest</option>
        </select>
        
        @auth
          {{-- Menu untuk user yang sudah login (mobile) --}}
          <div class="flex items-center gap-3 py-2">
            <div class="avatar">
              <div class="w-10 rounded-full">
                <img src="{{ asset('storage/public/avatars/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
              </div>
            </div>
            <span class="font-medium">{{ Auth::user()->name }}</span>
          </div>
          <a href="{{ route('profile.edit') }}" class="block py-2 text-gray-800 hover:text-gray-500">Profile</a>
          <a href="" class="block py-2 text-gray-800 hover:text-gray-500">Settings</a>
          <a href="" class="block py-2 text-gray-800 hover:text-gray-500">Settings</a>
          <form method="POST" action="{{ route('logout') }}" class="pt-2">
            @csrf
            <button type="submit" class="btn btn-outline w-full rounded-2xl">Logout</button>
          </form>
        @else
          {{-- Menu untuk user yang belum login (mobile) --}}
          <div class="flex flex-col gap-2">
            <a href="{{ route('login') }}"><button class="btn bg-primary text-white rounded-2xl w-full">Login</button></a>
            <a href="{{ route('register') }}" class="text-primary font-medium hover:underline text-center">
              Sign up
            </a>
          </div>
        @endauth
      </div>
    </ul>
  </div>

    <div id="toast-container" class="toast toast-top toast-end"></div>
    <div class="container mx-auto p-4 max-w-7xl">
        <h1 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Riwayat Reservasi Studio Anda</h1>
        
        @if($bookings->isEmpty())
            <div class="alert alert-info shadow-lg">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Anda belum memiliki riwayat reservasi studio.</span>
                </div>
            </div>
        @else
            {{-- Desktop Table --}}
            <div class="table-container bg-gray-200 rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead class="">
                            <tr>
                                <th class="text-left px-4 py-3 text-gray-800">ID Booking</th>
                                <th class="text-left px-4 py-3 text-gray-800">Studio</th>
                                <th class="text-left px-4 py-3 text-gray-800">Tanggal</th>
                                <th class="text-left px-4 py-3 text-gray-800">Waktu</th>
                                <th class="text-left px-4 py-3 text-gray-800">Durasi</th>
                                <th class="text-left px-4 py-3 text-gray-800">Jumlah Orang</th>
                                <th class="text-left px-4 py-3 text-gray-800">Total Harga</th>
                                <th class="text-left px-4 py-3 text-gray-800">Status</th>
                                <th class="text-left px-4 py-3 text-gray-800">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-300 border-b border-gray-100">
                                <td class="px-4 py-3 text-gray-800">#{{ $booking->booking_id }}</td>
                                <td class="px-4 py-3">
                                    @if($booking->studio)
                                        <div class="font-medium text-gray-800">{{ $booking->studio->nama }}</div>
                                    @else
                                        <span class="text-gray-400">Studio tidak tersedia</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-800">
                                    {{ $booking->tanggal_reservasi->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-800">
                                    {{ $booking->waktu_reservasi->format('H:i') }}
                                </td>
                                <td class="px-4 py-3 text-gray-800">{{ $booking->durasi_jam }} jam</td>
                                <td class="px-4 py-3 text-gray-800">{{ $booking->jumlah_pelanggan }} orang</td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-800">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusClass = [
                                            'pending' => 'badge-warning',
                                            'confirmed' => 'badge-success',
                                            'canceled' => 'badge-error',
                                            'completed' => 'badge-primary'
                                        ][$booking->status] ?? 'badge-secondary';
                                    @endphp
                                    <span class="badge {{ $statusClass }} gap-2">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('show', $booking->id) }}" 
                                           class="btn btn-circle btn-sm btn-ghost text-info hover:bg-info/20"
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($booking->status == 'pending')
                                        <button class="btn btn-circle btn-sm btn-ghost text-error hover:bg-error/20 cancel-booking" 
                                                data-booking-id="{{ $booking->id }}"
                                                title="Batalkan">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="flex justify-center p-4 border-t border-gray-100">
                    {{ $bookings->links() }}
                </div>
            </div>

            {{-- Mobile Cards --}}
            <div class="booking-cards lg:hidden space-y-4">
                @foreach($bookings as $booking)
                <div class="booking-card" data-booking-id="{{ $booking->id }}">
                    <div class="booking-card-header flex justify-between items-center">
                        <div>
                            <span class="font-bold">#{{ $booking->booking_id }}</span>
                            @if($booking->studio)
                                <div class="font-medium">{{ $booking->studio->nama }}</div>
                            @else
                                <span class="text-gray-400">Studio tidak tersedia</span>
                            @endif
                        </div>
                        @php
                            $statusClass = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'confirmed' => 'bg-green-100 text-green-800',
                                'canceled' => 'bg-red-100 text-red-800',
                                'completed' => 'bg-blue-100 text-blue-800'
                            ][$booking->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
                    </div>
                    
                    <div class="booking-details">
                        <div class="booking-detail">
                            <span class="booking-detail-label">Tanggal:</span>
                            <span>{{ $booking->tanggal_reservasi->format('d M Y') }}</span>
                        </div>
                        <div class="booking-detail">
                            <span class="booking-detail-label">Waktu:</span>
                            <span>{{ $booking->waktu_reservasi->format('H:i') }}</span>
                        </div>
                        <div class="booking-detail">
                            <span class="booking-detail-label">Durasi:</span>
                            <span>{{ $booking->durasi_jam }} jam</span>
                        </div>
                        <div class="booking-detail">
                            <span class="booking-detail-label">Jumlah Orang:</span>
                            <span>{{ $booking->jumlah_pelanggan }} orang</span>
                        </div>
                        <div class="booking-detail">
                            <span class="booking-detail-label">Total Harga:</span>
                            <span>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="booking-actions flex justify-end gap-2 pt-3">
                        <a href="{{ route('show', $booking->id) }}" 
                           class="btn btn-sm btn-ghost text-info hover:bg-info/20"
                           title="Detail">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </a>
                        @if($booking->status == 'pending')
                        <button class="btn btn-sm btn-ghost text-error hover:bg-error/20 cancel-booking" 
                                data-booking-id="{{ $booking->id }}"
                                title="Batalkan">
                            <i class="fas fa-times mr-1"></i> Batalkan
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach

                <!-- Pagination for mobile -->
                <div class="flex justify-center pt-4">
                    {{ $bookings->links() }}
                </div>
            </div>
        @endif
    </div>
    
    <!-- DaisyUI Modal for Confirmation -->
    <dialog id="cancel-modal" class="modal">
      <div class="modal-box">
        <h3 class="font-bold text-lg">Konfirmasi Pembatalan</h3>
        <p class="py-4">Apakah Anda yakin ingin membatalkan reservasi ini?</p>
        <div class="modal-action">
          <button class="btn btn-ghost" onclick="cancelModal.close()">Batal</button>
          <button id="confirm-cancel" class="btn btn-error">Ya, Batalkan</button>
        </div>
      </div>
    </dialog>
    
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        // Booking cancellation functionality
        const cancelModal = document.getElementById('cancel-modal');
        const confirmCancelBtn = document.getElementById('confirm-cancel');
        let currentBookingId = null;
    
        document.addEventListener('DOMContentLoaded', function() {
            // Set event listener for all cancel buttons (both in table and cards)
            document.querySelectorAll('.cancel-booking').forEach(button => {
                button.addEventListener('click', function() {
                    currentBookingId = this.dataset.bookingId;
                    cancelModal.showModal();
                });
            });
    
            confirmCancelBtn.addEventListener('click', requestCancelBooking);
        });
    
        async function requestCancelBooking() {
            if (!currentBookingId) return;
    
            try {
                confirmCancelBtn.disabled = true;
                confirmCancelBtn.innerHTML = '<span class="loading loading-spinner"></span> Memproses...';
    
                const response = await fetch(`/bookings/${currentBookingId}/request-cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
    
                const data = await response.json();
    
                if (!response.ok) {
                    throw new Error(data.message || 'Gagal memproses permintaan pembatalan');
                }
    
                if (data.success) {
                    updateBookingStatus(currentBookingId, 'request_cancel');
                    disableCancelButton(currentBookingId);
                    showToast('success', data.message);
                } else {
                    showToast('error', data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('error', error.message);
            } finally {
                confirmCancelBtn.disabled = false;
                confirmCancelBtn.textContent = 'Ya, Batalkan';
                cancelModal.close();
            }
        }
    
        function updateBookingStatus(bookingId, newStatus) {
            // Update table row if exists
            const tableRow = document.querySelector(`tr[data-booking-id="${bookingId}"]`);
            if (tableRow) {
                const statusBadge = tableRow.querySelector('.status-badge');
                if (statusBadge) {
                    statusBadge.className = `badge ${getStatusClass(newStatus)} gap-2 status-badge`;
                    statusBadge.textContent = formatStatusText(newStatus);
                }
            }
            
            // Update card if exists
            const card = document.querySelector(`.booking-card[data-booking-id="${bookingId}"]`);
            if (card) {
                const statusBadge = card.querySelector('.status-badge');
                if (statusBadge) {
                    statusBadge.className = `status-badge ${getMobileStatusClass(newStatus)}`;
                    statusBadge.textContent = formatStatusText(newStatus);
                }
            }
        }
    
        function disableCancelButton(bookingId) {
            // Disable in table
            const tableCancelBtn = document.querySelector(`tr[data-booking-id="${bookingId}"] .cancel-booking`);
            if (tableCancelBtn) {
                tableCancelBtn.disabled = true;
                tableCancelBtn.innerHTML = '<i class="fas fa-check"></i> Dibatalkan';
                tableCancelBtn.classList.remove('btn-error');
                tableCancelBtn.classList.add('btn-disabled');
            }
            
            // Disable in card
            const cardCancelBtn = document.querySelector(`.booking-card[data-booking-id="${bookingId}"] .cancel-booking`);
            if (cardCancelBtn) {
                cardCancelBtn.disabled = true;
                cardCancelBtn.innerHTML = '<i class="fas fa-check mr-1"></i> Dibatalkan';
                cardCancelBtn.classList.remove('text-error');
                cardCancelBtn.classList.add('text-gray-400', 'cursor-not-allowed');
            }
        }
    
        function getStatusClass(status) {
            const statusClasses = {
                'pending': 'badge-warning',
                'confirmed': 'badge-success',
                'request_cancel': 'badge-info',
                'canceled': 'badge-error',
                'completed': 'badge-primary'
            };
            return statusClasses[status] || 'badge-secondary';
        }
        
        function getMobileStatusClass(status) {
            const statusClasses = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'confirmed': 'bg-green-100 text-green-800',
                'request_cancel': 'bg-blue-100 text-blue-800',
                'canceled': 'bg-red-100 text-red-800',
                'completed': 'bg-blue-100 text-blue-800'
            };
            return statusClasses[status] || 'bg-gray-100 text-gray-800';
        }
    
        function formatStatusText(status) {
            const statusTexts = {
                'pending': 'Pending',
                'confirmed': 'Confirmed',
                'request_cancel': 'Request Cancel',
                'canceled': 'Canceled',
                'completed': 'Completed'
            };
            return statusTexts[status] || status;
        }
    
        function showToast(type, message) {
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'fixed top-4 left-0 right-0 flex justify-center z-50';
                document.body.appendChild(toastContainer);
            }

            const toastId = `toast-${Date.now()}`;
            
            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = `alert alert-${type} shadow-lg mb-2 animate-fade-in max-w-md w-full`;
            toast.innerHTML = `
                <div class="flex-1">
                    <span>${message}</span>
                </div>
                <button class="btn btn-sm btn-ghost" onclick="document.getElementById('${toastId}').remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            toastContainer.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('animate-fade-out');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }
    </script>

<script>
    const themeSelect = document.getElementById('themeSwitcher');
    if (themeSelect) {
      const currentTheme = localStorage.getItem('theme') || 'light';
      document.documentElement.setAttribute('data-theme', currentTheme);
      themeSelect.value = currentTheme;
  
      themeSelect.addEventListener('change', function () {
        const selected = this.value;
        document.documentElement.setAttribute('data-theme', selected);
        localStorage.setItem('theme', selected);
      });
    }
</script>
</body>
</html>
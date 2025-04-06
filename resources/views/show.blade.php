<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite('resources/css/app.css')
  <title>Studio Lens</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
          <li><a href="#" class="text-gray-800 dark:text-gray-100 hover:text-gray-500">Home</a></li>
          <li><a href="#" class="text-gray-800 dark:text-gray-100 hover:text-gray-500">Studios</a></li>
          <li><a href="#" class="text-gray-800 dark:text-gray-100 hover:text-gray-500">Services</a></li>
          <li><a href="#" class="text-gray-800 dark:text-gray-100 hover:text-gray-500">Portofolio</a></li>
          <li><a href="#" class="text-gray-800 dark:text-gray-100 hover:text-gray-500">Contact</a></li>
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
      <li><a href="#" class="block py-2 text-gray-800 dark:text-gray-800 hover:text-gray-500">Home</a></li>
      <li><a href="#" class="block py-2 text-gray-800 dark:text-gray-800 hover:text-gray-500">Studios</a></li>
      <li><a href="#" class="block py-2 text-gray-800 dark:text-gray-800 hover:text-gray-500">Services</a></li>
      <li><a href="#" class="block py-2 text-gray-800 dark:text-gray-800 hover:text-gray-500">Portofolio</a></li>
      <li><a href="#" class="block py-2 text-gray-800 dark:text-gray-800 hover:text-gray-500">Contact</a></li>
      
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

  <div class="container mx-auto p-4 max-w-4xl">
    <!-- Header with auto-generated booking ID -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Detail Reservasi 
            <span class="text-primary font-mono text-lg">
              #{{ $booking->booking_id }}
          </span>
        </h1>
        <span class="badge {{ $booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'completed' ? 'badge-primary' : 'badge-warning') }} gap-2">
            {{ ucfirst($booking->status) }}
        </span>
    </div>

    <!-- Card Detail -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <!-- Studio Info -->
            <div class="flex items-start gap-4 mb-6">
                <div class="avatar">
                    <div class="w-16 rounded-full">
                        <img src="{{ asset('storage/' . $booking->studio->cover_studio) }}" alt="{{ $booking->studio->nama }}">
                    </div>
                </div>
                <div>
                    <h2 class="card-title text-xl">{{ $booking->studio->nama }}</h2>
                    <p class="text-gray-500">{{ $booking->studio->lokasi }}</p>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar-day text-gray-400"></i>
                        <span><strong>Tanggal:</strong> {{ $booking->tanggal_reservasi->format('d F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-clock text-gray-400"></i>
                        <span><strong>Waktu:</strong> {{ $booking->waktu_reservasi->format('H:i') }}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-hourglass-half text-gray-400"></i>
                        <span><strong>Durasi:</strong> {{ $booking->durasi_jam }} jam</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-users text-gray-400"></i>
                        <span><strong>Jumlah Orang:</strong> {{ $booking->jumlah_pelanggan }}</span>
                    </div>
                </div>
            </div>

            <!-- Price -->
            <div class="bg-base-200 p-4 rounded-lg mb-6">
                <div class="flex justify-between items-center">
                    <span class="font-bold">Total Harga</span>
                    <span class="text-xl font-bold text-primary">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

<!-- Rating and Review Section (Visible only for completed bookings) -->
@if($booking->status === 'completed')
    <div class="border-t pt-6 mt-6">
        <h3 class="text-lg font-semibold mb-4">Beri Rating dan Ulasan</h3>

        @if(!$booking->rating)
        <form id="reviewForm" action="{{ route('bookings.submit-review', $booking->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-2">Rating</label>
                <div class="rating rating-lg" id="starRating">
                    @for($i = 1; $i <= 5; $i++)
                        <input 
                            type="radio" 
                            id="rating-{{ $i }}" 
                            name="rating" 
                            value="{{ $i }}" 
                            class="mask mask-star-2 bg-orange-400"
                            {{ old('rating', isset($booking->rating) ? $booking->rating : 0) == $i ? 'checked' : '' }}
                        />
                    @endfor
                </div>
                @error('rating')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        
            <div class="mb-4">
                <label class="block mb-2">Ulasan</label>
                <textarea name="review" class="textarea textarea-bordered w-full" rows="3" 
                    placeholder="Bagaimana pengalaman Anda?">{{ old('review', isset($booking->review) ? $booking->review : '') }}</textarea>
                @error('review')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        
            <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
        </form>

        @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const starInputs = document.querySelectorAll('#starRating input[type="radio"]');
    
    // Handle click on stars
    starInputs.forEach(input => {
        input.addEventListener('click', function() {
            // Get the selected value
            const selectedValue = parseInt(this.value);
            
            // Update all stars based on the selected value
            starInputs.forEach(star => {
                // Since stars are in reverse order (5 to 1), we need to check differently
                star.checked = parseInt(star.value) <= selectedValue;
            });
            
            console.log("Selected rating: " + selectedValue); // Debug
        });
    });

    // Initialize rating from old input if exists
    const initialRating = {{ old('rating', isset($booking->rating) ? $booking->rating : 0) }};
    if (initialRating > 0) {
        // Find the input with the matching value and trigger a click
        const targetInput = document.querySelector(`#rating-${initialRating}`);
        if (targetInput) {
            targetInput.click();
        }
    }
});
</script>
@endpush

        @else
            <div class="bg-base-200 p-4 rounded-lg">
                <div class="flex items-center mb-2">
                    <div class="rating rating-sm mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" 
                                   name="display-rating" 
                                   class="mask mask-star-2 bg-orange-400" 
                                   {{ $i <= $booking->rating ? 'checked' : 'disabled' }} />
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500">Dikirim pada {{ $booking->reviewed_at->format('d M Y H:i') }}</span>
                </div>
                <p class="text-gray-800">{{ $booking->review }}</p>
            </div>
        @endif
    </div>
@endif



            <!-- Actions -->
            <div class="card-actions justify-end mt-6">
                @if($booking->status == 'pending')
                <button class="btn btn-error gap-2 cancel-booking-btn"
        data-booking-id="{{ $booking->id }}">
        <i class="fas fa-times"></i>
        Batalkan Reservasi
    </button>
    <a href="javascript:void(0);" 
    class="btn btn-primary gap-2 edit-booking-btn" 
    data-booking='@json($booking)'>
     <i class="fas fa-edit"></i>
     Ubah Reservasi
 </a>
 
                @elseif($booking->status == 'confirmed')
                <button class="btn btn-warning gap-2">
                    <i class="fas fa-question-circle"></i>
                    Butuh Bantuan?
                </button>
                @endif
            </div>
        </div>
    </div>

    <div id="toast" class="hidden fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow-lg z-50">
      <span id="toast-message"></span>
  </div>
</div>

<!-- Edit Booking Modal -->
<dialog id="editModal" class="modal">
  <div class="modal-box">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h3 class="text-lg font-bold">Edit Reservasi</h3>
    <div class="py-4 space-y-4">
      <form id="editBookingForm" method="POST" action="">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="booking_id" id="editBookingId">
        
        <div class="form-control mb-4">
          <label class="label">Tanggal Reservasi</label>
          <input type="date" id="editDate" name="date" 
                 class="input input-bordered w-full" 
                 min="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-6">
          <label class="block text-sm font-medium mb-2">Waktu Reservasi</label>
          <div class="grid grid-cols-3 gap-2" id="timeSlotsContainer">
            @for($hour = 9; $hour <= 21; $hour++)
              <label class="flex items-center space-x-2 border rounded-lg p-3 cursor-pointer">
                <input type="radio" name="time" 
                       value="{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00"
                       class="radio radio-primary time-radio">
                <span>{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00</span>
              </label>
            @endfor
          </div>
        </div>

        <div class="p-4 border rounded-lg bg-gray-50 mb-6">
          <h4 class="font-medium text-gray-700 mb-2">Detail Reservasi:</h4>
          <div class="flex justify-between text-sm mb-1">
            <span>Studio:</span>
            <span id="studioNameDisplay"></span>
          </div>
          <div class="flex justify-between text-sm mb-1">
            <span>Jumlah Pelanggan:</span>
            <span id="customerCountDisplay"></span>
          </div>
          <div class="flex justify-between text-sm mb-1">
            <span>Durasi:</span>
            <span id="durationDisplay"></span>
          </div>
          <div class="border-t pt-2 mt-2 flex justify-between font-medium">
            <span>Total Harga:</span>
            <span id="totalPriceDisplay"></span>
          </div>
        </div>

        <div class="modal-action mt-6">
          <button type="button" class="btn" onclick="document.getElementById('editModal').close()">
            Batal
          </button>
          <button type="submit" class="btn btn-success gap-2">
            <i class="fas fa-save"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</dialog>



<!-- Cancel Booking Modal -->
<dialog id="cancelModal" class="modal">
  <div class="modal-box">
      <h3 class="font-bold text-lg">Konfirmasi Pembatalan</h3>
      <p class="py-4">Apakah Anda yakin ingin membatalkan reservasi ini?</p>
      <div class="modal-action">
          <form method="dialog">
              <button class="btn">Tutup</button>
          </form>
          <button id="confirmCancelBtn" class="btn btn-error">Ya, Batalkan</button>
      </div>
  </div>
</dialog>



<script>
  let currentBookingId = null;
  const cancelModal = document.getElementById('cancelModal');
  const confirmCancelBtn = document.getElementById('confirmCancelBtn');

  // Handle click tombol "Batalkan Reservasi"
  document.querySelectorAll('.cancel-booking-btn').forEach(button => {
      button.addEventListener('click', () => {
          currentBookingId = button.dataset.bookingId;
          cancelModal.showModal();
      });
  });

  // Handle submit tombol dalam modal
  confirmCancelBtn.addEventListener('click', requestCancelBooking);

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
              showToast('success', data.message);
              // Disable tombol cancel
              const btn = document.querySelector(`.cancel-booking-btn[data-booking-id="${currentBookingId}"]`);
              if (btn) btn.remove(); // atau btn.disabled = true;
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
      const badge = document.querySelector(`.status-badge[data-booking-id="${bookingId}"]`);
      if (badge) {
          badge.className = `badge ${getStatusClass(newStatus)} gap-2 status-badge`;
          badge.textContent = formatStatusText(newStatus);
      }
  }

  function getStatusClass(status) {
      switch (status) {
          case 'pending': return 'badge-warning';
          case 'confirmed': return 'badge-success';
          case 'request_cancel': return 'badge-error';
          default: return 'badge-ghost';
      }
  }

  function formatStatusText(status) {
      switch (status) {
          case 'pending': return 'Menunggu';
          case 'confirmed': return 'Terkonfirmasi';
          case 'request_cancel': return 'Dibatalkan';
          default: return status;
      }
  }

  function showToast(type, message) {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    const toast = document.createElement('div');
    
    toast.className = `toast toast-top`; // Hanya toast-top untuk posisi tengah atas
    toast.style.margin = '0 auto';
    toast.style.left = '0';
    toast.style.right = '0';
    toast.style.width = 'fit-content';
    
    toast.innerHTML = `
        <div class="alert alert-${type}">
            <div>
                <span>${message}</span>
            </div>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 5000);
}

  function createToastContainer() {
      const container = document.createElement('div');
      container.id = 'toast-container';
      container.className = 'toast-container';
      document.body.appendChild(container);
      return container;
  }
</script>


<script>
    // Theme switcher remains the same
    // ... 

    // Cancel booking functionality
    document.querySelectorAll('.cancel-booking').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('cancelModal').showModal();
        });
    });

    // Auto-generate booking ID (for reference)
    function generateBookingId(studioName, bookingDate, bookingId) {
        const studioCode = studioName.substring(0, 3).toUpperCase();
        const dateCode = bookingDate.replace(/-/g, '');
        return `${studioCode}-${dateCode}-${String(bookingId).padStart(4, '0')}`;
    }

    // Example usage in console:
    // console.log(generateBookingId('Studio Lens', '2023-06-15', 42));
    // Output: "STU-20230615-0042"

    const editModal = document.getElementById('editModal');
const editForm = document.getElementById('editBookingForm');
const editBookingIdInput = document.getElementById('editBookingId');
const editDateInput = document.getElementById('editDate');
const editTimeInput = document.getElementById('editTime');

document.querySelectorAll('.edit-booking-btn').forEach(button => {
    button.addEventListener('click', () => {
      const booking = JSON.parse(button.dataset.booking);
      const modal = document.getElementById('editModal');
      
      // Isi form dengan data booking
      document.getElementById('editBookingId').value = booking.id;
      document.getElementById('editDate').value = booking.tanggal_reservasi;
      
      // Set waktu yang dipilih
      const timeRadios = document.querySelectorAll('.time-radio');
      timeRadios.forEach(radio => {
        radio.checked = (radio.value === booking.waktu_reservasi);
      });
      
      // Tampilkan detail reservasi
      document.getElementById('studioNameDisplay').textContent = booking.studio.nama;
      document.getElementById('customerCountDisplay').textContent = booking.jumlah_pelanggan + ' orang';
      document.getElementById('durationDisplay').textContent = booking.durasi_jam + ' jam';
      document.getElementById('totalPriceDisplay').textContent = 'Rp' + booking.total_harga.toLocaleString('id-ID');
      
      // Set action form
      document.getElementById('editBookingForm').action = `/bookings/${booking.id}`;
      
      // Tampilkan modal
      modal.showModal();
    });
  });

  // Handle form submission
  document.getElementById('editBookingForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    
    try {
      // Tampilkan loading state
      submitButton.disabled = true;
      submitButton.innerHTML = '<span class="loading loading-spinner"></span> Menyimpan...';

      const response = await fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || 'Gagal memperbarui reservasi');
      }

      if (data.success) {
        // Tutup modal dan tampilkan notifikasi
        document.getElementById('editModal').close();
        showToast('success', 'Reservasi berhasil diperbarui');
        
        // Perbarui tampilan dengan data baru
        updateBookingDisplay(data.booking);
      } else {
        showToast('error', data.message);
      }
    } catch (error) {
      console.error('Error:', error);
      showToast('error', error.message);
    } finally {
      submitButton.disabled = false;
      submitButton.innerHTML = '<i class="fas fa-save"></i> Simpan Perubahan';
    }
  });

  function updateBookingDisplay(booking) {
    // Implementasi untuk memperbarui tampilan booking
    // Contoh:
    const bookingCard = document.querySelector(`.booking-card[data-booking-id="${booking.id}"]`);
    if (bookingCard) {
      const dateElement = bookingCard.querySelector('.booking-date');
      const timeElement = bookingCard.querySelector('.booking-time');
      
      if (dateElement) dateElement.textContent = booking.tanggal_reservasi;
      if (timeElement) timeElement.textContent = booking.waktu_reservasi;
    }
  }

  function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} fixed top-4 right-4 z-50 max-w-xs`;
    toast.innerHTML = `
      <div class="flex items-center">
        <span>${message}</span>
      </div>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
      toast.remove();
    }, 3000);
  }

</script>


</body>
</html>
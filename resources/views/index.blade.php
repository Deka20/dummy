<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

  {{-- Hero Section --}}
  <div class="hero bg-base-100 min-h-full pt-0 mt-0">
    <div class="hero-content flex-col lg:flex-row-reverse px-4 py-6 lg:px-16 lg:py-16">
      <img
      src="https://i.pinimg.com/736x/f5/ae/7d/f5ae7df196a797c96104311778212593.jpg"
      class="max-w-full lg:max-w-lg rounded-2xl shadow-[0px_0px_20px_10px_rgba(0,0,0,0.2)] mb-6 lg:mb-0"/>  
      <div class="text-center lg:text-left">
        <h1 class="text-3xl lg:text-5xl font-bold leading-tight">Professional Studio Space for Your Perfect Shot</h1>
        <p class="py-6 text-base lg:text-xl">
          Book premium photo studio space equipped with professional lighting and gear. Perfect for photographers, content creators, and artists.
        </p>
        <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
          <button class="btn btn-primary rounded-2xl">Reserve Studio</button>
          <button class="btn rounded-2xl">Take a Tour</button>
        </div>
      </div>
    </div>
  </div>
  {{-- Hero Section End --}}

  {{-- About Section --}}
  <h1 class="text-center text-3xl font-bold mt-10">Why Choose Our Studios</h1>
  <div class="min-h-full flex flex-col items-center justify-center p-4 bg-base-100">
    <!-- Container untuk card horizontal -->
    <div class="flex flex-col md:flex-row gap-6 items-center justify-center">
      <!-- Card 1 -->
      <div class="card bg-base-100 w-96 md:w-80 shadow-sm">
        <div class="card-body">
          <i class="fa-solid fa-camera text-primary text-2xl"></i>
          <h2 class="card-title">Professional Equipment</h2>
          <p>Access to high-end cameras, lighting, and accessories included with studio rental.</p>
        </div>
      </div>
      
      <!-- Card 2 -->
      <div class="card bg-base-100 w-96 md:w-80 shadow-sm">
        <div class="card-body">
          <i class="fa-solid fa-clock text-primary text-2xl"></i>
          <h2 class="card-title">Flexible Booking</h2>
          <p>Book by the hour or day, with easy scheduling and instant confirmation.</p>
        </div>
      </div>
      
      <!-- Card 3 -->
      <div class="card bg-base-100 w-96 md:w-80 shadow-sm">
        <div class="card-body">
          <i class="fa-solid fa-star text-2xl text-primary"></i>
          <h2 class="card-title">Premium Spaces</h2>
          <p>Multiple studio configurations with various backdrops and setups.</p>
        </div>
      </div>
    </div>
  </div>
  {{-- About Section End --}}

  {{-- Studio Section --}}
  <h1 class="text-center text-3xl font-bold mt-20">Our Studio Spaces</h1>
  <div class="flex flex-wrap justify-center gap-6 p-4">
    
    
    @php
use App\Models\Studio;
$studios = Studio::all();
@endphp

@foreach($studios as $studio)
<div class="relative">
  <!-- Kartu Studio -->
  <div class="card bg-base-100 shadow-xl w-96 md:w-80 rounded-2xl overflow-hidden cursor-pointer"
       onclick="document.getElementById('studio_modal_{{ $studio->id }}').showModal()">
      <figure>
          <img src="{{ asset('storage/' . $studio->cover_studio) }}"
               alt="{{ $studio->nama }}"
               class="w-full h-64 object-cover"/>
      </figure>
      <div class="absolute bottom-4 left-4">
          <button class="btn btn-sm rounded-xl">Rp{{ number_format($studio->harga_per_jam, 0, ',', '.') }}/Jam</button>
      </div>
  </div>

  <div class="mt-2">
      <h1 class="font-bold">{{ $studio->nama }}</h1>
      <p>{{ $studio->deskripsi }}</p>
  </div>

  <!-- Modal Booking -->
  <dialog id="studio_modal_{{ $studio->id }}" class="modal">
      <div class="modal-box">
          <form method="dialog">
              <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
          </form>
          <h3 class="text-lg font-bold">Booking Form for: {{ $studio->nama }}</h3>
          <div class="py-4 space-y-4">
              <img src="{{ asset('storage/' . $studio->cover_studio) }}"
                   class="rounded-lg w-full h-64 object-cover"
                   alt="{{ $studio->nama }}" />

              <form method="POST" action="{{ route('bookings.create') }}" id="bookingForm_{{ $studio->id }}">
                  @csrf
                  <input type="hidden" name="studio_id" value="{{ $studio->id }}">
                  <input type="hidden" name="harga_per_jam" value="{{ $studio->harga_per_jam }}">
                  <input type="hidden" name="biaya_per_pelanggan" value="5000">
                  <input type="hidden" name="booking_id" id="booking_id_{{ $studio->id }}">
                  <input type="hidden" name="total_harga" id="input_total_harga_{{ $studio->id }}">

                  <div class="form-control mb-4">
                      <label class="label">Jumlah Pelanggan</label>
                      <input type="number" name="jumlah_pelanggan" min="1" max="10" value="1"
                             class="input input-bordered" required
                             onchange="hitungTotal({{ $studio->id }})"
                             id="jumlah_pelanggan_{{ $studio->id }}">
                      <span class="text-xs text-gray-500 mt-1">*Biaya tambahan Rp5.000 per pelanggan</span>
                  </div>

                  <div class="form-control mb-4">
                      <label class="label">Tanggal Reservasi</label>
                      <input type="date" name="tanggal_reservasi" min="{{ date('Y-m-d') }}" class="input input-bordered" required>
                  </div>

                  <div class="mb-6">
                      <label class="block text-sm font-medium mb-2">Waktu Reservasi</label>
                      <div class="grid grid-cols-3 gap-2">
                          @for($hour = 9; $hour <= 21; $hour++)
                              <label class="flex items-center space-x-2 border rounded-lg p-3 cursor-pointer">
                                  <input type="radio" name="waktu_reservasi"
                                         value="{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00"
                                         class="radio radio-primary" required>
                                  <span>{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00</span>
                              </label>
                          @endfor
                      </div>
                  </div>

                  <div class="mb-6">
                      <label class="block text-sm font-medium mb-2">Durasi (Jam)</label>
                      <div class="flex space-x-4">
                          @foreach([1, 2, 3] as $durasi)
                              <label class="flex-1 flex flex-col items-center border rounded-lg p-4 cursor-pointer">
                                  <div class="flex items-center space-x-2 mb-2">
                                      <input type="radio" name="durasi_jam"
                                             value="{{ $durasi }}"
                                             class="radio radio-primary durasi-radio-{{ $studio->id }}"
                                             required
                                             onclick="hitungTotal({{ $studio->id }})"
                                             @if($durasi == 1) checked @endif>
                                      <span class="text-lg font-medium">{{ $durasi }} Jam</span>
                                  </div>
                                  <span class="text-sm text-gray-500">
                                      Rp{{ number_format($studio->harga_per_jam * $durasi, 0, ',', '.') }}
                                  </span>
                              </label>
                          @endforeach
                      </div>
                  </div>

                  <div class="p-4 border rounded-lg bg-gray-50 mb-6">
                      <h4 class="font-medium text-gray-700 mb-2">Rincian Harga:</h4>
                      <div class="flex justify-between text-sm mb-1">
                          <span>Harga Studio:</span>
                          <span id="harga_studio_{{ $studio->id }}"></span>
                      </div>
                      <div class="flex justify-between text-sm mb-1">
                          <span>Biaya Pelanggan:</span>
                          <span id="biaya_pelanggan_{{ $studio->id }}"></span>
                      </div>
                      <div class="border-t pt-2 mt-2 flex justify-between font-medium">
                          <span>Total:</span>
                          <span id="total_harga_{{ $studio->id }}"></span>
                      </div>
                  </div>

                  <div class="modal-action mt-6">
                      <button type="button" class="btn btn-primary w-full gap-2"
                              onclick="submitBookingForm({{ $studio->id }})">
                          <i class="fas fa-calendar-check"></i> Pesan Sekarang
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </dialog>

  <!-- Modal Konfirmasi -->
  <dialog id="confirmation_modal_{{ $studio->id }}" class="modal">
      <div class="modal-box text-center">
          <div class="flex flex-col items-center">
              <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
              </div>
              <h3 class="text-lg font-bold">Booking Berhasil!</h3>
              <p class="text-sm text-gray-600 mb-4">Detail pemesanan Anda dapat dilihat di menu Purchase History.</p>

              <div class="text-sm text-left w-full border p-4 rounded mb-4">
                  <div class="flex justify-between"><span>Booking ID:</span><span id="confirmation_booking_id_{{ $studio->id }}"></span></div>
                  <div class="flex justify-between"><span>Studio:</span><span>{{ $studio->nama }}</span></div>
                  <div class="flex justify-between"><span>Tanggal:</span><span id="confirmation_date_{{ $studio->id }}"></span></div>
                  <div class="flex justify-between"><span>Waktu:</span><span id="confirmation_time_{{ $studio->id }}"></span></div>
                  <div class="flex justify-between"><span>Durasi:</span><span id="confirmation_duration_{{ $studio->id }}"></span></div>
                  <div class="flex justify-between"><span>Jumlah Orang:</span><span id="confirmation_people_{{ $studio->id }}"></span></div>
                  <div class="flex justify-between border-t pt-2 mt-2"><span>Total:</span><span class="text-primary font-bold" id="confirmation_total_{{ $studio->id }}"></span></div>
              </div>

              <div class="flex gap-2 w-full">
                  <button class="btn btn-ghost flex-1" onclick="document.getElementById('confirmation_modal_{{ $studio->id }}').close()">Tutup</button>
                  <button class="btn btn-primary flex-1 gap-2" onclick="printBookingDetails({{ $studio->id }})"><i class="fas fa-print"></i> Cetak</button>
              </div>
          </div>
      </div>
  </dialog>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    hitungTotal({{ $studio->id }});
});

function hitungTotal(studioId) {
    const pelanggan = parseInt(document.getElementById(`jumlah_pelanggan_${studioId}`).value) || 0;
    const durasi = parseInt(document.querySelector(`.durasi-radio-${studioId}:checked`)?.value) || 1;
    const hargaPerJam = {{ $studio->harga_per_jam }};
    const biayaPerPelanggan = 5000;

    const totalStudio = hargaPerJam * durasi;
    const totalPelanggan = biayaPerPelanggan * pelanggan;
    const total = totalStudio + totalPelanggan;

    document.getElementById(`harga_studio_${studioId}`).textContent = 'Rp' + totalStudio.toLocaleString('id-ID');
    document.getElementById(`biaya_pelanggan_${studioId}`).textContent = 'Rp' + totalPelanggan.toLocaleString('id-ID');
    document.getElementById(`total_harga_${studioId}`).textContent = 'Rp' + total.toLocaleString('id-ID');
    document.getElementById(`input_total_harga_${studioId}`).value = total;
}

async function submitBookingForm(studioId) {
    const form = document.getElementById('bookingForm_' + studioId);
    const formData = new FormData(form);

    try {
        const response = await fetch("{{ route('bookings.create') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            document.getElementById('studio_modal_' + studioId).close();
            document.getElementById('confirmation_modal_' + studioId).showModal();

            document.getElementById('confirmation_booking_id_' + studioId).textContent = result.booking_id;
            document.getElementById('confirmation_date_' + studioId).textContent = formData.get('tanggal_reservasi');
            document.getElementById('confirmation_time_' + studioId).textContent = formData.get('waktu_reservasi');
            document.getElementById('confirmation_duration_' + studioId).textContent = formData.get('durasi_jam') + ' Jam';
            document.getElementById('confirmation_people_' + studioId).textContent = formData.get('jumlah_pelanggan') + ' Orang';
            document.getElementById('confirmation_total_' + studioId).textContent = 'Rp' + parseInt(formData.get('total_harga')).toLocaleString('id-ID');
        } else {
            alert('Gagal menyimpan booking.');
        }
    } catch (error) {
        console.error(error);
        alert('Terjadi error saat mengirim booking.');
    }
}

function printBookingDetails(studioId) {
    const win = window.open('', '_blank');
    const bookingHTML = `
        <h2>Booking Confirmation</h2>
        <p><strong>ID:</strong> ${document.getElementById('confirmation_booking_id_' + studioId).textContent}</p>
        <p><strong>Studio:</strong> {{ $studio->nama }}</p>
        <p><strong>Tanggal:</strong> ${document.getElementById('confirmation_date_' + studioId).textContent}</p>
        <p><strong>Waktu:</strong> ${document.getElementById('confirmation_time_' + studioId).textContent}</p>
        <p><strong>Durasi:</strong> ${document.getElementById('confirmation_duration_' + studioId).textContent}</p>
        <p><strong>Jumlah Orang:</strong> ${document.getElementById('confirmation_people_' + studioId).textContent}</p>
        <p><strong>Total:</strong> ${document.getElementById('confirmation_total_' + studioId).textContent}</p>
    `;
    win.document.write(`<html><head><title>Print Booking</title></head><body>${bookingHTML}</body></html>`);
    win.document.close();
    win.print();
}
</script>
@endforeach



  </div>
  {{-- Studio Section End --}}

  {{-- Portofolio Section --}}
  <h1 class="text-center text-3xl font-bold mt-20">Our Works</h1>

  <div class="carousel carousel-center rounded-box w-full mt-2">
    <!-- Carousel items with smaller images -->
    <div class="carousel-item w-full max-w-sm h-120">
      <img src="https://i.pinimg.com/736x/5a/43/f2/5a43f2ce1d97dcd421e143f8af0d7b9f.jpg" alt="Pizza" class="w-full h-full object-cover" />
    </div>
    <div class="carousel-item w-full max-w-sm h-120">
      <img src="https://i.pinimg.com/736x/3e/a5/28/3ea528de6bf87b2355ec2dfa12466cf2.jpg" alt="Pizza" class="w-full h-full object-cover" />
    </div>
    <div class="carousel-item w-full max-w-sm h-120">
      <img src="https://i.pinimg.com/736x/e5/62/91/e562915e7924c26cb987a2cf17a0df8b.jpg" alt="Pizza" class="w-full h-full object-cover" />
    </div>
    <div class="carousel-item w-full max-w-sm h-120">
      <img src="https://i.pinimg.com/736x/fc/99/6b/fc996b12c0597d22c5864932ee26ebef.jpg" alt="Pizza" class="w-full h-full object-cover" />
    </div>
    <div class="carousel-item w-full max-w-sm h-120">
      <img src="https://i.pinimg.com/736x/29/65/46/2965465644ad9029072e88867a54ae7f.jpg" alt="Pizza" class="w-full h-full object-cover" />
    </div>
    <div class="carousel-item w-full max-w-sm h-120">
      <img src="https://i.pinimg.com/736x/f5/19/d4/f519d497c0aa810919c6cce85a83f44b.jpg" alt="Pizza" class="w-full h-full object-cover" />
    </div>
    <div class="carousel-item w-full max-w-sm h-120">
      <img src="https://i.pinimg.com/736x/2c/1d/f8/2c1df8cc97600f808a70ec11d5757b8c.jpg" alt="Pizza" class="w-full h-full object-cover" />
    </div>
</div>
  </div>
  {{-- Portofolio Section End --}}

{{-- Rating Section --}}
<h1 class="text-center text-3xl font-bold mt-20">Ratings & Reviews</h1>

<div class="max-w-4xl mx-auto p-4 space-y-6">

  {{-- Persiapan Data Rating dari semua studio --}}
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

{{-- Card Rating Rata-rata --}}
<div class="card bg-base-100 shadow-lg">
<div class="card-body">
  <h2 class="card-title text-2xl">Ulasan Pengguna</h2>
  <div class="flex flex-col md:flex-row items-center gap-8">
    {{-- Bagian Rating --}}
    <div class="text-center">
      <div class="text-5xl font-bold text-primary">
        {{ number_format($averageRating, 1) }}
      </div>
      <div class="rating rating-md rating-half my-2">
        @for($i = 1; $i <= 5; $i++)
          <input type="radio" class="bg-green-500 mask mask-star-2" disabled {{ $i <= round($averageRating) ? 'checked' : '' }}/>
        @endfor
      </div>
      <p class="text-gray-500">Dari {{ $totalReviews }} ulasan</p>
    </div>

    {{-- Progress Bar --}}
    <div class="flex-1 w-full space-y-2">
      @foreach(range(5,1) as $star)
        @php
          $count = $ratingsDistribution[$star] ?? 0;
          $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        @endphp
        <div class="flex items-center gap-2">
          <!-- Star + Number -->
          <span class="w-16 text-sm flex items-center gap-1 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.286 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.286-3.955a1 1 0 00-.364-1.118L2.075 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.955z"/>
            </svg>
            {{ $star }}
          </span>
    
          <!-- Progress Bar -->
          <progress class="progress progress-primary h-3 w-full min-w-0" value="{{ $percentage }}" max="100"></progress>
    
          <!-- Count -->
          <span class="w-20 text-sm text-gray-500 flex-shrink-0 whitespace-nowrap text-right">
            {{ round($count) }} Orang
          </span>
        </div>
      @endforeach
    </div>    
  </div>
</div>
</div>

@php
$allReviews = App\Models\Booking::whereNotNull('review')
    ->whereNotNull('rating')
    ->with(['user', 'studio'])
    ->orderBy('reviewed_at', 'desc')
    ->paginate(5);

$editingReviewId = request()->query('edit'); // Ambil ID dari query param ?edit=ID
@endphp

@if($allReviews->count())
<div class="space-y-4">
  @foreach($allReviews as $booking)
  <div class="card bg-base-100 shadow-md p-4" x-data="{ editing: false }">
      <div class="flex justify-between items-start">
        <div class="flex items-center space-x-3">
          <div class="avatar">
            <div class="w-12 rounded-full">
              <img src="{{ $booking->user->avatar ? asset('storage/public/avatars/'.$booking->user->avatar) : 'https://i.pravatar.cc/150?img='.$booking->user->id }}" 
                   alt="{{ $booking->user->name }}" />
            </div>
          </div>
          <div>
              <h3 class="font-bold">{{ $booking->user->name }}</h3>
              <p class="text-sm text-gray-500">{{ $booking->studio->nama }}</p>
          </div>
      </div>      
          @if(Auth::id() == $booking->user_id)
              <div>
                  <button class="btn btn-sm btn-outline" @click="editing = !editing">Edit</button>
                  <form action="{{ route('reviews.destroy', $booking->id) }}" method="POST" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-error ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                  </form>
              </div>
          @endif
      </div>

      {{-- Show content or form based on Alpine state --}}
      <div x-show="!editing" class="mt-3">
          <p class="text-gray-700">{{ $booking->review }}</p>
          <div class="rating rating-sm mt-2">
              @for($i = 1; $i <= 5; $i++)
                  <input type="radio" class="mask mask-star bg-yellow-400" disabled {{ $i == $booking->rating ? 'checked' : '' }} />
              @endfor
          </div>
      </div>

      <div x-show="editing" class="mt-3">
          <form action="{{ route('reviews.update', $booking->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="mb-2">
                  <textarea name="review" class="textarea textarea-bordered w-full" required>{{ $booking->review }}</textarea>
              </div>
              <div class="mb-2">
                <label class="block mb-1">Rating:</label>
                <div class="rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <input type="radio" 
                               name="rating" 
                               value="{{ $i }}" 
                               class="mask mask-star bg-yellow-400" 
                               {{ $booking->rating == $i ? 'checked' : '' }} 
                               required />
                    @endfor
                </div>
            </div>
            
              <div class="flex gap-2">
                  <button type="submit" class="btn btn-sm btn-primary">Save</button>
                  <button type="button" class="btn btn-sm" @click="editing = false">Cancel</button>
              </div>
          </form>
      </div>
  </div>
@endforeach

</div>

<div class="mt-6">
    {{ $allReviews->withQueryString()->links() }}
</div>
@else
<p class="text-center text-gray-500">No reviews yet.</p>
@endif






  {{-- Footer --}}
  <footer class="footer sm:footer-horizontal bg-base-100 text-base-content p-10 mt-30">
    <nav>
      <i class="fa-solid fa-camera-retro text-3xl text-primary opacity-50"></i>
     <p class="text-gray-400 mt-3">Professional photo studio spaces <br>
       for creative presonals.</p>
    </nav>
    <nav>
      <a class="link link-hover text-gray-400">Studio</a>
      <a class="link link-hover text-gray-400">Services</a>
      <a class="link link-hover text-gray-400">Pricing</a>
      <a class="link link-hover text-gray-400">Contact</a>
    </nav>
    <nav>
      <div>
        <i class="fa-solid fa-location-dot text-gray-400"></i>
        <a class="link link-hover text-gray-400">Tiban 2 - B4 No.3</a>
      </div>
      <div>
        <i class="fa-solid fa-phone text-gray-400"></i>
        <a class="link link-hover text-gray-400">+62 88271159334</a>
      </div>
      <div>
        <i class="fa-solid fa-envelope text-gray-400"></i>
        <a class="link link-hover text-gray-400">Studiolens@gmail.com</a>
      </div>
    </nav>
    <nav>
      <h6 class="footer-title text-gray-400">Social</h6>
      <div class="grid grid-flow-col gap-4">
        <a href="">
          <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          class="fill-current text-cyan-500">
          <path
            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
        </svg>
        </a>
        <a href="">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            class="fill-current text-red-600">
            <path
              d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
          </svg>
        </a>
        <a href="">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            class="fill-current text-blue-600">
            <path
              d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
          </svg>
        </a>
      </div>
    </nav>
  </footer>

  <div class="flex items-center justify-center">
    <hr class="w-1/2 border-t-2 border-gray-300">
  </div>

  <footer class="footer sm:footer-horizontal footer-center bg-base-100 p-4 text-gray-400">
    <aside>
      <p>Copyright © 2025 StudioLens - All right reserved</p>
    </aside>
  </footer>
  {{-- Footer End --}}

  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
  // Modal Functionality
  const modal = document.getElementById('my_modal_3');
  if (modal) {
    modal.showModal();
    const closeButton = modal.querySelector('.btn-ghost');
    if (closeButton) {
      closeButton.addEventListener('click', () => {
        modal.close();
      });
    }
  }

  // Mobile Menu Functionality
  const menuButton = document.getElementById('mobile-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');
  
  // Define icons first
  const menuIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
  const closeIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';

  if (menuButton && mobileMenu) {
    const icon = menuButton.querySelector('svg');
    
    menuButton.addEventListener('click', (e) => {
      e.stopPropagation();
      const isHidden = mobileMenu.classList.toggle('hidden');
      
      // Update icon only if exists
      if (icon) {
        icon.innerHTML = isHidden ? menuIcon : closeIcon;
      }
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
      if (!mobileMenu.contains(e.target) && !menuButton.contains(e.target)) {
        mobileMenu.classList.add('hidden');
        if (icon) {
          icon.innerHTML = menuIcon;
        }
      }
    });

    // Close on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
        if (icon) {
          icon.innerHTML = menuIcon;
        }
      }
    });
  }
});
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

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
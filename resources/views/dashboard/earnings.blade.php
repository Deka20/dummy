<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>StudioLens Dashboard</title>
  <!-- Gunakan salah satu CSS framework, tidak perlu keduanya -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <!-- Load Font Awesome untuk icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Load Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .card {
      border-radius: 0.5rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .chart-area {
      position: relative;
      height: 400px;
      width: 100%;
    }
  </style>
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-8">
  <div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b flex justify-between items-center">
      <h1 class="text-xl font-bold text-gray-800">Data Penghasilan</h1>
      <div class="badge bg-red-500 text-white px-3 py-1 rounded-full">
        Pesan Baru: {{ $newOrdersCount ?? 0 }}
      </div>
    </div>
    
    <div class="p-6">
      <!-- Statistik Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Penghasilan -->
        <div class="bg-white border-l-4 border-blue-500 rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-500 uppercase">Total Penghasilan</p>
              <p class="text-2xl font-bold text-gray-800">
                Rp {{ isset($totalEarnings) ? number_format($totalEarnings, 0, ',', '.') : '0' }}
              </p>
            </div>
            <div class="text-gray-300">
              <i class="fas fa-money-bill-wave fa-2x"></i>
            </div>
          </div>
        </div>
        
        <!-- Penghasilan Bulan Ini -->
        <div class="bg-white border-l-4 border-green-500 rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-500 uppercase">Penghasilan Bulan Ini</p>
              <p class="text-2xl font-bold text-gray-800">
                Rp {{ isset($monthlyEarnings) ? number_format($monthlyEarnings, 0, ',', '.') : '0' }}
              </p>
            </div>
            <div class="text-gray-300">
              <i class="fas fa-calendar fa-2x"></i>
            </div>
          </div>
        </div>
        
        <!-- Penghasilan Minggu Ini -->
        <div class="bg-white border-l-4 border-cyan-500 rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-500 uppercase">Penghasilan Minggu Ini</p>
              <p class="text-2xl font-bold text-gray-800">
                Rp {{ isset($weeklyEarnings) ? number_format($weeklyEarnings, 0, ',', '.') : '0' }}
              </p>
            </div>
            <div class="text-gray-300">
              <i class="fas fa-calendar-week fa-2x"></i>
            </div>
          </div>
        </div>
        
        <!-- Transaksi Hari Ini -->
        <div class="bg-white border-l-4 border-yellow-500 rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-500 uppercase">Transaksi Hari Ini</p>
              <p class="text-2xl font-bold text-gray-800">
                {{ $todayBookingsCount ?? 0 }}
              </p>
            </div>
            <div class="text-gray-300">
              <i class="fas fa-receipt fa-2x"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Grafik -->
      <div class="mb-8">
        <div class="chart-area">
          <canvas id="earningsChart"></canvas>
        </div>
      </div>

      <!-- Filter -->
      <div class="bg-gray-50 p-4 rounded-lg">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Filter Data</h2>
        <form method="GET" action="{{ route('dashboard.earnings') }}" class="flex flex-col md:flex-row gap-4">
          <div class="flex-1">
            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
            <select name="year" id="year" class="w-full p-2 border rounded-md">
              @foreach($availableYears as $year)
                <option value="{{ $year }}" {{ ($selectedYear ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
              @endforeach
            </select>
          </div>
          
          <div class="flex-1">
            <label for="studio" class="block text-sm font-medium text-gray-700 mb-1">Studio</label>
            <select name="studio" id="studio" class="w-full p-2 border rounded-md">
              <option value="">Semua Studio</option>
              @foreach($studios as $studio)
                <option value="{{ $studio->id }}" {{ ($selectedStudio ?? '') == $studio->id ? 'selected' : '' }}>
                  {{ $studio->nama_studio }}
                </option>
              @endforeach
            </select>
          </div>
          
          <div class="self-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
              Filter
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Pastikan elemen canvas ada
    const ctx = document.getElementById('earningsChart');
    if (!ctx) return;

    // Data untuk chart
    const labels = {!! json_encode($monthlyLabels ?? []) !!};
    const data = {!! json_encode($monthlyData ?? []) !!};

    // Buat chart
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Penghasilan per Bulan (Rp)',
          data: data,
          backgroundColor: 'rgba(59, 130, 246, 0.05)',
          borderColor: 'rgba(59, 130, 246, 1)',
          borderWidth: 2,
          pointBackgroundColor: 'rgba(59, 130, 246, 1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(59, 130, 246, 1)',
          pointRadius: 4,
          pointHoverRadius: 6,
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';
                if (label) label += ': ';
                label += 'Rp ' + context.raw.toLocaleString('id-ID');
                return label;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });
  });
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Pemesanan - Studio Lens</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans">
    <div class="max-w-2xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Pesan Studio</h1>
        
        @if(session('success'))
            <div class="alert alert-success mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('bookings.store') }}">
            @csrf
            
            <!-- Studio Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Studio:</label>
                <select name="studio_id" class="w-full p-2 border rounded-md">
                    @foreach($studios as $studio)
                        <option value="{{ $studio->id }}">{{ $studio->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Jumlah orang -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Jumlah Orang:</label>
                <input 
                    type="number" 
                    name="jumlah_pelanggan"
                    min="1"
                    max="10"
                    class="w-full p-2 border rounded-md"
                    required
                >
            </div>

            <!-- Tanggal -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Tanggal:</label>
                <input 
                    type="date" 
                    name="tanggal_reservasi"
                    min="{{ date('Y-m-d') }}"
                    class="w-full p-2 border rounded-md"
                    required
                >
            </div>

            <!-- Waktu -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Waktu:</label>
                <input 
                    type="time" 
                    name="waktu_reservasi"
                    min="09:00"
                    max="22:00"
                    class="w-full p-2 border rounded-md"
                    required
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700"
            >
                Pesan Sekarang
            </button>
        </form>
    </div>
</body>
</html>
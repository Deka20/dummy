<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Create Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.3/dist/full.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full p-6 bg-white shadow-lg rounded-lg">
        <form action="{{ route('dashboard.update', $studio->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
        
            @if($errors->any())
                <div class="alert alert-error shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>
                            @foreach($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </span>
                    </div>
                </div>
            @endif
        
            <!-- Studio Name -->
            <div class="form-control">
                <label class="label" for="nama">
                    <span class="label-text">Studio Name</span>
                </label>
                <input type="text" id="nama" name="nama" 
                       class="input bg-white input-bordered w-full @error('nama') input-error @enderror" 
                       value="{{ old('nama', $studio->name) }}" required>
                @error('nama')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
        
            <!-- deskripsi -->
            <div class="form-control">
                <label class="label" for="deskripsi">
                    <span class="label-text">deskripsi</span>
                </label>
                <textarea id="deskripsi" name="deskripsi" 
                          class="textarea bg-white textarea-bordered h-24 @error('deskripsi') textarea-error @enderror">{{ old('deskripsi', $studio->deskripsi) }}</textarea>
                @error('deskripsi')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
        
            <!-- kapasitas -->
            <div class="form-control">
                <label class="label" for="kapasitas">
                    <span class="label-text">kapasitas</span>
                </label>
                <input type="number" id="kapasitas" name="kapasitas" min="1" 
                       class="input bg-white input-bordered w-full @error('kapasitas') input-error @enderror" 
                       value="{{ old('kapasitas', $studio->kapasitas) }}" required>
                @error('kapasitas')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
        
            <!-- Price per Hour -->
            <div class="form-control">
                <label class="label" for="harga_per_jam">
                    <span class="label-text">Price per Hour</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600">Rp</span>
                    <input type="number" id="harga_per_jam" name="harga_per_jam" min="0" 
                           class="input bg-white input-bordered w-full pl-10 @error('harga_per_jam') input-error @enderror" 
                           value="{{ old('harga_per_jam', $studio->harga_per_jam) }}" required>
                </div>
                @error('harga_per_jam')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
 
            <!-- Submit Button -->
            <div class="form-control pt-6">
                <button type="submit" class="btn btn-primary w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Update Studio
                </button>
            </div>
        </form>
    </div>
</body>
</html>

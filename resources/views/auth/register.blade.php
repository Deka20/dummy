<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="card-body p-8">
            <h2 class="text-2xl font-bold text-center mb-6">Create Your Account</h2>
            
            @if ($errors->any())
                <div class="alert alert-error mb-6 transition-all duration-300 animate-fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="font-bold">Registration Failed!</h3>
                        <div class="text-xs">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                
                <!-- Name Field -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Full Name</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        placeholder="John Doe" 
                        class="input input-bordered w-full bg-white @error('name') input-error @enderror"
                        value="{{ old('name') }}"
                        required
                        autofocus>
                    @error('name')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Username Field -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Username</span>
                    </label>
                    <input 
                        type="text" 
                        name="username" 
                        placeholder="johndoe123" 
                        class="input input-bordered w-full bg-white @error('username') input-error @enderror"
                        value="{{ old('username') }}"
                        required>
                    @error('username')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                
                <!-- Email Field -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Email Address</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="your@email.com" 
                        class="input input-bordered w-full bg-white @error('email') input-error @enderror"
                        value="{{ old('email') }}"
                        required>
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                
                <!-- Password Field -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Password</span>
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Minimum 8 characters" 
                        class="input input-bordered w-full bg-white @error('password') input-error @enderror"
                        required
                        minlength="8">
                    @error('password')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                
                <!-- Confirm Password Field -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Confirm Password</span>
                    </label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        placeholder="Re-type your password" 
                        class="input input-bordered w-full bg-white"
                        required
                        minlength="8">
                </div>
                
                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">
                        Already have an account? Login
                    </a>
                    
                    <button type="submit" class="btn btn-primary px-8 bg-gradient-to-r from-blue-500 to-purple-600 border-none hover:from-blue-600 hover:to-purple-700">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="flex h-screen bg-gray-50">
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
      <a href="{{ route('dashboard.studios') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 transition-colors duration-200">
        <i class="fas fa-camera mr-3 w-5 text-center"></i>
        Studios
      </a>
      <a href="{{route('dashboard.customers')}}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 transition-colors duration-200">
        <i class="fas fa-users mr-3 w-5 text-center"></i>
        Customers
      </a>
      <a href="{{route('dashboard.settings')}}" class="flex items-center px-4 py-3 bg-slate-700 text-white">
        <i class="fas fa-images mr-3 w-5 text-center"></i>
        Portfolio
      </a>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col overflow-hidden">
    <!-- Top Navbar -->
    <header class="bg-white shadow-sm">
      <div class="flex justify-between items-center p-4">
        <h2 class="text-xl font-semibold text-gray-800">Portfolio Management</h2>
        <div class="flex items-center space-x-4">
          <div class="avatar">
            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
              <i class="fas fa-user text-gray-500"></i>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
      <div class="max-w-7xl mx-auto">
        <!-- Success Message -->
        @if(session('success'))
          <div class="alert alert-success shadow-lg mb-6 transition-all duration-300">
            <div>
              <i class="fas fa-check-circle"></i>
              <span>{{ session('success') }}</span>
            </div>
          </div>
        @endif
        
        <!-- Upload Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">Upload New Image</h2>
            <i class="fas fa-cloud-upload-alt text-blue-500 text-xl"></i>
          </div>
          
          <form action="{{ route('dashboard.portfolio.save') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <!-- File Input -->
            <div class="form-control">
              <label class="label">
                <span class="label-text">Image File</span>
              </label>
              <label class="input-group">
                <span class="bg-blue-500 text-white"><i class="fas fa-image"></i></span>
                <input type="file" id="image" name="image" accept="image/*" 
                       class="file-input file-input-bordered w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
              </label>
              @error('image')
                <div class="text-red-500 text-sm mt-1 flex items-center">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  {{ $message }}
                </div>
              @enderror
            </div>
            
            <!-- Order Input -->
            <div class="form-control">
              <label class="label">
                <span class="label-text">Display Order</span>
              </label>
              <input type="number" id="order" name="order" min="1" 
                     class="input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                     placeholder="Leave empty to add at the end">
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload mr-2"></i>
                Upload Image
              </button>
            </div>
          </form>
        </div>
        
        <!-- Portfolio Gallery -->
        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Portfolio Gallery</h2>
            <span class="badge badge-primary">
              {{ $portfolioItems->count() }} {{ Str::plural('Image', $portfolioItems->count()) }}
            </span>
          </div>
          
          @if($portfolioItems->isEmpty())
            <div class="text-center py-12">
              <i class="fas fa-images text-4xl text-gray-300 mb-4"></i>
              <p class="text-gray-500 text-lg">No portfolio images uploaded yet.</p>
              <p class="text-gray-400">Upload your first image using the form above.</p>
            </div>
          @else
            <!-- Grid Layout -->
            <div id="portfolio-items" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
              @foreach($portfolioItems as $item)
                <div class="portfolio-item card bg-base-100 shadow-sm hover:shadow-md transition-shadow duration-300" data-id="{{ $item->id }}">
                  <figure class="relative aspect-square bg-gray-100">
                    <img src="{{ $item->image_url }}" class="w-full h-full object-cover" alt="Portfolio image">
                    
                    <!-- Image Actions -->
                    <div class="absolute top-3 right-3 flex space-x-2">
                      <span class="badge badge-neutral">
                        #{{ $item->order }}
                      </span>
                      <form action="{{ route('dashboard.portfolio.delete', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-circle btn-sm btn-error"
                                onclick="return confirm('Are you sure you want to delete this image?')">
                          <i class="fas fa-trash text-white"></i>
                        </button>
                      </form>
                    </div>
                  </figure>
                  
                  <div class="card-body p-4">
                    <div class="flex items-center justify-between">
                      <label class="text-gray-700">Order:</label>
                      <input type="number" value="{{ $item->order }}" min="1" 
                             class="order-input input input-bordered input-sm w-20 text-center">
                    </div>
                    <div class="text-xs text-gray-500 mt-2">
                      Uploaded: {{ $item->created_at->format('M d, Y') }}
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            
            <!-- Save Order Button -->
            <div class="mt-8 flex justify-center">
              <button id="save-order" class="btn btn-success">
                <i class="fas fa-save mr-2"></i>
                Save Order Changes
              </button>
            </div>
          @endif
        </div>
      </div>
    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Save order changes
      document.getElementById('save-order')?.addEventListener('click', function() {
        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
        btn.disabled = true;
        
        const items = [];
        document.querySelectorAll('.portfolio-item').forEach(function(item) {
          const id = item.dataset.id;
          const orderInput = item.querySelector('.order-input');
          
          items.push({
            id: parseInt(id),
            order: parseInt(orderInput.value)
          });
        });
        
        // Send AJAX request
        fetch('{{ route("dashboard.portfolio.update-order") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Create toast notification
            const toast = document.createElement('div');
            toast.className = 'toast toast-top toast-center';
            toast.innerHTML = `
              <div class="alert alert-success">
                <div>
                  <i class="fas fa-check-circle"></i>
                  <span>Order updated successfully!</span>
                </div>
              </div>
            `;
            document.body.appendChild(toast);
            
            // Remove toast after 3 seconds
            setTimeout(() => {
              toast.remove();
            }, 3000);
          } else {
            throw new Error(data.message || 'Failed to update order');
          }
        })
        .catch(error => {
          alert(error.message);
        })
        .finally(() => {
          btn.innerHTML = originalText;
          btn.disabled = false;
        });
      });
      
      // Image preview before upload
      const imageInput = document.getElementById('image');
      if (imageInput) {
        imageInput.addEventListener('change', function() {
          const preview = document.getElementById('image-preview');
          if (!preview) {
            const previewDiv = document.createElement('div');
            previewDiv.id = 'image-preview';
            previewDiv.className = 'mt-4';
            this.parentNode.appendChild(previewDiv);
          }
          
          if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
              const img = document.createElement('img');
              img.src = e.target.result;
              img.className = 'h-40 object-contain border rounded-lg';
              document.getElementById('image-preview').innerHTML = '';
              document.getElementById('image-preview').appendChild(img);
            }
            reader.readAsDataURL(this.files[0]);
          }
        });
      }
    });
  </script>
</body>
</html>
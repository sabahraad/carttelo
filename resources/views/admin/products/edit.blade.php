@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page_title', 'Edit Product: ' . $product->name)

@section('content')
    <style>
        .form-section {
            background: white;
            border-radius: 16px;
            padding: 32px;
            border: 1px solid #e5e7eb;
        }
        .section-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f3f4f6;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }
        .section-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }
        .form-group {
            margin-bottom: 24px;
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .form-label span.required {
            color: #ef4444;
            margin-left: 2px;
        }
        .form-label span.optional {
            color: #9ca3af;
            font-weight: 400;
        }
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.2s;
            background: white;
        }
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-input.error, .form-textarea.error, .form-select.error {
            border-color: #ef4444;
        }
        .form-input::placeholder, .form-textarea::placeholder {
            color: #9ca3af;
        }
        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }
        .input-hint {
            font-size: 12px;
            color: #6b7280;
            margin-top: 6px;
        }
        .error-message {
            font-size: 13px;
            color: #ef4444;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        /* Existing Images */
        .existing-images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }
        .existing-image-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid #e5e7eb;
        }
        .existing-image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .existing-image-item .main-badge {
            position: absolute;
            bottom: 6px;
            left: 6px;
            background: #3b82f6;
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 4px;
        }
        .existing-image-item .delete-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 24px;
            height: 24px;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        
        /* Drag & Drop Zone */
        .upload-zone {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            transition: all 0.2s;
            cursor: pointer;
            background: #f9fafb;
        }
        .upload-zone:hover, .upload-zone.dragover {
            border-color: #3b82f6;
            background: #eff6ff;
        }
        .upload-zone-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            color: #9ca3af;
        }
        .upload-zone-text {
            font-size: 14px;
            color: #374151;
        }
        .upload-zone-text span {
            color: #3b82f6;
            font-weight: 500;
        }
        .upload-zone-hint {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }
        
        /* New Image Preview Grid */
        .image-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 12px;
            margin-top: 16px;
        }
        .image-preview-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid #e5e7eb;
        }
        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .image-preview-remove {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 24px;
            height: 24px;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            line-height: 1;
        }
        
        /* Toggle Switch */
        .toggle-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .toggle {
            position: relative;
            width: 52px;
            height: 28px;
        }
        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e5e7eb;
            transition: .3s;
            border-radius: 28px;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }
        .toggle input:checked + .toggle-slider {
            background-color: #3b82f6;
        }
        .toggle input:checked + .toggle-slider:before {
            transform: translateX(24px);
        }
        .toggle-label {
            font-size: 14px;
            color: #374151;
        }
        .toggle-label strong {
            display: block;
            font-weight: 600;
        }
        .toggle-label span {
            font-size: 12px;
            color: #6b7280;
        }
        
        /* Submit Buttons */
        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        .btn-secondary {
            background: white;
            color: #374151;
            border: 1px solid #d1d5db;
        }
        .btn-secondary:hover {
            background: #f9fafb;
        }
        .btn-danger {
            background: #ef4444;
            color: white;
        }
        .btn-danger:hover {
            background: #dc2626;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 24px;
            margin-top: 24px;
            border-top: 1px solid #f3f4f6;
        }
        .form-actions-right {
            display: flex;
            gap: 12px;
        }
    </style>

    <div class="max-w-4xl">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="updateForm">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="form-section mb-6">
                <div class="section-header">
                    <h3 class="section-title">Basic Information</h3>
                    <p class="section-subtitle">Update the product name and description</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="form-group md:col-span-2">
                        <label for="name" class="form-label">
                            Product Name <span class="required">*</span>
                        </label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name', $product->name) }}"
                               class="form-input @error('name') error @enderror"
                               placeholder="e.g., Wireless Bluetooth Headphones"
                               required>
                        @error('name')
                            <p class="error-message">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="form-group md:col-span-2">
                        <label for="slug" class="form-label">
                            URL Slug <span class="optional">(optional)</span>
                        </label>
                        <input type="text" name="slug" id="slug" 
                               value="{{ old('slug', $product->slug) }}"
                               class="form-input @error('slug') error @enderror"
                               placeholder="wireless-bluetooth-headphones">
                        <p class="input-hint">This will be used in the product URL</p>
                        @error('slug')
                            <p class="error-message">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group md:col-span-2">
                        <label for="description" class="form-label">
                            Description
                        </label>
                        <textarea name="description" id="description" 
                                  class="form-textarea @error('description') error @enderror"
                                  placeholder="Describe your product features, specifications, and benefits...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="error-message">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="form-section mb-6">
                <div class="section-header">
                    <h3 class="section-title">Product Images</h3>
                    <p class="section-subtitle">Manage existing images or add new ones</p>
                </div>

                <!-- Existing Images -->
                @if ($product->images->count() > 0)
                    <div class="form-group">
                        <label class="form-label">Current Images ({{ $product->images->count() }})</label>
                        <div class="existing-images-grid">
                            @foreach ($product->images as $index => $image)
                                <div class="existing-image-item">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image">
                                    @if ($index === 0)
                                        <span class="main-badge">MAIN</span>
                                    @endif
                                    <button type="button" class="delete-btn" onclick="deleteImage({{ $image->id }})">×</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Add New Images -->
                <div class="form-group">
                    <label class="form-label">Add New Images</label>
                    <div class="upload-zone" id="dropZone">
                        <svg class="upload-zone-icon" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p class="upload-zone-text"><span>Click to upload</span> or drag and drop</p>
                        <p class="upload-zone-hint">PNG, JPG, GIF up to 2MB each</p>
                        <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden">
                    </div>
                    <div id="imagePreview" class="image-preview-grid"></div>
                    @error('images.*')
                        <p class="error-message">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Pricing -->
            <div class="form-section mb-6">
                <div class="section-header">
                    <h3 class="section-title">Pricing</h3>
                    <p class="section-subtitle">Update buy price, sell price, and discount</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Buy Price -->
                    <div class="form-group">
                        <label for="buy_price" class="form-label">
                            Buy Price <span class="optional">(Cost)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">৳</span>
                            <input type="number" name="buy_price" id="buy_price" 
                                   value="{{ old('buy_price', $product->buy_price) }}"
                                   min="0"
                                   step="0.01"
                                   class="form-input @error('buy_price') error @enderror pl-8"
                                   placeholder="0.00">
                        </div>
                        <p class="input-hint">Your purchase cost (internal only)</p>
                        @error('buy_price')
                            <p class="error-message">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Sell Price -->
                    <div class="form-group">
                        <label for="sell_price" class="form-label">
                            Sell Price <span class="required">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">৳</span>
                            <input type="number" name="sell_price" id="sell_price" 
                                   value="{{ old('sell_price', $product->sell_price) }}"
                                   min="0"
                                   step="0.01"
                                   class="form-input @error('sell_price') error @enderror pl-8"
                                   placeholder="0.00"
                                   required>
                        </div>
                        <p class="input-hint">Regular selling price</p>
                        @error('sell_price')
                            <p class="error-message">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Discount Price -->
                    <div class="form-group">
                        <label for="discount_price" class="form-label">
                            Discount Price <span class="optional">(Offer)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">৳</span>
                            <input type="number" name="discount_price" id="discount_price" 
                                   value="{{ old('discount_price', $product->discount_price) }}"
                                   min="0"
                                   step="0.01"
                                   class="form-input @error('discount_price') error @enderror pl-8"
                                   placeholder="0.00">
                        </div>
                        <p class="input-hint">Special offer price (optional)</p>
                        @error('discount_price')
                            <p class="error-message">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Video & Stock -->
            <div class="form-section mb-6">
                <div class="section-header">
                    <h3 class="section-title">Video & Inventory</h3>
                    <p class="section-subtitle">Update product video and stock quantity</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Video URL -->
                    <div class="form-group">
                        <label for="video_url" class="form-label">
                            YouTube Video URL
                        </label>
                        <input type="url" name="video_url" id="video_url" 
                               value="{{ old('video_url', $product->video_url) }}"
                               class="form-input @error('video_url') error @enderror"
                               placeholder="https://www.youtube.com/watch?v=...">
                        <p class="input-hint">Add a product demo or review video from YouTube</p>
                        @error('video_url')
                            <p class="error-message">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="form-group">
                        <label for="stock" class="form-label">
                            Stock Quantity <span class="required">*</span>
                        </label>
                        <input type="number" name="stock" id="stock" 
                               value="{{ old('stock', $product->stock) }}"
                               min="0"
                               class="form-input @error('stock') error @enderror"
                               placeholder="0"
                               required>
                        <p class="input-hint">Number of items available for sale</p>
                        @error('stock')
                            <p class="error-message">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Status Toggle -->
                    <div class="form-group md:col-span-2">
                        <label class="form-label">Product Status</label>
                        <div class="toggle-wrapper">
                            <label class="toggle">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <div class="toggle-label">
                                <strong>Active</strong>
                                <span>Product will be visible on the website</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="form-actions">
                <button type="button" onclick="confirmDelete()" class="btn btn-danger">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Product
                </button>
                <div class="form-actions-right">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Hidden Forms for Actions -->
    <form id="deleteForm" action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <form id="deleteImageForm" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                document.getElementById('deleteForm').submit();
            }
        }

        function deleteImage(imageId) {
            if (confirm('Delete this image?')) {
                const form = document.getElementById('deleteImageForm');
                form.action = '/admin/products/{{ $product->id }}/images/' + imageId;
                form.submit();
            }
        }

        // Image preview functionality
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('images');
        const previewContainer = document.getElementById('imagePreview');
        let selectedFiles = [];

        dropZone.addEventListener('click', () => fileInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
            handleFiles(files);
        });

        fileInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            handleFiles(files);
        });

        function handleFiles(files) {
            selectedFiles = [...selectedFiles, ...files];
            updatePreview();
            updateFileInput();
        }

        function updatePreview() {
            previewContainer.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'image-preview-item';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="image-preview-remove" onclick="removeImage(${index})">×</button>
                    `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1);
            updatePreview();
            updateFileInput();
        }
    </script>
@endsection

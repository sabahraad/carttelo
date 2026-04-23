@extends('layouts.admin')

@section('title', 'Logo Settings')
@section('page_title', 'Logo & Favicon')

@section('content')
    <style>
        .form-section {
            background: white;
            border-radius: 16px;
            padding: 32px;
            border: 1px solid #e5e7eb;
            max-width: 600px;
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
        
        /* Submit Button */
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
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        
        /* Info Card */
        .info-card {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 24px;
        }
        .info-card-title {
            font-weight: 600;
            color: #0369a1;
            margin-bottom: 4px;
        }
        .info-card-text {
            font-size: 14px;
            color: #0ea5e9;
        }

        /* Upload Areas */
        .logo-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #f9fafb;
        }
        .logo-upload-area:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }
        .logo-preview {
            max-width: 200px;
            max-height: 100px;
            margin: 0 auto 12px;
            border-radius: 8px;
        }
        .favicon-preview {
            width: 64px;
            height: 64px;
            margin: 0 auto 12px;
            border-radius: 8px;
            object-fit: contain;
            border: 1px solid #e5e7eb;
            background: white;
        }
        .logo-placeholder {
            width: 80px;
            height: 80px;
            background: #e5e7eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }
        .favicon-placeholder {
            width: 64px;
            height: 64px;
            background: #e5e7eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }
        .logo-placeholder svg,
        .favicon-placeholder svg {
            width: 32px;
            height: 32px;
            color: #9ca3af;
        }
        .logo-upload-text {
            font-size: 14px;
            color: #6b7280;
        }
        .logo-upload-text span {
            color: #3b82f6;
            font-weight: 600;
        }
        .current-logo-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }
        .current-logo-wrapper img {
            max-width: 180px;
            max-height: 90px;
            border-radius: 8px;
        }
        .current-favicon-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }
        .current-favicon-wrapper img {
            width: 64px;
            height: 64px;
            border-radius: 8px;
            object-fit: contain;
            border: 1px solid #e5e7eb;
            background: white;
        }
        .current-logo-info,
        .current-favicon-info {
            flex: 1;
        }
        .current-logo-info p,
        .current-favicon-info p {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }
        .current-logo-info p strong,
        .current-favicon-info p strong {
            color: #374151;
        }
        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 32px 0;
        }
    </style>

    <div class="form-section">
        <div class="section-header">
            <h3 class="section-title">Logo & Favicon</h3>
            <p class="section-subtitle">Upload your store logo and browser favicon</p>
        </div>

        <div class="info-card">
            <div class="info-card-title">ℹ️ Where they appear</div>
            <div class="info-card-text">
                <strong>Logo</strong> appears on the frontend navbar, admin sidebar, and admin login page.<br>
                <strong>Favicon</strong> appears in the browser tab next to the page title.
            </div>
        </div>

        <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ========== SITE LOGO SECTION ========== -->
            <div class="section-header" style="margin-top: 0;">
                <h3 class="section-title">Store Logo</h3>
                <p class="section-subtitle">Main logo displayed across your site</p>
            </div>

            <!-- Current Logo -->
            @if($settings['site_logo'])
                <div class="form-group">
                    <label class="form-label">Current Logo</label>
                    <div class="current-logo-wrapper">
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Current Logo">
                        <div class="current-logo-info">
                            <p><strong>File:</strong> {{ basename($settings['site_logo']) }}</p>
                            <p style="margin-top: 4px;">This logo is currently active across your site.</p>
                        </div>
                        <label class="btn btn-danger" style="cursor: pointer; flex-shrink: 0;">
                            <input type="checkbox" name="remove_logo" value="1" style="display: none;" onchange="if(confirm('Are you sure you want to remove the logo?')) { this.form.submit(); } else { this.checked = false; }">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Remove
                        </label>
                    </div>
                </div>
            @endif

            <!-- Logo Upload -->
            <div class="form-group">
                <label class="form-label">{{ $settings['site_logo'] ? 'Change Logo' : 'Upload Logo' }}</label>
                
                <div class="logo-upload-area" onclick="document.getElementById('site_logo').click()">
                    @if($settings['site_logo'])
                        <div class="logo-upload-text">
                            <span>Click to upload</span> a new logo to replace the current one
                        </div>
                    @else
                        <div class="logo-placeholder">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="logo-upload-text">
                            <span>Click to upload</span> or drag and drop
                        </div>
                    @endif
                    <p class="input-hint" style="margin-top: 8px;">PNG, JPG, SVG, WEBP up to 2MB. Recommended: transparent background.</p>
                </div>
                <input type="file" name="site_logo" id="site_logo" accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp" style="display: none;" onchange="previewLogo(this)">
                <img id="logoPreview" class="logo-preview" style="display: none; margin-top: 12px;">
                
                @error('site_logo')
                    <p class="error-message">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="divider"></div>

            <!-- ========== FAVICON SECTION ========== -->
            <div class="section-header" style="margin-top: 0;">
                <h3 class="section-title">Browser Favicon</h3>
                <p class="section-subtitle">Small icon shown in browser tabs</p>
            </div>

            <!-- Current Favicon -->
            @if($settings['site_favicon'])
                <div class="form-group">
                    <label class="form-label">Current Favicon</label>
                    <div class="current-favicon-wrapper">
                        <img src="{{ asset('storage/' . $settings['site_favicon']) }}?v={{ time() }}" alt="Current Favicon">
                        <div class="current-favicon-info">
                            <p><strong>File:</strong> {{ basename($settings['site_favicon']) }}</p>
                            <p style="margin-top: 4px;">This icon appears in browser tabs and bookmarks.</p>
                        </div>
                        <label class="btn btn-danger" style="cursor: pointer; flex-shrink: 0;">
                            <input type="checkbox" name="remove_favicon" value="1" style="display: none;" onchange="if(confirm('Are you sure you want to remove the favicon?')) { this.form.submit(); } else { this.checked = false; }">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Remove
                        </label>
                    </div>
                </div>
            @endif

            <!-- Favicon Upload -->
            <div class="form-group">
                <label class="form-label">{{ $settings['site_favicon'] ? 'Change Favicon' : 'Upload Favicon' }}</label>
                
                <div class="logo-upload-area" onclick="document.getElementById('site_favicon').click()">
                    @if($settings['site_favicon'])
                        <div class="logo-upload-text">
                            <span>Click to upload</span> a new favicon to replace the current one
                        </div>
                    @else
                        <div class="favicon-placeholder">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="logo-upload-text">
                            <span>Click to upload</span> or drag and drop
                        </div>
                    @endif
                    <p class="input-hint" style="margin-top: 8px;">PNG, ICO, JPG up to 1MB. Recommended size: 32x32px or 64x64px.</p>
                </div>
                <input type="file" name="site_favicon" id="site_favicon" accept="image/png,image/x-icon,image/jpg,image/jpeg" style="display: none;" onchange="previewFavicon(this)">
                <img id="faviconPreview" class="favicon-preview" style="display: none; margin-top: 12px;">
                
                @error('site_favicon')
                    <p class="error-message">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Changes
            </button>
        </form>
    </div>

    <script>
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('logoPreview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewFavicon(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('faviconPreview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

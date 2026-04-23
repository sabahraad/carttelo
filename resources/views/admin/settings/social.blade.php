@extends('layouts.admin')

@section('title', 'Social Media')
@section('page_title', 'Social Media Links')

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
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.2s;
            background: white;
        }
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-input.error {
            border-color: #ef4444;
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
        .social-input-wrapper {
            position: relative;
        }
        .social-input-wrapper .social-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }
        .social-input-wrapper input {
            padding-left: 44px;
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

        /* Preview Card */
        .preview-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 24px;
        }
        .preview-title {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 12px;
        }
        .preview-links {
            display: flex;
            gap: 12px;
        }
        .preview-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .preview-link.active {
            opacity: 1;
        }
        .preview-link.inactive {
            opacity: 0.3;
        }
    </style>

    <div class="form-section">
        <div class="section-header">
            <h3 class="section-title">Social Media Links</h3>
            <p class="section-subtitle">Configure links that appear in footer and contact page</p>
        </div>

        <div class="info-card">
            <div class="info-card-title">ℹ️ Where they appear</div>
            <div class="info-card-text">
                These links will be displayed in the website footer and on the Contact Us page. Leave empty to hide a link.
            </div>
        </div>

        <!-- Preview -->
        <div class="preview-card">
            <p class="preview-title">Preview</p>
            <div class="preview-links">
                <div class="preview-link {{ $settings['social_facebook'] ? 'active bg-blue-600' : 'inactive bg-gray-400' }}">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </div>
                <div class="preview-link {{ $settings['social_instagram'] ? 'active bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600' : 'inactive bg-gray-400' }}">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                </div>
                <div class="preview-link {{ $settings['social_email'] ? 'active bg-green-600' : 'inactive bg-gray-400' }}">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.settings.social.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Facebook -->
            <div class="form-group">
                <label for="social_facebook" class="form-label">Facebook Page URL</label>
                <div class="social-input-wrapper">
                    <svg class="social-icon w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    <input type="url" name="social_facebook" id="social_facebook" 
                           value="{{ old('social_facebook', $settings['social_facebook']) }}"
                           class="form-input @error('social_facebook') error @enderror"
                           placeholder="https://facebook.com/yourpage">
                </div>
                @error('social_facebook')
                    <p class="error-message">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Instagram -->
            <div class="form-group">
                <label for="social_instagram" class="form-label">Instagram Profile URL</label>
                <div class="social-input-wrapper">
                    <svg class="social-icon w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                    <input type="url" name="social_instagram" id="social_instagram" 
                           value="{{ old('social_instagram', $settings['social_instagram']) }}"
                           class="form-input @error('social_instagram') error @enderror"
                           placeholder="https://instagram.com/yourprofile">
                </div>
                @error('social_instagram')
                    <p class="error-message">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="social_email" class="form-label">Contact Email</label>
                <div class="social-input-wrapper">
                    <svg class="social-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <input type="email" name="social_email" id="social_email" 
                           value="{{ old('social_email', $settings['social_email']) }}"
                           class="form-input @error('social_email') error @enderror"
                           placeholder="contact@yourstore.com">
                </div>
                @error('social_email')
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
                Save Social Links
            </button>
        </form>
    </div>
@endsection

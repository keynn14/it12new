@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <div>
        <h1 class="h2 mb-1"><i class="bi bi-person-plus"></i> Create User</h1>
        <p class="text-muted mb-0">Add a new user to the system</p>
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="form-card">
    <div class="form-card-body">
        <form method="POST" action="{{ route('users.store') }}" id="userForm">
            @csrf
            
            <div class="form-section">
                <h5 class="form-section-title">
                    <span class="section-number">1</span>
                    <span><i class="bi bi-person"></i> Personal Information</span>
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">
                            <i class="bi bi-person"></i> Full Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control-custom @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter full name" required>
                        @error('name')
                            <div class="invalid-feedback-custom">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="form-help-text">Enter the user's full name</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">
                            <i class="bi bi-envelope"></i> Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" class="form-control-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter email address" required>
                        @error('email')
                            <div class="invalid-feedback-custom">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="form-help-text">Unique email address for login</small>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h5 class="form-section-title">
                    <span class="section-number">2</span>
                    <span><i class="bi bi-shield-lock"></i> Security</span>
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">
                            <i class="bi bi-lock"></i> Password <span class="text-danger">*</span>
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" name="password" id="password" class="form-control-custom @error('password') is-invalid @enderror" placeholder="Enter password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="bi bi-eye" id="password-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback-custom">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="form-help-text">Minimum 8 characters recommended</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">
                            <i class="bi bi-lock-fill"></i> Confirm Password <span class="text-danger">*</span>
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control-custom" placeholder="Confirm password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="bi bi-eye" id="password_confirmation-icon"></i>
                            </button>
                        </div>
                        <small class="form-help-text">Re-enter the password to confirm</small>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h5 class="form-section-title">
                    <span class="section-number">3</span>
                    <span><i class="bi bi-person-badge"></i> Role & Permissions</span>
                </h5>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label-custom">
                            <i class="bi bi-shield-check"></i> Role
                        </label>
                        <select name="role_id" class="form-control-custom @error('role_id') is-invalid @enderror">
                            <option value="">No Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="invalid-feedback-custom">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="form-help-text">Assign a role to define user permissions</small>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="bi bi-save"></i> Create User
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-cancel">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .form-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        transition: box-shadow 0.3s ease;
    }
    
    .form-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }
    
    .form-card-body {
        padding: 2.5rem;
    }
    
    .form-section {
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #e5e7eb;
        position: relative;
    }
    
    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .form-section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-number {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.875rem;
        flex-shrink: 0;
    }
    
    .form-label-custom {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.625rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-label-custom i {
        color: #6b7280;
        font-size: 1rem;
    }
    
    .form-control-custom {
        width: 100%;
        padding: 0.875rem 1rem;
        font-size: 0.9375rem;
        color: #111827;
        background: #ffffff;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        transition: all 0.2s ease;
    }
    
    .form-control-custom:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #fafbff;
    }
    
    .form-control-custom::placeholder {
        color: #9ca3af;
    }
    
    .password-input-wrapper {
        position: relative;
    }
    
    .password-input-wrapper .form-control-custom {
        padding-right: 3rem;
    }
    
    .password-toggle {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6b7280;
        cursor: pointer;
        padding: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s ease;
    }
    
    .password-toggle:hover {
        color: #2563eb;
    }
    
    .invalid-feedback-custom {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #ef4444;
    }
    
    .invalid-feedback-custom i {
        font-size: 1rem;
    }
    
    .form-control-custom.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }
    
    .form-control-custom.is-invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .form-help-text {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.8125rem;
        color: #6b7280;
    }
    
    .form-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 2px solid #e5e7eb;
    }
    
    .btn-submit {
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    
    .btn-cancel {
        padding: 0.875rem 1.5rem;
        border-radius: 10px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-cancel:hover {
        background: #f3f4f6;
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(inputId + '-icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
    
    document.getElementById('userForm')?.addEventListener('submit', function(e) {
        const form = this;
        const submitBtn = form.querySelector('.btn-submit');
        const originalText = submitBtn.innerHTML;
        
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        
        if (password !== passwordConfirmation) {
            e.preventDefault();
            alert('Passwords do not match. Please try again.');
            document.getElementById('password_confirmation').classList.add('is-invalid');
            return false;
        }
        
        if (password.length < 8) {
            if (!confirm('Password is less than 8 characters. Do you want to continue?')) {
                e.preventDefault();
                return false;
            }
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Creating...';
        
        setTimeout(() => {
            if (submitBtn.disabled) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }, 3000);
    });
</script>
@endpush
@endsection

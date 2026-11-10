@extends('layouts.auth-screen')

@section('title', 'Sign In')

@section('content')
<div class="login-wrapper">
    <!-- Glassmorphism Card -->
    <div class="glass-card">
        
        <!-- Back Button -->
        <a href="{{ route('welcome') }}" class="glass-back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
        </a>

        <!-- Logo -->
        <div class="glass-logo">
            @php
                $logoPath = \App\Models\Pengaturan::get('toko_logo');
                $tokoNama = \App\Models\Pengaturan::get('toko_nama', 'SiBuku');
            @endphp
            
            @if($logoPath)
                <img src="{{ asset('storage/' . $logoPath) }}" alt="{{ $tokoNama }}" class="logo-img">
            @else
                <i class="fas fa-sign-in-alt"></i>
            @endif
        </div>

        <!-- Title -->
        <h1 class="glass-title">Welcome Back</h1>
        <p class="glass-subtitle">Sign in to your account</p>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="glass-form">
            @csrf
            
            <!-- Email Input -->
            <div class="glass-input-group">
                <label class="glass-label">Email</label>
                <div class="glass-input-wrapper">
                    <i class="fas fa-envelope glass-input-icon"></i>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Enter your email" 
                           required 
                           autofocus
                           class="glass-input">
                </div>
                @error('email')
                    <p class="glass-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="glass-input-group">
                <label class="glass-label">Password</label>
                <div class="glass-input-wrapper">
                    <i class="fas fa-lock glass-input-icon"></i>
                    <input type="password" 
                           name="password" 
                           placeholder="Enter your password" 
                           required
                           class="glass-input">
                </div>
                @error('password')
                    <p class="glass-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="glass-checkbox-group">
                <label class="glass-remember">
                    <input type="checkbox" name="remember" id="remember">
                    <span>Remember me</span>
                </label>
                <a href="#" class="glass-forgot">Forgot password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="glass-btn glass-btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                <span>Sign In</span>
            </button>
        </form>

        <!-- Footer -->
        <p class="glass-footer">
            Don't have an account? 
            <a href="{{ route('register') }}" class="glass-link">Sign up</a>
        </p>
    </div>
</div>

<style>
/* ============================================
   GLASSMORPHISM LOGIN PAGE
   ============================================ */

.login-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

/* ============================================
   GLASS CARD
   ============================================ */
.glass-card {
    /* Glass effect */
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    
    /* Border & shadow */
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 28px;
    box-shadow: 
        0 8px 32px rgba(0, 0, 0, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
    
    /* Layout */
    padding: 48px 40px;
    max-width: 460px;
    width: 100%;
    position: relative;
    
    /* Animation */
    animation: glassFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes glassFadeIn {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.96);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* ============================================
   BACK BUTTON
   ============================================ */
.glass-back-btn {
    position: absolute;
    top: 24px;
    left: 24px;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.glass-back-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateX(-3px);
}

.glass-back-btn i {
    font-size: 12px;
}

/* ============================================
   LOGO
   ============================================ */
.glass-logo {
    width: 88px;
    height: 88px;
    margin: 0 auto 24px;
    border-radius: 22px;
    
    /* Glass effect for logo container */
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.glass-logo:hover {
    transform: scale(1.05) rotate(-2deg);
}

.glass-logo i {
    font-size: 40px;
    color: rgba(255, 255, 255, 0.95);
}

.logo-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 12px;
}

/* ============================================
   TYPOGRAPHY
   ============================================ */
.glass-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 34px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 8px;
    text-align: center;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    letter-spacing: 0.5px;
}

.glass-subtitle {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.75);
    font-weight: 500;
    margin-bottom: 32px;
    text-align: center;
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
}

/* ============================================
   FORM
   ============================================ */
.glass-form {
    margin-bottom: 24px;
}

.glass-input-group {
    margin-bottom: 20px;
}

.glass-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.glass-input-wrapper {
    position: relative;
}

.glass-input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255, 255, 255, 0.6);
    font-size: 14px;
    pointer-events: none;
}

.glass-input {
    width: 100%;
    padding: 14px 16px 14px 44px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 12px;
    color: #ffffff;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    outline: none;
}

.glass-input::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.glass-input:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.5);
    box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
}

.glass-input:focus + .glass-input-icon,
.glass-input-wrapper:focus-within .glass-input-icon {
    color: rgba(255, 255, 255, 0.9);
}

/* ============================================
   ERROR MESSAGE
   ============================================ */
.glass-error {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    padding: 8px 12px;
    background: rgba(239, 68, 68, 0.15);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 8px;
    color: rgba(255, 255, 255, 0.95);
    font-size: 12px;
    font-weight: 500;
}

.glass-error i {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.9);
}

/* ============================================
   CHECKBOX GROUP
   ============================================ */
.glass-checkbox-group {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    font-size: 13px;
}

.glass-remember {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    color: rgba(255, 255, 255, 0.85);
    font-weight: 500;
}

.glass-remember input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: rgba(255, 255, 255, 0.9);
    cursor: pointer;
}

.glass-forgot {
    color: rgba(255, 255, 255, 0.85);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.glass-forgot:hover {
    color: #ffffff;
    text-decoration: underline;
}

/* ============================================
   BUTTONS
   ============================================ */
.glass-btn {
    width: 100%;
    padding: 16px 24px;
    border-radius: 14px;
    font-weight: 700;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    letter-spacing: 0.5px;
    border: none;
    cursor: pointer;
}

.glass-btn-primary {
    background: rgba(255, 255, 255, 0.95);
    color: #1F3318;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.glass-btn-primary:hover {
    background: #ffffff;
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(255, 255, 255, 0.3);
}

.glass-btn:active {
    transform: translateY(-1px);
}

.glass-btn i {
    font-size: 16px;
}

/* ============================================
   FOOTER
   ============================================ */
.glass-footer {
    text-align: center;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.75);
    font-weight: 500;
}

.glass-link {
    color: rgba(255, 255, 255, 0.95);
    text-decoration: none;
    font-weight: 700;
    transition: color 0.3s ease;
}

.glass-link:hover {
    color: #ffffff;
    text-decoration: underline;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 640px) {
    .glass-card {
        padding: 36px 24px;
        border-radius: 24px;
    }
    
    .glass-title {
        font-size: 28px;
    }
    
    .glass-back-btn {
        top: 16px;
        left: 16px;
        padding: 6px 12px;
        font-size: 12px;
    }
    
    .glass-checkbox-group {
        flex-direction: column;
        gap: 12px;
        align-items: flex-start;
    }
}
</style>
@endsection
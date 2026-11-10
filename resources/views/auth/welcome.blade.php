@extends('layouts.auth-screen')

@section('title', 'Welcome')

@section('content')
<div class="welcome-wrapper">
    <!-- Glassmorphism Card -->
    <div class="glass-card">
        
        <!-- Logo -->
        <div class="glass-logo">
            @php
                $logoPath = \App\Models\Pengaturan::get('toko_logo');
                $tokoNama = \App\Models\Pengaturan::get('toko_nama', 'SiBuku');
            @endphp
            
            @if($logoPath)
                <img src="{{ asset('storage/' . $logoPath) }}" alt="{{ $tokoNama }}" class="logo-img">
            @else
                <i class="fas fa-book-open"></i>
            @endif
        </div>

        <!-- Title -->
        <h1 class="glass-title">{{ $tokoNama }}</h1>
        <p class="glass-subtitle">Bookstore Point of Sale System</p>

        <!-- Action Buttons -->
        <div class="glass-actions">
            <a href="{{ route('login') }}" class="glass-btn glass-btn-secondary">
                <i class="fas fa-sign-in-alt"></i>
                <span>SIGN IN</span>
            </a>
            <a href="{{ route('register') }}" class="glass-btn glass-btn-primary">
                <span>SIGN UP</span>
                <i class="fas fa-user-plus"></i>
            </a>
        </div>

        <!-- Demo Accounts -->
        <div class="glass-demo">
            <div class="demo-header">
                <i class="fas fa-info-circle"></i>
                <span>Demo Accounts</span>
            </div>
            <div class="demo-list">
                <div class="demo-item">
                    <span class="demo-badge admin">ADMIN</span>
                    <span class="demo-cred">admin@sibuku.com / admin123</span>
                </div>
                <div class="demo-item">
                    <span class="demo-badge kasir">KASIR</span>
                    <span class="demo-cred">kasir@sibuku.com / kasir123</span>
                </div>
                <div class="demo-list">
                <div class="demo-item">
                    <span class="demo-badge admin">OWNER</span>
                    <span class="demo-cred">owner@sibuku.com / owner123</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================
   GLASSMORPHISM WELCOME PAGE
   ============================================ */

.welcome-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

/* ============================================
   GLASS CARD - THE MAIN EFFECT
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
    text-align: center;
    
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
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    letter-spacing: 0.5px;
}

.glass-subtitle {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.75);
    font-weight: 500;
    margin-bottom: 32px;
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
}

/* ============================================
   ACTION BUTTONS
   ============================================ */
.glass-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 28px;
}

.glass-btn {
    padding: 14px 20px;
    border-radius: 14px;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    letter-spacing: 0.5px;
}

/* Secondary Button - Glass Style */
.glass-btn-secondary {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.35);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.glass-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

/* Primary Button - Solid with Glass Feel */
.glass-btn-primary {
    background: rgba(255, 255, 255, 0.95);
    color: #1F3318;
    border: 1px solid rgba(255, 255, 255, 0.5);
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

/* ============================================
   DEMO ACCOUNTS SECTION
   ============================================ */
.glass-demo {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 18px;
    padding: 20px;
    text-align: left;
}

.demo-header {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 14px;
}

.demo-header i {
    color: rgba(255, 255, 255, 0.8);
}

.demo-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.demo-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.demo-badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 10px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    flex-shrink: 0;
}

.demo-badge.admin {
    background: rgba(255, 255, 255, 0.95);
    color: #1F3318;
}

.demo-badge.kasir {
    background: rgba(255, 255, 255, 0.85);
    color: #2D4A23;
}

.demo-cred {
    font-family: 'Courier New', monospace;
    color: rgba(255, 255, 255, 0.85);
    font-size: 12px;
    background: rgba(255, 255, 255, 0.1);
    padding: 4px 8px;
    border-radius: 6px;
    border: 1px solid rgba(255, 255, 255, 0.15);
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
    
    .glass-actions {
        grid-template-columns: 1fr;
    }
    
    .demo-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
    }
}
</style>
@endsection
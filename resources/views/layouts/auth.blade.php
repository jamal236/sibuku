<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') - SiBuku Bookstore</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Bookshelf Background */
        .bookshelf-bg {
            background-image: 
                linear-gradient(rgba(44, 24, 16, 0.75), rgba(107, 68, 35, 0.65)),
                url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        /* Login Card Container */
        .login-container {
            max-width: 420px;
            width: 100%;
        }
        
        /* Header Bar dengan Gradient */
        .login-header {
            background: linear-gradient(135deg, #6B4423 0%, #4A2F1A 50%, #2C1810 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-radius: 20px 20px 0 0;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 8s infinite linear;
        }
        
        @keyframes shimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Logo Buku */
        .logo-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }
        
        .logo-container i {
            font-size: 40px;
            background: linear-gradient(135deg, #6B4423 0%, #4A2F1A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Form Section */
        .login-form {
            background: white;
            padding: 40px 30px;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        /* Input Styling */
        .input-group {
            margin-bottom: 20px;
        }
        
        .input-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #2C1810;
            margin-bottom: 8px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8B6F47;
            font-size: 18px;
        }
        
        .input-wrapper input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #E8D5C4;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #FDF8F3;
        }
        
        .input-wrapper input:focus {
            outline: none;
            border-color: #6B4423;
            background: white;
            box-shadow: 0 0 0 4px rgba(107, 68, 35, 0.1);
        }
        
        .input-wrapper input::placeholder {
            color: #A89080;
        }
        
        /* Toggle Password */
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #8B6F47;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        
        .toggle-password:hover {
            color: #6B4423;
        }
        
        /* Remember Me & Forgot Password */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 14px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #6B4423;
            cursor: pointer;
        }
        
        .forgot-password {
            color: #6B4423;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .forgot-password:hover {
            color: #4A2F1A;
            text-decoration: underline;
        }
        
        /* Sign In Button */
        .btn-signin {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #6B4423 0%, #4A2F1A 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(107, 68, 35, 0.3);
        }
        
        .btn-signin:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 68, 35, 0.4);
        }
        
        .btn-signin:active {
            transform: translateY(0);
        }
        
        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #8B6F47;
            font-size: 13px;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E8D5C4;
        }
        
        .divider span {
            padding: 0 15px;
        }
        
        /* Create Account Link */
        .create-account {
            text-align: center;
            font-size: 14px;
            color: #6B4423;
        }
        
        .create-account a {
            color: #6B4423;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .create-account a:hover {
            color: #4A2F1A;
            text-decoration: underline;
        }
        
        /* Demo Accounts Card */
        .demo-card {
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .demo-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
        
        .demo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6B4423 0%, #4A2F1A 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        
        .demo-title {
            font-size: 14px;
            font-weight: 600;
            color: #2C1810;
        }
        
        .demo-list {
            font-size: 12px;
            color: #6B4423;
            line-height: 1.8;
        }
        
        .demo-list strong {
            color: #4A2F1A;
        }
        
        /* Copyright */
        .copyright {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
        }
        
        /* Floating Books Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .floating-book {
            position: fixed;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            pointer-events: none;
        }
        
        .floating-book-1 {
            width: 60px;
            height: 80px;
            top: 15%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-book-2 {
            width: 50px;
            height: 70px;
            bottom: 20%;
            right: 15%;
            animation: float 6s ease-in-out infinite 2s;
        }
        
        .floating-book-3 {
            width: 40px;
            height: 60px;
            top: 40%;
            right: 25%;
            animation: float 6s ease-in-out infinite 4s;
        }
    </style>
</head>
<body class="bookshelf-bg min-h-screen flex items-center justify-center p-4">
    
    <!-- Floating Books Decoration -->
    <div class="floating-book floating-book-1"></div>
    <div class="floating-book floating-book-2"></div>
    <div class="floating-book floating-book-3"></div>

    <div class="login-container">
        
        <!-- Login Card -->
        <div>
            <!-- Header dengan Gradient -->
            <div class="login-header">
                <!-- Logo Buku -->
                <div class="logo-container">
                    <i class="fas fa-book-open"></i>
                </div>
                
                <h1 class="text-3xl font-bold text-white mb-2" style="font-family: 'Playfair Display', serif;">Welcome Back</h1>
                <p class="text-white/80 text-sm">Sign in to access the book lending system</p>
            </div>

            <!-- Form Section -->
            <div class="login-form">
                @yield('content')

                <!-- Divider -->
                <div class="divider">
                    <span>or</span>
                </div>

                <!-- Create Account -->
                <div class="create-account">
                    Don't have an account? <a href="#">Create Account</a>
                </div>
            </div>
        </div>

        <!-- Demo Accounts Card -->
        <div class="demo-card">
            <div class="demo-header">
                <div class="demo-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="demo-title">Demo Accounts</div>
            </div>
            <div class="demo-list">
                <p><strong>Admin:</strong> admin@sibuku.com / password</p>
                <p><strong>Kasir:</strong> kasir@sibuku.com / password</p>
                <p><strong>Owner:</strong> owner@sibuku.com / password</p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="copyright">
            <p>&copy; {{ date('Y') }} SiBuku. All rights reserved.</p>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
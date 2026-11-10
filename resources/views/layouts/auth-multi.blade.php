<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome') - SiBuku</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #F5F1E8 0%, #E8D5C4 50%, #D4C4B0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
        }
        
        /* Abstract Brown Background Shapes */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }
        
        .shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, #6B4423 0%, #4A2F1A 100%);
            opacity: 0.1;
            animation: float 20s infinite ease-in-out;
        }
        
        .shape-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }
        
        .shape-2 {
            width: 300px;
            height: 300px;
            top: 50%;
            right: -50px;
            animation-delay: 5s;
        }
        
        .shape-3 {
            width: 250px;
            height: 250px;
            bottom: -50px;
            left: 30%;
            animation-delay: 10s;
        }
        
        .shape-4 {
            width: 200px;
            height: 200px;
            top: 30%;
            left: 60%;
            animation-delay: 15s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(30px, -30px) rotate(90deg);
            }
            50% {
                transform: translate(-20px, 20px) rotate(180deg);
            }
            75% {
                transform: translate(20px, 30px) rotate(270deg);
            }
        }
        
        /* Container */
        .auth-container {
            width: 100%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            align-items: center;
        }
        
        @media (max-width: 968px) {
            .auth-container {
                grid-template-columns: 1fr;
                max-width: 400px;
            }
        }
        
        /* Card Styles */
        .auth-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(107, 68, 35, 0.15);
            transition: all 0.4s ease;
        }
        
        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(107, 68, 35, 0.2);
        }
        
        /* Header with Gradient */
        .card-header {
            background: linear-gradient(135deg, #6B4423 0%, #4A2F1A 50%, #2C1810 100%);
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 10s infinite linear;
        }
        
        @keyframes shimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .logo-wrapper {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            background: white;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }
        
        .logo-wrapper i {
            font-size: 45px;
            background: linear-gradient(135deg, #6B4423 0%, #4A2F1A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .card-header h1 {
            font-family: 'Playfair Display', serif;
            color: white;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .card-header p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }
        
        /* Form Section */
        .card-body {
            padding: 40px 30px;
        }
        
        /* Input Group */
        .input-group {
            margin-bottom: 20px;
        }
        
        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #2C1810;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper input {
            width: 100%;
            padding: 14px 16px 14px 45px;
            border: 2px solid #E8D5C4;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #FDF8F3;
            font-family: 'Inter', sans-serif;
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
        
        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #8B6F47;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        
        .input-group:focus-within i {
            color: #6B4423;
        }
        
        /* Checkbox */
        .checkbox-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            font-size: 14px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: #6B4423;
        }
        
        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #6B4423;
            cursor: pointer;
        }
        
        .forgot-link {
            color: #6B4423;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .forgot-link:hover {
            color: #4A2F1A;
            text-decoration: underline;
        }
        
        /* Buttons */
        .btn-primary {
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
            margin-bottom: 20px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 68, 35, 0.4);
        }
        
        .btn-secondary {
            width: 100%;
            padding: 16px;
            background: white;
            color: #6B4423;
            border: 2px solid #E8D5C4;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-secondary:hover {
            background: #FDF8F3;
            border-color: #6B4423;
        }
        
        .btn-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .btn-split .btn-secondary,
        .btn-split .btn-primary {
            margin-bottom: 0;
        }
        
        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #8B6F47;
            font-size: 13px;
            font-weight: 500;
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
        
        /* Social Login */
        .social-login {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .social-btn {
            width: 50px;
            height: 50px;
            border: 2px solid #E8D5C4;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }
        
        .social-btn:hover {
            border-color: #6B4423;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(107, 68, 35, 0.2);
        }
        
        .social-btn i {
            font-size: 22px;
            color: #6B4423;
        }
        
        .social-btn.facebook:hover i { color: #1877F2; }
        .social-btn.twitter:hover i { color: #1DA1F2; }
        .social-btn.google:hover i { color: #DB4437; }
        .social-btn.apple:hover i { color: #000000; }
        
        /* Footer Text */
        .footer-text {
            text-align: center;
            font-size: 14px;
            color: #6B4423;
        }
        
        .footer-text a {
            color: #6B4423;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .footer-text a:hover {
            color: #4A2F1A;
            text-decoration: underline;
        }
        
        /* Back Button */
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: none;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            z-index: 2;
        }
        
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-3px);
        }
    </style>
</head>
<body>
    <!-- Background Shapes -->
    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>

    <div class="auth-container">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
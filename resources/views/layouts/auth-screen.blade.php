<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SiBuku</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cormorant+Garamond:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'forest-50': '#F0F4E8',
                        'forest-100': '#DDE5C9',
                        'forest-200': '#B8C9A0',
                        'forest-300': '#8FA878',
                        'forest-400': '#6B8F5A',
                        'forest-500': '#4A6B3D',
                        'forest-600': '#3D5A2F',
                        'forest-700': '#2D4A23',
                        'forest-800': '#1F3318',
                        'forest-900': '#0F1F0F',
                        'moonlight-50': '#FAF7E8',
                        'moonlight-100': '#F0EAC8',
                        'moonlight-200': '#E8D98A',
                        'moonlight-300': '#D4C87A',
                        'moonlight-400': '#B8A85A',
                        'moonlight-500': '#9A8B3D',
                        'emerald-50': '#E8F5E8',
                        'emerald-100': '#C8E0C8',
                        'emerald-200': '#8FBC8F',
                        'emerald-300': '#5A9A5A',
                        'emerald-400': '#3D7A3D',
                        'emerald-500': '#2D5A2D',
                        'cream': '#F5F0D8',
                        'ivory': '#FAF7E8',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Cormorant Garamond', 'serif'],
                    },
                },
            },
        }
    </script>
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            /* Background lukisan dengan overlay hijau gelap yang subtle */
            background: 
                linear-gradient(135deg, 
                    rgba(15, 31, 15, 0.55) 0%, 
                    rgba(31, 51, 24, 0.45) 30%,
                    rgba(45, 74, 35, 0.4) 60%,
                    rgba(15, 31, 15, 0.6) 100%
                ),
                url('{{ asset("images/auth-background.png") }}') center center/cover no-repeat fixed;
            background-color: #1F3318;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto; /* PENTING: Izinkan scroll vertikal */
        }

        /* Efek moonlight glow - cahaya bulan dari lukisan */
        body::before {
            content: '';
            position: fixed;
            top: -100px;
            left: 30%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, 
                rgba(232, 217, 138, 0.25) 0%, 
                rgba(232, 217, 138, 0.1) 30%,
                transparent 70%
            );
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
            animation: moonPulse 6s ease-in-out infinite;
        }

        @keyframes moonPulse {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.1); }
        }

        /* Sparkle/Star Effect - seperti kilauan di permukaan air */
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(2px 2px at 20% 30%, rgba(232, 217, 138, 0.8), transparent),
                radial-gradient(1.5px 1.5px at 40% 70%, rgba(245, 240, 216, 0.6), transparent),
                radial-gradient(2px 2px at 60% 20%, rgba(232, 217, 138, 0.7), transparent),
                radial-gradient(1px 1px at 80% 50%, rgba(245, 240, 216, 0.5), transparent),
                radial-gradient(2px 2px at 10% 80%, rgba(232, 217, 138, 0.6), transparent),
                radial-gradient(1.5px 1.5px at 70% 90%, rgba(245, 240, 216, 0.7), transparent),
                radial-gradient(1px 1px at 90% 10%, rgba(232, 217, 138, 0.8), transparent),
                radial-gradient(2px 2px at 30% 50%, rgba(245, 240, 216, 0.5), transparent),
                radial-gradient(1px 1px at 50% 85%, rgba(232, 217, 138, 0.6), transparent),
                radial-gradient(1.5px 1.5px at 85% 35%, rgba(245, 240, 216, 0.7), transparent);
            background-size: 100% 100%;
            animation: sparkle 4s ease-in-out infinite;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes sparkle {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 1; }
        }

        /* Floating firefly particles */
        .particle {
            position: fixed;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(232, 217, 138, 0.9) 0%, transparent 70%);
            pointer-events: none;
            animation: float 12s infinite ease-in-out;
            box-shadow: 0 0 8px rgba(232, 217, 138, 0.6);
        }

        .particle:nth-child(1) { width: 4px; height: 4px; top: 25%; left: 15%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 6px; height: 6px; top: 65%; left: 80%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 3px; height: 3px; top: 75%; left: 35%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 5px; height: 5px; top: 20%; left: 65%; animation-delay: 6s; }
        .particle:nth-child(5) { width: 4px; height: 4px; top: 50%; left: 45%; animation-delay: 8s; }
        .particle:nth-child(6) { width: 3px; height: 3px; top: 85%; left: 25%; animation-delay: 10s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0.3; }
            25% { transform: translateY(-40px) translateX(25px); opacity: 0.9; }
            50% { transform: translateY(-70px) translateX(-15px); opacity: 0.5; }
            75% { transform: translateY(-40px) translateX(35px); opacity: 1; }
        }

        .auth-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            max-height: 95vh; /* PENTING: Batasi tinggi maksimal card */
            overflow-y: auto; /* PENTING: Izinkan scroll di dalam card */
            margin: 20px auto;
            background: rgba(245, 240, 216, 0.93);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 
                0 25px 60px rgba(15, 31, 15, 0.5),
                0 10px 30px rgba(15, 31, 15, 0.3),
                inset 0 1px 0 rgba(232, 217, 138, 0.4);
            border: 1px solid rgba(143, 168, 120, 0.3);
            overflow-x: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            /* Custom scrollbar styling */
            scrollbar-width: thin;
            scrollbar-color: #8FA878 rgba(245, 240, 216, 0.5);
        }

        /* Custom Scrollbar untuk Webkit (Chrome, Safari, Edge) */
        .auth-card::-webkit-scrollbar {
            width: 6px;
        }

        .auth-card::-webkit-scrollbar-track {
            background: rgba(245, 240, 216, 0.3);
            border-radius: 10px;
        }

        .auth-card::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #8FA878 0%, #4A6B3D 100%);
            border-radius: 10px;
            border: 2px solid rgba(245, 240, 216, 0.5);
        }

        .auth-card::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #6B8F5A 0%, #2D4A23 100%);
        }

        .auth-card:hover {
            box-shadow: 
                0 35px 80px rgba(15, 31, 15, 0.6),
                0 15px 40px rgba(15, 31, 15, 0.4),
                inset 0 1px 0 rgba(232, 217, 138, 0.5);
        }

        .card-header {
            padding: 35px 35px 25px;
            text-align: center;
            position: relative;
            background: linear-gradient(180deg, 
                rgba(143, 168, 120, 0.25) 0%, 
                rgba(245, 240, 216, 0) 100%
            );
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, 
                #2D4A23 0%, 
                #4A6B3D 25%,
                #8FA878 50%,
                #4A6B3D 75%,
                #2D4A23 100%
            );
        }

        .logo-wrapper {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #2D4A23 0%, #1F3318 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 
                0 10px 25px rgba(15, 31, 15, 0.5),
                inset 0 2px 0 rgba(232, 217, 138, 0.3);
            transition: all 0.3s ease;
        }

        .logo-wrapper:hover {
            transform: rotate(5deg) scale(1.05);
            box-shadow: 0 15px 35px rgba(15, 31, 15, 0.6);
        }

        .logo-wrapper i {
            font-size: 32px;
            color: #E8D98A;
        }

        .card-header h1 {
            font-size: 28px;
            font-weight: 800;
            color: #1F3318;
            margin: 0 0 8px;
            letter-spacing: -0.5px;
            font-family: 'Cormorant Garamond', serif;
        }

        .card-header p {
            font-size: 14px;
            color: #4A6B3D;
            margin: 0;
            font-weight: 500;
        }

        .card-body {
            padding: 10px 35px 35px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #2D4A23;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            color: #8FA878;
            font-size: 16px;
            transition: color 0.3s ease;
            z-index: 2;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 2px solid #B8C9A0;
            border-radius: 12px;
            font-size: 14px;
            color: #1F3318;
            background: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
            outline: none;
        }

        .input-wrapper input:focus {
            border-color: #4A6B3D;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 4px rgba(74, 107, 61, 0.15);
        }

        .input-wrapper input:focus + i,
        .input-wrapper input:focus ~ i {
            color: #4A6B3D;
        }

        .input-wrapper input::placeholder {
            color: #8FA878;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            background: none;
            border: none;
            color: #8FA878;
            cursor: pointer;
            padding: 4px;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #4A6B3D;
        }

        .checkbox-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: #2D4A23;
            font-weight: 500;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #4A6B3D;
            cursor: pointer;
        }

        .forgot-link {
            color: #4A6B3D;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #2D4A23;
            text-decoration: underline;
        }

        .btn-primary {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #2D4A23 0%, #1F3318 100%);
            background-size: 200% 200%;
            color: #F5F0D8;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(15, 31, 15, 0.4);
            animation: gradientShift 3s ease infinite;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(15, 31, 15, 0.5);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.8);
            color: #2D4A23;
            border: 2px solid #B8C9A0;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: rgba(143, 168, 120, 0.25);
            border-color: #4A6B3D;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 31, 15, 0.2);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 28px 0;
            color: #8FA878;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #B8C9A0, transparent);
        }

        .divider span {
            padding: 0 16px;
        }

        .social-login {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .social-btn {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.7);
            border: 2px solid #B8C9A0;
            color: #4A6B3D;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            transform: translateY(-3px);
            border-color: #4A6B3D;
            background: rgba(143, 168, 120, 0.25);
            box-shadow: 0 8px 16px rgba(15, 31, 15, 0.2);
        }

        .footer-text {
            text-align: center;
            font-size: 13px;
            color: #4A6B3D;
            margin: 0;
            font-weight: 500;
        }

        .footer-text a {
            color: #2D4A23;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .footer-text a:hover {
            color: #4A6B3D;
            text-decoration: underline;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
            color: #4A6B3D;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.9);
            color: #2D4A23;
            transform: translateX(-3px);
        }

        .agreement {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #2D4A23;
        }

        .agreement input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #4A6B3D;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .agreement a {
            color: #4A6B3D;
            font-weight: 600;
            text-decoration: none;
        }

        .agreement a:hover {
            text-decoration: underline;
        }

        /* Branding Footer - Fixed di bawah */
        .branding-footer {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            z-index: 10;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            padding: 8px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .branding-footer strong {
            color: rgba(255, 255, 255, 0.95);
            font-weight: 600;
        }

        /* Auth Container - Tambah padding bottom agar tidak tabrakan dengan footer */
        .auth-container {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
            animation: slideUp 0.6s ease-out;
            padding-bottom: 80px; /* Space untuk footer */
        }

        /* Responsive */
        @media (max-width: 480px) {
            body {
                padding: 10px;
                align-items: flex-start; /* PENTING: Card mulai dari atas di mobile */
                padding-top: 20px;
            }

            .auth-card {
                margin: 10px auto;
                border-radius: 20px;
                max-height: none; /* Hapus batasan tinggi di mobile */
            }

            .card-header {
                padding: 30px 25px 20px;
            }

            .card-body {
                padding: 10px 25px 30px;
            }

            .card-header h1 {
                font-size: 24px;
            }
            
            .branding-footer {
                bottom: 10px;
                width: calc(100% - 40px);
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    @yield('content')

    <div class="branding-footer">
        <p>&copy; {{ date('Y') }} <strong class="text-forest-700">SiBuku</strong>. All rights reserved.</p>
    </div>
</body>
</html>
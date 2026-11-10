<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk — {{ config('app.name', 'SiBuku') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2f2118 0%, #5b3a29 100%);
            font-size: 0.95rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,.25);
        }

        .login-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .5rem;
            margin-bottom: 1.25rem;
        }

        .login-brand .bi {
            font-size: 2.5rem;
            color: #5b3a29;
        }

        .login-brand h1 {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            color: #2f2118;
        }

        .login-brand small {
            color: #8a7a68;
            text-align: center;
        }

        .btn-sibuku {
            background-color: #5b3a29;
            border-color: #5b3a29;
            color: #fff;
        }

        .btn-sibuku:hover {
            background-color: #46291c;
            border-color: #46291c;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="card-body p-4 p-md-5">
            <div class="login-brand">
                <i class="bi bi-book-half"></i>
                <h1>SiBuku</h1>
                <small>Sistem Informasi Point of Sale<br>Toko Buku Bekas</small>
            </div>

            {{ $slot }}
        </div>
    </div>
</body>
</html>

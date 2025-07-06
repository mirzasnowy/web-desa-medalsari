<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Desa Medalsari</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/desa-medalsari.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">

    <style>
        /* Tambahan variabel warna khusus untuk tema sunset ini */
        :root {
            --sunset-orange: #FF6B35; /* Orange terang dari sunset */
            --sunset-gold: #F7931E;   /* Emas dari sunset */
            --sunset-warm-text: #FFF8E1; /* Warm white untuk teks utama */
            --sunset-dark-text: #2c3e50; /* Darker text untuk kontras */
            --sunset-light-border: rgba(255, 255, 255, 0.4); /* Border terang transparan */
            --sunset-dark-border: rgba(0, 0, 0, 0.2); /* Border gelap transparan */
            --sunset-input-bg: rgba(255, 255, 255, 0.1); /* Input background sangat transparan */
            --sunset-input-focus-glow: rgba(255, 107, 53, 0.3); /* Glow oranye saat focus */
            --sunset-error-color: #EF5350; /* Merah error */
        }

        /* Gaya khusus untuk halaman login admin yang ditingkatkan */
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--sunset-dark-text); /* Default text color */
            transition: background-color 0.4s ease, color 0.4s ease;

            /* Gaya Background Gambar - Pastikan PATH ini BENAR */
            background-image: url('{{ asset('photos/sunset.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
        }

        /* Overlay yang lebih soft untuk matching dengan sunset */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* Gradient overlay yang lebih menyatu dengan sunset */
            background: linear-gradient(180deg, rgba(255, 165, 0, 0.05), rgba(0, 0, 0, 0.5)); /* Orange-ish top, darker bottom */
            backdrop-filter: blur(5px); /* Blur sedikit lebih intens pada background utama */
            -webkit-backdrop-filter: blur(5px);
            z-index: 0;
            transition: background 0.6s ease, backdrop-filter 0.6s ease;
        }

        /* Dark Mode: Overlay lebih gelap dan sesuai */
        body.dark-mode::before {
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.8)); /* Lebih gelap keseluruhan */
            backdrop-filter: blur(10px); /* Blur lebih intens di dark mode */
            -webkit-backdrop-filter: blur(10px);
        }

        /* Efek partikel melayang untuk ambiance */
        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.08) 1px, transparent 1px),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.08) 1px, transparent 1px),
                radial-gradient(circle at 40% 60%, rgba(255, 255, 255, 0.06) 1px, transparent 1px);
            background-size: 60px 60px, 90px 90px, 150px 150px;
            animation: float-particles 25s linear infinite;
            z-index: 0;
            opacity: 0.7;
        }

        @keyframes float-particles {
            0% { transform: translate(0, 0); }
            100% { transform: translate(100px, 100px); } /* Bergerak ke kanan bawah */
        }
        body.dark-mode::after {
            background-image:
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                radial-gradient(circle at 40% 60%, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px; /* Sedikit lebih ramping */
            padding: 3rem 2.5rem; /* Padding lebih banyak */
            border-radius: 25px; /* Lebih rounded lagi */
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4); /* Shadow lebih kuat dan menyebar */
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
            transition: background-color 0.5s ease, box-shadow 0.5s ease, border 0.5s ease;

            /* Efek Glassmorphism yang ditingkatkan */
            background-color: rgba(255, 248, 225, 0.8); /* Warm white semi-transparan */
            border: 1px solid rgba(255, 255, 255, 0.6); /* Border terang lebih jelas */
            backdrop-filter: blur(25px); /* Blur lebih intens di dalam container */
            -webkit-backdrop-filter: blur(25px);
            /* Inner shadow untuk kedalaman */
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.2), /* Inner light shadow */
                        0 25px 80px rgba(0, 0, 0, 0.4); /* Outer shadow */
        }

        /* Dark Mode: Container login lebih gelap dan transparan */
        body.dark-mode .login-wrapper {
            background-color: rgba(45, 55, 72, 0.85); /* Lebih solid di dark mode */
            border: 1px solid rgba(74, 85, 104, 0.7); /* Border gelap dan lebih kontras */
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.2), /* Inner dark shadow */
                        0 25px 80px rgba(0, 0, 0, 0.6); /* Bayangan sangat gelap */
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header-logo { /* Kontainer baru untuk logo dan teks di atas form */
            margin-bottom: 2rem;
        }

        .login-app-icon { /* Untuk icon aplikasi di samping teks Desa Medalsari */
            width: 60px; /* Ukuran icon */
            height: 60px;
            margin-bottom: 0.5rem;
            display: block; /* Agar bisa diatur margin auto */
            margin-left: auto;
            margin-right: auto;
            border-radius: 15px; /* Rounded corners */
            filter: drop-shadow(0 4px 10px rgba(0,0,0,0.2)); /* Shadow pada icon */
            transition: filter 0.3s ease;
        }
        body.dark-mode .login-app-icon {
            filter: drop-shadow(0 4px 10px rgba(0,0,0,0.4));
        }

        .login-logo {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.2rem; /* Ukuran sesuai gambar */
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: block; /* Untuk gradient text */
            
            /* Gradient text yang matching dengan sunset */
            background: linear-gradient(135deg, var(--sunset-orange), var(--sunset-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 2px 4px rgba(255, 107, 53, 0.3)); /* Shadow pada teks logo */
        }

        /* Ubah warna logo untuk dark mode agar tetap terlihat */
        body.dark-mode .login-logo {
            background: linear-gradient(135deg, var(--sunset-orange), var(--sunset-gold)); /* Tetap gradien sunset */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
        }


        .login-wrapper h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem; /* Ukuran sesuai gambar */
            font-weight: 600;
            color: var(--sunset-dark-text); /* Warna gelap untuk kontras di light mode */
            margin-bottom: 2.5rem; /* Margin sedikit lebih banyak */
            text-align: center;
        }

        /* Dark Mode: Judul di dark mode */
        body.dark-mode .login-wrapper h2 {
            color: #E2E8F0; /* Putih keabu-abuan di dark mode */
        }


        .form-group {
            margin-bottom: 1.8rem;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 500;
            font-size: 0.95rem; /* Sedikit lebih besar */
            color: var(--sunset-dark-text); /* Warna gelap untuk label di light mode */
        }

        /* Dark Mode: Label di dark mode */
        body.dark-mode .form-group label {
            color: #E2E8F0; /* Putih keabu-abuan di dark mode */
        }

        .form-control {
            width: 100%;
            padding: 1.1rem 1.3rem;
            border: 1px solid var(--sunset-light-border); /* Border terang transparan */
            border-radius: 16px; /* Lebih rounded */
            background: var(--sunset-input-bg); /* Background input sangat transparan */
            color: var(--sunset-dark-text); /* Teks input gelap */
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
            backdrop-filter: blur(5px); /* Blur ringan pada input */
            -webkit-backdrop-filter: blur(5px);
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.05); /* Inner shadow halus */
        }

        .form-control:focus {
            outline: none;
            border-color: var(--sunset-orange); /* Border focus warna sunset */
            background: rgba(255, 255, 255, 0.15); /* Sedikit lebih solid saat focus */
            box-shadow: 
                0 0 0 4px var(--sunset-input-focus-glow), /* Glow warna sunset */
                inset 0 1px 3px rgba(0,0,0,0.1);
            transform: translateY(-1px); /* Efek sedikit mengangkat */
        }

        .form-control::placeholder {
            color: rgba(44, 62, 80, 0.6); /* Warna placeholder gelap tapi transparan */
        }

        /* Dark mode form controls */
        body.dark-mode .form-control {
            border: 1px solid rgba(160, 174, 192, 0.4);
            background: rgba(0, 0, 0, 0.1); /* Background input gelap transparan */
            color: #E2E8F0;
            box-shadow: inset 0 1px 3px rgba(255,255,255,0.05);
        }

        body.dark-mode .form-control:focus {
            border-color: var(--sunset-orange);
            background: rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 0 4px var(--sunset-input-focus-glow),
                        inset 0 1px 3px rgba(255,255,255,0.1);
        }

        body.dark-mode .form-control::placeholder {
            color: rgba(226, 232, 240, 0.6);
        }

        .form-control.is-invalid {
            border-color: var(--sunset-error-color);
            box-shadow: 0 0 0 4px rgba(239, 83, 80, 0.3);
        }

        .invalid-feedback {
            color: var(--sunset-error-color);
            font-size: 0.85rem;
            margin-top: 0.6rem; /* Margin lebih besar */
            display: block;
        }

        /* Styling for Laravel Flash Messages (Alerts) */
        .alert {
            padding: 1.2rem 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 500;
            text-align: left;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .alert-success {
            background: rgba(165, 214, 167, 0.9); /* Hijau muda yang lebih soft */
            color: #388E3C; /* Hijau gelap */
            border: 1px solid rgba(129, 199, 132, 0.6);
        }

        .alert-danger {
            background: rgba(255, 179, 186, 0.9); /* Merah muda yang lebih soft */
            color: #D32F2F; /* Merah gelap */
            border: 1px solid rgba(239, 154, 154, 0.6);
        }

        /* Dark mode overrides for alerts */
        body.dark-mode .alert-success {
            background: rgba(45, 55, 72, 0.9);
            color: #9AE6B4;
            border-color: #4CAF50;
        }

        body.dark-mode .alert-danger {
            background: rgba(45, 55, 72, 0.9);
            color: #FEB2B2;
            border-color: #E53E3E;
        }

        .btn-primary {
            display: inline-block;
            width: 100%;
            padding: 1.3rem 1.5rem;
            border: none;
            border-radius: 16px;
            font-weight: 600;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white; /* Warna teks tombol putih */
            position: relative;
            overflow: hidden;
            
            /* Gradient sunset yang menarik */
            background: linear-gradient(135deg, var(--sunset-orange), var(--sunset-gold));
            box-shadow: 
                0 10px 30px rgba(255, 107, 53, 0.5), /* Shadow utama */
                0 5px 15px rgba(247, 147, 30, 0.3); /* Shadow kedua */
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2); /* Shadow pada teks tombol */
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-5px); /* Lift lebih tinggi */
            box-shadow: 
                0 15px 40px rgba(255, 107, 53, 0.6), /* Shadow lebih intens */
                0 8px 20px rgba(247, 147, 30, 0.5); /* Shadow kedua lebih intens */
        }

        .btn-primary:active {
            transform: translateY(-2px); /* Penekanan saat klik */
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            body {
                padding: 15px;
            }
            .login-wrapper {
                padding: 2rem 1.5rem;
                border-radius: 20px;
                max-width: 90%; /* Sesuaikan agar tidak terlalu lebar */
            }
            .login-header-logo {
                margin-bottom: 1.5rem;
            }
            .login-app-icon {
                width: 50px;
                height: 50px;
            }
            .login-logo {
                font-size: 1.8rem;
                margin-bottom: 0.3rem;
            }
            .login-wrapper h2 {
                font-size: 1.3rem;
                margin-bottom: 2rem;
            }
            .form-group {
                margin-bottom: 1.5rem;
            }
            .form-group label {
                font-size: 0.9rem;
            }
            .form-control {
                padding: 1rem 1.1rem;
                border-radius: 12px;
            }
            .btn-primary {
                padding: 1.1rem 1.2rem;
                font-size: 1rem;
                border-radius: 12px;
            }
            .invalid-feedback {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
        }

        @media (max-width: 380px) { /* Lebih kecil dari 600px, tambahkan breakpoint lagi */
            .login-wrapper {
                padding: 1.5rem 1rem;
            }
            .login-logo {
                font-size: 1.6rem;
            }
            .login-app-icon {
                width: 45px;
                height: 45px;
            }
            .login-wrapper h2 {
                font-size: 1.2rem;
            }
            .form-group {
                margin-bottom: 1.2rem;
            }
        }
    </style>
</head>
<body class="light-mode">
    <div class="login-wrapper">
        <div class="login-header-logo">
            <img src="{{ asset('photos/logo-kabupaten-karawang.png') }}" alt="Desa App Icon" class="login-app-icon">
            <div class="login-logo">Desa Medalsari</div>
        </div>
        <h2>Login Admin</h2>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-4">Login</button>
        </form>
    </div>

    <script src="{{ asset('js/desa-medalsari.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusDiv = document.querySelector('.alert-success');
            const errorDiv = document.querySelector('.alert-danger');

            if (statusDiv) {
                setTimeout(() => {
                    statusDiv.style.display = 'none';
                }, 5000);
            }
            if (errorDiv) {
                setTimeout(() => {
                    errorDiv.style.display = 'none';
                }, 5000);
            }
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioFibreBeauty - L'élégance au naturel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ URL::asset('style.css') }}">
</head>

<body>

    <section class="admin-login-wrapper">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="admin-card" data-aos="fade-up">
                @include('layouts.status')
                <div class="admin-header">
                    <i class="bi bi-lock"></i>
                    <h1>Administration</h1>
                </div>

                <form action="{{ url('custom-login') }}" method="POST" role="form" class="admin-login-form">
                    @csrf
                    <div class="form-group-pin">
                        <input type="email" class="pin-input" placeholder="E-mail" name="email" required>
                    </div>
                    <div class="form-group-pin">
                        <input type="password" class="pin-input" placeholder="Mot de passe" name="password" required>
                    </div>

                    <button type="submit" class="btn-admin-submit">
                        Accéder
                    </button>
                </form>
                {{-- <div class="admin-footer-hint">
                   <strong>E-mail:</strong> theodoreyapi@gmail.com
                    <br>
                    <strong>Mot de passe:</strong> 1234567890
                </div> --}}
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true
        });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Montera - Catatan Keuangan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3034/3034827.png">
    <link rel="apple-touch-icon" href="https://cdn-icons-png.flaticon.com/512/3034/3034827.png">

    <link rel="manifest" href="{{ asset('manifest.json') }}?id={{ uniqid() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #0F0F0F; color: #FFFFFF; overflow-x: hidden; }
        .app-container { max-width: 450px; margin: 0 auto; min-height: 100vh; padding-bottom: 110px; position: relative; }
        
        /* CSS Modal tetap di sini agar global */
        .modal { position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; display: none; align-items: flex-end; }
        .modal-content { width: 100%; max-width: 450px; margin: 0 auto; background: #121212; border-radius: 40px 40px 0 0; padding: 40px 30px; transform: translateY(100%); transition: transform 0.4s ease; }
        .modal.active { display: flex; }
        .modal.active .modal-content { transform: translateY(0); }
        .input-control { width: 100%; background: #1A1A1A; border: 1px solid #222; padding: 15px; border-radius: 15px; color: white; margin-top: 5px; outline: none; }
        .btn-submit { width: 100%; background: #D32F2F; color: white; border: none; padding: 18px; border-radius: 20px; font-weight: 900; text-transform: uppercase; margin-top: 20px; cursor: pointer; }
    </style>
    @yield('styles')
</head>
<body>
    <div class="app-container">
        @include('partials.header')
        
        @yield('content')

        @include('partials.navbar')
    </div>

    @yield('scripts')
</body>
</html>
<script>
    function openModal() {
        const modal = document.getElementById('modalTransaction');
        modal.classList.add('active');
    }
    function closeModal() {
        const modal = document.getElementById('modalTransaction');
        modal.classList.remove('active');
    }
    
    // Menutup modal jika klik di area gelap (luar form)
    window.onclick = function(event) {
        const modal = document.getElementById('modalTransaction');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
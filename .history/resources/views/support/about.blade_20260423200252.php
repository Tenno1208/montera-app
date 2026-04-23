@extends('layouts.app')

@section('content')
<div style="padding: 25px; text-align: center;">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 50px; text-align: left;">
        <a href="{{ route('profil') }}" style="color: white; font-size: 1.2rem;"><i class="fa-solid fa-arrow-left"></i></a>
        <h2 style="font-weight: 900; margin: 0; letter-spacing: -1px;">Tentang <span style="color: #D32F2F;">Montera</span></h2>
    </div>

    <img src="{{ asset('img/logo-montera.png') }}" style="width: 120px; margin-bottom: 20px; filter: drop-shadow(0 0 15px rgba(211, 47, 47, 0.4));">
    
    <h2 style="font-weight: 900; margin-bottom: 5px;">MONTERA <span style="color: #D32F2F;">PREMIUM</span></h2>
    <p style="color: #555; font-size: 0.75rem; font-weight: 800; letter-spacing: 2px; text-transform: uppercase;">Version 2.5 (Stable)</p>

    <div style="background: #161616; padding: 25px; border-radius: 30px; border: 1px solid #222; margin-top: 40px; text-align: left;">
        <p style="color: #aaa; font-size: 0.85rem; line-height: 1.7; margin: 0;">
            <strong>Montera</strong> adalah asisten keuangan cerdas yang dirancang untuk membantu kamu mengelola arus kas dengan lebih mudah. 
            <br><br>
            Dilengkapi dengan teknologi <strong>Gemini 2.5 Flash AI</strong>, Montera mampu membaca struk fisik dan mencatatnya secara otomatis dalam hitungan detik.
        </p>
    </div>

    <p style="color: #333; font-size: 0.7rem; margin-top: 50px; font-weight: bold;">
        &copy; 2026 Montera Finance. Built for Excellence.
    </p>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div style="padding: 25px;">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
        <a href="{{ route('profil') }}" style="color: white; font-size: 1.2rem;"><i class="fa-solid fa-arrow-left"></i></a>
        <h2 style="font-weight: 900; margin: 0; letter-spacing: -1px;">Pusat <span style="color: #D32F2F;">Bantuan</span></h2>
    </div>

    <div style="display: flex; flex-direction: column; gap: 15px;">
        <div style="background: #161616; padding: 20px; border-radius: 25px; border: 1px solid #222;">
            <h4 style="color: #D32F2F; margin-bottom: 8px; font-size: 0.9rem;">Cara Scan Nota AI?</h4>
            <p style="color: #666; font-size: 0.8rem; line-height: 1.5; margin: 0;">Klik tombol (+) di navigasi bawah, lalu pilih ikon kamera. Pastikan foto struk terlihat jelas dan terang agar AI Gemini dapat merinci data otomatis.</p>
        </div>

        <div style="background: #161616; padding: 20px; border-radius: 25px; border: 1px solid #222;">
            <h4 style="color: #D32F2F; margin-bottom: 8px; font-size: 0.9rem;">Data Tidak Muncul?</h4>
            <p style="color: #666; font-size: 0.8rem; line-height: 1.5; margin: 0;">Pastikan kamu sudah login. Jika menggunakan filter tanggal, pastikan rentang tanggal yang dipilih sesuai dengan transaksi yang pernah kamu buat.</p>
        </div>

        <div style="background: linear-gradient(135deg, #D32F2F, #7B1111); padding: 25px; border-radius: 30px; margin-top: 20px; text-align: center;">
            <i class="fa-brands fa-whatsapp" style="font-size: 2rem; margin-bottom: 10px;"></i>
            <h4 style="margin-bottom: 5px;">Butuh Bantuan Lain?</h4>
            <p style="font-size: 0.75rem; opacity: 0.8; margin-bottom: 15px;">Tim support kami siap membantu masalah teknismu.</p>
            <a href="https://wa.me/6281" style="display: block; background: white; color: black; padding: 12px; border-radius: 15px; text-decoration: none; font-weight: 900; font-size: 0.8rem;">HUBUNGI WHATSAPP</a>
        </div>
    </div>
</div>
@endsection
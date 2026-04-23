@extends('layouts.app')

@section('content')
<div style="padding: 25px; padding-bottom: 100px;">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
        <a href="{{ route('profil') }}" style="color: white; font-size: 1.2rem;"><i class="fa-solid fa-arrow-left"></i></a>
        <h2 style="font-weight: 900; margin: 0; letter-spacing: -1px;">Keamanan <span style="color: #D32F2F;">Akun</span></h2>
    </div>

    <form action="{{ route('profil.keamanan.update') }}" method="POST">
        @csrf @method('PUT')
        
        <div style="margin-bottom: 25px;">
            <label style="font-size: 10px; color: #555; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Kata Sandi Saat Ini</label>
            <input type="password" name="current_password" required
                   style="width: 100%; background: #161616; border: 1px solid #222; color: white; padding: 15px; border-radius: 15px; margin-top: 8px; outline: none; transition: 0.3s;">
            @error('current_password') <small style="color: #D32F2F; font-weight: bold; margin-top: 5px; display: block;">{{ $message }}</small> @enderror
        </div>

        <div style="height: 1px; background: #222; margin-bottom: 25px;"></div>

        <div style="margin-bottom: 15px;">
            <label style="font-size: 10px; color: #555; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Kata Sandi Baru</label>
            <input type="password" name="password" required
                   style="width: 100%; background: #161616; border: 1px solid #222; color: white; padding: 15px; border-radius: 15px; margin-top: 8px; outline: none;">
            @error('password') <small style="color: #D32F2F; font-weight: bold; margin-top: 5px; display: block;">{{ $message }}</small> @enderror
        </div>

        <div style="background: rgba(255,255,255,0.02); padding: 15px; border-radius: 15px; border: 1px solid #222; margin-bottom: 20px;">
            <p style="font-size: 10px; color: #777; font-weight: 800; margin-bottom: 8px; text-transform: uppercase;">Kriteria Sandi Aman:</p>
            <ul style="margin: 0; padding-left: 15px; font-size: 0.75rem; color: #555; display: flex; flex-direction: column; gap: 4px;">
                <li>Minimal <strong>8 Karakter</strong></li>
                <li>Gunakan campuran <strong>Huruf Besar & Kecil</strong></li>
                <li>Wajib menyertakan <strong>Angka (0-9)</strong></li>
                <li>Wajib menyertakan <strong>Simbol (@, $, !, %, *, #, ?, &)</strong></li>
            </ul>
        </div>

        <div style="margin-bottom: 30px;">
            <label style="font-size: 10px; color: #555; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Konfirmasi Kata Sandi Baru</label>
            <input type="password" name="password_confirmation" required
                   style="width: 100%; background: #161616; border: 1px solid #222; color: white; padding: 15px; border-radius: 15px; margin-top: 8px; outline: none;">
        </div>

        <button type="submit" class="btn-submit" style="width: 100%; background: #D32F2F; color: white; border: none; padding: 18px; border-radius: 20px; font-weight: 900; font-size: 14px; cursor: pointer; box-shadow: 0 10px 20px rgba(211, 47, 47, 0.2);">
            PERBARUI KATA SANDI
        </button>
    </form>
</div>
@endsection
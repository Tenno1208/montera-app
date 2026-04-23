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
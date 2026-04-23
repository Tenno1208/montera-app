@extends('layouts.app')

@section('styles')
<style>
    .password-wrapper {
        position: relative;
        width: 100%;
    }
    .toggle-password {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #444;
        cursor: pointer;
        font-size: 1.1rem;
        z-index: 10;
        padding: 5px;
        transition: 0.3s;
    }
    .toggle-password:active {
        color: #D32F2F;
    }
    .input-pass {
        width: 100%; 
        background: #161616; 
        border: 1px solid #222; 
        color: white; 
        padding: 15px; 
        padding-right: 50px; /* Ruang untuk ikon mata */
        border-radius: 15px; 
        margin-top: 8px; 
        outline: none; 
        transition: 0.3s;
    }
    .input-pass:focus {
        border-color: #D32F2F;
    }
</style>
@endsection

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
            <div class="password-wrapper">
                <input type="password" name="current_password" class="input-pass" id="pass1" required>
                <i class="fa-solid fa-eye toggle-password" onclick="togglePass('pass1', this)"></i>
            </div>
            @error('current_password') <small style="color: #D32F2F; font-weight: bold; margin-top: 5px; display: block;">{{ $message }}</small> @enderror
        </div>

        <div style="height: 1px; background: #222; margin-bottom: 25px;"></div>

        <div style="margin-bottom: 20px;">
            <label style="font-size: 10px; color: #555; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Kata Sandi Baru</label>
            <div class="password-wrapper">
                <input type="password" name="password" class="input-pass" id="pass2" required>
                <i class="fa-solid fa-eye toggle-password" onclick="togglePass('pass2', this)"></i>
            </div>
            @error('password') <small style="color: #D32F2F; font-weight: bold; margin-top: 5px; display: block;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 30px;">
            <label style="font-size: 10px; color: #555; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Konfirmasi Kata Sandi Baru</label>
            <div class="password-wrapper">
                <input type="password" name="password_confirmation" class="input-pass" id="pass3" required>
                <i class="fa-solid fa-eye toggle-password" onclick="togglePass('pass3', this)"></i>
            </div>
        </div>

        <div style="background: rgba(255,255,255,0.02); padding: 15px; border-radius: 15px; border: 1px solid #222; margin-bottom: 30px;">
            <p style="font-size: 10px; color: #777; font-weight: 800; margin-bottom: 8px; text-transform: uppercase;">Kriteria Sandi Aman:</p>
            <ul style="margin: 0; padding-left: 15px; font-size: 0.75rem; color: #555; display: flex; flex-direction: column; gap: 4px;">
                <li>Minimal <strong>8 Karakter</strong></li>
                <li>Gunakan campuran <strong>Huruf Besar & Kecil</strong></li>
                <li>Wajib menyertakan <strong>Angka (0-9)</strong></li>
                <li>Wajib menyertakan <strong>Simbol (@, $, !, %, *, #, ?, &)</strong></li>
            </ul>
        </div>

        <button type="submit" class="btn-submit" style="width: 100%; background: #D32F2F; color: white; border: none; padding: 18px; border-radius: 20px; font-weight: 900; font-size: 14px; cursor: pointer; box-shadow: 0 10px 20px rgba(211, 47, 47, 0.2);">
            PERBARUI KATA SANDI
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function togglePass(id, icon) {
        const input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
            icon.style.color = "#D32F2F";
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            icon.style.color = "#444";
        }
    }
</script>
@endsection
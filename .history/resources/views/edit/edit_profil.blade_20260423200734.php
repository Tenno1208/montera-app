@extends('layouts.app')

@section('content')
<div style="padding: 25px;">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
        <a href="{{ route('profil') }}" style="color: white; font-size: 1.2rem;"><i class="fa-solid fa-arrow-left"></i></a>
        <h2 style="font-weight: 900; margin: 0;">Edit <span style="color: #D32F2F;">Profil</span></h2>
    </div>

    <form action="{{ route('profil.update') }}" method="POST">
        @csrf @method('PUT')
        <div style="margin-bottom: 20px;">
            <label style="font-size: 10px; color: #555; font-weight: 800; text-transform: uppercase;">Nama Lengkap</label>
            <input type="text" name="name" class="input-control" value="{{ $user->name }}" required 
                   style="width: 100%; background: #161616; border: 1px solid #222; color: white; padding: 15px; border-radius: 15px; margin-top: 8px;">
        </div>

        <div style="margin-bottom: 30px;">
            <label style="font-size: 10px; color: #555; font-weight: 800; text-transform: uppercase;">Alamat Email</label>
            <input type="email" name="email" class="input-control" value="{{ $user->email }}" required
                   style="width: 100%; background: #161616; border: 1px solid #222; color: white; padding: 15px; border-radius: 15px; margin-top: 8px;">
        </div>

        <button type="submit" class="btn-submit" style="width: 100%; background: #D32F2F; color: white; border: none; padding: 18px; border-radius: 20px; font-weight: 900;">SIMPAN PERUBAHAN</button>
    </form>
</div>
@endsection
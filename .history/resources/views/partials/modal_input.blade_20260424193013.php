<div class="modal" id="modalTransaction">
    <div class="modal-content">
        <div style="width: 50px; height: 5px; background: #333; margin: 0 auto 30px; border-radius: 10px;"></div>
        
        <h2 style="text-align: center; margin-bottom: 10px; font-weight: 900; letter-spacing: -1px; color: white;">CATAT TRANSAKSI</h2>
        
        <div style="margin-bottom: 25px; text-align: center;">
            <label for="scan-camera" style="cursor: pointer; display: inline-block; width: 100%;">
                <div style="background: rgba(var(--montera-red-rgb, 211, 47, 47), 0.05); padding: 15px; border-radius: 20px; border: 1px dashed var(--montera-red); color: var(--montera-red); transition: 0.3s;" id="scan-box">
                    <i class="fa-solid fa-wand-magic-sparkles" style="font-size: 1.2rem; margin-bottom: 5px; display: block;"></i>
                    <span style="font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Scan Nota via AI</span>
                </div>
            </label>
            <input type="file" id="scan-camera" accept="image/*" capture="environment" style="display: none;" onchange="prosesScan(this)">
            
            <p id="loading-ai" style="display:none; font-size: 10px; color: var(--montera-red); margin-top: 10px; font-weight: bold;">
                <i class="fa-solid fa-spinner fa-spin"></i> AI Sedang Menganalisa Struk...
            </p>
        </div>

        <form action="{{ route('store') }}" method="POST" id="form-transaksi">
            @csrf
            
            <div style="display: flex; gap: 10px; margin-bottom: 25px;">
                <label style="flex: 1; position: relative;">
                    <input type="radio" name="type" value="expense" checked style="display:none;" id="radio-exp">
                    <div onclick="selectType('expense')" id="btn-exp" style="text-align: center; padding: 12px; background: var(--montera-red); color: white; border-radius: 15px; font-size: 11px; font-weight: bold; cursor: pointer; transition: 0.3s; border: 1px solid transparent;">
                        PENGELUARAN
                    </div>
                </label>
                <label style="flex: 1; position: relative;">
                    <input type="radio" name="type" value="income" style="display:none;" id="radio-inc">
                    <div onclick="selectType('income')" id="btn-inc" style="text-align: center; padding: 12px; background: #1A1A1A; color: #555; border-radius: 15px; font-size: 11px; font-weight: bold; cursor: pointer; transition: 0.3s; border: 1px solid #222;">
                        PEMASUKAN
                    </div>
                </label>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 10px; color: #555; font-weight: bold; margin-left: 5px; text-transform: uppercase;">Nominal (Rp)</label>
                <input type="number" name="amount" class="input-control" placeholder="0" required style="width: 100%; background: #1A1A1A; border: 1px solid #222; color: white; padding: 15px; border-radius: 15px; margin-top: 5px; font-weight: 800; font-size: 1.1rem;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 10px; color: #555; font-weight: bold; margin-left: 5px; text-transform: uppercase;">Keterangan</label>
                <input type="text" name="title" class="input-control" placeholder="Beli apa hari ini?" required style="width: 100%; background: #1A1A1A; border: 1px solid #222; color: white; padding: 15px; border-radius: 15px; margin-top: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 10px; color: #555; font-weight: bold; margin-left: 5px; text-transform: uppercase;">Kategori</label>
                <input type="text" name="category" class="input-control" placeholder="Makanan, Transport, dll" required style="width: 100%; background: #1A1A1A; border: 1px solid #222; color: white; padding: 15px; border-radius: 15px; margin-top: 5px;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="font-size: 10px; color: #555; font-weight: bold; margin-left: 5px; text-transform: uppercase;">Tanggal</label>
                <input type="date" name="date" class="input-control" value="{{ date('Y-m-d') }}" required style="width: 100%; background: #1A1A1A; border: 1px solid #222; color: white; padding: 15px; border-radius: 15px; margin-top: 5px;">
            </div>

            <button type="submit" class="btn-submit" style="width: 100%; background: var(--montera-red); color: white; border: none; padding: 18px; border-radius: 18px; font-weight: 900; letter-spacing: 1px; box-shadow: 0 10px 20px rgba(var(--montera-red-rgb), 0.2); transition: 0.3s;">
                SIMPAN TRANSAKSI
            </button>
            <button type="button" onclick="closeModal()" style="width: 100%; background: none; border: none; color: #444; margin-top: 15px; font-weight: bold; cursor: pointer; font-size: 11px;">TUTUP</button>
        </form>
    </div>
</div>

<script>
    // FUNGSI GANTI TIPE - SINKRON TEMA
    function selectType(type) {
        const btnExp = document.getElementById('btn-exp');
        const btnInc = document.getElementById('btn-inc');
        const radExp = document.getElementById('radio-exp');
        const radInc = document.getElementById('radio-inc');
        
        const themeColor = localStorage.getItem('montera_theme_red') || '#D32F2F';

        if(type === 'expense') {
            btnExp.style.background = themeColor;
            btnExp.style.color = 'white';
            btnInc.style.background = '#1A1A1A';
            btnInc.style.color = '#555';
            radExp.checked = true;
        } else {
            btnExp.style.background = '#1A1A1A';
            btnExp.style.color = '#555';
            btnInc.style.background = '#22c55e'; // Pemasukan tetap hijau demi UX
            btnInc.style.color = 'white';
            radInc.checked = true;
        }
    }

    // FUNGSI AI SCAN - DENGAN SINKRONISASI TEMA
    function prosesScan(input) {
        if (input.files && input.files[0]) {
            const loading = document.getElementById('loading-ai');
            const scanBox = document.getElementById('scan-box');
            const themeColor = localStorage.getItem('montera_theme_red') || '#D32F2F';
            
            loading.style.display = 'block';
            loading.style.color = themeColor;
            scanBox.style.opacity = '0.4';

            let formData = new FormData();
            formData.append('image', input.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('/scan-nota', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector('input[name="amount"]').value = data.amount;
                document.querySelector('input[name="title"]').value = data.title;
                document.querySelector('input[name="category"]').value = data.category;
                document.querySelector('input[name="date"]').value = data.date;

                selectType('expense');

                loading.innerHTML = "<span style='color: #22c55e;'><i class='fa-solid fa-check-double'></i> Nota berhasil dibaca!</span>";
                scanBox.style.opacity = '1';
                scanBox.style.borderColor = '#22c55e';
                scanBox.style.background = 'rgba(34, 197, 94, 0.05)';
                
                setTimeout(() => {
                    loading.style.display = 'none';
                    scanBox.style.borderColor = themeColor;
                    scanBox.style.background = `rgba(var(--montera-red-rgb), 0.05)`;
                }, 3000);
            })
            .catch(error => {
                loading.innerHTML = "<span style='color: #ff4d4d;'>Gagal menganalisa nota.</span>";
                scanBox.style.opacity = '1';
            });
        }
    }

    // Pastikan warna awal tombol sesuai tema
    document.addEventListener('DOMContentLoaded', () => {
        const currentTheme = localStorage.getItem('montera_theme_red') || '#D32F2F';
        document.getElementById('btn-exp').style.background = currentTheme;
    });
</script>
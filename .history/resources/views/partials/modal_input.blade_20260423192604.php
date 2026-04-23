<div class="modal" id="modalTransaction">
    <div class="modal-content">
        <div style="width: 50px; height: 5px; background: #333; margin: 0 auto 30px; border-radius: 10px;"></div>
        
        <h2 style="text-align: center; margin-bottom: 10px; font-weight: 900; letter-spacing: -1px;">CATAT TRANSAKSI</h2>
        
        <div style="margin-bottom: 25px; text-align: center;">
            <label for="scan-camera" style="cursor: pointer; display: inline-block; width: 100%;">
                <div style="background: rgba(211, 47, 47, 0.05); padding: 15px; border-radius: 20px; border: 1px dashed #D32F2F; color: #D32F2F; transition: 0.3s;" id="scan-box">
                    <i class="fa-solid fa-camera" style="font-size: 1.2rem; margin-bottom: 5px; display: block;"></i>
                    <span style="font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Scan Nota via AI</span>
                </div>
            </label>
            <input type="file" id="scan-camera" accept="image/*" capture="environment" style="display: none;" onchange="prosesScan(this)">
            
            <p id="loading-ai" style="display:none; font-size: 10px; color: #D32F2F; margin-top: 10px; font-weight: bold;">
                <i class="fa-solid fa-spinner fa-spin"></i> AI Sedang Menganalisa Struk...
            </p>
        </div>

        <form action="{{ route('store') }}" method="POST" id="form-transaksi">
            @csrf
            <div style="display: flex; gap: 10px; margin-bottom: 25px;">
                <label style="flex: 1; position: relative;">
                    <input type="radio" name="type" value="expense" checked style="display:none;" id="radio-exp">
                    <div onclick="selectType('expense')" id="btn-exp" style="text-align: center; padding: 12px; background: #D32F2F; border-radius: 15px; font-size: 11px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                        PENGELUARAN
                    </div>
                </label>
                <label style="flex: 1; position: relative;">
                    <input type="radio" name="type" value="income" style="display:none;" id="radio-inc">
                    <div onclick="selectType('income')" id="btn-inc" style="text-align: center; padding: 12px; background: #1A1A1A; border-radius: 15px; font-size: 11px; font-weight: bold; cursor: pointer; transition: 0.3s; border: 1px solid #222;">
                        PEMASUKAN
                    </div>
                </label>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 10px; color: #555; font-weight: bold; margin-left: 5px;">NOMINAL (RP)</label>
                <input type="number" name="amount" class="input-control" placeholder="0" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 10px; color: #555; font-weight: bold; margin-left: 5px;">KETERANGAN</label>
                <input type="text" name="title" class="input-control" placeholder="Contoh: Beli Kopi" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 10px; color: #555; font-weight: bold; margin-left: 5px;">KATEGORI</label>
                <input type="text" name="category" class="input-control" placeholder="Makanan, Transportasi, dll" required>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="font-size: 10px; color: #555; font-weight: bold; margin-left: 5px;">TANGGAL</label>
                <input type="date" name="date" class="input-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <button type="submit" class="btn-submit shadow-lg">SIMPAN TRANSAKSI</button>
            <button type="button" onclick="closeModal()" style="width: 100%; background: none; border: none; color: #555; margin-top: 15px; font-weight: bold; cursor: pointer; font-size: 12px;">BATALKAN</button>
        </form>
    </div>
</div>

<script>
    function selectType(type) {
        const btnExp = document.getElementById('btn-exp');
        const btnInc = document.getElementById('btn-inc');
        const radExp = document.getElementById('radio-exp');
        const radInc = document.getElementById('radio-inc');

        if(type === 'expense') {
            btnExp.style.background = '#D32F2F';
            btnInc.style.background = '#1A1A1A';
            radExp.checked = true;
        } else {
            btnExp.style.background = '#1A1A1A';
            btnInc.style.background = '#22c55e';
            radInc.checked = true;
        }
    }

    // FUNGSI PROSES SCAN NOTA
    function prosesScan(input) {
        if (input.files && input.files[0]) {
            const loading = document.getElementById('loading-ai');
            const scanBox = document.getElementById('scan-box');
            
            loading.style.display = 'block';
            scanBox.style.opacity = '0.5';

            let formData = new FormData();
            formData.append('image', input.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('/scan-nota', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Mengisi input otomatis dari hasil AI
                document.getElementsByName('amount')[0].value = data.amount;
                document.getElementsByName('title')[0].value = data.title;
                document.getElementsByName('category')[0].value = data.category;
                document.getElementsByName('date')[0].value = data.date;
                
                loading.innerHTML = "✅ Analisa Berhasil!";
                scanBox.style.opacity = '1';
                setTimeout(() => loading.style.display = 'none', 3000);
            })
            .catch(error => {
                console.error(error);
                loading.innerHTML = "❌ Gagal menganalisa. Coba lagi.";
                scanBox.style.opacity = '1';
            });
        }
    }
</script>
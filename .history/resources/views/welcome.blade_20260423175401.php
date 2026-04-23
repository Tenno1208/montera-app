<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Montera - Premium Finance</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* RESET & BASE */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        body { background-color: #0F0F0F; color: #FFFFFF; line-height: 1.6; overflow-x: hidden; }

        /* LAYOUT */
        .app-container { max-width: 450px; margin: 0 auto; min-height: 100vh; padding-bottom: 100px; position: relative; }

        /* HEADER */
        header { padding: 25px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; background: rgba(15, 15, 15, 0.9); backdrop-filter: blur(10px); z-index: 10; }
        .logo-section { display: flex; align-items: center; gap: 12px; }
        .logo-img { width: 45px; height: 45px; object-fit: contain; }
        .brand-name h1 { font-size: 1.2rem; font-weight: 900; letter-spacing: -1px; margin-bottom: -4px; }
        .brand-name p { font-size: 0.6rem; color: #D32F2F; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; }

        /* LUXURY CARD */
        .balance-card { 
            margin: 10px 20px; 
            padding: 30px; 
            border-radius: 35px; 
            background: linear-gradient(135deg, #D32F2F 0%, #7B1111 50%, #121212 100%);
            box-shadow: 0 20px 40px rgba(211, 47, 47, 0.3);
            position: relative;
            overflow: hidden;
        }
        .card-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px; opacity: 0.7; font-weight: 600; }
        .card-balance { font-size: 2.2rem; font-weight: 800; margin: 5px 0 25px 0; letter-spacing: -1px; }
        .card-stats { display: grid; grid-template-cols: 1fr 1fr; gap: 15px; }
        .stat-box { background: rgba(255, 255, 255, 0.1); padding: 12px; border-radius: 18px; border: 1px solid rgba(255, 255, 255, 0.1); }
        .stat-label { font-size: 0.6rem; text-transform: uppercase; opacity: 0.6; margin-bottom: 4px; display: block; }
        .stat-value { font-size: 0.9rem; font-weight: bold; }

        /* SECTION ACTIVITY */
        .section-title { padding: 30px 25px 15px; display: flex; justify-content: space-between; align-items: center; }
        .section-title h3 { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: #555; }
        
        .transaction-list { padding: 0 20px; }
        .transaction-item { 
            background: #1A1A1A; 
            padding: 18px; 
            border-radius: 25px; 
            display: flex; 
            align-items: center; 
            margin-bottom: 12px; 
            border: 1px solid #222;
        }
        .icon-box { width: 48px; height: 48px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-size: 1.2rem; }
        .icon-income { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
        .icon-expense { background: rgba(211, 47, 47, 0.1); color: #D32F2F; }
        
        .trans-info { flex: 1; }
        .trans-title { font-size: 0.9rem; font-weight: bold; margin-bottom: 2px; }
        .trans-cat { font-size: 0.65rem; color: #555; text-transform: uppercase; font-weight: 700; }
        
        .trans-amount { text-align: right; }
        .amount-val { font-size: 0.9rem; font-weight: 900; }
        .amount-date { font-size: 0.6rem; color: #444; margin-top: 2px; }

        /* NAVIGATION */
        .bottom-nav { 
            position: fixed; bottom: 25px; left: 50%; transform: translateX(-50%); 
            width: 90%; max-width: 400px; height: 75px; 
            background: rgba(18, 18, 18, 0.95); border-radius: 30px; 
            display: flex; justify-content: space-around; align-items: center; 
            border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            z-index: 100;
        }
        .nav-btn { color: #444; font-size: 1.3rem; border: none; background: none; cursor: pointer; }
        .nav-btn.active { color: #D32F2F; }
        .add-btn { 
            width: 60px; height: 60px; background: #D32F2F; color: white; 
            border-radius: 50%; display: flex; align-items: center; justify-content: center; 
            margin-top: -45px; border: 5px solid #0F0F0F; font-size: 1.5rem;
            box-shadow: 0 10px 20px rgba(211, 47, 47, 0.4);
        }

        /* MODAL / BOTTOM SHEET */
        .modal { position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; display: none; align-items: flex-end; }
        .modal-content { 
            width: 100%; max-width: 450px; margin: 0 auto; 
            background: #121212; border-radius: 40px 40px 0 0; padding: 40px 30px; 
            transform: translateY(100%); transition: transform 0.4s ease;
        }
        .modal.active { display: flex; }
        .modal.active .modal-content { transform: translateY(0); }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 0.7rem; text-transform: uppercase; color: #555; margin-bottom: 8px; font-weight: bold; padding-left: 5px; }
        .input-control { width: 100%; background: #1A1A1A; border: 1px solid #222; padding: 15px; border-radius: 15px; color: white; font-size: 1rem; outline: none; }
        .input-control:focus { border-color: #D32F2F; }
        
        .btn-submit { width: 100%; background: #D32F2F; color: white; border: none; padding: 18px; border-radius: 20px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; margin-top: 10px; cursor: pointer; }
        
        .type-selector { display: flex; gap: 10px; margin-bottom: 25px; }
        .type-option { flex: 1; text-align: center; padding: 12px; border-radius: 12px; border: 1px solid #222; cursor: pointer; font-size: 0.7rem; font-weight: bold; text-transform: uppercase; color: #555; }
        .type-option.active-expense { background: #D32F2F; color: white; border-color: #D32F2F; }
        .type-option.active-income { background: #22c55e; color: white; border-color: #22c55e; }
        input[type="radio"] { display: none; }
    </style>
</head>
<body>

    <div class="app-container">
        <header>
            <div class="logo-section">
                <img src="{{ asset('img/logo-montera.png') }}" alt="M" class="logo-img">
                <div class="brand-name">
                    <h1>MONTERA</h1>
                    <p>Premium</p>
                </div>
            </div>
            <button class="nav-btn"><i class="fa-solid fa-user-circle"></i></button>
        </header>

        <div class="balance-card">
            <span class="card-label">Available Balance</span>
            <div class="card-balance">Rp {{ number_format($balance ?? 0, 0, ',', '.') }}</div>
            
            <div class="card-stats">
                <div class="stat-box">
                    <span class="stat-label">Income</span>
                    <span class="stat-value">+{{ number_format($totalIncome ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="stat-box">
                    <span class="stat-label">Expenses</span>
                    <span class="stat-value">-{{ number_format($totalExpense ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="section-title">
            <h3>Recent Wealth Activity</h3>
            <i class="fa-solid fa-sliders text-gray-500"></i>
        </div>

        <div class="transaction-list">
            @forelse($transactions ?? [] as $item)
            <div class="transaction-item">
                <div class="icon-box {{ $item->type == 'income' ? 'icon-income' : 'icon-expense' }}">
                    <i class="fa-solid {{ $item->type == 'income' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                </div>
                <div class="trans-info">
                    <p class="trans-title">{{ $item->title }}</p>
                    <p class="trans-cat">{{ $item->category }}</p>
                </div>
                <div class="trans-amount">
                    <p class="amount-val" style="color: {{ $item->type == 'income' ? '#22c55e' : '#FFFFFF' }}">
                        {{ $item->type == 'income' ? '+' : '-' }} {{ number_format($item->amount, 0, ',', '.') }}
                    </p>
                    <p class="amount-date">{{ date('d M Y', strtotime($item->date)) }}</p>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 40px; color: #444;">
                <p>No transactions yet.</p>
            </div>
            @endforelse
        </div>

        <nav class="bottom-nav">
            <button class="nav-btn active"><i class="fa-solid fa-house"></i></button>
            <button class="add-btn" onclick="openModal()"><i class="fa-solid fa-plus"></i></button>
            <button class="nav-btn"><i class="fa-solid fa-chart-pie"></i></button>
        </nav>
    </div>

    <div class="modal" id="modalTransaction">
        <div class="modal-content">
            <div style="width: 50px; height: 5px; background: #333; margin: 0 auto 30px; border-radius: 10px;"></div>
            <h2 style="text-align: center; margin-bottom: 30px; font-weight: 900;">NEW RECORD</h2>
            
            <form action="{{ route('store') }}" method="POST">
                @csrf
                <div class="type-selector">
                    <label class="type-option active-expense" id="label-expense">
                        <input type="radio" name="type" value="expense" checked onchange="updateType('expense')"> Expense
                    </label>
                    <label class="type-option" id="label-income">
                        <input type="radio" name="type" value="income" onchange="updateType('income')"> Income
                    </label>
                </div>

                <div class="form-group">
                    <label>Amount (IDR)</label>
                    <input type="number" name="amount" class="input-control" placeholder="0" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="title" class="input-control" placeholder="Food, Salary, etc." required>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category" class="input-control" placeholder="General" required>
                </div>

                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" class="input-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <button type="submit" class="btn-submit">Save Record</button>
                <button type="button" onclick="closeModal()" style="width: 100%; background: none; border: none; color: #555; margin-top: 15px; font-weight: bold; cursor: pointer;">CANCEL</button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modalTransaction').classList.add('active');
        }
        function closeModal() {
            document.getElementById('modalTransaction').classList.remove('active');
        }
        function updateType(type) {
            const exp = document.getElementById('label-expense');
            const inc = document.getElementById('label-income');
            if(type === 'expense') {
                exp.classList.add('active-expense');
                inc.classList.remove('active-income');
            } else {
                inc.classList.add('active-income');
                exp.classList.remove('active-expense');
            }
        }
        // Close modal if clicked outside
        window.onclick = function(event) {
            let modal = document.getElementById('modalTransaction');
            if (event.target == modal) closeModal();
        }
    </script>
</body>
</html>
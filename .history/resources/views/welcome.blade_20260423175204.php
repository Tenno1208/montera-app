<body class="bg-[#0F0F0F] text-white font-sans selection:bg-red-600">

    <div class="max-w-md mx-auto min-h-screen relative pb-28">
        
        <header class="p-6 flex justify-between items-center bg-[#0F0F0F]/80 backdrop-blur-md sticky top-0 z-40">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo-montera.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                <div>
                    <h1 class="text-lg font-black tracking-tighter leading-none">MONTERA</h1>
                    <p class="text-[10px] text-red-500 font-bold tracking-[0.2em] uppercase">Premium Finance</p>
                </div>
            </div>
            <div class="w-10 h-10 rounded-full border border-gray-800 flex items-center justify-center bg-gradient-to-tr from-gray-900 to-black">
                <i class="fa-solid fa-user-astronaut text-xs"></i>
            </div>
        </header>

        <div class="px-6 mt-4">
            <div class="relative p-8 rounded-[2.5rem] bg-gradient-to-br from-red-700 to-red-900 shadow-[0_20px_50px_rgba(185,28,28,0.3)] overflow-hidden">
                <img src="{{ asset('img/logo-montera.png') }}" class="absolute -right-10 -bottom-10 w-48 opacity-10 grayscale brightness-200">
                
                <div class="relative z-10">
                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-red-200/70">Total Portfolio</span>
                    <h2 class="text-4xl font-black mt-1 tracking-tight">Rp {{ number_format($balance, 0, ',', '.') }}</h2>
                    
                    <div class="mt-10 grid grid-cols-2 gap-4">
                        <div class="bg-black/20 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                            <p class="text-[9px] uppercase font-bold text-red-200/50 mb-1">Income</p>
                            <p class="text-sm font-bold text-white leading-none">+{{ number_format($totalIncome, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-black/20 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                            <p class="text-[9px] uppercase font-bold text-red-200/50 mb-1">Expenses</p>
                            <p class="text-sm font-bold text-white leading-none">-{{ number_format($totalExpense, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 px-6">
            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-500 mb-6 flex items-center gap-2">
                <span class="w-2 h-2 bg-red-600 rounded-full animate-pulse"></span>
                Live Activity
            </h3>

            <div class="space-y-4">
                @foreach($transactions as $item)
                <div class="group bg-[#1A1A1A] hover:bg-[#222] p-4 rounded-[1.8rem] flex items-center transition-all duration-300 border border-transparent hover:border-gray-800">
                    <div class="w-12 h-12 {{ $item->type == 'income' ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }} rounded-2xl flex items-center justify-center mr-4 shadow-inner">
                        <i class="fa-solid {{ $item->type == 'income' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm tracking-tight">{{ $item->title }}</p>
                        <p class="text-[10px] text-gray-500 font-medium uppercase tracking-tighter">{{ date('d M Y', strtotime($item->date)) }} • {{ $item->category }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-sm {{ $item->type == 'income' ? 'text-green-500' : 'text-white' }}">
                            {{ $item->type == 'income' ? '+' : '-' }} {{ number_format($item->amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <nav class="fixed bottom-8 left-1/2 -translate-x-1/2 w-[90%] max-w-md h-20 bg-black/90 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] flex justify-around items-center px-6 shadow-2xl z-50">
            <button class="text-red-600"><i class="fa-solid fa-grid-2 text-xl"></i></button>
            
            <button onclick="toggleModal()" class="w-14 h-14 bg-red-600 rounded-full flex items-center justify-center shadow-[0_0_20px_rgba(220,38,38,0.5)] active:scale-90 transition-transform -mt-12 border-4 border-[#0F0F0F]">
                <i class="fa-solid fa-plus text-white text-xl"></i>
            </button>
            
            <button class="text-gray-600"><i class="fa-solid fa-chart-line text-xl"></i></button>
        </nav>
    </div>

    <div id="modalAdd" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[60] hidden transition-opacity">
        <div class="absolute bottom-0 left-0 right-0 max-w-md mx-auto bg-[#121212] rounded-t-[3rem] p-10 border-t border-white/10 transform translate-y-full transition-transform duration-500 shadow-2xl" id="modalContent">
            <div class="w-12 h-1 bg-gray-800 rounded-full mx-auto mb-8"></div>
            
            <h2 class="text-2xl font-black mb-6 text-center">New Transaction</h2>
            
            <form action="{{ route('store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative group cursor-pointer">
                        <input type="radio" name="type" value="expense" checked class="peer hidden">
                        <div class="p-4 rounded-2xl border border-gray-800 text-center peer-checked:bg-red-600 peer-checked:border-red-600 transition-all">
                            <span class="text-xs font-bold uppercase tracking-widest text-gray-400 peer-checked:text-white">Expense</span>
                        </div>
                    </label>
                    <label class="relative group cursor-pointer">
                        <input type="radio" name="type" value="income" class="peer hidden">
                        <div class="p-4 rounded-2xl border border-gray-800 text-center peer-checked:bg-green-600 peer-checked:border-green-600 transition-all">
                            <span class="text-xs font-bold uppercase tracking-widest text-gray-400 peer-checked:text-white">Income</span>
                        </div>
                    </label>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-500 uppercase ml-2">Amount</label>
                    <input type="number" name="amount" placeholder="0" class="w-full bg-transparent text-4xl font-black focus:outline-none border-b border-gray-800 focus:border-red-600 pb-2 transition-colors">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-gray-500 uppercase ml-2">Title</label>
                    <input type="text" name="title" placeholder="What is this for?" class="w-full bg-[#1A1A1A] p-4 rounded-2xl border border-gray-800 focus:outline-none focus:border-red-600">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="category" placeholder="Category" class="w-full bg-[#1A1A1A] p-4 rounded-2xl border border-gray-800 focus:outline-none">
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full bg-[#1A1A1A] p-4 rounded-2xl border border-gray-800 focus:outline-none">
                </div>

                <button type="submit" class="w-full bg-red-600 py-5 rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-red-600/20 active:scale-95 transition-transform">Save Transaction</button>
                <button type="button" onclick="toggleModal()" class="w-full text-gray-500 font-bold text-xs uppercase tracking-widest mt-2">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('modalAdd');
            const content = document.getElementById('modalContent');
            
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    content.classList.remove('translate-y-full');
                }, 10);
            } else {
                content.classList.add('translate-y-full');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 500);
            }
        }
    </script>
</body>
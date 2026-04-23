<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Montera - Premium Finance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="manifest" href="/manifest.json">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; -webkit-tap-highlight-color: transparent; }
        .luxury-card { background: linear-gradient(135deg, #121212 0%, #330000 100%); }
    </style>
</head>
<body class="bg-gray-50">

    <div class="max-w-md mx-auto min-h-screen relative pb-24">
        <header class="p-6 flex justify-between items-center">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest">Welcome back,</p>
                <h1 class="text-xl font-bold text-black">User Montera</h1>
            </div>
            <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center">
                <i class="fa-solid fa-bell text-red-600"></i>
            </div>
        </header>

        <div class="px-6">
            <div class="luxury-card p-8 rounded-[2.5rem] shadow-2xl shadow-red-900/20 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-sm opacity-60">Total Savings</p>
                    <h2 class="text-3xl font-bold mt-1">Rp {{ number_format($balance, 0, ',', '.') }}</h2>
                    <div class="mt-8 flex justify-between">
                        <div>
                            <p class="text-[10px] uppercase opacity-50">Income</p>
                            <p class="text-sm font-semibold text-green-400">+Rp {{ number_format($totalIncome/1000000, 1) }}M</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] uppercase opacity-50">Expense</p>
                            <p class="text-sm font-semibold text-red-400">-Rp {{ number_format($totalExpense/1000000, 1) }}M</p>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-600/10 rounded-full blur-3xl"></div>
            </div>
        </div>

        <div class="mt-10 px-6">
            <div class="flex justify-between items-end mb-6">
                <h3 class="text-lg font-bold">Latest Activity</h3>
                <a href="#" class="text-red-600 text-xs font-bold">View All</a>
            </div>

            <div class="space-y-4">
    @foreach($transactions as $item)
    <div class="bg-white p-4 rounded-[1.5rem] flex items-center shadow-sm border border-gray-50">
        <div class="w-12 h-12 {{ $item->type == 'income' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} rounded-2xl flex items-center justify-center mr-4">
            <i class="fa-solid {{ $item->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
        </div>
        <div class="flex-1">
            <p class="font-bold text-sm text-gray-900">{{ $item->title }}</p>
            <p class="text-[10px] text-gray-400 uppercase">{{ date('d M', strtotime($item->date)) }} • {{ $item->category }}</p>
        </div>
        <p class="font-bold {{ $item->type == 'income' ? 'text-green-600' : 'text-red-600' }} text-sm">
            {{ $item->type == 'income' ? '+' : '-' }} Rp {{ number_format($item->amount, 0, ',', '.') }}
        </p>
    </div>
    @endforeach
</div>

        <nav class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-white/80 backdrop-blur-lg border-t border-gray-100 px-8 py-4 flex justify-between items-center rounded-t-[2rem]">
            <i class="fa-solid fa-house text-red-600 text-xl"></i>
            <div class="w-14 h-14 bg-black rounded-full -mt-14 border-8 border-gray-50 flex items-center justify-center shadow-xl shadow-red-600/20 text-white cursor-pointer active:scale-90 transition-transform">
                <i class="fa-solid fa-plus text-lg"></i>
            </div>
            <i class="fa-solid fa-chart-simple text-gray-300 text-xl"></i>
        </nav>
    </div>

    <script>
        // Mendaftarkan Service Worker agar bisa PWA
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js');
        }
    </script>
</body>
</html>
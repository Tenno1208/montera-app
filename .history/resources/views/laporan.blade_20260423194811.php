@section('content')
<div class="report-container">
    <h2 style="margin-bottom: 20px; font-weight: 800;">Analisis Keuangan</h2>

    <div class="filter-container" style="margin: 0 0 20px 0;">
        <form action="{{ route('laporan') }}" method="GET" class="filter-form">
            <input type="date" name="start_date" class="filter-input" value="{{ request('start_date') }}">
            <input type="date" name="end_date" class="filter-input" value="{{ request('end_date') }}">
            <button type="submit" class="btn-filter">Update</button>
        </form>
    </div>

    <div class="stat-card">
        <div class="chart-box">
            <div class="chart-inner">
                {{ round($incomePercent) }}%<br>INCOME
            </div>
        </div>
        </div>
</div>
@endsection
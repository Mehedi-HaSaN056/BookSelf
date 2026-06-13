@extends('layouts.app')
@section('title', 'Monthly Budget')
@section('page-title', 'Monthly Budget')

@section('content')
<!-- Year Selector -->
<div class="d-flex align-items-center gap-2 mb-4">
    @foreach($years as $y)
        <a href="{{ route('budget.index', ['year' => $y]) }}" class="btn btn-sm {{ $y == $year ? 'btn-indigo' : 'btn-outline-secondary' }}">{{ $y }}</a>
    @endforeach
    <div class="ms-auto">
        <span class="badge bg-light text-dark me-2">Total Budget: ৳{{ number_format($totalBudget, 0) }}</span>
        <span class="badge bg-indigo">Total Spent: ৳{{ number_format($totalSpent, 0) }}</span>
    </div>
</div>

<!-- Monthly Table -->
<div class="card mb-4">
    <div class="card-header bg-white py-3 fw-600">
        <i class="bi bi-wallet2 me-2 text-indigo"></i>Budget vs Spending — {{ $year }}
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Month</th>
                        <th>Budget (৳)</th>
                        <th>Spent (৳)</th>
                        <th>Books</th>
                        <th>Remaining</th>
                        <th style="min-width:150px;">Progress</th>
                        <th>Set Budget</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($months as $m => $data)
                    <tr class="budget-row">
                        <td class="fw-500">{{ $data['month_name'] }}</td>
                        <td>৳{{ number_format($data['budget'], 0) }}</td>
                        <td class="fw-500">৳{{ number_format($data['spent'], 0) }}</td>
                        <td class="text-center">
                            @if($data['count'] > 0)
                                <a href="{{ route('books.index', ['month' => $m, 'year' => $year]) }}" class="badge bg-indigo text-decoration-none">{{ $data['count'] }}</a>
                            @else
                                <span class="text-muted">0</span>
                            @endif
                        </td>
                        <td class="{{ $data['remaining'] < 0 ? 'budget-over' : 'budget-ok' }}">
                            {{ $data['remaining'] < 0 ? '-' : '' }}৳{{ number_format(abs($data['remaining']), 0) }}
                            @if($data['remaining'] < 0) <i class="bi bi-exclamation-triangle-fill"></i> @endif
                        </td>
                        <td>
                            @if($data['budget'] > 0)
                                <div class="progress" style="height:8px;">
                                    <div class="progress-bar {{ $data['percent'] >= 100 ? 'bg-danger' : ($data['percent'] >= 80 ? 'bg-warning' : 'bg-success') }}"
                                        style="width:{{ $data['percent'] }}%"></div>
                                </div>
                                <small class="text-muted">{{ $data['percent'] }}%</small>
                            @else
                                <small class="text-muted">No budget set</small>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#budgetModal{{ $m }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Budget Edit Modal -->
                    <div class="modal fade" id="budgetModal{{ $m }}" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Set Budget — {{ $data['month_name'] }} {{ $year }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('budget.upsert') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="year" value="{{ $year }}">
                                    <input type="hidden" name="month" value="{{ $m }}">
                                    <div class="modal-body">
                                        <label class="form-label">Budget Amount (৳)</label>
                                        <input type="number" name="budget_amount" class="form-control" value="{{ $data['budget'] }}" min="0" step="0.01" required>
                                        <label class="form-label mt-2">Notes</label>
                                        <input type="text" name="notes" class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-indigo">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
                <tfoot class="table-light fw-600">
                    <tr>
                        <td>Total</td>
                        <td>৳{{ number_format($totalBudget, 0) }}</td>
                        <td class="{{ $totalSpent > $totalBudget ? 'text-danger' : 'text-success' }}">৳{{ number_format($totalSpent, 0) }}</td>
                        <td colspan="4"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Budget Chart -->
<div class="card">
    <div class="card-header bg-white py-3 fw-600"><i class="bi bi-bar-chart me-2 text-indigo"></i>Budget vs Spent Chart</div>
    <div class="card-body">
        <canvas id="budgetChart" height="80"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script>
const budgetData = @json(array_column($months, 'budget'));
const spentData  = @json(array_column($months, 'spent'));
const labels     = @json(array_column($months, 'month_name'));

new Chart(document.getElementById('budgetChart'), {
    type: 'bar',
    data: {
        labels,
        datasets: [
            { label: 'Budget (৳)', data: budgetData, backgroundColor: 'rgba(79,70,229,0.3)', borderColor: '#4f46e5', borderWidth: 1.5, borderRadius: 4 },
            { label: 'Spent (৳)', data: spentData, backgroundColor: 'rgba(239,68,68,0.7)', borderRadius: 4 }
        ]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
});
</script>
@endpush

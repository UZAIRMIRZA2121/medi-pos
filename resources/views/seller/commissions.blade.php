@extends('layouts.app')

@section('content')
<main class="page-content">
    <div class="page-header" style="margin-bottom: 20px;">
        <h1 class="page-title">Commission History</h1>
        <p class="page-subtitle">Track your referred stores and earnings.</p>
    </div>

    <div class="card" style="margin-bottom: 20px;">
        <div class="card-header">
            <h3>Commission History</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Store Referred</th>
                            <th>Package</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wallets as $wallet)
                        <tr>
                            <td>{{ $wallet->created_at->format('M d, Y') }}</td>
                            <td style="font-weight: 500;">{{ $wallet->store->name }}</td>
                            <td>{{ $wallet->subscription && $wallet->subscription->package ? $wallet->subscription->package->name : 'N/A' }}</td>
                            <td style="font-weight: 600; color: #10b981;">PKR {{ number_format($wallet->c_amount, 2) }}</td>
                            <td>
                                @if($wallet->status === 'paid')
                                    <span class="badge badge-success">Paid</span>
                                    @if($wallet->receipt_image)
                                    <div style="margin-top:5px;">
                                        <a href="javascript:void(0)" onclick="showReceipt('{{ Storage::url($wallet->receipt_image) }}')" style="color: #4f46e5; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 4px;">
                                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                            View Receipt
                                        </a>
                                    </div>
                                    @endif
                                @else
                                    <span class="badge badge-warning" style="background:#f59e0b; color:white;">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        
                        @if($wallets->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center" style="padding:20px;">No commissions earned yet. Start referring!</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showReceipt(url) {
        Swal.fire({
            title: 'Payment Receipt',
            imageUrl: url,
            imageAlt: 'Receipt',
            imageWidth: '100%',
            width: 600,
            confirmButtonText: 'Close',
            confirmButtonColor: '#4f46e5'
        });
    }
</script>
@endsection
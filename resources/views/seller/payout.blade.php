@extends('layouts.app')

@section('content')
<main class="page-content">
    <div class="page-header" style="margin-bottom: 20px;">
        <h1 class="page-title">Payout Settings</h1>
        <p class="page-subtitle">Manage how you receive your earnings.</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 20px; padding: 10px; background-color: #d1fae5; color: #065f46; border-radius: 4px;">
        {{ session('success') }}
    </div>
    @endif

    <div class="card" style="margin-bottom: 20px;">
        <div class="card-header">
            <h3>Withdrawal Method / Payout Settings</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Set up where you want to receive your commission payouts (JazzCash, EasyPaisa, Bank Transfer).</p>
        </div>
        <div class="card-body">
            <form action="{{ route('seller.payout.update') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px;">
                    <div class="form-group">
                        <label>Payment Method</label>
                        <select name="payout_method" class="input" required>
                            <option value="">Select Method</option>
                            <option value="JazzCash" {{ auth()->user()->payout_method === 'JazzCash' ? 'selected' : '' }}>JazzCash</option>
                            <option value="EasyPaisa" {{ auth()->user()->payout_method === 'EasyPaisa' ? 'selected' : '' }}>EasyPaisa</option>
                            <option value="Bank Transfer" {{ auth()->user()->payout_method === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Account Name (Title)</label>
                        <input type="text" name="payout_account_name" class="input" value="{{ auth()->user()->payout_account_name }}" required placeholder="e.g. John Doe">
                    </div>
                    <div class="form-group">
                        <label>Account Number (IBAN / Phone)</label>
                        <input type="text" name="payout_account_number" class="input" value="{{ auth()->user()->payout_account_number }}" required placeholder="e.g. 03001234567">
                    </div>
                    <div class="form-group">
                        <label>Bank Name (If applicable)</label>
                        <input type="text" name="payout_bank_name" class="input" value="{{ auth()->user()->payout_bank_name }}" placeholder="e.g. Meezan Bank">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Payout Settings</button>
            </form>
        </div>
    </div>
</main>
@endsection
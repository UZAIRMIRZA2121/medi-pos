<x-guest-layout>
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="color: #ef4444; font-weight: 700; font-size: 1.5rem; margin-bottom: 5px;">Subscription Inactive</h2>
        <p style="color: #64748b; font-size: 0.9rem;">Your store is currently locked because you do not have an active subscription.</p>
    </div>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($paymentRequest && $paymentRequest->status === 'pending')
        <div style="background-color: #fef3c7; color: #92400e; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; border: 1px solid #fcd34d;">
            <strong>Under Review</strong><br>
            You have uploaded a payment proof. Our admin will review and activate your subscription shortly. Please check back later.
        </div>
        
        <div style="text-align: center; margin-top: 15px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost" style="width: 100%;">Logout</button>
            </form>
        </div>
    @else
        @if($paymentRequest && $paymentRequest->status === 'rejected')
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; border: 1px solid #fca5a5;">
                <strong>Payment Rejected</strong><br>
                {{ $paymentRequest->admin_feedback ?? 'Your payment proof was rejected. Please try again.' }}
            </div>
        @endif

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
            <h4 style="margin: 0 0 10px 0; font-size: 1rem; color: #1e293b;">Payment Instructions</h4>
            <ul style="margin: 0; padding-left: 15px; color: #475569; font-size: 0.9rem; line-height: 1.5;">
                <li>Please pay the required amount for your selected package to our bank or mobile account.</li>
                <li><strong>JazzCash:</strong> 0300-0000000 (Account Title)</li>
                <li><strong>Bank:</strong> XYZ Bank, A/C: 123456789</li>
                <li style="margin-top: 5px;">Take a screenshot of the successful transaction and upload it below.</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('subscription.payment.upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">Description / Transaction ID</label>
                <textarea name="description" class="input" rows="2" style="padding: 8px; resize: vertical;" placeholder="Optional: Enter transaction ID or any notes"></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">Upload Payment Screenshot</label>
                <input type="file" name="payment_proof" class="input" accept="image/*" required style="padding: 8px;" />
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; display: flex; justify-content: center; gap: 10px; margin-bottom: 10px;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                Submit Payment Proof
            </button>
        </form>

        <div style="text-align: center; margin-top: 15px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost" style="width: 100%; color: #64748b;">Logout & Return Later</button>
            </form>
        </div>
    @endif
</x-guest-layout>

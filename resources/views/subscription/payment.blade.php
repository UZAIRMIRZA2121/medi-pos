<x-guest-layout>
    @php
        $isManuallyInactive = $lastSubscription && $lastSubscription->status === 'inactive' && $lastSubscription->end_date && now()->lessThanOrEqualTo($lastSubscription->end_date);
    @endphp

    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="color: #ef4444; font-weight: 700; font-size: 1.5rem; margin-bottom: 5px;">
            {{ $isManuallyInactive ? 'Account Inactive' : 'Subscription Inactive' }}
        </h2>
        
        @if($isManuallyInactive)
            <p style="color: #64748b; font-size: 1rem; font-weight: 500; line-height: 1.5;">
                Your account is inactive right now. Please contact administrative support on WhatsApp: <br>
                <a href="https://wa.me/923086452242" target="_blank" style="color: #25D366; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 5px; margin-top: 5px;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.487-1.761-1.663-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    03086452242
                </a>
            </p>
        @elseif($storeUser->package_id && $storeUser->package_id != 1 && $lastSubscription)
            <p style="color: #64748b; font-size: 0.9rem;">
                Your <strong>{{ $storeUser->package->name ?? 'Package' }}</strong> subscription 
                @if($lastSubscription->end_date && now()->greaterThan($lastSubscription->end_date))
                    expired on <strong style="color:#ef4444;">{{ \Carbon\Carbon::parse($lastSubscription->end_date)->format('M d, Y') }}</strong>.
                @else
                    is currently inactive.
                @endif
                Please upload a new payment proof to renew.
            </p>
        @else
            <p style="color: #64748b; font-size: 0.9rem;">Your store is currently locked because you do not have an active subscription.</p>
        @endif
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

    @if($isManuallyInactive)
        <div style="text-align: center; margin-top: 15px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-primary" style="width: 100%;">Logout</button>
            </form>
        </div>
    @elseif($paymentRequest && $paymentRequest->status === 'pending')
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

        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            <div style="flex: 1; min-width: 250px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
                    <h4 style="margin: 0 0 10px 0; font-size: 1rem; color: #1e293b;">Payment Instructions</h4>
                    <ul style="margin: 0; padding-left: 15px; color: #475569; font-size: 0.9rem; line-height: 1.5;">
                        <li>Please pay the required amount for your selected package to our bank or mobile account.</li>
                        <li><strong>JazzCash:</strong> 0300-0000000 (Account Title)</li>
                        <li><strong>Bank:</strong> XYZ Bank, A/C: 123456789</li>
                        <li style="margin-top: 5px;">Take a screenshot of the successful transaction and upload it below.</li>
                    </ul>
                </div>
            </div>

            <div style="flex: 1; min-width: 250px;">
                <form method="POST" action="{{ route('subscription.payment.upload') }}" enctype="multipart/form-data">
                    @csrf

                    @if(isset($packages) && $packages->count() > 0)
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1e293b;">Select Package *</label>
                            <select name="package_id" class="input" required style="padding: 8px; width: 100%;">
                                <option value="">-- Choose a Package --</option>
                                @foreach($packages as $pkg)
                                    <option value="{{ $pkg->id }}">{{ $pkg->name }} - {{ number_format($pkg->price, 2) }} / {{ str_replace('_', ' ', $pkg->billing_type) }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

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
            </div>
        </div>

        <div style="text-align: center; margin-top: 15px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost" style="width: 100%; color: #64748b;">Logout & Return Later</button>
            </form>
        </div>
    @endif
</x-guest-layout>

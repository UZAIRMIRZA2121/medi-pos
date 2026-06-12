@extends('layouts.app')

@section('content')
<main class="page-content">
    <div class="page-header" style="margin-bottom: 20px;">
        <h1 class="page-title">Seller Dashboard</h1>
        <p class="page-subtitle">Welcome, {{ auth()->user()->name }}!</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Packages for Referral</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Copy the registration link for a package below to refer stores. They will be registered under your account.</p>
        </div>
        <div class="card-body" style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                @foreach($packages as $package)
                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; display: flex; flex-direction: column; background: #fff;">
                        <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; color: #1e293b;">{{ $package->name }}</h4>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #4f46e5; margin-bottom: 15px;">
                            {{ number_format($package->price, 2) }} <span style="font-size: 0.9rem; color: #64748b; font-weight: 400;">/ {{ str_replace('_', ' ', $package->billing_type) }}</span>
                        </div>
                        <p style="color: #475569; font-size: 0.9rem; flex-grow: 1; margin-bottom: 20px;">
                            {{ $package->short_description ?: 'No description provided.' }}
                        </p>
                        
                        <div style="margin-top: auto;">
                            @php
                                $refLink = route('register', ['ref_id' => auth()->user()->id, 'package_id' => $package->id]);
                            @endphp
                            <div style="display: flex; gap: 10px;">
                                <input type="text" class="input" value="{{ $refLink }}" readonly style="flex-grow: 1; font-size: 0.8rem; padding: 6px 10px; background: #f8fafc;" id="link-{{ $package->id }}">
                                <button class="btn btn-primary btn-sm" onclick="copyLink('link-{{ $package->id }}')" style="padding: 6px 12px; white-space: nowrap;">
                                    Copy Link
                                </button>
                                <a href="https://wa.me/?text={{ urlencode('Register for the ' . $package->name . ' package here: ' . $refLink) }}" target="_blank" class="btn btn-sm" style="padding: 6px 12px; background: #25D366; color: white; white-space: nowrap; border: none; display: flex; align-items: center; gap: 5px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($packages->isEmpty())
                <div style="text-align: center; padding: 30px; color: #64748b;">
                    No packages available for referral at the moment.
                </div>
            @endif
        </div>
    </div>

    <div class="card" style="margin-top: 20px;">
        <div class="card-header">
            <h3>My Referred Stores</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">List of stores registered using your referral links.</p>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Store Name</th>
                        <th>Email</th>
                        <th>Package</th>
                        <th>Status</th>
                        <th>Joined Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stores as $store)
                        @php
                            $sub = $store->subscriptions->first();
                            $status = 'Demo / Grace Period';
                            $badgeClass = 'badge-warning';
                            $badgeStyle = 'background:#fef3c7; color:#92400e;';

                            if ($sub && $sub->status === 'active') {
                                if ($sub->end_date && now()->greaterThan($sub->end_date)) {
                                    $status = 'Expired';
                                    $badgeClass = 'badge-danger';
                                    $badgeStyle = 'background:#fee2e2; color:#b91c1c;';
                                } else {
                                    $status = 'Active';
                                    $badgeClass = 'badge-success';
                                    $badgeStyle = 'background:#d1fae5; color:#065f46;';
                                }
                            } elseif ($sub && $sub->status === 'inactive') {
                                $status = 'Inactive';
                                $badgeClass = 'badge-danger';
                                $badgeStyle = 'background:#fee2e2; color:#b91c1c;';
                            }
                        @endphp
                        <tr>
                            <td style="font-weight: 500;">{{ $store->name }}</td>
                            <td>{{ $store->email }}</td>
                            <td>{{ $store->package->name ?? 'None' }}</td>
                            <td>
                                <span class="badge {{ $badgeClass }}" style="{{ $badgeStyle }} padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;">
                                    {{ $status }}
                                </span>
                            </td>
                            <td>{{ $store->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-cell" style="text-align: center; padding: 20px; color: #64748b;">You haven't referred any stores yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function copyLink(inputId) {
        var copyText = document.getElementById(inputId);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(copyText.value).then(function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Link copied to clipboard!',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }, function(err) {
            console.error('Could not copy text: ', err);
            // fallback
            document.execCommand('copy');
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Link copied to clipboard!',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    }
</script>
@endsection

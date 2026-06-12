<?php
$file = 'c:\xampp\htdocs\medi-pos\resources\views\package.blade.php';
$content = file_get_contents($file);
$navEnd = strpos($content, '</nav>') + 6;
$footerStart = strpos($content, '<!-- =============================================', $navEnd);

if ($navEnd !== false && $footerStart !== false) {
    $newBlock = '

<!-- =============================================
     SINGLE PACKAGE DETAILS
============================================= -->
<section id="hero" style="padding-top: 150px; min-height: 80vh;">
  <div class="bg-orb orb-1"></div>
  <div class="container position-relative" style="z-index:2;">
    <div class="row align-items-center justify-content-center">
      <div class="col-lg-8 text-center reveal">
        <div class="hero-badge"><i class="bi bi-box-seam"></i> {{ ucfirst(str_replace("_", " ", $package->billing_type)) }} Plan</div>
        <h1 class="hero-title">{{ $package->name }}</h1>
        <p class="hero-subtitle mx-auto" style="font-size: 1.2rem;">{{ $package->short_description ?? "The best solution for your pharmacy." }}</p>

        <div class="glass-card pricing-card text-start mx-auto mt-5" style="max-width: 500px; padding: 2.5rem;">
          <div class="pricing-price justify-content-center mb-4">
            @if($package->price > 0)
                <span class="price-currency">₨</span>
                <span class="price-amount">{{ number_format($package->price) }}</span>
                <span class="price-period">/{{ $package->billing_type == "monthly" ? "month" : ($package->billing_type == "yearly" ? "year" : "lifetime") }}</span>
            @else
                <span class="price-amount" style="font-size:2.2rem;">Custom Pricing</span>
            @endif
          </div>
          
          <div class="pricing-divider"></div>
          
          <h4 class="text-white mb-3" style="font-family: var(--font-display); font-size: 1.1rem;">Package Features</h4>
          
          @if($package->is_cloud)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Cloud Sync & Backup</div>
          @endif
          @if($package->is_offline)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Offline Desktop App Included</div>
          @endif
          @if($package->lifetime_license)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Lifetime Access (No Recurring Fees)</div>
          @endif
          @if($package->hosting_included)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Hosting & Domain Included</div>
          @endif
          @if($package->support_included)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Priority Customer Support</div>
          @endif
          @if($package->free_updates)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Free System Updates</div>
          @endif
          
          @if($package->description)
              <div class="mt-4 mb-2 text-muted" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Additional Details</div>
              @foreach(explode("\n", $package->description) as $line)
                  @if(trim($line))
                  <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>{{ trim($line) }}</div>
                  @endif
              @endforeach
          @endif

          <div class="mt-5 text-center">
            <a href="{{ route("register") }}?package={{ $package->id }}" class="btn-primary-custom d-block w-100" style="text-decoration: none;">
              {{ $package->price > 0 ? "Subscribe to " . $package->name : "Contact Sales" }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

';

    $newContent = substr($content, 0, $navEnd) . $newBlock . substr($content, $footerStart);
    file_put_contents($file, $newContent);
    echo "Done";
} else {
    echo "Could not find tags.";
}
?>

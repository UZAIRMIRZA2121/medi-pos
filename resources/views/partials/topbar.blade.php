<header class="topbar">
    <div class="topbar-left">
      <button class="menu-btn" id="menuBtn">
        <span></span><span></span><span></span>
      </button>
      @if(request()->routeIs('pos.index'))
      <a href="{{ route('dashboard') }}" class="btn btn-sm btn-ghost" style="margin-right: 10px; text-decoration: none;">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
        Back to Dashboard
      </a>
      <div class="page-title" id="pageTitle">POS / Billing</div>
      @else
      <div class="page-title" id="pageTitle">Dashboard</div>
      @endif
    </div>
    <div class="topbar-right">
      <button onclick="document.getElementById('shortcutsModal').classList.remove('hidden')" title="Keyboard Shortcuts" class="btn btn-ghost" style="margin-right: 15px; display: inline-flex; align-items: center; gap: 8px; padding: 5px 10px; font-weight: 600; text-decoration: none; border: 1px solid #ef4444; color: #ef4444; border-radius: var(--radius-sm); transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='#ef4444';">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2" ry="2"/><line x1="6" y1="8" x2="6" y2="8"/><line x1="10" y1="8" x2="10" y2="8"/><line x1="14" y1="8" x2="14" y2="8"/><line x1="18" y1="8" x2="18" y2="8"/><line x1="6" y1="12" x2="6" y2="12"/><line x1="10" y1="12" x2="10" y2="12"/><line x1="14" y1="12" x2="14" y2="12"/><line x1="18" y1="12" x2="18" y2="12"/><line x1="8" y1="16" x2="16" y2="16"/></svg>
      </button>
      @if(config('app.env') === 'local' && !session()->has('staff_id'))
      <form method="POST" action="{{ route('manual.sync') }}" style="display: inline;" onsubmit="return handleSyncSubmit(event, this);">
        @csrf
        <button type="submit" class="btn btn-primary" style="margin-right: 15px; display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; font-weight: 600; text-decoration: none; background: #4f46e5; border-color: #4f46e5;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Sync
        </button>
      </form>
      <script>
        function handleSyncSubmit(e, form) {
            e.preventDefault();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Syncing Data...',
                    html: 'Please wait while we synchronize your data with the cloud.<br><br><span style="color:#64748b;font-size:0.9rem;">Do not close this window.</span>',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                        const container = document.querySelector('.swal2-container');
                        if (container) {
                            container.style.backdropFilter = 'blur(5px)';
                            container.style.webkitBackdropFilter = 'blur(5px)';
                            container.style.backgroundColor = 'rgba(0,0,0,0.5)';
                        }
                    }
                });
            }
            form.submit();
        }

        // Show toast notification for sync result
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                if (typeof toast !== 'undefined') {
                    toast("{{ session('success') }}", "success");
                }
            @endif

            @if(session('error'))
                if (typeof toast !== 'undefined') {
                    toast("{{ session('error') }}", "danger");
                }
            @endif
        });
      </script>
      @endif
      @if(Auth::check() && Auth::user()->type === 'store' && !request()->routeIs('pos.index'))
      <a href="{{ route('pos.index') }}" class="btn btn-primary" style="margin-right: 15px; display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; font-weight: 600; text-decoration: none;">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
        POS
      </a>
      @endif
      @if(request()->routeIs('pos.index'))
      <button class="icon-btn" id="fullscreenBtn" title="Toggle Fullscreen" onclick="toggleFullscreen()" style="margin-right: 8px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg>
      </button>
      @endif
      <button class="icon-btn theme-toggle" id="themeToggle" title="Toggle theme">
        <svg id="themeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
      </button>
      <div class="topbar-date" id="topbarDate"></div>
    </div>
  </header>
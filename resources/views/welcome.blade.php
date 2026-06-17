<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="MediPOS – The Complete Medical Store Point of Sale System. Manage inventory, sales, purchases, customers, suppliers, reports, and billing with one powerful POS platform." />
  <meta name="keywords" content="medical POS, pharmacy software, medical store management, POS system, inventory management, billing software" />
  <meta name="author" content="MediPOS" />
  <meta property="og:title" content="MediPOS – Medical Store POS System" />
  <meta property="og:description" content="The complete POS solution built for modern medical stores and pharmacies." />
  <meta property="og:type" content="website" />
  <title>MediPOS – Medical Store POS System</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />

  <style>
    /* =============================================
       CSS CUSTOM PROPERTIES
    ============================================= */
    :root {
      --navy:        #0a0f1e;
      --navy-mid:    #0d1530;
      --navy-card:   #111827;
      --indigo:      #4f46e5;
      --indigo-light:#6366f1;
      --blue:        #3b82f6;
      --blue-light:  #60a5fa;
      --violet:      #8b5cf6;
      --violet-light:#a78bfa;
      --cyan:        #06b6d4;
      --white:       #ffffff;
      --off-white:   #f0f4ff;
      --muted:       rgba(160,174,220,0.7);
      --glass-bg:    rgba(255,255,255,0.06);
      --glass-border:rgba(255,255,255,0.12);
      --glass-hover: rgba(255,255,255,0.10);
      --glow-blue:   rgba(59,130,246,0.35);
      --glow-violet: rgba(139,92,246,0.35);
      --gradient-primary: linear-gradient(135deg, var(--indigo), var(--blue), var(--violet));
      --gradient-hero:    linear-gradient(135deg, #4f46e5 0%, #3b82f6 50%, #8b5cf6 100%);
      --font-display: 'Outfit', sans-serif;
      --font-body:    'Inter', sans-serif;
      --radius-sm:   8px;
      --radius-md:   16px;
      --radius-lg:   24px;
      --radius-xl:   32px;
      --shadow-glass: 0 8px 32px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.1);
      --shadow-card:  0 20px 60px rgba(0,0,0,0.5);
      --shadow-glow:  0 0 40px rgba(79,70,229,0.4);
      --transition:   all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* =============================================
       RESET & BASE
    ============================================= */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
      font-family: var(--font-body);
      background-color: var(--navy);
      color: var(--white);
      overflow-x: hidden;
      line-height: 1.6;
    }

    ::selection { background: var(--indigo); color: white; }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--navy); }
    ::-webkit-scrollbar-thumb { background: var(--indigo); border-radius: 3px; }

    h1, h2, h3, h4, h5, h6 { font-family: var(--font-display); font-weight: 700; }

    section { position: relative; overflow: hidden; }

    /* =============================================
       PARTICLE CANVAS
    ============================================= */
    #particles-canvas {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      pointer-events: none;
      z-index: 0;
      opacity: 0.5;
    }

    /* =============================================
       FLOATING BACKGROUND SHAPES
    ============================================= */
    .bg-orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      pointer-events: none;
      z-index: 0;
      animation: floatOrb 8s ease-in-out infinite;
    }
    .orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(79,70,229,0.25), transparent 70%); top: -100px; right: -100px; animation-delay: 0s; }
    .orb-2 { width: 400px; height: 400px; background: radial-gradient(circle, rgba(139,92,246,0.2), transparent 70%); bottom: 10%; left: -80px; animation-delay: 3s; }
    .orb-3 { width: 300px; height: 300px; background: radial-gradient(circle, rgba(59,130,246,0.2), transparent 70%); top: 40%; right: 10%; animation-delay: 1.5s; }

    @keyframes floatOrb {
      0%, 100% { transform: translateY(0) scale(1); }
      50%       { transform: translateY(-30px) scale(1.05); }
    }

    /* =============================================
       UTILITY CLASSES
    ============================================= */
    .gradient-text {
      background: var(--gradient-hero);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .glass-card {
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-glass);
      transition: var(--transition);
    }

    .glass-card:hover {
      background: var(--glass-hover);
      border-color: rgba(255,255,255,0.2);
      transform: translateY(-6px);
      box-shadow: var(--shadow-card), 0 0 30px rgba(79,70,229,0.2);
    }

    .btn-primary-custom {
      background: var(--gradient-hero);
      border: none;
      border-radius: 50px;
      padding: 14px 32px;
      font-family: var(--font-display);
      font-weight: 600;
      font-size: 1rem;
      color: white;
      cursor: pointer;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(79,70,229,0.4);
    }

    .btn-primary-custom::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
      opacity: 0;
      transition: opacity 0.3s;
    }

    .btn-primary-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(79,70,229,0.6);
      color: white;
    }
    .btn-primary-custom:hover::before { opacity: 1; }

    .btn-outline-custom {
      background: transparent;
      border: 1.5px solid var(--glass-border);
      border-radius: 50px;
      padding: 13px 32px;
      font-family: var(--font-display);
      font-weight: 600;
      font-size: 1rem;
      color: var(--white);
      cursor: pointer;
      transition: var(--transition);
      backdrop-filter: blur(10px);
    }

    .btn-outline-custom:hover {
      border-color: var(--indigo);
      background: rgba(79,70,229,0.15);
      transform: translateY(-2px);
      color: white;
    }

    .section-label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 0.8rem;
      font-weight: 600;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--blue-light);
      background: rgba(59,130,246,0.1);
      border: 1px solid rgba(59,130,246,0.25);
      border-radius: 50px;
      padding: 6px 16px;
      margin-bottom: 1.25rem;
    }

    .section-label .dot {
      width: 6px; height: 6px;
      background: var(--blue-light);
      border-radius: 50%;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; transform: scale(1); }
      50%       { opacity: 0.5; transform: scale(1.5); }
    }

    .section-title {
      font-size: clamp(2rem, 4vw, 3rem);
      font-weight: 800;
      line-height: 1.15;
      margin-bottom: 1rem;
    }

    .section-subtitle {
      font-size: 1.1rem;
      color: var(--muted);
      max-width: 580px;
      line-height: 1.7;
    }

    /* Scroll Reveal */
    .reveal {
      opacity: 0;
      transform: translateY(40px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }
    .reveal-left {
      opacity: 0;
      transform: translateX(-40px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal-left.visible { opacity: 1; transform: translateX(0); }
    .reveal-right {
      opacity: 0;
      transform: translateX(40px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal-right.visible { opacity: 1; transform: translateX(0); }

    /* =============================================
       NAVBAR
    ============================================= */
    #mainNav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 1000;
      padding: 16px 0;
      transition: var(--transition);
    }

    #mainNav.scrolled {
      background: rgba(10,15,30,0.85);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border-bottom: 1px solid var(--glass-border);
      padding: 10px 0;
      box-shadow: 0 4px 30px rgba(0,0,0,0.4);
    }

    .navbar-brand {
      font-family: var(--font-display);
      font-size: 1.5rem;
      font-weight: 800;
      color: white !important;
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .brand-icon {
      width: 38px; height: 38px;
      background: var(--gradient-hero);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      box-shadow: 0 4px 15px rgba(79,70,229,0.5);
    }

    .brand-name span { color: var(--blue-light); }

    .nav-link-custom {
      font-family: var(--font-display);
      font-weight: 500;
      font-size: 0.95rem;
      color: rgba(255,255,255,0.75) !important;
      text-decoration: none;
      padding: 6px 14px !important;
      border-radius: 8px;
      transition: var(--transition);
      position: relative;
    }

    .nav-link-custom::after {
      content: '';
      position: absolute;
      bottom: 0; left: 50%; right: 50%;
      height: 2px;
      background: var(--gradient-hero);
      border-radius: 2px;
      transition: var(--transition);
    }

    .nav-link-custom:hover {
      color: white !important;
      background: rgba(255,255,255,0.07);
    }

    .nav-link-custom:hover::after { left: 14px; right: 14px; }

    .nav-login-btn {
      font-family: var(--font-display);
      font-weight: 600;
      font-size: 0.9rem;
      color: white;
      background: rgba(79,70,229,0.25);
      border: 1px solid rgba(79,70,229,0.5);
      border-radius: 50px;
      padding: 8px 22px;
      text-decoration: none;
      transition: var(--transition);
    }

    .nav-login-btn:hover {
      background: var(--indigo);
      border-color: var(--indigo);
      color: white;
      box-shadow: 0 4px 20px rgba(79,70,229,0.4);
      transform: translateY(-1px);
    }

    .navbar-toggler {
      border: 1px solid var(--glass-border);
      border-radius: var(--radius-sm);
      padding: 6px 10px;
      background: var(--glass-bg);
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    /* =============================================
       HERO SECTION
    ============================================= */
    #hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 120px 0 80px;
      background: var(--navy);
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 0.82rem;
      font-weight: 600;
      color: var(--blue-light);
      background: rgba(59,130,246,0.1);
      border: 1px solid rgba(59,130,246,0.2);
      border-radius: 50px;
      padding: 6px 16px;
      margin-bottom: 1.5rem;
    }

    .hero-badge i { font-size: 0.85rem; }

    .hero-title {
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 900;
      line-height: 1.1;
      margin-bottom: 1.5rem;
      letter-spacing: -0.02em;
    }

    .hero-subtitle {
      font-size: 1.15rem;
      color: var(--muted);
      line-height: 1.75;
      margin-bottom: 2.5rem;
      max-width: 500px;
    }

    .hero-btns { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 3rem; }

    .hero-stats {
      display: flex;
      gap: 32px;
      flex-wrap: wrap;
    }

    .hero-stat {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .hero-stat-icon {
      width: 36px; height: 36px;
      background: rgba(79,70,229,0.2);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      color: var(--blue-light);
    }

    .hero-stat-text strong {
      display: block;
      font-family: var(--font-display);
      font-weight: 700;
      font-size: 1rem;
      color: white;
    }

    .hero-stat-text small { font-size: 0.78rem; color: var(--muted); }

    /* ---- DASHBOARD MOCKUP ---- */
    .dashboard-wrapper {
      perspective: 1200px;
      perspective-origin: center;
    }

    .dashboard-scene {
      transform-style: preserve-3d;
      transition: transform 0.12s ease-out;
      will-change: transform;
    }

    .dashboard-mockup {
      background: rgba(13,21,48,0.9);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: var(--radius-xl);
      padding: 0;
      overflow: hidden;
      box-shadow: 0 30px 80px rgba(0,0,0,0.7), 0 0 0 1px rgba(255,255,255,0.05), inset 0 1px 0 rgba(255,255,255,0.1);
      position: relative;
      animation: floatDashboard 6s ease-in-out infinite;
    }

    @keyframes floatDashboard {
      0%, 100% { transform: translateY(0px); }
      50%       { transform: translateY(-16px); }
    }

    .db-topbar {
      background: rgba(255,255,255,0.04);
      border-bottom: 1px solid var(--glass-border);
      padding: 12px 18px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .db-dots { display: flex; gap: 6px; }
    .db-dot { width: 10px; height: 10px; border-radius: 50%; }
    .db-dot.red { background: #ff5f57; }
    .db-dot.yellow { background: #ffbd2e; }
    .db-dot.green { background: #28c840; }

    .db-title {
      font-family: var(--font-display);
      font-size: 0.78rem;
      font-weight: 600;
      color: rgba(255,255,255,0.6);
      flex: 1;
      text-align: center;
    }

    .db-body {
      padding: 18px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .db-card {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: var(--radius-md);
      padding: 14px;
    }

    .db-card.full { grid-column: 1 / -1; }

    .db-card-label {
      font-size: 0.68rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--muted);
      margin-bottom: 6px;
    }

    .db-card-value {
      font-family: var(--font-display);
      font-size: 1.4rem;
      font-weight: 800;
      color: white;
    }

    .db-card-sub {
      font-size: 0.7rem;
      color: #4ade80;
      margin-top: 2px;
    }

    .db-mini-chart {
      height: 36px;
      display: flex;
      align-items: flex-end;
      gap: 4px;
      margin-top: 10px;
    }

    .db-bar {
      flex: 1;
      border-radius: 3px 3px 0 0;
      background: var(--gradient-hero);
      opacity: 0.7;
      animation: barGrow 1.5s ease-out forwards;
      transform-origin: bottom;
    }

    @keyframes barGrow {
      from { transform: scaleY(0); }
      to   { transform: scaleY(1); }
    }

    .db-table-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 6px 0;
      border-bottom: 1px solid rgba(255,255,255,0.05);
      font-size: 0.72rem;
    }

    .db-table-row:last-child { border-bottom: none; }

    .db-pill {
      padding: 2px 8px;
      border-radius: 50px;
      font-size: 0.65rem;
      font-weight: 600;
    }

    .db-pill.green { background: rgba(74,222,128,0.15); color: #4ade80; }
    .db-pill.blue  { background: rgba(96,165,250,0.15); color: #60a5fa; }
    .db-pill.amber { background: rgba(251,191,36,0.15); color: #fbbf24; }

    .db-progress {
      height: 5px;
      background: rgba(255,255,255,0.1);
      border-radius: 3px;
      margin-top: 8px;
      overflow: hidden;
    }

    .db-progress-fill {
      height: 100%;
      border-radius: 3px;
      background: var(--gradient-hero);
      animation: fillBar 2s ease-out forwards;
    }

    @keyframes fillBar {
      from { width: 0; }
    }

    .db-donut {
      width: 60px; height: 60px;
      border-radius: 50%;
      background: conic-gradient(var(--indigo) 65%, var(--violet) 65% 80%, var(--blue) 80%);
      margin: 8px auto 0;
      position: relative;
    }

    .db-donut::after {
      content: '78%';
      position: absolute;
      inset: 10px;
      background: rgba(13,21,48,0.95);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.6rem;
      font-weight: 700;
      color: white;
    }

    .db-floating-card {
      position: absolute;
      background: rgba(13,21,48,0.9);
      border: 1px solid rgba(79,70,229,0.4);
      border-radius: var(--radius-md);
      padding: 10px 14px;
      display: flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.5);
      backdrop-filter: blur(10px);
      font-size: 0.75rem;
    }

    .db-floating-card.fc-1 {
      top: -20px; right: -30px;
      animation: floatCard1 5s ease-in-out infinite;
    }

    .db-floating-card.fc-2 {
      bottom: 40px; left: -35px;
      animation: floatCard2 6s ease-in-out infinite 1s;
    }

    @keyframes floatCard1 {
      0%, 100% { transform: translateY(0) rotate(-2deg); }
      50%       { transform: translateY(-12px) rotate(0deg); }
    }

    @keyframes floatCard2 {
      0%, 100% { transform: translateY(0) rotate(2deg); }
      50%       { transform: translateY(-10px) rotate(0deg); }
    }

    .fc-icon {
      width: 32px; height: 32px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
    }

    /* =============================================
       FEATURES SECTION
    ============================================= */
    #features {
      padding: 100px 0;
      background: linear-gradient(180deg, var(--navy) 0%, var(--navy-mid) 100%);
    }

    .feature-card {
      padding: 2rem;
      height: 100%;
      cursor: default;
    }

    .feature-icon-wrap {
      width: 56px; height: 56px;
      border-radius: var(--radius-md);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      margin-bottom: 1.25rem;
      position: relative;
      transition: var(--transition);
    }

    .feature-card:hover .feature-icon-wrap {
      transform: scale(1.1) rotateY(15deg);
    }

    .feature-card-title {
      font-family: var(--font-display);
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 0.6rem;
      color: white;
    }

    .feature-card-desc {
      font-size: 0.9rem;
      color: var(--muted);
      line-height: 1.65;
    }

    /* feature icon colors */
    .fi-1 { background: rgba(79,70,229,0.2); color: var(--indigo-light); box-shadow: 0 0 20px rgba(79,70,229,0.3); }
    .fi-2 { background: rgba(59,130,246,0.2); color: var(--blue-light); box-shadow: 0 0 20px rgba(59,130,246,0.3); }
    .fi-3 { background: rgba(139,92,246,0.2); color: var(--violet-light); box-shadow: 0 0 20px rgba(139,92,246,0.3); }
    .fi-4 { background: rgba(6,182,212,0.2); color: var(--cyan); box-shadow: 0 0 20px rgba(6,182,212,0.3); }
    .fi-5 { background: rgba(251,191,36,0.2); color: #fbbf24; box-shadow: 0 0 20px rgba(251,191,36,0.3); }
    .fi-6 { background: rgba(74,222,128,0.2); color: #4ade80; box-shadow: 0 0 20px rgba(74,222,128,0.3); }
    .fi-7 { background: rgba(248,113,113,0.2); color: #f87171; box-shadow: 0 0 20px rgba(248,113,113,0.3); }
    .fi-8 { background: rgba(167,139,250,0.2); color: var(--violet-light); box-shadow: 0 0 20px rgba(167,139,250,0.3); }

    /* =============================================
       PACKAGES / PRICING
    ============================================= */
    #packages {
      padding: 100px 0;
      background: var(--navy);
    }

    .pricing-card {
      border-radius: var(--radius-xl);
      padding: 2.5rem 2rem;
      height: 100%;
      position: relative;
      overflow: hidden;
      cursor: default;
      transition: var(--transition);
    }

    .pricing-card::before {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: inherit;
      background: var(--gradient-hero);
      opacity: 0;
      transition: opacity 0.35s;
      z-index: 0;
    }

    .pricing-card.popular {
      border-color: rgba(79,70,229,0.5) !important;
    }

    .pricing-card.popular::before { opacity: 0.06; }

    .pricing-card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 30px 80px rgba(0,0,0,0.6), 0 0 50px rgba(79,70,229,0.3);
    }

    .pricing-card > * { position: relative; z-index: 1; }

    .popular-badge {
      position: absolute;
      top: 18px; right: 18px;
      background: var(--gradient-hero);
      font-family: var(--font-display);
      font-size: 0.72rem;
      font-weight: 700;
      color: white;
      padding: 4px 14px;
      border-radius: 50px;
      z-index: 2;
    }

    .pricing-tier {
      font-family: var(--font-display);
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--blue-light);
      margin-bottom: 0.5rem;
    }

    .pricing-name {
      font-family: var(--font-display);
      font-size: 1.5rem;
      font-weight: 800;
      color: white;
      margin-bottom: 0.5rem;
    }

    .pricing-price {
      display: flex;
      align-items: flex-end;
      gap: 4px;
      margin-bottom: 1.5rem;
    }

    .price-currency { font-size: 1.2rem; font-weight: 600; color: var(--muted); margin-bottom: 6px; }
    .price-amount   { font-family: var(--font-display); font-size: 3.5rem; font-weight: 900; color: white; line-height: 1; }
    .price-period   { font-size: 0.85rem; color: var(--muted); margin-bottom: 10px; }

    .pricing-desc {
      font-size: 0.88rem;
      color: var(--muted);
      margin-bottom: 1.5rem;
      line-height: 1.6;
    }

    .pricing-divider {
      height: 1px;
      background: var(--glass-border);
      margin-bottom: 1.5rem;
    }

    .pricing-feature {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 0.88rem;
      color: rgba(255,255,255,0.8);
      margin-bottom: 0.7rem;
    }

    .pricing-feature i {
      font-size: 0.9rem;
      color: #4ade80;
      flex-shrink: 0;
    }

    .pricing-cta {
      display: block;
      width: 100%;
      text-align: center;
      margin-top: 2rem;
      padding: 13px;
      border-radius: 50px;
      font-family: var(--font-display);
      font-weight: 600;
      font-size: 0.95rem;
      text-decoration: none;
      transition: var(--transition);
    }

    .cta-outline {
      background: transparent;
      border: 1.5px solid var(--glass-border);
      color: white;
    }

    .cta-outline:hover {
      background: rgba(255,255,255,0.08);
      border-color: rgba(255,255,255,0.3);
      color: white;
    }

    .cta-solid {
      background: var(--gradient-hero);
      border: none;
      color: white;
      box-shadow: 0 4px 20px rgba(79,70,229,0.4);
    }

    .cta-solid:hover {
      box-shadow: 0 8px 30px rgba(79,70,229,0.6);
      transform: translateY(-2px);
      color: white;
    }

    /* =============================================
       WHY CHOOSE SECTION
    ============================================= */
    #why {
      padding: 100px 0;
      background: linear-gradient(180deg, var(--navy-mid) 0%, var(--navy) 100%);
    }

    .stat-card {
      text-align: center;
      padding: 2.5rem 2rem;
    }

    .stat-icon {
      width: 64px; height: 64px;
      border-radius: var(--radius-md);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      margin: 0 auto 1.25rem;
    }

    .stat-number {
      font-family: var(--font-display);
      font-size: 2.8rem;
      font-weight: 900;
      line-height: 1;
      margin-bottom: 0.4rem;
    }

    .stat-label {
      font-size: 0.95rem;
      color: var(--muted);
      font-weight: 500;
    }

    /* =============================================
       TESTIMONIALS
    ============================================= */
    #testimonials {
      padding: 100px 0;
      background: var(--navy);
    }

    .testimonial-card {
      padding: 2rem;
      height: 100%;
    }

    .stars { color: #fbbf24; font-size: 0.9rem; margin-bottom: 1rem; letter-spacing: 2px; }

    .testimonial-text {
      font-size: 0.95rem;
      color: rgba(255,255,255,0.8);
      line-height: 1.75;
      margin-bottom: 1.5rem;
      font-style: italic;
    }

    .testimonial-author { display: flex; align-items: center; gap: 12px; }

    .author-avatar {
      width: 44px; height: 44px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: var(--font-display);
      font-weight: 700;
      font-size: 1rem;
      color: white;
      flex-shrink: 0;
    }

    .author-name {
      font-family: var(--font-display);
      font-weight: 700;
      font-size: 0.95rem;
      color: white;
    }

    .author-pos {
      font-size: 0.8rem;
      color: var(--muted);
    }

    /* =============================================
       CTA SECTION
    ============================================= */
    #cta {
      padding: 120px 0;
      background: var(--navy-mid);
      text-align: center;
    }

    .cta-inner {
      background: linear-gradient(135deg, rgba(79,70,229,0.15) 0%, rgba(139,92,246,0.10) 100%);
      border: 1px solid rgba(79,70,229,0.3);
      border-radius: var(--radius-xl);
      padding: 80px 40px;
      position: relative;
      overflow: hidden;
    }

    .cta-inner::before {
      content: '';
      position: absolute;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(79,70,229,0.25), transparent 70%);
      top: -100px; left: -100px;
      border-radius: 50%;
    }

    .cta-inner::after {
      content: '';
      position: absolute;
      width: 300px; height: 300px;
      background: radial-gradient(circle, rgba(139,92,246,0.2), transparent 70%);
      bottom: -80px; right: -80px;
      border-radius: 50%;
    }

    .cta-inner > * { position: relative; z-index: 1; }

    .cta-title {
      font-size: clamp(2rem, 4vw, 3.2rem);
      font-weight: 900;
      line-height: 1.15;
      margin-bottom: 1rem;
    }

    .cta-sub {
      font-size: 1.1rem;
      color: var(--muted);
      margin-bottom: 2.5rem;
      max-width: 500px;
      margin-left: auto;
      margin-right: auto;
    }

    /* =============================================
       FOOTER
    ============================================= */
    footer {
      background: rgba(0,0,0,0.5);
      border-top: 1px solid var(--glass-border);
      padding: 70px 0 30px;
    }

    .footer-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      margin-bottom: 1rem;
    }

    .footer-desc {
      font-size: 0.88rem;
      color: var(--muted);
      line-height: 1.7;
      max-width: 280px;
      margin-bottom: 1.5rem;
    }

    .social-links { display: flex; gap: 10px; }

    .social-btn {
      width: 36px; height: 36px;
      border-radius: 8px;
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--muted);
      text-decoration: none;
      font-size: 0.95rem;
      transition: var(--transition);
    }

    .social-btn:hover {
      background: var(--indigo);
      border-color: var(--indigo);
      color: white;
      transform: translateY(-3px);
    }

    .footer-heading {
      font-family: var(--font-display);
      font-size: 0.82rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.5);
      margin-bottom: 1.2rem;
    }

    .footer-link {
      display: block;
      font-size: 0.88rem;
      color: var(--muted);
      text-decoration: none;
      margin-bottom: 0.6rem;
      transition: var(--transition);
    }

    .footer-link:hover { color: white; padding-left: 4px; }

    .footer-bottom {
      margin-top: 50px;
      padding-top: 24px;
      border-top: 1px solid var(--glass-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
    }

    .footer-copy {
      font-size: 0.82rem;
      color: rgba(255,255,255,0.35);
    }

    .footer-copy span { color: var(--blue-light); }

    /* =============================================
       RESPONSIVE
    ============================================= */
    @media (max-width: 991.98px) {
      .hero-subtitle { max-width: 100%; }
      .dashboard-wrapper { margin-top: 3rem; }
      .db-floating-card.fc-1 { top: -10px; right: -10px; }
      .db-floating-card.fc-2 { display: none; }
    }

    @media (max-width: 767.98px) {
      #hero { padding: 100px 0 60px; }
      .hero-btns { flex-direction: column; align-items: flex-start; }
      .hero-stats { gap: 20px; }
      .db-body { grid-template-columns: 1fr; }
      .db-card.full { grid-column: 1; }
      .pricing-card { margin-bottom: 20px; }
      .cta-inner { padding: 50px 24px; }
      .footer-bottom { text-align: center; justify-content: center; }
    }

    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
      }
    }
  </style>
</head>
<body>

<!-- Particle Canvas -->
<canvas id="particles-canvas"></canvas>

<!-- =============================================
     NAVIGATION
============================================= -->
<nav id="mainNav" class="navbar navbar-expand-lg" aria-label="Main navigation">
  <div class="container">
    <a class="navbar-brand" href="#hero">
      <div class="brand-icon"><i class="bi bi-heart-pulse-fill text-white"></i></div>
      <span class="brand-name">Medi<span>POS</span></span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav mx-auto gap-1">
        <li class="nav-item"><a class="nav-link-custom" href="#hero">Home</a></li>
        <li class="nav-item"><a class="nav-link-custom" href="#features">Features</a></li>
        <li class="nav-item"><a class="nav-link-custom" href="#packages">Pricing</a></li>
        <li class="nav-item"><a class="nav-link-custom" href="#packages">Packages</a></li>
        <li class="nav-item"><a class="nav-link-custom" href="#why">Why Us</a></li>
        <li class="nav-item"><a class="nav-link-custom" href="#footer">Contact</a></li>
      </ul>
      <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/home') }}" class="nav-login-btn">
                  <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-login-btn">
                  <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="nav-login-btn" style="background: var(--gradient-hero); border: none;">
                      <i class="bi bi-person-plus me-2"></i>Register
                    </a>
                @endif
            @endauth
        @endif
      </div>
    </div>
  </div>
</nav>

<!-- =============================================
     HERO SECTION
============================================= -->
<section id="hero">
  <div class="bg-orb orb-1"></div>
  <div class="bg-orb orb-2"></div>
  <div class="bg-orb orb-3"></div>

  <div class="container position-relative" style="z-index:2;">
    <div class="row align-items-center g-5">

      <!-- Left: Copy -->
      <div class="col-lg-6 reveal-left">
        <div class="hero-badge">
          <i class="bi bi-stars"></i>
          Pakistan's #1 Medical POS Platform
        </div>
        <h1 class="hero-title">
          The Complete <span class="gradient-text">Medical Store</span> POS Solution
        </h1>
        <p class="hero-subtitle">
          Manage inventory, sales, purchases, customers, suppliers, reports, and billing with one powerful POS system built for modern pharmacies.
        </p>
        <div class="hero-btns">
          <a href="#packages" class="btn-primary-custom">
            <i class="bi bi-rocket-takeoff me-2"></i>Get Started Free
          </a>
          <a href="#packages" class="btn-outline-custom">
            <i class="bi bi-tag me-2"></i>View Pricing
          </a>
        </div>
        <div class="hero-stats">
          <div class="hero-stat">
            <div class="hero-stat-icon"><i class="bi bi-shop"></i></div>
            <div class="hero-stat-text">
              <strong>500+</strong>
              <small>Medical Stores</small>
            </div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-icon"><i class="bi bi-lightning-charge"></i></div>
            <div class="hero-stat-text">
              <strong>50K+</strong>
              <small>Daily Transactions</small>
            </div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-icon"><i class="bi bi-shield-check"></i></div>
            <div class="hero-stat-text">
              <strong>99.9%</strong>
              <small>Uptime SLA</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Right: Dashboard Mockup -->
      <div class="col-lg-6 reveal-right">
        <div class="dashboard-wrapper position-relative">

          <!-- Floating notification cards -->
          <div class="db-floating-card fc-1">
            <div class="fc-icon" style="background:rgba(74,222,128,0.15);">
              <i class="bi bi-arrow-up-right" style="color:#4ade80;"></i>
            </div>
            <div>
              <div style="font-weight:700;color:white;font-size:0.78rem;">Revenue Up 24%</div>
              <div style="color:var(--muted);font-size:0.7rem;">vs last month</div>
            </div>
          </div>

          <div class="db-floating-card fc-2">
            <div class="fc-icon" style="background:rgba(79,70,229,0.2);">
              <i class="bi bi-box-seam" style="color:var(--indigo-light);"></i>
            </div>
            <div>
              <div style="font-weight:700;color:white;font-size:0.78rem;">12 Items Low Stock</div>
              <div style="color:#fbbf24;font-size:0.7rem;">Action required</div>
            </div>
          </div>

          <div class="dashboard-scene" id="dashScene">
            <div class="dashboard-mockup">

              <!-- Topbar -->
              <div class="db-topbar">
                <div class="db-dots">
                  <div class="db-dot red"></div>
                  <div class="db-dot yellow"></div>
                  <div class="db-dot green"></div>
                </div>
                <div class="db-title">MediPOS Dashboard — Al-Shifa Pharmacy</div>
              </div>

              <!-- Dashboard Grid -->
              <div class="db-body">

                <!-- Revenue card -->
                <div class="db-card">
                  <div class="db-card-label">Today's Revenue</div>
                  <div class="db-card-value">₨ 84,320</div>
                  <div class="db-card-sub"><i class="bi bi-arrow-up-short"></i> +18.4% from yesterday</div>
                  <div class="db-mini-chart">
                    <div class="db-bar" style="height:45%;animation-delay:0.1s;"></div>
                    <div class="db-bar" style="height:60%;animation-delay:0.15s;"></div>
                    <div class="db-bar" style="height:40%;animation-delay:0.2s;"></div>
                    <div class="db-bar" style="height:80%;animation-delay:0.25s;"></div>
                    <div class="db-bar" style="height:55%;animation-delay:0.3s;"></div>
                    <div class="db-bar" style="height:90%;animation-delay:0.35s;"></div>
                    <div class="db-bar" style="height:70%;animation-delay:0.4s;"></div>
                  </div>
                </div>

                <!-- Inventory card -->
                <div class="db-card">
                  <div class="db-card-label">Stock Health</div>
                  <div class="db-donut"></div>
                  <div style="font-size:0.68rem;color:var(--muted);text-align:center;margin-top:6px;">1,284 SKUs tracked</div>
                </div>

                <!-- Recent Sales -->
                <div class="db-card full">
                  <div class="db-card-label" style="margin-bottom:10px;">Recent Transactions</div>
                  <div class="db-table-row">
                    <span style="color:rgba(255,255,255,0.85);">Panadol 500mg × 3</span>
                    <span style="color:white;font-weight:600;">₨ 135</span>
                    <span class="db-pill green">Paid</span>
                  </div>
                  <div class="db-table-row">
                    <span style="color:rgba(255,255,255,0.85);">Augmentin 625mg × 1</span>
                    <span style="color:white;font-weight:600;">₨ 480</span>
                    <span class="db-pill green">Paid</span>
                  </div>
                  <div class="db-table-row">
                    <span style="color:rgba(255,255,255,0.85);">Insulin Glargine × 2</span>
                    <span style="color:white;font-weight:600;">₨ 2,400</span>
                    <span class="db-pill blue">Credit</span>
                  </div>
                  <div class="db-table-row">
                    <span style="color:rgba(255,255,255,0.85);">Ventolin Inhaler × 1</span>
                    <span style="color:white;font-weight:600;">₨ 340</span>
                    <span class="db-pill amber">Pending</span>
                  </div>
                </div>

                <!-- Purchase order card -->
                <div class="db-card">
                  <div class="db-card-label">Monthly Target</div>
                  <div class="db-card-value" style="font-size:1.1rem;">₨ 2.4M / 3M</div>
                  <div class="db-progress" style="margin-top:10px;">
                    <div class="db-progress-fill" style="width:80%;"></div>
                  </div>
                  <div style="font-size:0.68rem;color:#4ade80;margin-top:6px;">80% achieved</div>
                </div>

                <!-- Alerts card -->
                <div class="db-card">
                  <div class="db-card-label">Expiry Alerts</div>
                  <div class="db-card-value" style="font-size:1.4rem;color:#fbbf24;">7</div>
                  <div style="font-size:0.7rem;color:var(--muted);margin-top:4px;">Items expiring in 30 days</div>
                  <div class="db-progress" style="margin-top:10px;">
                    <div class="db-progress-fill" style="width:35%;background:linear-gradient(90deg,#fbbf24,#f87171);"></div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- =============================================
     FEATURES SECTION
============================================= -->
<section id="features">
  <div class="bg-orb orb-1" style="opacity:0.5;"></div>
  <div class="container position-relative" style="z-index:2;">
    <div class="text-center mb-5 reveal">
      <div class="section-label"><span class="dot"></span>Powerful Features</div>
      <h2 class="section-title">Everything Your Medical Store <span class="gradient-text">Needs</span></h2>
      <p class="section-subtitle mx-auto">A complete suite of tools designed specifically for pharmacies and medical retailers.</p>
    </div>

    <div class="row g-4">
      <!-- Feature 1 -->
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.05s;">
        <div class="glass-card feature-card">
          <div class="feature-icon-wrap fi-1"><i class="bi bi-boxes"></i></div>
          <div class="feature-card-title">Inventory Management</div>
          <p class="feature-card-desc">Real-time stock tracking, auto-reorder alerts, batch & expiry management for thousands of SKUs.</p>
        </div>
      </div>
      <!-- Feature 2 -->
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.1s;">
        <div class="glass-card feature-card">
          <div class="feature-icon-wrap fi-2"><i class="bi bi-receipt-cutoff"></i></div>
          <div class="feature-card-title">Sales Management</div>
          <p class="feature-card-desc">Fast checkout, discount handling, refunds, and end-of-day cash reconciliation in seconds.</p>
        </div>
      </div>
      <!-- Feature 3 -->
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.15s;">
        <div class="glass-card feature-card">
          <div class="feature-icon-wrap fi-3"><i class="bi bi-cart-check"></i></div>
          <div class="feature-card-title">Purchase Management</div>
          <p class="feature-card-desc">Create purchase orders, receive stock, and track supplier invoices with full audit trails.</p>
        </div>
      </div>
      <!-- Feature 4 -->
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.2s;">
        <div class="glass-card feature-card">
          <div class="feature-icon-wrap fi-4"><i class="bi bi-people"></i></div>
          <div class="feature-card-title">Customer Management</div>
          <p class="feature-card-desc">Build customer profiles, track credit balances, purchase history, and loyalty records.</p>
        </div>
      </div>
      <!-- Feature 5 -->
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.05s;">
        <div class="glass-card feature-card">
          <div class="feature-icon-wrap fi-5"><i class="bi bi-truck"></i></div>
          <div class="feature-card-title">Supplier Management</div>
          <p class="feature-card-desc">Manage supplier contacts, payment terms, and purchase histories in one central hub.</p>
        </div>
      </div>
      <!-- Feature 6 -->
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.1s;">
        <div class="glass-card feature-card">
          <div class="feature-icon-wrap fi-6"><i class="bi bi-upc-scan"></i></div>
          <div class="feature-card-title">Barcode Support</div>
          <p class="feature-card-desc">Scan any barcode for instant lookup. Print custom labels for unlabelled medicines.</p>
        </div>
      </div>
      <!-- Feature 7 -->
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.15s;">
        <div class="glass-card feature-card">
          <div class="feature-icon-wrap fi-7"><i class="bi bi-graph-up-arrow"></i></div>
          <div class="feature-card-title">Reports & Analytics</div>
          <p class="feature-card-desc">Profit & loss, sales trends, stock valuation, and custom date-range reports exported to PDF/Excel.</p>
        </div>
      </div>
      <!-- Feature 8 -->
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.2s;">
        <div class="glass-card feature-card">
          <div class="feature-icon-wrap fi-8"><i class="bi bi-person-badge"></i></div>
          <div class="feature-card-title">Multi-User Access</div>
          <p class="feature-card-desc">Role-based permissions — give cashiers, managers, and owners different levels of system access.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     PACKAGES / PRICING SECTION
============================================= -->
<section id="packages">
  <div class="container position-relative" style="z-index:2;">
    <div class="text-center mb-5 reveal">
      <div class="section-label"><span class="dot"></span>Simple Pricing</div>
      <h2 class="section-title">Choose the Perfect <span class="gradient-text">Package</span></h2>
      <p class="section-subtitle mx-auto">Transparent pricing with no hidden fees. Scale as your medical store grows.</p>
    </div>

    <!--
      NOTE FOR LARAVEL BLADE:
      Replace the cards below with a @@foreach($packages as $pkg) loop.
      Each card uses the same Bootstrap .glass-card .pricing-card structure.
      Add class="popular" to the recommended tier card.
    -->
    <div class="row g-4 justify-content-center">

      @foreach($packages as $index => $package)
      <div class="col-lg-4 col-md-6 reveal" style="transition-delay:{{ 0.05 * (($index % 3) + 1) }}s;">
        <div class="glass-card pricing-card {{ $index === 1 ? 'popular' : '' }}">
          @if($index === 1)
          <div class="popular-badge"><i class="bi bi-star-fill me-1"></i>Most Popular</div>
          @endif
          <div class="pricing-tier">{{ ucfirst(str_replace('_', ' ', $package->billing_type)) }}</div>
          <div class="pricing-name">{{ $package->name }}</div>
          <div class="pricing-price">
            @if($package->price > 0)
                <span class="price-currency">₨</span>
                <span class="price-amount">{{ number_format($package->price) }}</span>
                <span class="price-period">/{{ $package->billing_type == 'monthly' ? 'month' : ($package->billing_type == 'yearly' ? 'year' : 'lifetime') }}</span>
            @else
                <span class="price-amount" style="font-size:2.2rem;">Custom</span>
            @endif
          </div>
          <p class="pricing-desc">{{ $package->short_description ?? 'The best solution for your pharmacy.' }}</p>
          <div class="pricing-divider"></div>
          
          @if($package->is_cloud)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Cloud Sync</div>
          @endif
          @if($package->is_offline)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Offline Ready</div>
          @endif
          @if($package->lifetime_license)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Lifetime License</div>
          @endif
          @if($package->hosting_included)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Hosting Included</div>
          @endif
          @if($package->support_included)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Support Included</div>
          @endif
          @if($package->free_updates)
          <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>Free Updates</div>
          @endif
          
          @if($package->description)
              @foreach(explode("\n", $package->description) as $line)
                  @if(trim($line))
                  <div class="pricing-feature"><i class="bi bi-check-circle-fill"></i>{{ trim($line) }}</div>
                  @endif
              @endforeach
          @endif

          <a href="https://wa.me/923086452242?text={{ urlencode('im intrested ' . $package->name . '.can you guide me for this please.') }}" target="_blank" class="pricing-cta {{ $index === 1 ? 'cta-solid' : 'cta-outline' }}">
            {{ $package->price > 0 ? 'Get Started' : 'Contact Sales' }}
          </a>
        </div>
      </div>
      @endforeach

    </div>
  </div>
</section>

<!-- =============================================
     WHY CHOOSE MediPOS
============================================= -->
<section id="why">
  <div class="bg-orb orb-2" style="opacity:0.4;"></div>
  <div class="container position-relative" style="z-index:2;">
    <div class="text-center mb-5 reveal">
      <div class="section-label"><span class="dot"></span>Why MediPOS</div>
      <h2 class="section-title">Trusted by Medical Stores <span class="gradient-text">Across Pakistan</span></h2>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.05s;">
        <div class="glass-card stat-card">
          <div class="stat-icon fi-2"><i class="bi bi-shop"></i></div>
          <div class="stat-number gradient-text" data-target="500">0</div>
          <div class="stat-label">Medical Stores Onboarded</div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.1s;">
        <div class="glass-card stat-card">
          <div class="stat-icon fi-3"><i class="bi bi-lightning-charge-fill"></i></div>
          <div class="stat-number gradient-text" data-target="50000">0</div>
          <div class="stat-label">Transactions Processed Daily</div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.15s;">
        <div class="glass-card stat-card">
          <div class="stat-icon fi-1"><i class="bi bi-shield-check"></i></div>
          <div class="stat-number gradient-text" data-target="99" data-suffix=".9%">0</div>
          <div class="stat-label">Platform Uptime Guaranteed</div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 reveal" style="transition-delay:0.2s;">
        <div class="glass-card stat-card">
          <div class="stat-icon fi-4"><i class="bi bi-headset"></i></div>
          <div class="stat-number gradient-text">24/7</div>
          <div class="stat-label">Expert Support Available</div>
        </div>
      </div>
    </div>

    <!-- Value Propositions -->
    <div class="row g-4">
      <div class="col-md-4 reveal" style="transition-delay:0.05s;">
        <div class="glass-card feature-card text-center">
          <div class="feature-icon-wrap fi-2 mx-auto"><i class="bi bi-cloud-arrow-up"></i></div>
          <div class="feature-card-title">Cloud-Based & Offline Ready</div>
          <p class="feature-card-desc">Works seamlessly online and syncs automatically. Never lose data during internet outages.</p>
        </div>
      </div>
      <div class="col-md-4 reveal" style="transition-delay:0.1s;">
        <div class="glass-card feature-card text-center">
          <div class="feature-icon-wrap fi-6 mx-auto"><i class="bi bi-phone"></i></div>
          <div class="feature-card-title">Works on Any Device</div>
          <p class="feature-card-desc">Optimized for Windows PCs, tablets, and Android devices. No expensive hardware required.</p>
        </div>
      </div>
      <div class="col-md-4 reveal" style="transition-delay:0.15s;">
        <div class="glass-card feature-card text-center">
          <div class="feature-icon-wrap fi-7 mx-auto"><i class="bi bi-translate"></i></div>
          <div class="feature-card-title">Urdu & English Interface</div>
          <p class="feature-card-desc">Switch between Urdu and English UI at any time. Tailored for Pakistani pharmacy workflows.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     TESTIMONIALS
============================================= -->
<section id="testimonials">
  <div class="container position-relative" style="z-index:2;">
    <div class="text-center mb-5 reveal">
      <div class="section-label"><span class="dot"></span>Customer Stories</div>
      <h2 class="section-title">Medical Store Owners <span class="gradient-text">Love MediPOS</span></h2>
    </div>

    <div class="row g-4">
      <div class="col-lg-4 reveal" style="transition-delay:0.05s;">
        <div class="glass-card testimonial-card">
          <div class="stars">★★★★★</div>
          <p class="testimonial-text">"MediPOS transformed how we run our pharmacy. Inventory that used to take hours to audit now takes minutes. The expiry alerts alone have saved us thousands in waste."</p>
          <div class="testimonial-author">
            <div class="author-avatar" style="background:linear-gradient(135deg,#4f46e5,#3b82f6);">AK</div>
            <div>
              <div class="author-name">Ahmed Khan</div>
              <div class="author-pos">Owner – Al-Noor Medical, Karachi</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 reveal" style="transition-delay:0.1s;">
        <div class="glass-card testimonial-card">
          <div class="stars">★★★★★</div>
          <p class="testimonial-text">"The barcode scanning is lightning fast and the reporting dashboard gives me a complete picture of my business every morning. We expanded to 3 branches after switching to MediPOS."</p>
          <div class="testimonial-author">
            <div class="author-avatar" style="background:linear-gradient(135deg,#8b5cf6,#6366f1);">SR</div>
            <div>
              <div class="author-name">Sara Raza</div>
              <div class="author-pos">Pharmacist – City Pharmacy, Lahore</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 reveal" style="transition-delay:0.15s;">
        <div class="glass-card testimonial-card">
          <div class="stars">★★★★★</div>
          <p class="testimonial-text">"We tried two other POS systems before MediPOS. Nothing compares. The support team responds within the hour and the system has never gone down once in 8 months."</p>
          <div class="testimonial-author">
            <div class="author-avatar" style="background:linear-gradient(135deg,#06b6d4,#3b82f6);">MI</div>
            <div>
              <div class="author-name">Muhammad Imran</div>
              <div class="author-pos">Manager – Health Plus Pharmacy, Islamabad</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     CTA SECTION
============================================= -->
<section id="cta">
  <div class="container position-relative" style="z-index:2;">
    <div class="cta-inner reveal">
      <div class="section-label mx-auto"><span class="dot"></span>Ready to get started?</div>
      <h2 class="cta-title">
        Start Managing Your Medical Store<br>
        <span class="gradient-text">Smarter Today</span>
      </h2>
      <p class="cta-sub">Join 500+ pharmacies already growing their business with MediPOS. Setup takes less than 15 minutes.</p>
      <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="#packages" class="btn-primary-custom">
          <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial
        </a>
        <a href="https://wa.me/923086452242?text={{ urlencode('Hello MediPOS Team, I would like to book a demo for your Medical POS Software.') }}" target="_blank" class="btn-outline-custom">
          <i class="bi bi-calendar-check me-2"></i>Book a Demo
        </a>
      </div>
      <p style="font-size:0.82rem;color:var(--muted);margin-top:1.5rem;">
        <i class="bi bi-shield-lock me-1"></i>No credit card required &nbsp;·&nbsp;
        <i class="bi bi-arrow-counterclockwise me-1"></i>Cancel anytime &nbsp;·&nbsp;
        <i class="bi bi-headset me-1"></i>Free onboarding support
      </p>
    </div>
  </div>
</section>

<!-- =============================================
     FOOTER
============================================= -->
<footer id="footer">
  <div class="container">
    <div class="row g-5">

      <!-- Brand -->
      <div class="col-lg-4">
        <a href="#hero" class="footer-brand">
          <div class="brand-icon"><i class="bi bi-heart-pulse-fill text-white"></i></div>
          <span class="navbar-brand mb-0" style="font-size:1.4rem;">Medi<span style="color:var(--blue-light);">POS</span></span>
        </a>
        <p class="footer-desc">Pakistan's most trusted medical store POS system. Built for pharmacists, by technology experts who understand healthcare retail.</p>
        <div class="social-links">
          <a href="#" class="social-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="social-btn" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="social-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="social-btn" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
          <a href="#" class="social-btn" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-6 col-lg-2">
        <div class="footer-heading">Product</div>
        <a href="#features" class="footer-link">Features</a>
        <a href="#packages" class="footer-link">Pricing</a>
        <a href="#packages" class="footer-link">Packages</a>
        <a href="#why" class="footer-link">Why MediPOS</a>
        <a href="#" class="footer-link">Changelog</a>
      </div>

      <div class="col-6 col-lg-2">
        <div class="footer-heading">Company</div>
        <a href="#" class="footer-link">About Us</a>
        <a href="#" class="footer-link">Blog</a>
        <a href="#" class="footer-link">Careers</a>
        <a href="#" class="footer-link">Partners</a>
        <a href="#" class="footer-link">Contact</a>
      </div>

      <div class="col-6 col-lg-2">
        <div class="footer-heading">Legal</div>
        <a href="#" class="footer-link">Privacy Policy</a>
        <a href="#" class="footer-link">Terms of Service</a>
        <a href="#" class="footer-link">Refund Policy</a>
        <a href="#" class="footer-link">Security</a>
      </div>

      <!-- Contact -->
      <div class="col-6 col-lg-2">
        <div class="footer-heading">Contact</div>
      <a href="mailto:[EMAIL_ADDRESS]" class="footer-link"><i class="bi bi-envelope me-2"></i>[EMAIL_ADDRESS]</a>
        <a href="tel:+923086452242" class="footer-link"><i class="bi bi-telephone me-2"></i>+92 308 645 2242</a>
       <a href="https://wa.me/923086452242?text=Hello%20MediPOS%20Team,%20I%20would%20like%20to%20book%20a%20demo%20for%20your%20Medical%20POS%20Software." 
   target="_blank" 
   class="footer-link">
    <i class="bi bi-whatsapp me-2"></i>WhatsApp Chat
</a>
        <a href="#" class="footer-link"><i class="bi bi-geo-alt me-2"></i>Faisalabad, Pakistan</a>
      </div>

    </div>

    <div class="footer-bottom">
      <p class="footer-copy">© 2026 <span>MediPOS</span>. All rights reserved. Made with <i class="bi bi-heart-fill" style="color:#f87171;"></i> in Pakistan.</p>
      <div class="d-flex gap-3">
        <a href="#" class="footer-link mb-0" style="font-size:0.8rem;">Privacy</a>
        <a href="#" class="footer-link mb-0" style="font-size:0.8rem;">Terms</a>
        <a href="#" class="footer-link mb-0" style="font-size:0.8rem;">Sitemap</a>
      </div>
    </div>
  </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* =============================================
   PARTICLE SYSTEM
============================================= */
(function () {
  const canvas = document.getElementById('particles-canvas');
  const ctx = canvas.getContext('2d');
  let W = window.innerWidth, H = window.innerHeight;
  canvas.width = W; canvas.height = H;

  const PARTICLE_COUNT = 70;
  const particles = [];

  function rand(min, max) { return Math.random() * (max - min) + min; }

  class Particle {
    constructor() { this.reset(); }
    reset() {
      this.x  = rand(0, W);
      this.y  = rand(0, H);
      this.r  = rand(0.5, 2);
      this.vx = rand(-0.15, 0.15);
      this.vy = rand(-0.25, -0.05);
      this.alpha = rand(0.1, 0.5);
      this.color = Math.random() > 0.5 ? '99,130,246' : '59,130,246';
    }
    update() {
      this.x += this.vx;
      this.y += this.vy;
      if (this.y < -5 || this.x < -5 || this.x > W + 5) this.reset();
    }
    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
      ctx.fillStyle = `rgba(${this.color},${this.alpha})`;
      ctx.fill();
    }
  }

  for (let i = 0; i < PARTICLE_COUNT; i++) particles.push(new Particle());

  // Draw connection lines
  function drawConnections() {
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < 100) {
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.strokeStyle = `rgba(99,130,246,${0.08 * (1 - dist / 100)})`;
          ctx.lineWidth = 0.5;
          ctx.stroke();
        }
      }
    }
  }

  function animate() {
    ctx.clearRect(0, 0, W, H);
    drawConnections();
    particles.forEach(p => { p.update(); p.draw(); });
    requestAnimationFrame(animate);
  }
  animate();

  window.addEventListener('resize', () => {
    W = window.innerWidth; H = window.innerHeight;
    canvas.width = W; canvas.height = H;
  });
})();

/* =============================================
   NAVBAR SCROLL
============================================= */
const nav = document.getElementById('mainNav');
window.addEventListener('scroll', () => {
  nav.classList.toggle('scrolled', window.scrollY > 40);
}, { passive: true });

/* =============================================
   SCROLL REVEAL (Intersection Observer)
============================================= */
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      revealObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

document.querySelectorAll('.reveal, .reveal-left, .reveal-right')
  .forEach(el => revealObserver.observe(el));

/* =============================================
   ANIMATED COUNTERS
============================================= */
function animateCounter(el) {
  const target  = parseInt(el.dataset.target) || 0;
  const suffix  = el.dataset.suffix || (target >= 500 ? '+' : '');
  const duration = 2000;
  const start   = performance.now();

  function tick(now) {
    const elapsed  = now - start;
    const progress = Math.min(elapsed / duration, 1);
    const eased    = 1 - Math.pow(1 - progress, 3);
    el.textContent = Math.round(target * eased).toLocaleString() + (progress === 1 ? suffix : '');
    if (progress < 1) requestAnimationFrame(tick);
  }
  requestAnimationFrame(tick);
}

const counterObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting && entry.target.dataset.target) {
      animateCounter(entry.target);
      counterObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.5 });

document.querySelectorAll('[data-target]').forEach(el => counterObserver.observe(el));

/* =============================================
   3D DASHBOARD MOUSE TRACKING
============================================= */
(function () {
  const wrapper = document.querySelector('.dashboard-wrapper');
  const scene   = document.getElementById('dashScene');
  if (!wrapper || !scene) return;

  let targetX = 0, targetY = 0, currentX = 0, currentY = 0;
  const MAX_ROT = 12;

  wrapper.addEventListener('mousemove', e => {
    const rect = wrapper.getBoundingClientRect();
    const cx   = rect.left + rect.width / 2;
    const cy   = rect.top  + rect.height / 2;
    targetX = ((e.clientY - cy) / rect.height) * -MAX_ROT;
    targetY = ((e.clientX - cx) / rect.width)  *  MAX_ROT;
  });

  wrapper.addEventListener('mouseleave', () => { targetX = 0; targetY = 0; });

  function lerp(a, b, t) { return a + (b - a) * t; }

  function loop() {
    currentX = lerp(currentX, targetX, 0.08);
    currentY = lerp(currentY, targetY, 0.08);
    scene.style.transform = `rotateX(${currentX}deg) rotateY(${currentY}deg)`;
    requestAnimationFrame(loop);
  }
  loop();
})();

/* =============================================
   PARALLAX FLOATING BACKGROUND SHAPES
============================================= */
window.addEventListener('scroll', () => {
  const y = window.scrollY;
  document.querySelectorAll('.bg-orb').forEach((orb, i) => {
    const speed = 0.1 + i * 0.05;
    orb.style.transform = `translateY(${y * speed}px)`;
  });
}, { passive: true });

/* =============================================
   SMOOTH ACTIVE NAV LINK ON SCROLL
============================================= */
(function () {
  const sections = document.querySelectorAll('section[id]');
  const links    = document.querySelectorAll('.nav-link-custom');

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        links.forEach(l => l.style.color = '');
        const active = document.querySelector(`.nav-link-custom[href="#${entry.target.id}"]`);
        if (active) active.style.color = 'white';
      }
    });
  }, { threshold: 0.5 });

  sections.forEach(s => observer.observe(s));
})();

/* =============================================
   PRICING CARD 3D HOVER
============================================= */
document.querySelectorAll('.pricing-card').forEach(card => {
  card.addEventListener('mousemove', e => {
    const rect = card.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const cx = rect.width  / 2;
    const cy = rect.height / 2;
    const rotX = ((y - cy) / cy) * -6;
    const rotY = ((x - cx) / cx) *  6;
    card.style.transform = `translateY(-10px) scale(1.02) rotateX(${rotX}deg) rotateY(${rotY}deg)`;
    // dynamic glow
    card.style.boxShadow = `
      ${rotY * 2}px ${-rotX * 2}px 50px rgba(79,70,229,0.25),
      0 30px 80px rgba(0,0,0,0.6)
    `;
  });
  card.addEventListener('mouseleave', () => {
    card.style.transform = '';
    card.style.boxShadow = '';
  });
});
</script>

</body>
</html>
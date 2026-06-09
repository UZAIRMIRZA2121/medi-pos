<?php
$html = file_get_contents('MediPoint_POS (2).html');

// We need to slice it.
// 1. Sidebar
preg_match('/<!-- SIDEBAR -->(.*?)<!-- OVERLAY -->/s', $html, $sidebarMatches);
$sidebar = trim($sidebarMatches[1] ?? '');

// 2. Topbar
preg_match('/<!-- TOPBAR -->(.*?)<!-- PAGES -->/s', $html, $topbarMatches);
$topbar = trim($topbarMatches[1] ?? '');

// 3. Main content (Pages)
preg_match('/<!-- PAGES -->(.*?)<!-- MODALS -->/s', $html, $pagesMatches);
$pages = trim($pagesMatches[1] ?? '');
$pages = preg_replace('/<\/main>\s*<\/div>$/', '</main>', $pages);

// 4. Modals
preg_match('/<!-- MODALS -->(.*?)<!-- TOAST -->/s', $html, $modalsMatches);
$modals = trim($modalsMatches[1] ?? '');

// 5. Toast & Script
preg_match('/<!-- TOAST -->(.*?)$/s', $html, $scriptsMatches);
$scripts = trim($scriptsMatches[1] ?? '');

// 6. Layout top (Everything before Sidebar)
preg_match('/^(.*?)<!-- SIDEBAR -->/s', $html, $headMatches);
$head = trim($headMatches[1] ?? '');

// We want to combine into layout app.blade.php
$layout = $head . "

    @include('partials.sidebar')
    
    <!-- OVERLAY -->
    <div class=\"overlay\" id=\"overlay\"></div>
    
    <!-- MAIN -->
    <div class=\"main-wrapper\">
        @include('partials.topbar')
        
        @yield('content')
    </div>
    
    @include('partials.modals')
    
" . $scripts;

if(!is_dir('resources/views/layouts')) mkdir('resources/views/layouts', 0777, true);
if(!is_dir('resources/views/partials')) mkdir('resources/views/partials', 0777, true);
if(!is_dir('resources/views/pos')) mkdir('resources/views/pos', 0777, true);

file_put_contents('resources/views/layouts/app.blade.php', $layout);
file_put_contents('resources/views/partials/sidebar.blade.php', $sidebar);
file_put_contents('resources/views/partials/topbar.blade.php', $topbar);
file_put_contents('resources/views/partials/modals.blade.php', $modals);

$posContent = "@extends('layouts.app')\n\n@section('content')\n" . $pages . "\n@endsection\n";
file_put_contents('resources/views/pos/index.blade.php', $posContent);

echo "Successfully split HTML into Blade templates.\n";

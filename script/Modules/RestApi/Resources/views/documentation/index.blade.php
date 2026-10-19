@php
    use Illuminate\Support\Str;

    $locale = $locale ?? app()->getLocale();
    $direction = $direction ?? (in_array($locale, ['ar', 'fa', 'ur']) ? 'rtl' : 'ltr');
    $isRtl = $direction === 'rtl';
    $fontFamily = $fontFamily ?? 'Inter';
    $logoUrl = $logoUrl ?? null;
    $moduleVersion = $moduleVersion ?? '1.0.0';
    $googleFontFamily = str_replace(' ', '+', $fontFamily);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $direction }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('applicationintegration-docs::doc.api_docs') }} | REST API</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family={{ $googleFontFamily }}:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --surface-2: #f1f5f9;
            --muted: #64748b;
            --text: #0f172a;
            --border: #e2e8f0;
            --accent: #4f46e5;
            --accent-hover: #4338ca;
            --accent-light: rgba(79, 70, 229, 0.1);
            --gradient-primary: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --glass-bg: rgba(255, 255, 255, 0.85);
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px -2px rgba(15, 23, 42, 0.05);
            --shadow-lg: 0 12px 24px -4px rgba(15, 23, 42, 0.08);
            --method-get: #10b981;
            --method-post: #3b82f6;
            --method-put: #f59e0b;
            --method-delete: #ef4444;
        }
        body.dark {
            --bg: #0b0f19;
            --surface: #131c2e;
            --surface-2: #1e293b;
            --muted: #94a3b8;
            --text: #f8fafc;
            --border: #223049;
            --accent: #6366f1;
            --accent-hover: #818cf8;
            --accent-light: rgba(99, 102, 241, 0.15);
            --glass-bg: rgba(19, 28, 46, 0.85);
            --shadow-md: 0 4px 12px -2px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 12px 24px -4px rgba(0, 0, 0, 0.4);
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body { 
            font-family: '{{ $fontFamily }}', 'Inter', system-ui, sans-serif; 
            background: var(--bg); 
            color: var(--text);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        
        a { color: inherit; text-decoration: none; }
        
        /* Header */
        .header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }
        
        .header-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--gradient-primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 14px;
            letter-spacing: 0.5px;
        }
        
        .header-title {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }
        
        .version-badge {
            font-size: 11px;
            background: var(--accent-light);
            color: var(--accent);
            padding: 1px 8px;
            border-radius: 6px;
            font-weight: 600;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }
        
        .search-container {
            flex: 1;
            max-width: 440px;
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: 8px 14px;
            padding-right: 65px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--surface);
            color: var(--text);
            font-size: 14px;
            transition: all 0.2s ease;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-light);
        }
        
        .search-kbd {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 10px;
            padding: 3px 6px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 4px;
            color: var(--muted);
            font-family: 'JetBrains Mono', monospace;
        }
        
        .header-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .control-btn {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .control-btn:hover {
            border-color: var(--accent);
            background: var(--surface-2);
        }
        
        /* Layout */
        .page {
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr); /* Crucial Fix: Prevent layout blow-out */
            gap: 40px;
            max-width: 1340px;
            padding: 40px 24px;
            margin: 0 auto;
        }
        
        /* Sidebar */
        .sidebar {
            position: sticky;
            top: 90px;
            align-self: start;
            max-height: calc(100vh - 130px);
            overflow-y: auto;
            padding-right: 8px;
        }
        
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }
        
        .sidebar-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--muted);
            margin-bottom: 12px;
            font-weight: 700;
        }
        
        .nav {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            color: var(--muted);
            font-weight: 500;
            font-size: 14px;
            transition: all 0.15s ease;
        }
        
        .nav a:hover {
            background: var(--surface-2);
            color: var(--text);
            transform: translateX({{ $isRtl ? '-2px' : '2px' }});
        }
        
        .nav a.active {
            background: var(--accent-light);
            color: var(--accent);
            font-weight: 600;
        }
        
        .nav-icon {
            width: 6px;
            height: 6px;
            background: currentColor;
            border-radius: 50%;
            opacity: 0.5;
        }
        
        /* Content */
        .content {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        
        /* Cards */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 32px;
            box-shadow: var(--shadow-sm);
        }
        
        .section-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 20px;
        }
        
        .section-title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text);
        }
        
        .section-desc {
            color: var(--muted);
            font-size: 14px;
            max-width: 100%;
            margin-top: 6px;
        }
        
        .section-badge {
            display: inline-flex;
            align-items: center;
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 6px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            color: var(--muted);
            font-weight: 600;
            font-family: 'JetBrains Mono', monospace;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .section-badge:hover {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }
        
        /* Quick Info Grid */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .quick-item {
            padding: 14px 16px;
            background: var(--surface-2);
            border-radius: 8px;
            border: 1px solid var(--border);
        }
        
        .quick-label {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
            font-weight: 600;
        }
        
        .quick-value {
            font-size: 14px;
            font-weight: 700;
            font-family: 'JetBrains Mono', monospace;
            color: var(--text);
        }
        
        /* Endpoints */
        .endpoint {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 24px;
            margin-top: 20px;
            background: var(--surface);
            box-shadow: var(--shadow-sm);
        }
        
        .endpoint-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        
        .method {
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 0.05em;
            color: white;
            font-family: 'JetBrains Mono', monospace;
        }
        
        .method-GET { background: var(--method-get); }
        .method-POST { background: var(--method-post); }
        .method-PUT { background: var(--method-put); }
        .method-DELETE { background: var(--method-delete); }
        
        .endpoint-path {
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }
        
        .auth-badge {
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 6px;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.15);
            font-weight: 600;
        }
        
        .endpoint-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 6px;
        }
        
        .endpoint-summary {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 16px;
        }
        
        .copy-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--surface-2);
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 16px;
        }
        
        .copy-btn:hover {
            background: var(--accent-light);
            color: var(--accent);
            border-color: var(--accent);
        }
        
        /* Tables Fix */
        .table-responsive {
            width: 100%;
            overflow-x: auto; /* Thêm cuộn riêng cho bảng nếu dữ liệu dài */
            margin: 16px 0;
            border: 1px solid var(--border);
            border-radius: 8px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            background: var(--surface);
        }
        
        .table th {
            text-align: {{ $isRtl ? 'right' : 'left' }};
            padding: 12px 14px;
            background: var(--surface-2);
            border-bottom: 1px solid var(--border);
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 10px;
        }
        
        .table td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
            font-family: 'JetBrains Mono', monospace;
            color: var(--text);
        }
        
        .table tr:last-child td {
            border-bottom: none;
        }
        
        /* Callouts */
        .callout {
            padding: 12px 16px;
            border-radius: 8px;
            background: var(--accent-light);
            border-left: 4px solid var(--accent);
            color: var(--text);
            margin: 16px 0 8px 0;
            font-size: 13px;
        }
        
        .callout-title {
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--accent);
        }
        
        .callout-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 4px;
        }
        
        /* Code Blocks Window Mode */
        .code-shell {
            border: 1px solid #1e293b;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 16px;
            background: #0f172a;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.2);
        }
        
        .code-tabs {
            display: flex;
            gap: 4px;
            padding: 10px 16px;
            background: #0b0f19;
            border-bottom: 1px solid #1e293b;
        }
        
        .code-tab {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            background: transparent;
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .code-tab:hover {
            color: #94a3b8;
            background: rgba(255, 255, 255, 0.03);
        }
        
        .code-tab.active {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
        }
        
        .code-body {
            position: relative;
        }
        
        .code-copy {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid #334155;
            background: #1e293b;
            color: #94a3b8;
            font-size: 11px;
            cursor: pointer;
            transition: all 0.2s;
            z-index: 10;
        }
        
        .code-copy:hover {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }
        
        pre {
            margin: 0;
            padding: 18px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            overflow-x: auto; /* Cho phép cuộn ngang độc lập */
            max-width: 100%;
            color: #e2e8f0;
            background: #0f172a !important;
        }
        
        /* TOC Links */
        .toc-links {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .toc-link {
            padding: 6px 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--surface-2);
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            transition: all 0.2s;
        }
        
        .toc-link:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--surface);
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .page {
                grid-template-columns: 1fr;
                gap: 24px;
                padding: 24px 16px;
            }
            .sidebar {
                position: relative;
                top: 0;
                max-height: none;
                padding-right: 0;
                border-bottom: 1px solid var(--border);
                padding-bottom: 16px;
            }
            .header {
                padding: 12px 16px;
            }
            .search-container {
                order: 3;
                max-width: 100%;
                margin-top: 4px;
            }
        }
        
        /* Custom Public Banner */
        .public-banner {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(59, 130, 246, 0.05));
            border: 1px dashed var(--accent);
            padding: 20px;
        }
    </style>
</head>
<body class="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <header class="header">
        <div class="header-brand">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="Logo" class="logo-img" style="max-height: 38px; width: auto; border-radius: 6px; object-fit: contain;">
            @else
                <div class="logo-icon">API</div>
            @endif
            <div>
                <div class="header-title">{{ __('applicationintegration-docs::doc.api_docs') }}</div>
                <span class="version-badge">v{{ $moduleVersion }}</span>
            </div>
        </div>
        
        <div class="search-container">
            <input type="search" id="search-input" class="search-input" placeholder="{{ __('applicationintegration-docs::documentation.search_placeholder') ?? 'Search endpoints...' }}">
            <kbd class="search-kbd">Ctrl+K</kbd>
        </div>
        
        <div class="header-controls">
            <button id="theme-toggle" class="control-btn">
                <span id="theme-icon">🌙</span>
            </button>
        </div>
    </header>

    <div class="page">
        <aside class="sidebar">
            <div class="sidebar-title">{{ __('applicationintegration-docs::doc.toc') }}</div>
            <ul class="nav">
                @foreach($toc as $link)
                    <li>
                        <a href="#{{ $link['id'] }}">
                            <span class="nav-icon"></span>
                            {{ $link['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <main class="content">
            @if($isPublic)
                <div class="card public-banner">
                    <p>{{ __('applicationintegration-docs::doc.public_banner') }}</p>
                </div>
            @endif

            <div class="card" style="padding: 20px;">
                <div class="toc-links">
                    @foreach($toc as $link)
                        <a href="#{{ $link['id'] }}" class="toc-link">{{ $link['title'] }}</a>
                    @endforeach
                </div>
            </div>

            @foreach($sections as $section)
                <section id="{{ $section['id'] }}" class="card">
                    <div class="section-header">
                        <div>
                            <h3 class="section-title">{{ $section['title'] }}</h3>
                            <p class="section-desc">{{ $section['description'] }}</p>
                        </div>
                        <button class="section-badge copy-anchor" data-copy="{{ url()->current() }}#{{ $section['id'] }}">
                            <span>#{{ $section['id'] }}</span>
                        </button>
                    </div>

                    @if(!empty($section['quick'] ?? []))
                        <div class="quick-grid">
                            @foreach($section['quick'] as $item)
                                <div class="quick-item">
                                    <div class="quick-label">{{ $item['label'] }}</div>
                                    <div class="quick-value">{{ $item['value'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($section['endpoints'] ?? []))
                        @foreach($section['endpoints'] as $endpoint)
                            <div class="endpoint" data-searchable>
                                <div class="endpoint-header">
                                    <span class="method method-{{ $endpoint['method'] }}">{{ $endpoint['method'] }}</span>
                                    <span class="endpoint-path">{{ $endpoint['path'] }}</span>
                                    @if(!empty($endpoint['auth']))
                                        <span class="auth-badge">🔒 {{ __('applicationintegration-docs::doc.auth_required') }}</span>
                                    @endif
                                </div>
                                
                                <h4 class="endpoint-title">{{ $endpoint['name'] }}</h4>
                                <p class="endpoint-summary">{{ $endpoint['summary'] }}</p>
                                
                                <button class="copy-btn copy-endpoint" data-copy="{{ $baseUrl }}{{ $endpoint['path'] }}">
                                    📋 {{ __('applicationintegration-docs::doc.copy_link') }}
                                </button>

                                @if(!empty($endpoint['headers'] ?? []))
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('applicationintegration-docs::doc.header') }}</th>
                                                    <th>{{ __('applicationintegration-docs::doc.value') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($endpoint['headers'] as $header)
                                                    <tr>
                                                        <td>{{ $header['name'] }}</td>
                                                        <td>{{ $header['value'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @if(isset($endpoint['body']))
                                    <div class="callout">
                                        <div class="callout-title">📥 {{ __('applicationintegration-docs::doc.body_schema') }}</div>
                                    </div>
                                    <div class="code-shell" style="margin-top: 8px;">
                                        <pre class="language-json"><code>{!! json_encode($endpoint['body'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</code></pre>
                                    </div>
                                @endif

                                @if(!empty($endpoint['notes'] ?? []))
                                    <div class="callout" style="background: rgba(245, 158, 11, 0.08); border-left-color: #f59e0b;">
                                        <div class="callout-title" style="color: #d97706;">💡 Notes</div>
                                        @foreach($endpoint['notes'] as $note)
                                            <div class="callout-item">{{ $note }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                @include('applicationintegration::documentation.partials.code', [
                                    'method' => $endpoint['method'],
                                    'path' => $endpoint['path'],
                                    'body' => $endpoint['body'] ?? null,
                                    'response' => $endpoint['response'] ?? [],
                                    'baseUrl' => $baseUrl
                                ])
                            </div>
                        @endforeach
                    @endif

                    @if(!empty($section['samples'] ?? []))
                        <div class="endpoint">
                            @include('applicationintegration::documentation.partials.code', [
                                'method' => $section['samples']['method'],
                                'path' => $section['samples']['path'],
                                'body' => $section['samples']['body'],
                                'response' => $section['samples']['response'],
                                'baseUrl' => $baseUrl
                            ])
                        </div>
                    @endif
                </section>
            @endforeach
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
    <script>
        // Theme toggle
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const savedTheme = localStorage.getItem('docs-theme');
        if (savedTheme === 'dark') {
            document.body.classList.add('dark');
            themeIcon.textContent = '☀️';
        }
        
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark');
            const isDark = document.body.classList.contains('dark');
            themeIcon.textContent = isDark ? '☀️' : '🌙';
            localStorage.setItem('docs-theme', isDark ? 'dark' : 'light');
        });
        
        // Search functionality
        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            document.querySelectorAll('.endpoint').forEach(ep => {
                const text = ep.textContent.toLowerCase();
                ep.style.display = query === '' || text.includes(query) ? 'block' : 'none';
            });
        });
        
        // Keyboard shortcut (Ctrl+K)
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        });
        
        // Code tabs
        document.querySelectorAll('.code-tabs').forEach((tabs) => {
            tabs.addEventListener('click', (e) => {
                if (!e.target.classList.contains('code-tab')) return;
                const lang = e.target.dataset.lang;
                const shell = tabs.closest('.code-shell');
                shell.querySelectorAll('.code-tab').forEach(btn => btn.classList.remove('active'));
                e.target.classList.add('active');
                shell.querySelectorAll('pre').forEach(pre => {
                    pre.style.display = pre.dataset.lang === lang ? 'block' : 'none';
                });
            });
        });
        
        // Copy buttons for data-copy attributes
        document.querySelectorAll('[data-copy]').forEach(el => {
            el.addEventListener('click', async () => {
                const val = el.getAttribute('data-copy');
                if (val && navigator.clipboard) {
                    await navigator.clipboard.writeText(val);
                    const originalText = el.innerHTML;
                    el.innerHTML = '✅ Copied!';
                    setTimeout(() => el.innerHTML = originalText, 1500);
                }
            });
        });
        
        // Copy buttons for code blocks
        document.querySelectorAll('.code-copy').forEach(btn => {
            btn.addEventListener('click', async () => {
                const codeBody = btn.closest('.code-body');
                if (codeBody) {
                    const visiblePre = codeBody.querySelector('pre:not([style*="none"])') || codeBody.querySelector('pre');
                    if (visiblePre && navigator.clipboard) {
                        await navigator.clipboard.writeText(visiblePre.textContent);
                        const originalText = btn.textContent;
                        btn.textContent = '✓ Copied!';
                        setTimeout(() => btn.textContent = originalText, 1500);
                    }
                }
            });
        });
        
        // Active section observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const id = entry.target.getAttribute('id');
                if (entry.isIntersecting) {
                    document.querySelectorAll('.nav a').forEach(link => link.classList.remove('active'));
                    const active = document.querySelector(`.nav a[href="#${id}"]`);
                    if (active) active.classList.add('active');
                }
            });
        }, { rootMargin: '-30% 0px -60% 0px' });
        
        document.querySelectorAll('section[id]').forEach(sec => observer.observe(sec));
        
        // Prism highlight
        Prism.highlightAll();
    </script>
</body>
</html>

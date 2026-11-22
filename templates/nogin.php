<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#8fd3f4" data-light="#8fd3f4" data-dark="#0b1a33">
    <title><?php echo ucfirst($name) ?> is nogin.nl</title>
    <link rel="icon" href="/assets/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/apple-touch-icon.png">
    <link rel="stylesheet" href="/assets/css/nogin.css?v=9">
    <script src="/assets/js/theme.js?v=3"></script>
</head>

<body>
<main class="page">
    <button type="button" id="theme-toggle" class="sun" title="Switch to dark mode" aria-label="Switch to dark mode"></button>
    <div class="cloud cloud-one" aria-hidden="true"></div>
    <div class="cloud cloud-two" aria-hidden="true"></div>
    <div class="cloud cloud-three" aria-hidden="true"></div>

    <section class="card" aria-labelledby="headline">
        <div class="flag" aria-label="Dutch flag"></div>

        <h1 id="headline">
            <?php echo ucfirst($name) ?> is
            <span>Nog in NL</span>
        </h1>

        <p class="message">
            🥳 Whoooooop WHooooop 🥳
        </p>

        <div class="stamp">🇳🇱 STATUS: PARTY TIME</div>
    </section>

    <div class="landscape" aria-hidden="true">
        <svg class="layer" viewBox="0 0 1000 300" preserveAspectRatio="none">
            <path d="M0 130 V127 Q10 123 20 126 T40 125 T60 127.5 T80 124.5 T100 126.5 T120 125.5 T140 127 T160 124 T180 125 T200 127.5 T220 124.5 T240 126.5 T260 125.5 T280 127 T300 124 T320 125 T340 127.5 T360 124.5 T380 126.5 T400 125.5 T420 127 T440 124 T460 125 T480 127.5 T500 124.5 T520 126.5 T540 125.5 T560 127 T580 124 T600 125 T620 127.5 T640 124.5 T660 126.5 T680 125.5 T700 127 T720 124 T740 125 T760 127.5 T780 124.5 T800 126.5 T820 125.5 T840 127 T860 124 T880 125 T900 127.5 T920 124.5 T940 126.5 T960 125.5 T980 127 T1000 124 V130 Z" class="hill" fill="#8fbf88"/>
            <rect y="130" width="1000" height="170" class="field" fill="#b9dfb1"/>
        </svg>

        <div class="windmill">
            <svg viewBox="0 0 100 140">
                <path class="tower" d="M38 140 L44 62 H56 L62 140 Z" fill="#2f5d73"/>
                <rect class="tower-dark" x="46" y="118" width="8" height="22" rx="4" fill="#1d3f50"/>
                <path class="tower-dark" d="M42 64 Q50 48 58 64 Z" fill="#1d3f50"/>
            </svg>
            <!-- separate element so the spin is a cheap compositor animation, not an SVG repaint -->
            <svg class="sails" viewBox="0 0 100 140">
                <g class="sail" fill="#fff8e8" stroke="#2f5d73" stroke-width="1.5">
                    <rect x="51" y="12" width="9" height="42"/>
                    <rect x="51" y="12" width="9" height="42" transform="rotate(90 50 58)"/>
                    <rect x="51" y="12" width="9" height="42" transform="rotate(180 50 58)"/>
                    <rect x="51" y="12" width="9" height="42" transform="rotate(270 50 58)"/>
                </g>
                <path class="sail-frame" d="M50 8 V108 M0 58 H100" stroke="#2f5d73" stroke-width="2.5"/>
                <circle class="tower-dark" cx="50" cy="58" r="4" fill="#1d3f50"/>
            </svg>
        </div>

        <svg class="layer" viewBox="0 0 1000 300" preserveAspectRatio="none">
            <defs>
                <linearGradient id="haze" x1="0" y1="0" x2="0" y2="1">
                    <stop class="haze" offset="0" stop-color="#fff" stop-opacity=".45"/>
                    <stop class="haze" offset=".45" stop-color="#fff" stop-opacity="0"/>
                </linearGradient>
            </defs>
            <rect y="160" width="1000" height="140" class="meadow" fill="#86c67f"/>
            <rect y="180" width="1000" height="12" class="water" fill="#4fb3dc"/>
            <rect y="183" width="1000" height="2" class="glint" fill="#fff" opacity=".55"/>
            <rect y="192" width="1000" height="108" class="grass" fill="#5fae5e"/>
            <polygon points="-6,192 49,192 -480,300 -600,300" class="tulip-orange" fill="#f28c38"/>
            <polygon points="86,192 141,192 -280,300 -400,300" class="tulip-red" fill="#e0443e"/>
            <polygon points="178,192 233,192 -80,300 -200,300" class="tulip-yellow" fill="#f6c343"/>
            <polygon points="270,192 325,192 120,300 0,300" class="tulip-pink" fill="#ef7fa6"/>
            <polygon points="362,192 417,192 320,300 200,300" class="tulip-white" fill="#fff4ee"/>
            <polygon points="454,192 509,192 520,300 400,300" class="tulip-orange" fill="#f28c38"/>
            <polygon points="546,192 601,192 720,300 600,300" class="tulip-red" fill="#e0443e"/>
            <polygon points="638,192 693,192 920,300 800,300" class="tulip-yellow" fill="#f6c343"/>
            <polygon points="730,192 785,192 1120,300 1000,300" class="tulip-pink" fill="#ef7fa6"/>
            <polygon points="822,192 877,192 1320,300 1200,300" class="tulip-white" fill="#fff4ee"/>
            <polygon points="914,192 969,192 1520,300 1400,300" class="tulip-orange" fill="#f28c38"/>
            <rect y="192" width="1000" height="108" fill="url(#haze)"/>
        </svg>
    </div>
</main>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo ucfirst($name) ?> is nog in NL</title>

    <link rel="stylesheet" href="/css/nogin.css">
</head>

<body>
<main class="page">
    <div class="cloud cloud-one"></div>
    <div class="cloud cloud-two"></div>

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
        <div class="water"></div>
        <div class="horizon"></div>
        <div class="bicycle">🚲</div>

        <div class="tulips">
            <span>🌷</span>
            <span>🌷</span>
            <span>🌷</span>
            <span>🌷</span>
        </div>
    </div>
</main>
</body>
</html>

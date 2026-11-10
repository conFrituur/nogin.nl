<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#6150ff">
    <title><?php echo ucfirst($name) ?> nietin.nl</title>
    <meta name="apple-mobile-web-app-title" content="Nogin.nl">
    <link rel="icon" href="/assets/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/apple-touch-icon.png">
    <link rel="stylesheet" href="/assets/css/nietin.css">
</head>

<body>
<main class="page">
    <div class="globe" aria-hidden="true"></div>

    <div class="continent continent-one" aria-hidden="true"></div>
    <div class="continent continent-two" aria-hidden="true"></div>
    <div class="continent continent-three" aria-hidden="true"></div>

    <div class="route" aria-hidden="true"></div>
    <div class="pin pin-netherlands" aria-hidden="true"></div>
    <div class="pin pin-destination" aria-hidden="true"></div>
    <div class="airplane" aria-hidden="true">✈</div>

    <section class="card" aria-labelledby="headline">
        <div class="travel-icon" aria-hidden="true">🌍</div>

        <h1 id="headline">
            <?php echo ucfirst($name) ?> is
            <span>Niet in NL</span>
        </h1>

        <p class="message">
            Eindelijk...
        </p>

        <div class="stamp">✈ STATUS: GEDEPORTEERD</div>

        <p class="coordinates"></p>
    </section>
</main>
</body>
</html>

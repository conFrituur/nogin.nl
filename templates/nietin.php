<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo ucfirst($name) ?> nietin.nl</title>

    <link rel="stylesheet" href="/css/nietin.css">
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

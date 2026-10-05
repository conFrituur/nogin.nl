<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo ucfirst($name) ?> nietin.nl</title>

    <style>
        :root {
            --navy: #102a43;
            --blue: #2176ae;
            --sky: #dff5ff;
            --cream: #fffaf0;
            --coral: #ef6f61;
            --yellow: #f7c948;
            --green: #4d9f70;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            overflow: hidden;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--navy);
            background:
                    radial-gradient(circle at 15% 20%, rgba(255,255,255,.8) 0 2px, transparent 3px),
                    radial-gradient(circle at 80% 15%, rgba(255,255,255,.7) 0 2px, transparent 3px),
                    linear-gradient(160deg, #b9eaff, #6dbbdd 55%, #327da8);
            background-size: 130px 130px, 180px 180px, cover;
        }

        .page {
            position: relative;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px 16px;
            isolation: isolate;
        }

        /* Decorative globe */
        .globe {
            position: absolute;
            top: -95px;
            right: -110px;
            width: 310px;
            height: 310px;
            border: 18px solid rgba(255, 255, 255, 0.35);
            border-radius: 50%;
            background:
                    linear-gradient(25deg, transparent 45%, rgba(255,255,255,.22) 46% 48%, transparent 49%),
                    linear-gradient(-25deg, transparent 52%, rgba(255,255,255,.18) 53% 55%, transparent 56%),
                    #2384b5;
            box-shadow:
                    inset -30px -25px 0 rgba(12, 61, 94, 0.2),
                    0 20px 50px rgba(16, 42, 67, 0.2);
            z-index: -2;
        }

        .globe::before,
        .globe::after {
            content: "";
            position: absolute;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
        }

        .globe::before {
            inset: 20px 65px;
        }

        .globe::after {
            inset: 65px 20px;
        }

        /* World-map-like decorative shapes */
        .continent {
            position: absolute;
            background: rgba(246, 218, 154, 0.75);
            border-radius: 48% 52% 40% 60%;
            z-index: -1;
        }

        .continent-one {
            width: 130px;
            height: 65px;
            top: 13%;
            left: 3%;
            transform: rotate(-20deg);
        }

        .continent-two {
            width: 90px;
            height: 130px;
            bottom: 8%;
            right: 4%;
            transform: rotate(25deg);
        }

        .continent-three {
            width: 75px;
            height: 42px;
            top: 38%;
            right: 12%;
            transform: rotate(-12deg);
        }

        /* Travel route */
        .route {
            position: absolute;
            width: 240px;
            height: 130px;
            top: 18%;
            left: 18%;
            border-top: 3px dashed rgba(255, 255, 255, 0.75);
            border-radius: 50%;
            transform: rotate(18deg);
            z-index: -1;
        }

        .pin {
            position: absolute;
            width: 18px;
            height: 18px;
            border: 4px solid white;
            border-radius: 50% 50% 50% 0;
            background: var(--coral);
            transform: rotate(-45deg);
            box-shadow: 0 3px 8px rgba(16, 42, 67, 0.25);
            z-index: -1;
        }

        .pin::after {
            content: "";
            position: absolute;
            inset: 4px;
            border-radius: 50%;
            background: white;
        }

        .pin-netherlands {
            top: 19%;
            left: 17%;
        }

        .pin-destination {
            top: 35%;
            right: 18%;
            background: var(--yellow);
        }

        .airplane {
            position: absolute;
            top: 27%;
            left: 48%;
            color: white;
            font-size: 2.3rem;
            transform: rotate(18deg);
            filter: drop-shadow(0 4px 3px rgba(16, 42, 67, 0.2));
            z-index: -1;
        }

        .card {
            width: min(100%, 430px);
            padding: 34px 22px 30px;
            text-align: center;
            background: rgba(255, 250, 240, 0.96);
            border: 4px solid var(--navy);
            border-radius: 28px;
            box-shadow: 0 14px 0 rgba(16, 42, 67, 0.2);
        }

        .travel-icon {
            display: grid;
            place-items: center;
            width: 76px;
            height: 76px;
            margin: 0 auto 20px;
            border: 4px solid var(--navy);
            border-radius: 50%;
            background: var(--blue);
            color: white;
            font-size: 2.5rem;
            transform: rotate(-8deg);
        }

        .eyebrow {
            margin: 0 0 8px;
            color: var(--blue);
            font-size: 0.85rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            font-size: clamp(2.4rem, 12vw, 4.5rem);
            line-height: 0.95;
            letter-spacing: -0.07em;
        }

        h1 span {
            display: block;
            color: var(--coral);
        }

        .message {
            max-width: 325px;
            margin: 24px auto 0;
            font-size: 1.08rem;
            line-height: 1.55;
        }

        .stamp {
            display: inline-block;
            margin-top: 24px;
            padding: 9px 14px;
            border: 2px dashed var(--coral);
            border-radius: 8px;
            color: var(--coral);
            font-weight: 800;
            transform: rotate(-3deg);
        }

        .coordinates {
            margin: 20px 0 0;
            color: #59758d;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        @media (min-width: 600px) {
            .globe {
                top: -120px;
                right: -80px;
                width: 380px;
                height: 380px;
            }

            .route {
                left: 28%;
            }
        }
    </style>
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

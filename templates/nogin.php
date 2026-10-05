<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo ucfirst($name) ?> is nog in NL</title>

    <style>
        :root {
            --navy: #12304a;
            --blue: #3ba7d8;
            --sky: #c9f0ff;
            --cream: #fff8e8;
            --red: #d94a45;
            --yellow: #f5c542;
            --green: #4f9d69;
            --pink: #e8799d;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--navy);
            background:
                    linear-gradient(to bottom, var(--sky) 0 67%, #92d5ef 67% 100%);
        }

        .page {
            position: relative;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px 16px 150px;
            isolation: isolate;
        }

        .cloud {
            position: absolute;
            width: 110px;
            height: 28px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.8);
            z-index: -1;
        }

        .cloud::before,
        .cloud::after {
            content: "";
            position: absolute;
            bottom: 0;
            border-radius: 50%;
            background: inherit;
        }

        .cloud::before {
            left: 20px;
            width: 45px;
            height: 45px;
        }

        .cloud::after {
            right: 18px;
            width: 55px;
            height: 55px;
        }

        .cloud-one {
            top: 10%;
            left: -35px;
        }

        .cloud-two {
            top: 20%;
            right: -35px;
            transform: scale(0.75);
        }

        .card {
            width: min(100%, 430px);
            padding: 34px 22px 30px;
            text-align: center;
            background: rgba(255, 248, 232, 0.95);
            border: 4px solid var(--navy);
            border-radius: 28px;
            box-shadow: 0 12px 0 rgba(18, 48, 74, 0.18);
        }

        .flag {
            width: 100px;
            height: 66px;
            margin: 0 auto 22px;
            border: 3px solid var(--navy);
            border-radius: 6px;
            background: linear-gradient(
                    to bottom,
                    #ae1c28 0 33.33%,
                    white 33.33% 66.66%,
                    #21468b 66.66%
            );
        }

        .eyebrow {
            margin: 0 0 8px;
            color: var(--red);
            font-size: 0.85rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            font-size: clamp(2.3rem, 12vw, 4.5rem);
            line-height: 0.95;
            letter-spacing: -0.07em;
        }

        h1 span {
            display: block;
            color: var(--red);
        }

        .message {
            margin: 24px auto 0;
            max-width: 320px;
            font-size: 1.1rem;
            line-height: 1.55;
        }

        .stamp {
            display: inline-block;
            margin-top: 24px;
            padding: 9px 14px;
            border: 2px dashed var(--red);
            border-radius: 8px;
            color: var(--red);
            font-weight: 800;
            transform: rotate(-3deg);
        }

        .landscape {
            position: absolute;
            inset: auto 0 0;
            height: 150px;
            overflow: visible; /* prevents decorative elements from being clipped */
            z-index: -1;
        }
        .water {
            position: absolute;
            inset: 72px 0 0;
            background: repeating-linear-gradient(
                    to bottom,
                    #3cafd0 0 3px,
                    transparent 3px 13px
            );
            opacity: 0.65;
        }

        .horizon {
            position: absolute;
            bottom: 55px;
            width: 100%;
            height: 65px;
            background: var(--green);
            clip-path: polygon(
                    0 42%, 8% 36%, 16% 43%, 25% 28%, 35% 40%,
                    44% 25%, 55% 38%, 64% 30%, 73% 44%, 84% 27%,
                    94% 41%, 100% 33%, 100% 100%, 0 100%
            );
        }


        .bicycle {
            position: absolute;
            left: 8%;
            bottom: 35px;
            color: var(--navy);
            font-size: 58px;
            transform: rotate(-8deg);
        }

        .tulips {
            position: absolute;
            bottom: 36px;
            left: 50%;
            width: 170px;
            transform: translateX(-50%);
            font-size: 2.3rem;
            letter-spacing: 10px;
            white-space: nowrap;
        }

        .tulips span:nth-child(1) { color: var(--red); }
        .tulips span:nth-child(2) { color: var(--yellow); }
        .tulips span:nth-child(3) { color: var(--pink); }
        .tulips span:nth-child(4) { color: var(--red); }

        @media (min-width: 600px) {
            .page {
                padding-bottom: 180px;
            }

            .landscape {
                height: 180px;
            }

            .windmill {
                right: 20%;
            }

            .bicycle {
                left: 18%;
            }
        }
    </style>
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

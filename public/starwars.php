<html>
<header>
    <title>Star Wars - The Lost Jedi</title>

    <style>
        body {
            width: 100%;
            height: 100%;
            background: #000;
            overflow: hidden;
        }

        .fade {
            position: relative;
            width: 100%;
            min-height: 60vh;
            top: -25px;
            background-image: linear-gradient(0deg, transparent, black 75%);
            z-index: 1;
        }

        .star-wars {
            display: flex;
            justify-content: center;
            position: relative;
            height: 800px;
            color: #feda4a;
            font-family: 'Pathway Gothic One', sans-serif;
            font-size: 500%;
            font-weight: 600;
            letter-spacing: 6px;
            line-height: 150%;
            perspective: 400px;
            text-align: justify;
        }

        .crawl {
            position: relative;
            top: 9999px;
            transform-origin: 50% 100%;
            animation: crawl 60s linear;
        }

        .crawl > .title {
            font-size: 90%;
            text-align: center;
        }

        .crawl > .title h1 {
            margin: 0 0 100px;
            text-transform: uppercase;
        }

        @keyframes crawl {
            0% {
                top: 0;
                transform: rotateX(20deg) translateZ(0);
            }
            100% {
                top: -6000px;
                transform: rotateX(25deg) translateZ(-2500px);
            }
        }

    </style>
</header>
<body>
<section class="star-wars">

    <div class="crawl">

        <div class="title">
            <p>Episode XII</p>
            <h1>The Lost Jedi</h1>
        </div>

        <p>It is a period of civil war. Rebel spaceships, striking from a hidden base, have won their first victory
            against the evil Galactic Empire.</p>
        <p>During the battle, Rebel spies managed to steal secret plans to the Empire’s ultimate weapon, the DEATH STAR,
            an armored space station with enough power to destroy an entire planet.</p>
        <p>Pursued by the Empire’s sinister agents, Princess Leia races home aboard her starship, custodian of the
            stolen plans that can save her people and restore freedom to the galaxy…</p>

    </div>

</section>
</body>
</html>

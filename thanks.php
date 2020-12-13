<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="favicon.ico">
    <link href="css/style.css" rel="stylesheet">
    <title>Pineapple Subsribe to newsletter</title>
</head>
<body>
<div class="container">

    <div class="left-side">

        <header>

            <div class="logo-container">
                <div class="logo-image"></div>
                <div class="logo-image-pineapple"></div>
            </div>

            <div class="menu">
                <ul>
                    <li><a href="#">About</a></li>
                    <li><a href="#">How it works</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

        </header>

        <div v-if="thanksMessage" class="content-container" id="thanks">

            <img class="cup" src="images/cup.png">
            <h1>Thanks for subscribing!</h1>

            <div class="text-block">
                You have successfully subscriped to our email listing.
                Check your email for the discount code.
            </div>

            <div class="line">
                <svg width="24.7vw" height="1" viewBox="0 0 400 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="24.7vw" height="1" fill="#E3E3E4"/>
                </svg>
            </div>

            <div class="social-icon">

                <a href="#">
                    <div class="icon" id="facebook">
                        <span class="icon-ic_facebook"></span>
                    </div>
                </a>

                <a href="#">
                    <div class="icon" id="instagram">
                        <span class="icon-ic-instagram"></span>
                    </div>
                </a>

                <a href="#">
                    <div class="icon" id="twitter">
                        <span class="icon-ic_twitter"></span>
                    </div>
                </a>

                <a href="#">
                    <div class="icon" id="youtube">
                        <span class="icon-ic-youtube"></span>
                    </div>
                </a>

            </div>

        </div>

    </div>

    <div class="right-side"></div>
</div>
</body>
</html>

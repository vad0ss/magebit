<?php
    include 'backend/vendor/autoload.php';

    use App\Config\Config;

    $message = $_GET['message'];
    $config = new Config();

    if(isset($message)) {
        $message = $message === 'empty' ? $config->EMPTY_MESSAGE : $message;
        $message = $message === 'exists' ? $config->ADDRESS_EXISTS_MESSAGE : $message;
        $message = $message === 'nomail' ? $config->NOT_VALID_EMAIL_MESSAGE : $message;
        $message = $message === 'columbia' ? $config->IS_COLUMBIA_MESSAGE : $message;
        $message = $message === 'notchecked' ? $config->NOT_CHECKED_MESSAGE : $message;
        $message = $message === 'servererror' ? $config->SERVER_ERROR_MESSAGE : $message;
    }

?>

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

        <div class="content-container">

            <h1>Subscribe to newsletter</h1>

            <div class="text-block">
                Subscribe to our newsletter and get 10% discount on
                pineapple glasses.
            </div>

            <div class="errormessage">
                <p><?php echo $message; ?></p>
            </div>

            <form method="post" action="backend/api/addmail_nojs.php">

                <input type="text"
                       id="email"
                       name="email"
                       placeholder="Type your email address here...">

                <button type="submit">
                    <svg width="1.3vw" height="4vh" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M17.7071 0.2929C17.3166 -0.0976334 16.6834 -0.0976334 16.2929 0.2929C15.9023 0.683403 15.9023 1.31658 16.2929 1.70708L20.5858 5.99999H1C0.447693 5.99999 0 6.44772 0 6.99999C0 7.55227 0.447693 7.99999 1 7.99999H20.5858L16.2929 12.2929C15.9023 12.6834 15.9023 13.3166 16.2929 13.7071C16.6834 14.0976 17.3166 14.0976 17.7071 13.7071L23.7071 7.70708C24.0977 7.31658 24.0977 6.6834 23.7071 6.2929L17.7071 0.2929Z" fill="#131821"/>
                    </svg>
                </button>
                <div class="termscheck">
                    <input type="checkbox" name="checked">
                    <label for="terms_checkbox">I agree to <a href="#">terms of service</a></label>
                </div>
            </form>

            <div class="line">
                <svg width="24.7vw" height="1" viewBox="0 0 400 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="24.7vw" height="1"  fill="#E3E3E4"/>
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

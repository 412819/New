<?php
include 'settings.php';

// Domain setup
$portfolioUrl = "https://mohara-coaching-center.base44.app";
$adminUrl     = "https://mohara-coaching-center.base44.app/admin";

// URL check
$requestUri = $_SERVER['REQUEST_URI'];

if (strpos($requestUri, '/admin') !== false) {
    $targetUrl = $adminUrl;
} else {
    $targetUrl = $portfolioUrl;
}

$path = parse_url($requestUri, PHP_URL_PATH);
$cleanPath = str_replace('/admin', '', $path);
$fullUrl = $targetUrl . ($cleanPath === '/' ? '' : $cleanPath);

// WhatsApp Link
$whatsappLink = "https://wa.me/" . $whatsappNumber;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- ✅ Fixed Title -->
    <title>Mohora Coaching Center</title>

    <!-- ✅ Favicon -->
    <link rel="icon" href="logo.png">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            background: #fff;
        }

        #content-frame {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Contact Button (center bottom) */
        #contact-btn {
            position: fixed;
            bottom: <?php echo $btnBottom; ?>;
            left: 50%;
            transform: translateX(-50%);
            background: <?php echo $btnBgColor; ?>;
            color: <?php echo $btnTextColor; ?>;
            padding: <?php echo $btnPadding; ?>;
            border-radius: <?php echo $btnRadius; ?>;
            font-size: <?php echo $btnFontSize; ?>;
            text-decoration: none;
            font-weight: 500;
            backdrop-filter: <?php echo $btnBlur; ?>;
            -webkit-backdrop-filter: <?php echo $btnBlur; ?>;
            z-index: 9999;
            box-shadow: <?php echo $btnShadow; ?>;
            transition: 0.3s;
        }

        #contact-btn:hover {
            background: <?php echo $btnHoverColor; ?>;
        }
    </style>
</head>
<body>

    <iframe 
        id="content-frame"
        src="<?php echo $fullUrl; ?>" 
        allow="camera; microphone; fullscreen; clipboard-write; autoplay; payment"
        sandbox="allow-forms allow-modals allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts">
    </iframe>

    <!-- WhatsApp Button -->
    <a href="<?php echo $whatsappLink; ?>" target="_blank" id="contact-btn">
        <?php echo $footerText; ?>
    </a>

    <script>
        // Login Fix (same as before)
        window.addEventListener('message', function(e) {
            if (e.data.type === 'login_request') {
                var loginWin = window.open('<?php echo $portfolioUrl; ?>/login', 'Login', 'width=500,height=600');
                var timer = setInterval(function() { 
                    if(loginWin.closed) {
                        clearInterval(timer);
                        window.location.reload(); 
                    }
                }, 1000);
            }
        });

        // Admin back fix
        setInterval(function() {
            try {
                var frameUrl = document.getElementById('content-frame').contentWindow.location.href;
                if (!frameUrl.includes('/admin') && window.location.pathname.includes('/admin')) {
                    window.history.replaceState(null, '', '/');
                }
            } catch(e) {}
        }, 1000);

        window.addEventListener('popstate', function() {
            if (window.location.pathname.includes('/admin')) {
                window.location.href = '/';
            }
        });
    </script>

</body>
</html>
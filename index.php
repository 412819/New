<?php
// ১. আপনার টার্গেট ডোমেইনগুলো সেট করুন
$portfolioUrl = "https://sah-portfolio.base44.app";
$adminUrl     = "https://sah-portfolio.base44.app/admin";

// ২. ইউআরএল চেক করা হচ্ছে
$requestUri = $_SERVER['REQUEST_URI'];

if (strpos($requestUri, '/admin') !== false) {
    $targetUrl = $adminUrl;
} else {
    $targetUrl = $portfolioUrl;
}

$path = parse_url($requestUri, PHP_URL_PATH);
$cleanPath = str_replace('/admin', '', $path);
$fullUrl = $targetUrl . ($cleanPath === '/' ? '' : $cleanPath);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- ✅ Fixed Title -->
    <title>Mohora Coaching Center</title>

    <!-- ✅ Favicon (এখানে তোমার logo change করতে পারবা) -->
    <link rel="icon" type="image/png" href="logo.png">
    <!-- SVG use করলে এইটা -->
    <!-- <link rel="icon" type="image/svg+xml" href="logo.svg"> -->

    <style>
        body, html { margin: 0; padding: 0; height: 100vh; width: 100vw; overflow: hidden; background: #fff; }
        #content-frame { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; }
        
        #footer {
            position: fixed;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.4);
            padding: 6px 15px;
            border-radius: 25px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #444;
            text-decoration: none;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 9999;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            white-space: nowrap;
            transition: 0.3s;
        }
        #footer:hover {
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
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

    <a href="https://wa.me/8801974694241" target="_blank" id="footer">
        Created by Tanzim
    </a>

    <script>
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
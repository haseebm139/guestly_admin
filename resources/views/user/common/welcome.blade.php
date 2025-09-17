<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Guestly</title>
    <link rel="icon" type="image/png" href="/guestly_favicon.png">
    <script src="https://unpkg.com/lottie-web@latest/build/player/lottie.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #e6f4f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        #lottie {
            width: 800px;
            height: 800px;
            transition: opacity 0.8s ease;
        }
        .fade-out {
            opacity: 0;
        }
    </style>
</head>
<body>
<div id="lottie"></div>

<script>
    var animation = lottie.loadAnimation({
        container: document.getElementById('lottie'),
        renderer: 'svg',
        loop: false,
        autoplay: true,
        path: 'Splash Screen.json' // Replace with correct path
    });

    function redirectToNext() {
        // Add fade-out class for smooth transition
        document.getElementById('lottie').classList.add('fade-out');
        // Wait for fade-out to finish then redirect
        setTimeout(() => {
            window.location.href = '{{ url('form_slider') }}';
        }, 500); // same as CSS transition duration
    }

    // Redirect after animation completes with fade-out
    animation.addEventListener('complete', redirectToNext);

    // Fallback redirect if animation fails (after 5s)
    setTimeout(redirectToNext, 5000);
</script>
</body>
</html>


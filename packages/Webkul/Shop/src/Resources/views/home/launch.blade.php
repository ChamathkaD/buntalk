<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        /* Body styles */
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif; /* Use a common sans-serif font */
        }

        /* Button styles */
        .launch-button {
            padding: 15px 30px;
            background-color: #000; /* Orange color for a warm, inviting feel */
            color: white;
            font-size: 20px;
            border: none;
            border-radius: 25px; /* Rounded corners for a softer look */
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            text-transform: uppercase; /* Uppercase text for emphasis */
        }

        .launch-button:hover {
            background-color: #ff6f00; /* Darker orange on hover for effect */
        }

        /* Optional: Animation for hover effect */
        .launch-button:hover {
            animation: pulse 0.5s infinite alternate;
        }

        @keyframes pulse {
            to {
                transform: scale(1.02);
            }
        }

        /* Confetti container */
        #confetti-container {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none; /* Allow button clicks through the confetti */
            z-index: 1000; /* Ensure confetti is above other elements */
        }
        input[type="text"] {
            width: 20%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
            margin-bottom: 15px;
            font-size: 20px;
            text-align: center;
        }
    </style>
    <title>Launch</title>
</head>
<body>
<form id="launch-form" action="{{ route('shop.home.launch') }}" method="GET">
    @csrf
    <div style="display:flex; justify-content: center; margin-bottom: 50px">
        <img
            src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
            width="40%"
            alt="{{ config('app.name') }}"
        >
    </div>
    <div style="display:flex; justify-content: center">
        <label for="pin" hidden>Enter PIN:</label>
        <input type="text" id="pin" name="pin" placeholder="Enter Pin" required>
    </div>

    @if(session('error'))
        <div style="text-align: center; color: red; margin-bottom: 10px">{{ session('error') }}</div>
    @endif
    <div style="display:flex; justify-content: center">
        <button class="launch-button" type="submit" id="launch-button">Launch</button>
    </div>
</form>

<!-- Confetti container -->
<div id="confetti-container"></div>
<script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>
<script>
    document.getElementById('launch-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        let pinInput = document.getElementById('pin').value;
        let validPin = "0418";

        // Check if the entered PIN is valid
        if (pinInput === validPin) {

            // hide pin input
            document.getElementById('pin').style.display = 'none';
            // hide launch button
            document.getElementById('launch-button').style.display = 'none';

            let duration = 15 * 1000;
            let animationEnd = Date.now() + duration;
            let defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            let interval = setInterval(function() {
                let timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                let particleCount = 50 * (timeLeft / duration);
                // since particles fall down, start a bit higher than random
                confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } });
                confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } });
            }, 250);

            // Submit the form after a short delay (to allow confetti animation to play)
            setTimeout(function() {
                document.getElementById('launch-form').submit();
            }, 4000); // Adjust the delay as needed
        } else {
            alert('Invalid PIN. Please try again.');
        }
    });
</script>
</body>
</html>

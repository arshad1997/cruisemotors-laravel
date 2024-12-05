<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Calibri, sans-serif;
        }

        .container {
            background-color: #eaf0f3;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 60px;
            text-align: center;
        }

        .header img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
        }

        .greeting {
            font-size: 18px;
            color: #333333;
            /*margin-bottom: 20px;*/
        }

        .greeting strong {
            font-size: 20px;
        }

        .details {
            /*background-color: #f5f7fa;*/
            padding: 50px 50px 10px 50px;
            border-radius: 8px;
            /*margin: 20px 0;*/
            text-align: left;
        }

        .details ul {
            list-style-type: none;
            padding: 0;
        }

        .details ul li {
            margin-bottom: 10px;
            font-size: 16px;
            color: #333333;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .details table thead {
            background-color: #f5f7fa;
        }

        .details table th, .details table td {
            border: 1px solid #e0e0e0;
            padding: 5px;
        }

        .details table th {
            background-color: #f5f7fa;
        }

        .details table td {
            text-align: center;
        }

        .details h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .details p {
            margin: 0;
            font-size: 16px;
            color: #333333;
        }

        .app-section h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .app-section p {
            font-size: 14px;
            color: #555555;
        }

        .app-buttons {
            margin-top: 10px;

        }

        .app-buttons img {
            width: 150px;
            margin: 0 10px;
        }

        .social-icons {
            margin-top: 20px;
        }

        .social-icons img {
            width: 30px;
            margin: 0 5px;
        }

        .footer p {
            font-size: 14px;
            color: #555555;
        }

    </style>
</head>
<body>
<div class="container">
    <!-- Logo Section -->
    <div class="header">
        <img src="{{asset('assets/logo.png')}}" alt="Cruise Motors Logo">
        <div class="greeting">
            <p>Hi <strong>{{ $user->name }}</strong>,</p>
            <p>Thank you submitting {{ucwords(str_replace('-', ' ', $type))}}</p>
        </div>
    </div>

    <!-- Card Content -->
    <div class="card">
        @if($type=='deal')
            <x-deal-component :data="$data"/>
        @elseif($type=='supply-contract')
            <x-supply-contract-component :data="$data"/>
        @elseif($type=='quotation')
            <x-quotation-component :data="$data"/>
        @elseif($type=='order-vehicle')
            <x-order-vehicle-component :data="$data"/>
        @elseif($type=='offer-vehicle')
            <x-offer-vehicle-component :data="$data"/>
        @elseif($type=='documentation')
            <x-documentation-component :data="$data"/>
        @endif
        <hr style="background-color: #2d3748; width: 50%; opacity: 0.6">
        <p>We will get back to you shortly.</p>

    </div>

    <div class="card">
        <div class="app-section">
            <h2>Get the Cruise Motors app!</h2>
            <p>Get the most of Cruise Motors by installing our mobile app. You can log in using your existing email
                address and password.</p>
            <div class="app-buttons">
                <img src="{{asset('assets/google-play.png')}}" alt="Google Play">
                <img src="{{asset('assets/app-store.png')}}" alt="App Store">
            </div>
        </div>
    </div>

    <!-- Social Icons and Footer -->
    <div class="social-icons">
        <a href="https://www.facebook.com/people/Cruise-Motors-Fze/61555353302317" target="_blank">
            <img src="{{asset('assets/facebook.png')}}" alt="Facebook">
        </a>
        <img src="{{asset('assets/twitter.png')}}" alt="Twitter">
        <img src="{{asset('assets/linkedin.png')}}" alt="LinkedIn">
        <a href="https://www.instagram.com/cruisemotors.co" target="_blank">
            <img src="{{asset('assets/instagram.png')}}" alt="Instagram">
        </a>
    </div>

    <div class="footer">
        <p>Copyright &copy; 2024 Cruise Motors</p>
        <p>Drive Your Dream</p>
    </div>
</div>
</body>
</html>

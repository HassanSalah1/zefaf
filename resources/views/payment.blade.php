<html>
<head>
    <style>
        iframe {
            width: 100%;
            height: 100%;
            margin: 0;
        }

        body {
            overflow: hidden;
            margin: 0;
        }
    </style>
</head>
<body>

<iframe src="https://accept.paymobsolutions.com/api/acceptance/iframes/{{config('paymob.iframe_id')}}?payment_token={{$token}}"></iframe>
</body>
</html>

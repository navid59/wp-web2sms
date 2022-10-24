<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 5 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid p-5 bg-primary text-white text-center">
        <img src="https://netopia-payments.com/core/assets/5993428bab/images/logo.svg" width="250px">
        <hr>
        <h1></h1>
        <p>NETOPIA Payments Woocommerce Payment Gateway</p> 
    </div>
    
    <div class="container mt-5">
        <div class="row">
            <h3>Description</h3>
            <p>NETOPIA Payments Woocommerce Payment Gateway extends WooCommerce payment options by adding NETOPIA’s Payment Gateway options.</p>
        </div>
        <div class="row">
            <h3>FEATURES</h3>
            <ul>
                <li>100% FREE TO USE (GPLv2 license).</li>
                <li>Integrates NETOPIA payments’ card and cryptocoin payments service with your WordPress + WooCommerce online shop. SMS and Wire transfer options are still under development.</li>
                <li>Accepts payments with Visa and Mastercard credit/debit cards, Bitcoin and Ethereum</li>
                <li>Handles IPN responses and automatically changes order status on your shop in real time (confirmed/paid or failure messages and refunds).</li>
            </ul>
        </div>
        <div class="row">
            <h3>Installation</h3>
            <ul>
                <li>Install the plugin through the WordPress plugins screen directly (recommended) or upload netopiapayments to the /wp-content/plugins/ directory using your favourite FTP client.</li>
                <li>Activate the plugin through the Plugins menu in WordPress.</li>
                <li>Configure your settings under WooCommerce > Settings > Checkout > NETOPIA Payments option panel: enable the payment gateway and test mode, fill in your Seller Account ID (get it from your Netopia account under Admin – Seller accounts – Edit – Security settings) and select at least one payment option (usually Credit Card).</li>
                <li>Upload your live private.key and public.cer files from your NETOPIA merchant account. These certificates should look like this: live.XXXX-XXXX-XXXX-XXXX-XXXXprivate.key and live.XXXX-XXXX-XXXX-XXXX-XXXX.public.cer. Don’t rename .key and .cer files and make sure that XXXX-XXXX-XXXX-XXXX-XXXX matches your Seller Account ID!</li>
                <li>For testing purposes you will also need your sandbox keys to be uploaded into the plugin. Synchronize your seller account in Admin – Seller accounts – Edit – Synchronize and then access sandbox through Implementation – Test the implementation. Once in sandbox, download the certificates from Admin – Seller accounts – Edit – Security settings). They should look like this: sandbox.XXXX-XXXX-XXXX-XXXX-XXXXprivate.key and sandbox.XXXX-XXXX-XXXX-XXXX-XXXX.public.cer. Don’t rename .key and .cer files and make sure that XXXX-XXXX-XXXX-XXXX-XXXX matches your Seller Account ID!</li>
                <li>With test mode enabled contact NETOPIA’s support team to test the configuration. Send your shop URL to implementare@netopia.ro and ask for your account to be tested and activated for live mode.</li>
            </ul>
        </div>        
        <div class="row">
            <p>Pentru mai multe informaţii, vă rugăm să ne contactaţi la echipa de <a href="mailto:suport@netopia-system.com">suport</a></p>
            <p>&nbsp;</p>
        </div>
    </div>
</body>
</html>

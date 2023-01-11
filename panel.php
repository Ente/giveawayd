<!DOCTYPE html>
<html lang="en">
<?php
require_once "api/inc/db.inc.php";
require_once "api/inc/discord.inc.php";

checkID();

$user = apiRequest($apiURLBase);

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>GIVEAWAY</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap">
    <link rel="stylesheet" href="assets/css/styles.min.css?h=5e45cf66b170e84f294a29a109b64069">
</head>

<body>
    <div class="justify-content-center text-center">
        <h1></h1>
    </div>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
        <div class="container"><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/support">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link invisible" href="/panel">Panel</a></li>
                    </ul><span class="navbar-text actions"> <a class="login" href="<?php if(isset($_SESSION["access_token"]) == true){ checkID(); echo "#giveaway";} else { echo "api/discord_login.php";}  ?>"><?php if(isset($_SESSION["access_token"]) == true){ echo "Panel";} else { echo "Log In";};    ?></a><a class="btn btn-light action-button" role="button" href="<?php if(checkID()){ echo "/api/logout.php"; } else { echo "/api/login.php";}  ?>"><?php if(checkID()){ echo "Sign out";} else { echo "Sign up"; };   ?></a></span>                <ul class="navbar-nav"></ul>
            </div>
        </div>
    </nav>
    <div class="justify-content-center text-center">
        <h1 style="font-family: Lato, sans-serif;">🎉 GiveawaysD 🎉<br></h1>
    </div>
    <hr>
    <div class="alert alert-warning text-center invisible alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4 class="alert-heading">Attention: {%sInfoType} - {%sInfoTitle}</h4><span><strong>{%sInfoText}</strong></span></div>
        <div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <span><strong>Delete Account:&nbsp; &nbsp; &nbsp;</strong><br><strong>ATTENTION:</strong>&nbsp;THIS CANNOT BE UNDONE!<br></span><a class="alert-link border rounded border-danger" href="api/v1/deleteAccount/?id=<?php print_r($user->id);  ?>">Press me to delete account.</a></div>
    <div class="container" style="border-style: solid;"><div class="row"><div class="col-md-4"><p style="color: var(--bs-blue);">
        <strong>Your Giveaways:</strong></p></div><div class="col-md-8"><a href="#">{%sNumber} . {%sGiveawayName}</a></div></div></div>
        <h3 class="text-center" id="giveaway">Create Giveaway</h3>
            <form method="POST" action="api/v1/createGiveaway.php" id="form" name="giveaway">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label">Giveaway Name*:<br><small class="form-text">The name should be short and meaningful.</small><br></label>
                        </div>
                        <div class="col-md-6"><input class="form-control" type="text" placeholder="Ducky" name="g_name" required=""></div></div></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label">Giveaway Description*:<br><small class="form-text">What's the Giveaway about? Any other information to give?</small><br></label></div>
                            <div class="col-md-6"><textarea class="form-control" required="" maxlength="2000" name="g_description" placeholder="You can win a fancy duck!"></textarea></div></div></div><div class="container"><div class="row"><div class="col-md-6"><label class="col-form-label">Public or Private*:<br><small class="form-text">When the Giveaway is public, all participants will be displayed on the Page (only their Discord Name e.g. Discord#0000)</small><br></label></div><div class="col-md-6"><select class="form-select" name="g_public" required=""><option value="true" selected="">Public</option><option value="false">Private</option></select></div></div></div><div class="container"><div class="row"><div class="col-md-6"><label class="col-form-label">Giveaway Prize*:<br><small class="form-text">What are you going to give away?</small><br></label></div><div class="col-md-6"><input class="form-control" type="text" name="g_prize" placeholder="A duck!" required=""></div></div></div><div class="container"><div class="row"><div class="col-md-6"><label class="col-form-label">How long should the Giveaway last?*:<br><small class="form-text">You can manually end the giveaway or enter the time.<br>If you choose nothing, the giveaway ends when you'd like to end it.<br></small><br></label></div><div class="col-md-6"><input type="date" name="g_timeleft"><div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">I'd like to end the giveaway on my own</label></div></div></div></div><div class="container"><hr><div class="row"><div class="col-md-6"><strong>Attention: Please decide!<br><br></strong><label class="form-label">Would you like to send the Winner message via Webhook or our bot? <strong>(Webhook only available right now)</strong>*:</label></div><div class="col-md-6"><select disabled="" name="g_webhook" value="true"><option value="true" selected="">Webhook</option><option value="false">Bot</option></select></div></div></div><div class="container"><hr><div class="row"><div class="col-md-6"><label class="col-form-label">If choosen Webhook, please enter the Webhook URL for the Channel*:<br>More help <a href="https://support.discord.com/hc/en-us/articles/228383668-Intro-to-Webhooks" target="_blank">here</a>!<br></label></div><div class="col-md-6"><input type="url" placeholder="https://discord.com/api/webhooks/XXX" name="g_webhook_url" style="width: 400px;"></div></div></div><div class="text-center justify-content-center text-center"><button class="btn btn-success" type="submit">Create Giveaway!</button></form></div><footer class="text-center d-block footer-basic position-sticky"><ul class="list-inline"><li class="list-inline-item"><a href="index.html">Home</a></li><li class="list-inline-item"><a href="#">Other Services</a></li><li class="list-inline-item"><a href="https://github.com/Ente" target="_blank">GitHub</a></li><li class="list-inline-item"><a href="#">Terms</a></li><li class="list-inline-item"><a href="#">Privacy Policy</a></li></ul><p class="copyright">GiveawayD x Ente © 2021</p></footer><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
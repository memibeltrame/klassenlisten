<?php


$roles = $GLOBALS['roles'];
$brand = $GLOBALS['brand'];
$application = $GLOBALS['application'];
$config = $GLOBALS['config'];
$db = $GLOBALS['db'];


require_once( 'Facebook/FacebookSession.php' );
require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
require_once( 'Facebook/FacebookRequest.php' );
require_once( 'Facebook/FacebookResponse.php' );
require_once( 'Facebook/FacebookSDKException.php' );
require_once( 'Facebook/FacebookRequestException.php' );
require_once( 'Facebook/FacebookAuthorizationException.php' );
require_once( 'Facebook/GraphObject.php' );
require_once( 'Facebook/GraphUser.php' );

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;


// init app with app id and secret
FacebookSession::setDefaultApplication('573965516035861', '24e2938e44debe32f4bba29ecdf4f9c1');

$url = "http://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]";

$helper = new FacebookRedirectLoginHelper($url, $apiVersion = NULL);
try {
    $session = $helper->getSessionFromRedirect();
} catch(FacebookRequestException $ex) {
    // When Facebook returns an error

    echo "facebook fehler";
    echo $ex;


} catch(\Exception $ex) {
    // When validation fails or other local issues
    echo $ex;
}
if ($session) {
  $_SESSION['loggedIn'] = true ;
  $me = (new FacebookRequest(
    $session, 'GET', '/me'
  ))->execute()->getGraphObject(GraphUser::className());

    $stmt = $db->prepare('
         Select is_admin, fach from people where facebook_id = '.$me->getId().' ;
    ');
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    $is_admin = $row['is_admin'];
    $fach = $row['fach'];


    $email = $me->getProperty('email');


    $is_dozent = checkDozent($email, $db);

   $user = array("name" => $me->getName(), "id" => $me->getId(), "fach" => $fach, "is_admin" => $is_admin, "is_dozent" => $is_dozent);
   $_SESSION['user'] = $user;
   setcookie("user",serialize($user), time()+60*60*24*700);

  return;
}

?>
<body>
        <div class="container">
            <br>
            <div class="row">
                <span class="col-md-6 col-xs-12">
                    <h1>
                        <a href="<?php echo $helper->getLoginUrl() ;?>"><i class="fa fa-facebook-square"></i> Mit Facebook einloggen</a>
                    </h1>

                        <a href="javascript:history.back()">Zurück</a>
                </span>
                <span class="col-md-6">

                </span>
            </div>
            <br>


            <?php //include("./snippets/loginForm.php");?>
            <br><br>
            <?php // this includes the footer
            include('./snippets/footer.php');?>

        </div> <!-- /container -->

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php

        // This includes the needed javascript files
        // DO NOT REMOVE
        include ('./snippets/meta_javascripts.php');?>
  </body>
</html>
<?php die(); ?>

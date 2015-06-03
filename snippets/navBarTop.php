<?php
// Define Navigation keys
// You can use these to specify which item should be active


$stmt = $db->prepare("
        Select * from klassen where aktiv = 1 and typ != 'Dozenten' order by id, bis;
 ");

    $result = $stmt->execute();
    $naviklassen = getSqliteArray($result);

$stmt = $db->prepare('
        Select * from klassen where aktiv = 0 order by bis;
 ');

    $result = $stmt->execute();
    $archivklassen = getSqliteArray($result);


$navKeys = array();

foreach ($naviklassen as $key => $naviklasse) {
    $navKeys[] = $naviklasse['id'];
}

// LEAVE ALONE
$navbarClasses = array_fill(0, 10, '');
foreach ($navKeys as $key => $item){
    if($item == $activeNavigation) {
        $navbarClasses[$key] = "active";
    }
 }
?>

<header role="banner" class="navbar navbar-default  ">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#headernav">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">SfGBB Klassenlisten</a>
    </div>
    <nav role="navigation" class="collapse navbar-collapse " id="headernav" >
      <ul class="nav navbar-nav">
        <?php foreach ($naviklassen as $key => $naviklasse) {?>

        <li  class="<?php echo $navbarClasses[$key];?>">
          <a href="index.php?aktiveListe=<?php echo $naviklasse['id'] ;?>"><?php echo $naviklasse['kuerzel'] ;?></a>
        </li>
        <?php } ?>
        <li  class="<?php echo $navbarClasses[3];?>">
          <a href="index.php?aktiveListe=dozenten">Dozenten</a>
        </li>
        <li  class="<?php echo $navbarClasses[4];?>">
          &nbsp;
        </li>

        <li class="dropdown">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Archiv <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <?php foreach ($archivklassen as $key => $archivklasse) {?>

            <li><a href="index.php?aktiveListe=<?php echo $archivklasse['id'] ;?>"><?php echo $archivklasse['kuerzel'] ;?></a></li>

        <?php } ?>

          </ul>
        </li>
        <?php if($is_admin) {?>
        <li  class="<?php echo $navbarClasses[4];?>">
            <a href="admin.php">Admin</a>
        </li>
        <?php } ?>
      </ul>
      <?php if(!empty($isLoggedIn)) { ?>
          <ul class="nav navbar-nav navbar-right">
              <!-- <li class="" ><a href="" class="" ><i class="icon-user"></i> <?= $_SESSION['user']['name']; ?></a></li> -->
              <li>

                <a href="index.php?logout=true">Logout</a>
              </li>
          </ul>
        <?php } else { ?>

          <ul class="nav navbar-nav navbar-right">
              <li>


              </li>
          </ul>
          <?php }?>

    </nav>
  </div>
</header>
<?php //include("./snippets/fblogin.html");?>
<!-- <div id="fb-root"></div> -->
<!-- <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="true"></div> -->

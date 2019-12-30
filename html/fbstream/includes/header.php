<?php
initSession();
$userSQL = "SELECT * FROM `user_info` WHERE `user_id`='".$_SESSION['userid']."'";
$userResult = mysql_query($userSQL);
$userRow = mysql_fetch_array($userResult);
if ($userRow['user_pic']!='') {
	$currUserImageMin = 'userData/'.$_SESSION['userid'].'/userImage/user_'.$_SESSION['userid'].'_48x48'.$userRow['user_pic'];
	$time = time();
    $imagePath = "/{$currUserImageMin}?{$time}";
} else {
	$imagePath = "/images/user_66x66.png";
}

if(IS_BRANDED) {
	$logoImage = "/images/bs-images/logo-branded-blue.png";
} else {
	$logoImage = "/images/bs-images/logo.png";
}

?>
<nav class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/" style="padding: 7px;"><img id="logo" src="<?php echo $logoImage; ?>" alt="Streemin" width="150" height="40"></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/search">Watch</a></li>
				<?php if ($_SESSION['userid']) {?>
				<li class="active"><a href="/broadcaster">Go Live</a></li>
				<?php } else { ?>
				<li class="active"><a href="#" data-toggle="modal" data-target="#login-modal" >Go Live</a></li>
				<?php } ?>
				<li><div class="vr hidden-xs"></div></li>
				<?php if ($_SESSION['userid']) {?>
				<li class="dropdown ">
					<a href="#" class="dropdown-toggle no-padding" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="rectPic">
							<img src="<?php echo $imagePath; ?>" width="50" height="50" alt="">
						</span>
						
						<span class="caret"></span>
					</a>
					<span style="font-size:17px;color:grey;">MENU</span>
					<ul class="dropdown-menu ">
						<li>
							<a  id="menuUN" href="/dashboard"><?php echo $userRow['user_name']; ?></a>
						</li>
						<li class="divider"></li>
						<li><a  href="/dashboard">Dashboard</a></li>
						<li class="divider"></li>
						<li><a href="/profile">Your profile</a></li>
						<li class="divider"></li>
						<li><a id="logout" href="/logout">Log out</a></li>
					</ul>
				</li>
				<?php } else { ?>
				<li><a id="loginBut3" data-toggle="modal" data-target="#login-modal"  class="login">Log in</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>
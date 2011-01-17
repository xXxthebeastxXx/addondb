<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: book_of_condolences.php
| Author: PHP-Fusion Addons Team
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include INFUSIONS."book_of_condolences/infusion_db.php";

if (file_exists(INFUSIONS."book_of_condolences/locale/".$settings['locale'].".php")) {
	include INFUSIONS."book_of_condolences/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."book_of_condolences/locale/English.php";
}

add_to_title(" | ".$locale['m4n_012']);
add_to_head('<link type="text/css" rel="stylesheet" href="css/styles.css" />');
if (isset($_GET['rowstart']) && isnum($_GET['rowstart'])) {
	$rowstart = $_GET['rowstart'];
} else {
	$rowstart = 0;
}

$limit = "20";

$counter = (dbcount("(m4n_id)", DB_CONDOLENCES, "m4n_status ='1'"));
?>

<div id="condolences">
	<img src="img/4.png" alt="Nick Jones" title="<?php echo $locale['m4n_012']; ?>" />
    <p style="margin:350px 40px 0 40px; text-align:justify; color:#FFF"><?php echo $locale['m4n_022']; ?></p>
</div>

<?php
$result = dbquery("
	SELECT a.m4n_id, a.m4n_user, a.m4n_text, u.user_id, u.user_name, u.user_status 
	FROM ".DB_CONDOLENCES." a 
	LEFT JOIN ".DB_USERS." u ON u.user_id=a.m4n_user 
	WHERE a.m4n_status = '1' 
	ORDER BY m4n_datestamp 
	DESC LIMIT $rowstart,$limit
");

opentable($locale['m4n_001']);
if (dbrows($result)): ?>
<div class="grid_12 tbl-border alpha">
	<?php while($data = dbarray($result)): ?>
	<?php $text = nl2br(censorwords($data['m4n_text'])); ?>
	<blockquote style="margin:40px">
		<p><?php echo preg_replace('/\[\/?[a-z(=|#)?0-9]+\]/si', '', $text); ?></p>
		<cite>&ndash; <?php echo profile_link($data['user_id'], $data['user_name'], $data['user_status']); ?></cite>
	</blockquote>
	<?php endwhile ?>
    <?php  if ($counter > $limit) { echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart, $limit, $counter, 3)."</div>"; } ?>
</div>
<?php endif;
closetable();

if (iMEMBER) {
	$status = "0";
	$entry_check = (dbcount("(m4n_id)", DB_CONDOLENCES, "m4n_user ='".$userdata['user_id']."'"));
	if (!$entry_check) {
		if (isset($_POST['cond_send'])) {
			if (isset($_POST['m4n_text'])) {
				$text = stripinput($_POST['m4n_text']);
				$result = dbquery("INSERT INTO  ".DB_CONDOLENCES." (m4n_user, m4n_status, m4n_admin, m4n_text, m4n_datestamp) VALUES ('".$userdata['user_id']."', '0', '0', '".$text."', '".time()."')");
			}
			$status = "1";
		}
		if ($status == '1') {
			opentable($locale['m4n_024']);
			echo "<div align='center'><br />".$locale['m4n_025']."<br/></div>\n";
			echo "<br /><a href='".FUSION_SELF."'>".$locale['m4n_026']."</a><br />";
			closetable();
		} else { ?>

<div class="grid_11 omega tbl-border">
	<?php opentable($locale['m4n_014']); ?>
	<form id="cond_send" name="cond_send" method="post" action="<?php echo FUSION_SELF ?>">
		<label for="m4n_text"><?php echo $locale['m4n_010'] ?></label>
		<textarea name="m4n_text" id="m4n_text" cols="50" rows="5" style="margin:10px 0"></textarea>
		<button type="submit" name="cond_send" class="button"><span><?php echo $locale['m4n_015']; ?></span></button>
	</form>
	<?php closetable(); ?>
</div> <?php
		}
	} else {
		?>

<div class="grid_11 omega tbl-border">
	<?php opentable($locale['m4n_014']); ?>
	<form id="cond_send" name="cond_send" method="post" action="<?php echo FUSION_SELF ?>" style="opacity:.5">
		<label for="m4n_text"><?php echo $locale['m4n_029']; ?></label>
		<textarea name="m4n_text" id="m4n_text" cols="50" rows="5" style="margin:10px 0" disabled="disabled"></textarea>
		<button type="submit" name="cond_send" class="button" disabled="disabled"><span><?php echo $locale['m4n_015']; ?></span></button>
	</form>
	<?php closetable(); ?>
</div> <?php
	}
}  else {
		?>

<div class="grid_11 omega tbl-border">
	<?php opentable($locale['m4n_014']); ?>
	<form id="cond_send" name="cond_send" method="post" action="<?php echo FUSION_SELF ?>" style="opacity:.5">
		<label for="m4n_text">Login to submit your Condolences.</label>
		<textarea name="m4n_text" id="m4n_text" cols="50" rows="5" style="margin:10px 0" disabled="disabled"></textarea>
		<button type="submit" name="cond_send" class="button" disabled="disabled"><span><?php echo $locale['m4n_015']; ?></span></button>
	</form>

	<?php closetable(); ?>
</div> <?php

	}
	
if (!isset($_GET['rowstart'])) {
echo "<script>var condolences_p = true;</script>";
}
require_once THEMES."templates/footer.php";
?>
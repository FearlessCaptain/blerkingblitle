<?php  include_once 'header.php'; include_once 'includes\loadThread-inc.php'; include_once 'includes\dbh-inc.php';?>
<br>
<section class="thread-container">
	<div class="thread-content">

		<?php
		 	if (!isset($_SESSION['u_username'])){
				header("Location: index.php?error=logintoaccess");
			}
			?>

			<div class="thread-view">

				<div class="threadtitle-view">
					<p class="threadTitleC"><b><?= getTitle($conn, $_GET['threadid']);?></b></p>
					<p class="threadTitleC"><b>Posted by:</b> <?php getPoster($conn, $_GET['threadid']);?></p>
					<p class="threadTitleC"><a class="nav-button" href="postreply.php?threadid=<?php echo $_GET['threadid'];?>">Post Reply</a></p>
				</div>

				<br>

				<?php
					getThread($conn, $_GET['threadid'], $_SESSION['u_role']);
				?>
				<p><a class="nav-button"  href="postreply.php?threadid=<?php echo $_GET['threadid'];?>">Post Reply</a></p>
			</div>

	</div>
</section>
<?php  include_once 'footer.php'; ?>

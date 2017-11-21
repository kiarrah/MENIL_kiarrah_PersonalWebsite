<footer>
	<div class="container">
		<div class="row">
			<div class="four columns">
				<h5>GET CONNECTED</h5>
				<p>Connect with Hamit Hotel &amp; Suites on social media.</p>
				<div class="social-icons">
					<a href="#" class="socicon-facebook"></a>
					<a href="#" class="socicon-twitter"></a>
					<a href="#" class="socicon-googleplus"></a>
					<a href="#" class="socicon-youtube"></a>
				</div>
			</div>
			<div class="four columns">
				<h5>GET IN TOUCH</h5>
				<p>Contact our staff Kiarrah &amp; Pauline if you have any questions regarding accommodation or our location on beautiful Mt Apo.</p>
				<p>
					<i class="material-icons">&#xE0C8;</i>&nbsp;&nbsp;&nbsp;Mt. Apo
					<br/><i class="material-icons">&#xE0CF;</i>&nbsp;&nbsp;&nbsp;+63 91 2345 6789
					<br/><i class="material-icons">&#xE0D0;</i>&nbsp;&nbsp;&nbsp;info@hamit.com
				</p>
			</div>
			<div class="four columns">
				<h5>RATINGS AND REVIEWS</h5>
				<p>Hamit Hotel &amp; Suites was named in the top 10 hotels in Philippines as part of the TripAdvisor 2017 Travellers' Choice Awards.</p>
				<a href="#" class="tripadvisor">
					<div class="socicon-tripadvisor"></div>
					<div>
						<div>tripadvisor</div>
						<div>travellers choice 2017</div>
					</div>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="eight columns">
				<div class="copyright">Copyright Hamit Hotel &amp; Suites © 2017. All Rights Reserved.</div>
			</div>
			<div class="four columns">

				<?php if (isset($_SESSION['account']) && $_SESSION['account']['level'] == 'ADMIN') { ?>
				<a class="login" href="<?php pUrl() ?>/logout.php">Logout</a>
				<a class="login" href="<?php pUrl() ?>/admin">Admin Panel</a>
				<?php } else if (isset($_SESSION['account'])) { ?>
				<a class="login" href="<?php pUrl() ?>/logout.php">Logout</a>
				<?php } else if (!isset($_SESSION['account'])) { ?>
				<a class="login" href="<?php pUrl() ?>/login.php">Login</a>
				<?php } ?>
				
			</div>
		</div>
	</div>
</footer>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="js/date.format.js"></script>
<script type="text/javascript" src="js/reservation.js"></script>
<script type="text/javascript" src="js/script.js"></script>
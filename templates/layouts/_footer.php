			<footer id="footer" class="block">
				<div class="row">
					<div class="desktop-4 tablet-3 mobile-2 min-half">
						<div class="logo_footer">
							Neustadt Creative Marketing
						</div>
						<div class="info">
							<span class="address">
								1714 Eastern Avenue<br/>
								Baltimore, MD 21231<br/>
							</span>
							<span class="phone">
								tel 410-825-7660
							</span>
							<span class="fax">
								fax 410-825-7650
							</span>
							<span class="email">
								<a href="mailto:info@ncmark.com">info@ncmark.com</a>
							</span>
						</div>
					</div>
					<div class="desktop-8 tablet-3 mobile-1 min-half">
						<div class="social">
							<a href="http://twitter.com/NeustadtCreativ" class="twitter" target="_blank">NCM on Twitter</a>
							<a href="http://www.facebook.com/NeustadtCreativeMarketing" class="facebook" target="_blank">NCM on Facebook</a>
							<a href="<?=$cms->getLink(20)?>" class="blogs">NCM Blog</a>
							<a href="<?=$cms->getLink(21)?>" class="mark">Mark's Blog</a>
						</div>
					</div>
					<div class="desktop-12 tablet-6 mobile-full bottom">
						<span class="copyright">&copy; <?=date("Y")?> Neustadt Creative Marketing. All Rights Reserved.</span>
						<a href="http://www.door2agency.com/" target="_blank"><div class="door2">Door No. 2</div></a>
					</div>
				</div>
			</footer>
		</div>
		<div class="nav_slider_navigation">
			<nav id="navigation_mobile">
				<? 
					$mobileNav = $cms->getNavByParent(0, 10);
					recurseNav($mobileNav);
				?>
			</nav>
		</div>
	</body>
</html>
<header id="header" class="page-topbar">
	<!-- start header nav-->
	<div class="navbar-fixed">
		<nav class="navbar-color">
			<div class="nav-wrapper">
				<ul class="left">                      
				  <li><h1 class="logo-wrapper"><a href="index.html" class="brand-logo darken-1"><img src="images/materialize-logo.png" alt="materialize logo"></a> <span class="logo-text">Materialize</span></h1></li>
				</ul>
				<div class="header-search-wrapper hide-on-med-and-down">
					<i class="mdi-action-search"></i>
					<input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Find Boards"/>
				</div>
				<ul class="right hide-on-med-and-down">
					<li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
					</li>
					
				</ul>
			</div>
		</nav>
		 <nav id="horizontal-nav" class="white hide-on-med-and-down">
			<div class="nav-wrapper">                  
			  
			</div>
		  </nav>
	</div>
</header>

<aside id="left-sidebar-nav hide-on-large-only">
    
</aside>

<!-- START MAIN -->
<div id="main">
	<div class="wrapper">
		<section id="content">
			<div class="container">
				<div class="section">
					<div id="card-stats">
						<div class="colListUser" id="colList" style="">
							<div class="card">
								<div class="card-content grey lighten-2 white-text" style="height:100%;">
									<p class=" grey-text text-darken-4 truncate" style="font-weight:bold;font-size:150%;">List<a href="javascript:void(0);" onclick="#" class="black-text"><i class="mdi-navigation-more-vert right"></i></a></p>
									<div id="list1" class="listUser dropable sortable" style="height:100%;min-height:60px;width:100%;">
										<div class="dragable cDrag1 cardUser1" id="cDrag1" style="width:100%;height:100%;">
											<a id="card'.$c->cardId.'" href="javascript:void(0);" class="aCardUserLabel" onclick="ajaxModalCard(1)">
												<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">
													<div class="left-align black-text" style="word-wrap:break-word;" id="cardTitle'.$c->cardId.'">Satu</div>
												</div>
											</a>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
					<div style="width:25%;">
					    <table class="bordered">
					    	<tr>
					    		<th>Nama User</th>
					    		<th>Email</th>
					    	</tr>
					    	{% for item in page.items %}
					    		<tr>
					    			<td>{{item.userName}}</td>
					    			<td>{{item.userEmail}}</td>
					    		</tr>
					    	{% endfor %}
					    </table>
					    <a href="testBoard" class="black-text">First</a> - <a href="testBoard?currentPage={{page.before}}" class="black-text">Previous</a> - <a href="testBoard?currentPage={{page.next}}" class="black-text">Next</a>
					    <p> You are in page {{page.current}} from {{page.total_pages}} Page</p>
					</div>
				</div>
			</div>
		</section>

	</div>
	<!-- END WRAPPER -->
</div>
<!-- END MAIN -->

<!-- START HEADER -->
<header id="header" class="page-topbar">
	<!-- start header nav-->
	<div class="navbar-fixed">
		<nav class="navbar-color">
			<div class="nav-wrapper">
				<ul class="left">                      
				  <li><h1 class="logo-wrapper"><a href="home" class="brand-logo darken-1"><img src="images/materialize-logo.png" alt="materialize logo"></a> <span class="logo-text">Materialize</span></h1></li>
				</ul>
				<div class="header-search-wrapper hide-on-med-and-down">
					<i class="mdi-action-search"></i>
					<input type="text" id="txtFindBoards" name="Search" class="header-search-input z-depth-2" placeholder="Find Boards"/>
				</div>
				<ul class="right hide-on-med-and-down">
					<li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
					</li>
					<li><a href="javascript:void(0);" class="waves-effect waves-block waves-light translation-button"  data-activates="translation-dropdown"><img src="<?php 
		                    if(strpos($user->userImage,"userImage") !== false)
		                    {
		                   		echo $user->userImage."?".filemtime($user->userImage); 
		                    }
		                    else if(strpos($user->userImage,"googleusercontent.com") !== false)
		                    {
		                    	echo $user->userImage;
		                    }
		                    else
		                    {
		                    	echo "userImage/user.jpg";
		                    }

		                    ?>" width="32px" height="32px" style="border-radius:50%" /></a>
					</li>
				</ul>
				<!-- translation-button -->
				<ul id="translation-dropdown" class="dropdown-content">
				  <li>
					<a href="userProfile?userId=<?php echo $user->userId ?>"><img src="<?php 
		                    if(strpos($user->userImage,"userImage") !== false)
		                    {
		                   		echo $user->userImage."?".filemtime($user->userImage); 
		                    }
		                    else if(strpos($user->userImage,"googleusercontent.com") !== false)
		                    {
		                    	echo $user->userImage;
		                    }
		                    else
		                    {
		                    	echo "userImage/user.jpg";
		                    }

		                    ?>" width="32px" height="32px" alt="Profile" />  <span class="language-select">Profile</span></a>
				  </li>
				  <li>
					<a href="javascript:void(0);" onclick="cekLogout()"><img src="images/user/logout.png" width="32px" height="32px" alt="French" />  <span class="language-select">Log Out</span></a>
				  </li>
				  
				</ul>
			</div>
		</nav>

		<!-- HORIZONTL NAV START-->
		 <nav id="horizontal-nav" class="white hide-on-med-and-down">
			<div class="nav-wrapper">                  
			  <ul id="ul-horizontal-nav" class="left hide-on-med-and-down">
				<li>
					<a href="home" class="cyan-text">
						<i class="mdi-action-dashboard"></i>
						<span>Home</span>
					</a>
				</li>
			  </ul>
			</div>
		  </nav>
		<!-- HORIZONTL NAV END-->
	</div>
	<!-- end header nav-->
</header>
<!-- END HEADER -->

<!-- START LEFT SIDEBAR NAV-->
<aside id="left-sidebar-nav hide-on-large-only">
    <ul id="slide-out" class="side-nav leftside-navigation ">
        <li class="user-details cyan darken-2">
            <div class="row">
                <div class="col col s4 m4 l4">
                    <img src="<?php 
		                    if(strpos($user->userImage,"userImage") !== false)
		                    {
		                   		echo $user->userImage."?".filemtime($user->userImage); 
		                    }
		                    else if(strpos($user->userImage,"googleusercontent.com") !== false)
		                    {
		                    	echo $user->userImage;
		                    }
		                    else
		                    {
		                    	echo "userImage/user.jpg";
		                    }

		                    ?>" alt="" class="circle responsive-img valign profile-image">
                </div>
                <div class="col col s8 m8 l8">
                    <a class="dropdown-button waves-effect waves-light profile-btn white-text" href="#" disabled><?php echo $user->userName ?><i class="mdi-navigation-arrow-drop-down right"></i></a>
                </div>
            </div>
        </li>
        <li class="bold active"><a href="home" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> Home</a>
        </li>
        <div class="divider"></div>
        <li class="bold active"><a href="userProfile?userId=<?php echo $userId ?>" class="waves-effect waves-cyan">Profile</a>
        </li>
        <li class="bold active"><a onclick="cekLogout()" class="waves-effect waves-cyan">Log Out</a>
        </li>
    </ul>
    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
</aside>
<!-- END LEFT SIDEBAR NAV-->


<!-- START MAIN -->
<div id="main">
	<!-- START WRAPPER -->
	<div class="wrapper">

		<!-- START CONTENT -->
		<section id="content">

			<!--start container-->
			<div class="container">
				<!-- trello start here -->
				<div class="section">
				<!-- PROFILE -->
		        <div id="profile-page" class="section">
		            <!-- profile-page-header -->
		            <div id="profile-page-header" class="card">
		                <div class="card-image waves-effect waves-block waves-light">
		                    <img class="" src="images/user-profile-bg.jpg" alt="user background">                    
		                </div>
		                <figure class="card-profile-image">
		                </figure>
		                <div class="card-content" style="margin-top:6px;">
		                  <div class="row">
		                    <div class="col s5 m4 l2">
		                    
    		                    <img id="groupImage" src="<?php 
    		                    if(strpos($groupUser->groupImage,"groupImage") !== false)
    		                    {
    		                   		echo $groupUser->groupImage."?".filemtime($groupUser->groupImage); 
    		                    }
    		                    else if(strpos($groupUser->groupImage,"googleusercontent.com") !== false)
    		                    {
    		                    	echo $groupUser->groupImage;
    		                    }
    		                    else
    		                    {
    		                    	echo "groupImage/group.png";
    		                    }
    
    		                    ?>" alt="profile image" style="width:100px;height:100px;margin-left:10%;" class="circle">
		                    </div>
		                    <div class="col s3 m4 l8">                        
		                        <h4 class="card-title grey-text text-darken-4"><b><?= $groupUser->groupName ?></b></h4>
		                        <p class="medium-small grey-text"><?= $groupUser->groupWebsite ?></p>                        
		                    </div>
		                  </div>
		                  <div class="row">
		                    <div class="col s3 center-align">
		                        <h4 class="card-title grey-text text-darken-4">
		                        	<?php $total = 0; ?>
		                        	<?php foreach ($board as $b) { ?>
			                        	<?php foreach ($boardGroup as $bg) { ?>
			                        		<?php if ($bg->boardId == $b->boardId) { ?>
			                        			<?php $total += 1; ?>
			                        		<?php } ?>
			                        	<?php } ?>
		                        	<?php } ?>
		                        	<?php if ($total > 10) { ?>
		                        		<?= '10+' ?>
		                        	<?php } else { ?>
		                        		<?= $total ?>
		                        	<?php } ?>
		                        </h4>
		                        <p class="medium-small grey-text">Boards</p>                        
		                    </div>
		                    <div class="col s3 center-align">
		                        <h4 class="card-title grey-text text-darken-4">
	                        	<?php $total = 0; ?>
	                        	<?php foreach ($groupMember as $g) { ?>
	                        		<?php $total += 1; ?>
	                        	<?php } ?>
	                        	<?= $total ?>
		                    	</h4>
		                        <p class="medium-small grey-text">Members</p>                        
		                    </div>                   
		                    <div class="col s6 center-align">
		                        <h4 class="card-title grey-text text-darken-4"><?php echo date_format(date_create($groupUser->groupCreated),"d F Y"); ?></h4>
		                        <p class="medium-small grey-text">Created</p>                        
		                    </div>
		                   </div>
		                  </div>
		                </div>
		            </div>
		            <!--/ profile-page-header -->

		            <!-- profile-page-content -->
		            <div id="profile-page-content" class="row">
		              <!-- profile-page-sidebar-->
		              <div id="profile-page-sidebar" class="col s12 m6">
		                <!-- Profile About  -->
		                <div class="card white" <?php
		                	if($owner == "true" && $role == "Admin")
		                	{
		                		echo "style='display:block;'";
		                	}
		                	else
		                	{
		                		echo "style='display:none;'";
		                	}
		                ?>>
		                  <div class="card-content black-text">
		                    <span class="card-title"><b>Invite Member</b></span>
		                    <div class="input-field">
		                          <input type="email" id="inviteEmail">
		                          <label for="email">Email</label>
							</div>
							<div class="input-field right-align" style="margin-bottom:15px;">
								<p id="wait" style="display:none;"><b>Please wait..</b></p>
	                        	<a onclick="createInvite()" href="javascript:void(0);" class="btn waves-effect waves-light green darken-1">Invite<i class="mdi-content-send right"></i></a>
	                         </div>
	                         <div id="ajaxMember">
	                         	<?php
	                         		foreach($groupMember as $gm)
	                         		{
	                         			foreach($listUserProfile as $prof)
	                         			{
	                         				if($gm->userId == $prof->userId)
	                         				{

		                         				$directory = $prof->userImage;
		                         				$name = $prof->userName;
		                         				$userId = $prof->userId;
			                         			echo '<div class="row">';
			                         			echo '<div class="col s6 m4 l1">';
			                         			echo '<img src="'.$directory.'" style="border-radius:50%;margin-left:10px;" width="32px" height="32px" alt="Profile" />';
			                         			echo '</div>';
			                         			echo '<div class="col s6 m8 l11">';
			                         			echo '<div style="margin-top:5px;"><a href="userProfile?userId='.$userId.'">'.$name.'</a> ('.$gm->memberRole.')';
			                         			if($gm->memberRole == "Admin")
			                         			{
			                         				if($user->userId != $gm->userId)
			                         				{
			                         					echo ' -<a href="javascript:void(0);" onclick="changeMemberToMember(\''.$gm->userId.'\')" class="green-text lighten-2 ultra-small"> Change to Member</a>';
			                         				}
			                         			}
			                         			else if($gm->memberRole == "Member")
			                         			{
			                         				echo ' -<a href="javascript:void(0);" onclick="changeMemberToAdmin(\''.$gm->userId.'\')" class="green-text lighten-2 ultra-small"> Change to Admin</a>';
			                         			}
			                         			if($user->userId != $gm->userId)
		                         				{
		                         					echo ' -<a href="javascript:void(0);" onclick="removeMember(\''.$gm->userId.'\')" class="red-text lighten-2 ultra-small"> Remove</a>';
		                         				}
			                         			echo '</div>';
			                         			echo '</div>';
			                         			echo '</div>';
	                         				}
	                         			}
	                         		}
	                         	?>
	                         </div>
		                  </div>                  
		                </div>
		                <div class="card white"<?php
		                	if($owner == "true" && $role == "Admin")
		                	{
		                		echo "style='display:block;'";
		                	}
		                	else
		                	{
		                		echo "style='display:none;'";
		                	}
		                ?>>
		                  <div class="card-content black-text">
		                    <span class="card-title"><b>Edit Group Profile</b></span>
		                   		<input type="hidden" id="hiddenUserId" value="<?php echo $user->userId?>">
		                    	<input type="hidden" id="hiddenGroupId" value="<?php echo $groupUser->groupId?>">
		                        <div class="input-field">
		                          <input type="text" value="<?php echo $groupUser->groupName; ?>" id="groupName">
		                          <label for="groupName">Name</label>
		                        </div>
		                        <label class="red-text" style="display:none;" id="errorName">Name at least 3 characters.</label>
		                        <div class="input-field">
		                          <textarea class="materialize-textarea" length="120" id="groupDescription"><?php echo $groupUser->groupDescription; ?></textarea>
                          		  <label for="groupDescription">Description</label>
		                        </div>
		                        <div class="input-field">
		                          <input id="groupWebsite" type="email" class="validate" value="<?php echo $groupUser->groupWebsite; ?>">
		                          <label for="groupWebsite">Website</label>
		                        </div>
		                        <div class="input-field">
		                          <input type="text" value="<?php echo $groupUser->groupLocation ?>" id="groupLocation">
		                          <label for="groupLocation">Location</label>
		                        </div>
		                        <div class="input-field right-align" style="margin-bottom:15px;">
		                        	<a onclick="changeData()" class="btn waves-effect waves-light red">Change Profile<i class="mdi-content-send right"></i></a>
		                          </div>
		                        <div class="divider"></div>
		                    	<div class="file-field input-field">
			                      <div class="btn">
			                        <span>File</span>
			                        <input type="file" id="inputImage">
			                      </div>
			                      <div class="file-path-wrapper">
			                        <input class="file-path validate" type="text">
			                      </div>
			                    </div>
			                    <label class="red-text" style="display:none;" id="errorImage">File is not supported.</label>
		                        <div class="input-field right-align" style="margin-bottom:15px;">
		                        	<a onclick="changeProfile()" href="javascript:void(0);" class="btn waves-effect waves-light green">Change Image<i class="mdi-content-send right"></i></a>
		                        </div>
		                  </div>                  
		                </div>
		                <div class="card white"<?php
		                	if($owner == "true")
		                	{
		                		echo "style='display:block;'";
		                	}
		                	else
		                	{
		                		echo "style='display:none;'";
		                	}
		                ?>>
		                  <div class="card-content black-text">
		                    <span class="card-title"><b>Setting Group</b></span>
		                      <div class="input-field">
	                        	<a onclick="leaveGroup()" class="btn waves-effect waves-light red">Leave group<i class="mdi-content-send right"></i></a>
		                      	<?php
		                      		if($role == "Admin")
		                      		{
		                      			echo '<a onclick="deleteGroup()" class="btn waves-effect waves-light red">Delete group<i class="mdi-content-send right"></i></a>';
		                      		}
		                      	?>
	                          </div>
		                  </div>                  
		                </div>
		                <!-- Profile About  -->

		              </div>
		              <!-- profile-page-sidebar-->

		              <!-- profile-page-wall -->
		              <div class="col s12 m6">
                        <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                          <li class="active">
                            <div class="collapsible-header"><i class="mdi-communication-live-help"></i> Members</div>
                            <div class="collapsible-body" style="display: none;">
                              <p>
                              	<b><u>Members</u></b></br>
                              	<?php foreach ($groupMember as $g) { ?>
                              		<?php if ($g->memberStatus == '1') { ?>
                              			<?php foreach ($listUser as $lu) { ?>
                              				<?php if ($g->userId == $lu->userId) { ?>
                              				- <a href='userProfile?userId=<?= $g->userId ?>'><?= $lu->userName ?></a></br>
                              				<?php } ?>
                              			<?php } ?>
                              		<?php } ?>
                              	<?php } ?>
                              </p>
                            </div>
                          </li>
                          <li class="active">
                            <div class="collapsible-header"><i class="mdi-communication-live-help"></i> Boards</div>
                            <div class="collapsible-body" style="display: none;">
                              <p>
                              	<b><u>Boards</u></b></br>
                              	<?php foreach ($board as $b) { ?>
                              		<?php foreach ($boardGroup as $bg) { ?>
                              			<?php if ($bg->boardId == $b->boardId) { ?>
                              				- <a href='board?id=<?= $b->boardId ?>'><?= $b->boardTitle ?></a></br>
                              			<?php } ?>
                              		<?php } ?>
                              	<?php } ?>
                              </p>
                            </div>
                          </li>
                          <li>
                            <div class="collapsible-header active"><i class="mdi-communication-email"></i> Profile</div>
                            <div class="collapsible-body" style="">
                              <p>
			                    	<b id="visitGroupName"><?= $groupUser->groupName ?></b></br>
			                    	<u><?= $groupUser->groupWebsite ?><?php echo $groupUser->groupWebsite ?></u>
                              </p>
                              <div class="divider"></div>
                              <p id="visitGroupBio" style="margin-top:-25px;"> 
                              	<b><u>Description</u></b></br>
                              	<?= $groupUser->groupDescription ?></br></br>
                              	<b><u>Website</u></b></br>
                              	<?= $groupUser->groupWebsite ?></br></br>
                              	<b><u>Location</u></b></br>
                             	<?= $groupUser->groupLocation ?></br></br>
                              </p>
                            </div>
                          </li>
                        </ul>
                      </div>
		              <!--/ profile-page-wall -->

		            </div>
		        </div>
			</div>
			<!--end container-->
		</section>
		<!-- END CONTENT -->

	</div>
	<!-- END WRAPPER -->
</div>
<!-- END MAIN -->
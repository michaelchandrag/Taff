<header id="header" class="page-topbar">
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
		                    if(strpos($userProfile->userImage,"userImage") !== false)
		                    {
		                   		echo $userProfile->userImage."?".filemtime($userProfile->userImage); 
		                    }
		                    else if(strpos($userProfile->userImage,"googleusercontent.com") !== false)
		                    {
		                    	echo $userProfile->userImage;
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
					<a href="userProfile?userId=<?php echo $userId ?>"><img src="<?php 
		                    if(strpos($userProfile->userImage,"userImage") !== false)
		                    {
		                   		echo $userProfile->userImage."?".filemtime($userProfile->userImage); 
		                    }
		                    else if(strpos($userProfile->userImage,"googleusercontent.com") !== false)
		                    {
		                    	echo $userProfile->userImage;
		                    }
		                    else
		                    {
		                    	echo "userImage/user.jpg";
		                    }

		                    ?>" width="32px" height="32px" alt="Profile" />  <span class="language-select">Profile</span></a>
				  </li>
				  <li>
					<a onclick="cekLogout()"><img src="images/user/logout.png" width="32px" height="32px" alt="French" />  <span class="language-select">Log Out</span></a>
				  </li>
				  
				</ul>
			</div>
		</nav>
		 <nav id="horizontal-nav" class="white hide-on-med-and-down">
			<div class="nav-wrapper">                  
			  <ul id="ul-horizontal-nav" class="left hide-on-med-and-down">
				<li>
					<a href="home" class="cyan-text">
						<i class="mdi-action-dashboard"></i>
						<span>Home</span>
					</a>
				</li>
				<li>
					<?php
						echo '<a href="#modalcreateboard" class="cyan-text modal-trigger" onclick="hiddenGroupId(\''.$userId.'\')">';
					?>
						<i class="mdi-action-note-add"></i>
						<span>Create Board</span>
					</a>
				</li> 
				<li>
					<a id="cokbesar" href="#modalcreategroup" class="modal-trigger cyan-text">
						<i class="mdi-social-group"></i>
						<span>Create Group Board</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" onclick="openClosedBoard()" class="cyan-text">
						<i class="mdi-navigation-close"></i>
						<span>Closed Boards</span>
					</a>
				</li>
			  </ul>
			</div>
		  </nav>
	</div>
</header>

<aside id="left-sidebar-nav hide-on-large-only">
    <ul id="slide-out" class="side-nav leftside-navigation ">
        <li class="user-details cyan darken-2">
            <div class="row">
                <div class="col col s4 m4 l4">
                    <img src="<?php 
		                    if(strpos($userProfile->userImage,"userImage") !== false)
		                    {
		                   		echo $userProfile->userImage."?".filemtime($userProfile->userImage); 
		                    }
		                    else if(strpos($userProfile->userImage,"googleusercontent.com") !== false)
		                    {
		                    	echo $userProfile->userImage;
		                    }
		                    else
		                    {
		                    	echo "userImage/user.jpg";
		                    }

		                    ?>" alt="" class="circle responsive-img valign profile-image">
                </div>
                <div class="col col s8 m8 l8">
                    <a class="dropdown-button waves-effect waves-light profile-btn white-text" href="#" disabled><?php echo $userProfile->userName ?><i class="mdi-navigation-arrow-drop-down right"></i></a>
                </div>
            </div>
        </li>
        <li class="bold active"><a href="home" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> Home</a>
        </li>
        <li class="bold active">
            <?php
                echo '<a href="#modalcreateboard" class="cyan-text modal-trigger" onclick="hiddenGroupId(\''.$userId.'\')">';
            ?>
            <i class="mdi-action-note-add"></i> Create Board</a>
        </li>
        <li class="bold active"><a href="#modalcreategroup" class="waves-effect waves-cyan modal-trigger"><i class="mdi-social-group"></i> Create Group Board</a>
        </li>
        <li class="bold active"><a href="javascript:void(0);" onclick="openClosedBoard()" class="waves-effect waves-cyan modal-trigger"><i class="mdi-navigation-close"></i> Closed Boards</a>
        </li>
        <div class="divider"></div>
        <li class="bold active"><a href="userProfile?userId=<?php echo $userId ?>" class="waves-effect waves-cyan">Profile</a>
        </li>
        <li class="bold active"><a onclick="cekLogout()" class="waves-effect waves-cyan">Log Out</a>
        </li>
    </ul>
    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
</aside>

<div id="main">
	<div class="wrapper">
		<section id="content">
			<div class="container">
				<div class="section">
					<div id="modalcreateboard" class="modal">
		                  <div class="modal-content">
		                    <div class="col s12 m6 l12">
		                    	<div class="row">
		                    		<h6><b>Create a board..</b></h6>
		                    		<div class="divider"></div>
		                    		<p>Title</p>
		                    		<input type="text" placeholder="Title.." id="boardTitle">
		                    		<input type="hidden" id="hiddenOwnerId">
                                    <p class="red-text" id="errorBoardTitle" style="display:none;">Board title is required.</p>
		                    	</div>
		                    </div>
		                  </div>
		                  <div class="modal-footer">
		                    <a class="waves-effect waves-red btn-flat modal-action modal-close">Close</a>
		                  	<a onclick="createBoard()" class="waves-effect waves-red btn-flat modal-action">Create</a>
		                  </div>
	                </div>
	                <div id="modalcreategroup" class="modal">
		                  <div class="modal-content">
		                    <div class="col s12 m6 l12">
		                    	<div class="row">
		                    		<h6><b>Create a group board..</b></h6>
		                    		<div class="divider"></div>
		                    		<p>Name</p>
		                    		<input type="text" placeholder="Name.." id="groupName">
                                    <p class="red-text" id="errorGroupTitle" style="display:none;">Group title is required.</p>
		                    	</div>
		                    </div>
		                  </div>
		                  <div class="modal-footer">
		                    <a href="#" class="waves-effect waves-red btn-flat modal-action modal-close">Close</a>
		                  	<a onclick="createGroup()" class="waves-effect waves-red btn-flat modal-action">Create</a>
		                  </div>
	                </div>
	                <div id="modalclosedboards" class="modal">
		                  <div class="modal-content">
		                    <div class="col s12 m6 l12">
		                    	<div class="row">
		                    		<h6><b>Closed boards..</b></h6>
		                    		<div class="divider"></div>
		                    		<div class="col s12 m6 l12">
		                    			<p><b>Boards</b></p>
		                    			<div class="divider"></div>
		                    			<div id="closedboard">
		                    			</div>
		                    			
		                    		</div>
		                    	</div>
		                    </div>
		                  </div>
		                  <div class="modal-footer">
		                    <a href="#" class="waves-effect waves-red btn-flat modal-action modal-close">Close</a>
		                  </div>
	                </div>
	                <div class="col s12 m4 l8">
							<p><b>Filter Board</b></p>
							<input type="checkbox" id="filterred" onchange="setFilter()" />
	                      	<label for="filterred"><div style="background-color:red;width:32px;height:32px;border-radius:15%;margin-left:-12px;margin-top:-5px;margin-right:12px;"></div></label>
                      		<input type="checkbox" id="filteryellow" onchange="setFilter()"/>
	                      	<label for="filteryellow"><div style="background-color:yellow;width:32px;height:32px;border-radius:15%;margin-left:-12px;margin-top:-5px;margin-right:12px;"></div></label>
                      		<input type="checkbox" id="filtergreen" onchange="setFilter()"/>
	                      	<label for="filtergreen"><div style="background-color:green;width:32px;height:32px;border-radius:15%;margin-left:-12px;margin-top:-5px;margin-right:12px;"></div></label>
                      		<input type="checkbox" id="filterblue" onchange="setFilter()"/>
	                      	<label for="filterblue"><div style="background-color:blue;width:32px;height:32px;border-radius:15%;margin-left:-12px;margin-top:-5px;margin-right:12px;"></div></label>
					        <input type="checkbox" id="filterview1" onchange="setFilter()"/>
                            <label for="filterview1"><div style="background:url('view1.jpg');width:32px;height:32px;border-radius:15%;margin-left:-12px;margin-top:-5px;margin-right:12px;"></div></label>
                            <input type="checkbox" id="filterview2" onchange="setFilter()"/>
                            <label for="filterview2"><div style="background:url('view2.jpg');width:32px;height:32px;border-radius:15%;margin-left:-12px;margin-top:-5px;margin-right:12px;"></div></label>
					</div>
					<div class="divider"></div>
					<p class="caption"><img src="images/user/star.png" width="20px" height="20px" alt="Profile" /> <b>Favorite Boards</b></p>
                    <div id="card-stats">
                        <div class="row">
                        		{% for member in boardMember %}
                        		    {% if member.favoriteChecked == "1" %}
                                        {% for b in board %}
                                            {% if b.boardId == member.boardId and b.boardClosed == "0" and b.boardStatus == "1" and member.memberStatus == "1" %}
                                                <div class="col s12 m6 l3">
                                                    <div class="card">
                                                        <a href="board?id={{b.boardId}}" >
                                                            <div class="card-content {{b.boardBackground}} black-text">
                                                                {% set warna_teks = "black_text" %}
                                                                    {% if b.boardBackground == "red" or b.boardBackground == "blue" or b.boardBackground == "green" %}
                                                                        {% set warna_teks = "white-text" %}
                                                                    {% else %}
                                                                        {% set warna_teks = "black-text" %}
                                                                    {% endif %}
                                                                <h2 class="card-stats-title {{warna_teks}}">{{b.boardTitle}}</h2>
                                                            </div>
                                                            <div class="card-action {{b.boardBackground}} darken-2">
                                                                <div id="invoice-line" class="center-align {{warna_teks}}"><?php echo date_format(new DateTime($b->boardCreated),"d M Y"); ?></div>
                                                             </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            {% endif %}
                                        {% endfor %}
                        			{% endif %}
                                {% endfor %}
                        		
                        </div>
                    </div>
                    <div class="divider"></div>
	            	<p class="caption"><img src="images/user/user5.png" width="20px" height="20px" alt="Profile" /><b> My Boards</b></p>

            		<div id="card-stats">
           			<div class="row">
           			<div id="ajaxBoard{{userId}}" style="margin-top:-25px;">
               		   {% for bm in boardMember %}
                        {% if bm.userId == userId and bm.memberStatus == "1"%}
                            {% for r in board %}
                                {%  if r.boardGroup == "0" and r.boardClosed == "0" and r.boardStatus == "1" and r.boardId == bm.boardId %}
                                    <div class="col s12 m6 l3 colBoardUser">
                                        <a href="board?id={{r.boardId}}" >
                                            <div class="card">
                                                <div class="secondary-content yellow"></div>
                                                <div class="card-content {{r.boardBackground}} black-text boardUser">
                                                    {% set warna_teks = "white-text" %}
                                                    {% if r.boardBackground == "red" or r.boardBackground == "blue" or r.boardBackground == "green" %}
                                                        {% set warna_teks = "white-text" %}
                                                    {% else %}
                                                        {% set warna_teks = "black-text" %}
                                                    {% endif %}
                                                    <h2 class="card-stats-title {{warna_teks}}">{{r.boardTitle}}</h2>
                                                </div>
                                            <div class="card-action {{r.boardBackground}} darken-2"> 
                                                <div id="invoice-line" class="center-align {{warna_teks}}"><?php echo date_format(new DateTime($r->boardCreated),"d M Y"); ?></div>    
                                            </div> 
                                            </div>
                                        </a>
                                    </div>
                                {% endif %}
                            {% endfor %}
                        {% endif %}
                       {% endfor %}
                   </div>
                    <div class="col s12 m6 l3">
                        <div class="card">
                            <div class="card-content grey white-text">
                                <a href="#modalcreateboard" class="modal-trigger" onclick="hiddenGroupId('{{userId}}')">
                                    <h2 class="card-stats-title white-text">Create a new Board..</h2>
                                </a> 
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="divider"></div>
                		<div id="ajaxGroup">
	            	<?php
                        foreach($groupUser as $g)
                        {
                            $active = false;
                            foreach($groupMember as $gm)
                            {
                                if($g->groupId == $gm->groupUserId)
                                {
                                    $active = true;
                                }
                            }
                            foreach($boardGroup as $bg)
                            {
                                if($g->groupId == $bg->groupId)
                                {
                                    foreach($boardMember as $bm)
                                    {
                                        if($bm->boardId == $bg->boardId && $bm->memberStatus == "1")
                                        {
                                            foreach($board as $b)
                                            {
                                                if($bg->boardId == $b->boardId && $b->boardClosed == '0' && $b->boardStatus='1')
                                                {
                                                    $active = true;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            if($active == true)
                            {
                                $groupName = $g->groupName;
                                $groupId = $g->groupId;
                                echo '<p class="caption"><img src="'.$g->groupImage.'" width="20px" height="20px" alt="Profile" /><a href="groupProfile?id='.$groupId.'" class="black-text"> <b>'.$groupName.'</b> </a></p>';
                                echo '<div id="card-stats">';
                                echo   '<div class="row">';
                                echo '<div id="ajaxBoard'.$groupId.'" style="margin-top:-25px;">';
                                foreach($board as $b)
                                {
                                    foreach($boardGroup as $bg)
                                    {

                                        if($b->boardClosed == "0" && $b->boardStatus == "1" && $bg->boardId == $b->boardId && $bg->groupId == $groupId)
                                        {
                                            echo        '<div class="col s12 m6 l3 colBoardUser">';
                                            echo            '<a href="board?id='.$b->boardId.'" >';
                                            echo            '<div class="card">';
                                            echo                '<div class="card-content '.$b->boardBackground.' black-text boardUser">';
                                            $warna_teks = "black-text";
                                            if($b->boardBackground == "red" || $b->boardBackground == "blue" || $b->boardBackground == "green")
                                            {
                                                $warna_teks = "white-text";
                                            }
                                            else
                                            {
                                                $warna_teks = "black-text";
                                            }
                                            echo                    '<h2 class="card-stats-title '.$warna_teks.'">'.$b->boardTitle.'</h2>';
                                            echo                '</div>';
                                            echo                '<div class="card-action '.$b->boardBackground.' darken-2">';
                                            echo                  '<div id="invoice-line" class="center-align '.$warna_teks.'">'.date_format(new DateTime($b->boardCreated),"d M Y").'</div>';
                                            echo                '</div>';
                                            echo            '</div>';
                                            echo            '</a>';
                                            echo        '</div>';
                                        }
                                    }
                                }
                                echo '</div>';
                                
                                foreach($groupMember as $gm)
                                {
                                    if($g->groupId == $gm->groupUserId && ($gm->memberRole == "Admin" || $gm->memberRole == "Member"))
                                    {
                                        echo        '<div class="col s12 m6 l3">';
                                        echo            '<div class="card">';
                                        echo                '<div class="card-content grey white-text">';
                                        echo                        '<a href="#modalcreateboard" class="modal-trigger" onclick="hiddenGroupId(\''.$groupId.'\')">';
                                        echo                        '<h2 class="card-stats-title white-text">Create a new Board..</h2>';
                                        echo                    '</a>';
                                        echo                '</div>';
                                        echo            '</div>';
                                        echo        '</div>';
                                    }
                                }
                                
                                echo    '</div>';
                                echo '</div>';
                                echo "<div class='divider'></div>";
                            }

                        }
	            	?>
	            	</div>
            	</div>
			</div>
		</section>
	</div>
</div>
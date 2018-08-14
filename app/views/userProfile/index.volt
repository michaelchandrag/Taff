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

                            ?>" width="32px" height="32px" class="userImage" style="border-radius:50%" /></a>
                    </li>
                </ul>
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

                            ?>" width="32px" height="32px" class="userImage" alt="Profile" />  <span class="language-select">Profile</span></a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" onclick="cekLogout()"><img src="images/user/logout.png" width="32px" height="32px" alt="French" />  <span class="language-select">Log Out</span></a>
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

                            ?>" alt="" class="userImage circle responsive-img valign profile-image">
                </div>
                <div class="col col s8 m8 l8">
                    <a class="dropdown-button waves-effect waves-light profile-btn white-text" href="#" disabled><?php echo $userProfile->userName ?><i class="mdi-navigation-arrow-drop-down right"></i></a>
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


<div id="main">
    <div class="wrapper">
        <section id="content">
            <div class="container">
                <div class="section">
                <div id="profile-page" class="section">
                    <div id="profile-page-header" class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="" src="images/user-profile-bg.jpg" alt="user background">                    
                        </div>
                        <figure class="card-profile-image" style="float:left;">
                            
                        </figure>
                        <div class="card-content" style="margin-top:6px;">
                          <div class="row">
                            <div class="col s5 m4 l2">
                                <img id="userImage" src="<?php 
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
    
                                ?>" alt="profile image" style="width:100px;height:100px;margin-left:10%;" class="circle" >
                            </div>
                            
                            <div class="col s3 m4 l8">                         
                                <h4 class="card-title grey-text text-darken-4"><b><?php echo $userProfile->userName ?></b></h4>
                                <p class="medium-small grey-text"><?php echo $userProfile->userEmail ?></p>                        
                            </div>
                            </div>
                            <div class="row">
                            <div class="col s2 center-align">
                                <h4 class="card-title grey-text text-darken-4">
                                    {% set total = 0 %}
                                    {% for b in board %}
                                        {% if b.boardStatus == "1" and b.boardGroup == "0" %}
                                            {% set total+=1 %}
                                        {% endif %}
                                    {% endfor %}
                                    {{ total }}
                                    <?php
                                    ?>
                                </h4>
                                <p class="medium-small grey-text">Boards</p>                        
                            </div>
                            <div class="col s2 center-align">
                                <h4 class="card-title grey-text text-darken-4">
                                {% set total = 0 %}
                                    {% for g in groupMember %}
                                        {% if g.memberStatus == "1" %}
                                            {% for u in groupUser %}
                                                {% if g.groupUserId == u.groupId %}
                                                    {% set total+=1 %}
                                                {% endif %}
                                            {% endfor %}
                                        {% endif %}
                                    {% endfor%}
                                {{ total }}
                                <?php
                                    /*$total = 0;
                                    foreach($groupMember as $g)
                                    {
                                        if($g->memberStatus == "1")
                                        {
                                            foreach($groupUser as $u)
                                            {
                                                if($g->groupUserId == $u->groupId)
                                                {
                                                    $total++;
                                                }
                                            }
                                        }
                                    }
                                    echo $total;*/
                                ?>
                                </h4>
                                <p class="medium-small grey-text">Groups</p>                        
                            </div>                   
                            <div class="col s2 center-align">
                                <h4 class="card-title grey-text text-darken-4"><?php echo date_format(date_create($userProfile->userJoined),"d F Y"); ?></h4>
                                <p class="medium-small grey-text">Joined</p>                        
                            </div>
                            </div>
                          </div>
                        </div>
                    </div>

                    <div id="profile-page-content" class="row">
                      <div id="profile-page-sidebar" class="col s12 m6"
                      <?php
                        if($owner == "true")
                        {
                            echo "style='display:block;'";
                        }
                        else
                        {
                            echo "style='display:none;'";
                        }
                      ?>
                      >
                        <div class="card white">
                          <div class="card-content black-text">
                            <span class="card-title"><b>Edit Profile</b></span>
                                <input type="hidden" id="hiddenUserId" value="<?php echo $userProfile->userId?>">
                                <div class="input-field">
                                  <input type="text" value="<?php echo $userProfile->userName; ?>" id="userName">
                                  <label for="name">Name</label>

                                </div>
                                <label class="red-text" style="display:none;" id="errorName">Name at least 3 characters.</label>
                                <div class="input-field">
                                  <input id="userEmail" type="email" class="validate" value="<?php echo $userProfile->userEmail; ?>" disabled>
                                  <label for="email">Email</label>
                                </div>
                                <div class="input-field">
                                  <textarea class="materialize-textarea" length="120" id="userBio"><?php echo $userProfile->userBio; ?></textarea>
                                  <label for="bio">Bio</label>
                                </div>
                                <div class="input-field">
                                  <input type="text" value="<?php echo $userProfile->userLocation ?>" id="userLocation">
                                  <label for="name">Location</label>
                                </div>
                                <div class="input-field">
                                    <label for="bio">Gender</label><br>
                                    <input name="rgender" type="radio" id="rmale" <?php if($userProfile->userGender == "Male") echo "checked='checked'"?> />
                                    <label for="rmale">Male</label>
                                    <input name="rgender" type="radio" id="rfemale" <?php if($userProfile->userGender == "Female") echo "checked='checked'"?>/>
                                    <label for="rfemale">Female</label>
                                </div>
                                <div class="input-field right-align" style="margin-bottom:15px;">
                                    <a onclick="changeData()" class="btn waves-effect waves-light red">Change Profile<i class="mdi-content-send right"></i></a>
                                  </div>
                          </div>                  
                        </div>
                        <div class="card white">
                          <div class="card-content black-text">
                            <span class="card-title"><b>Change Image</b></span>
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
                        <div class="card white">
                          <div class="card-content black-text">
                            <span class="card-title"><b>Change Password</b></span>
                                <div class="input-field">
                                  <input id="newpass" type="password" class="validate">
                                  <label for="newpass">New Password</label>
                                </div>
                                <div class="input-field">
                                  <input id="confpass" type="password" class="validate">
                                  <label for="confpass">Confirm Password</label>
                                </div>
                                <div class="input-field" id="errorChangePassword" style="display:none;">
                                    <label class="red-text">Password must be at least 1 character and have to match with confirm password.</label><br><br>
                                </div>
                                  <div class="input-field right-align">
                                    <a onclick="changePassword()" class="btn waves-effect waves-light red">Change Password<i class="mdi-content-send right"></i></a>
                                  </div>
                          </div>                  
                        </div>

                      </div>

                      <div class="col s12 m6">
                        <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                          <li class="active">
                            <div class="collapsible-header"><i class="mdi-communication-live-help"></i> Groups</div>
                            <div class="collapsible-body" style="display: none;">
                              <p>
                                <b><u>Groups</u></b></br>
                                {% for g in groupMember %}
                                    {% if g.memberStatus == "1" %}
                                        {% for u in groupUser %}
                                            {% if g.groupUserId == u.groupId and u.groupStatus == "1"%}
                                                - <a href='groupProfile?id={{u.groupId}}'>{{u.groupName}}</a></br>
                                            {% endif %}
                                        {% endfor %}
                                    {% endif %}
                                {% endfor %}
                                <?php
                                /*foreach($groupMember as $g)
                                {
                                    if($g->memberStatus == "1")
                                    {
                                        foreach($groupUser as $u)
                                        {
                                            if($g->groupUserId == $u->groupId && $u->groupStatus == "1")
                                            {
                                                echo " - <a href='groupprofile?id=".$u->groupId."'>".$u->groupName."</a></br>";
                                            }
                                        }
                                    }
                                }*/

                                ?>
                              </p>
                            </div>
                          </li>
                          <li >
                            <div class="collapsible-header active"><i class="mdi-communication-email"></i> Profile</div>
                            <div class="collapsible-body" style="">
                              <div class="divider"></div>
                              <p id="visitUserBio" style="margin-top:-25px;"> 
                                <b><u>Name</u></b></br>
                                {{userProfile.userName}}</br></br>
                                <b><u>Email</u></b></br>
                                {{userProfile.userEmail}}</br></br>
                                <b><u>Bio</u></b></br>
                                {{userProfile.userBio}}</br></br>
                                <b><u>Location</u></b></br>
                                {{userProfile.userLocation}}</br></br>
                                <b><u>Gender</u></b></br>
                                {{userProfile.userGender}}</br></br>
                              </p>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
<script type="text/javascript" src="js/myjs/jsUserProfile.js"></script>
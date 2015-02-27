<div id="popup-loading">
    <div id="loader">
        <svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    	 width="112.296px" height="131px" viewBox="0 0 112.296 131" enable-background="new 0 0 112.296 131" xml:space="preserve">
            <g>
            	<g>
            		<g>
            			<line x1="53.079" y1="8.629" x2="3.742" y2="37.638"/>
            			<g>
            				<path class="cinq" fill="#FFFFFF" d="M51.186,5.392C34.74,15.061,18.295,24.73,1.85,34.4c-4.165,2.449-0.394,8.933,3.785,6.476
            					c16.446-9.669,32.891-19.339,49.336-29.008C59.136,9.418,55.365,2.935,51.186,5.392L51.186,5.392z"/>
            			</g>
            		</g>
            		<g>
            			<line x1="53.648" y1="8.629" x2="102.984" y2="37.638"/>
            			<g>
            				<path class="six" fill="#FFFFFF" d="M51.756,11.867c16.445,9.669,32.89,19.339,49.335,29.008c4.178,2.457,7.95-4.027,3.785-6.476
            					C88.432,24.73,71.986,15.061,55.541,5.392C51.362,2.935,47.591,9.418,51.756,11.867L51.756,11.867z"/>
            			</g>
            		</g>
            		<g>
            			<line x1="54.038" y1="67.07" x2="4.703" y2="38.062"/>
            			<g>
            				<path class="huit" fill="#FFFFFF" d="M55.93,63.832c-16.445-9.669-32.89-19.338-49.335-29.007c-4.179-2.457-7.95,4.027-3.785,6.476
            					C19.255,50.97,35.7,60.639,52.145,70.308C56.324,72.765,60.095,66.281,55.93,63.832L55.93,63.832z"/>
            			</g>
            		</g>
            		<g>
            			<line x1="54.609" y1="67.07" x2="103.945" y2="38.062"/>
            			<g>
            				<path class="sept" fill="#FFFFFF" d="M56.501,70.308C72.947,60.639,89.392,50.97,105.837,41.3c4.166-2.449,0.394-8.933-3.785-6.476
            					c-16.445,9.669-32.891,19.338-49.336,29.007C48.551,66.281,52.323,72.765,56.501,70.308L56.501,70.308z"/>
            			</g>
            		</g>
            		<g>
            			<line x1="53.185" y1="125.082" x2="3.849" y2="96.073"/>
            			<g>
            				<path class="trois" fill="#FFFFFF" d="M55.077,121.844c-16.445-9.67-32.89-19.34-49.335-29.009c-4.178-2.457-7.95,4.027-3.785,6.476
            					c16.445,9.67,32.89,19.34,49.335,29.009C55.47,130.777,59.242,124.293,55.077,121.844L55.077,121.844z"/>
            			</g>
            		</g>
            		<g>
            			<line x1="53.755" y1="125.082" x2="103.091" y2="96.073"/>
            			<g>
            				<path class="deux" fill="#FFFFFF" d="M55.648,128.32c16.445-9.669,32.891-19.339,49.336-29.009c4.165-2.449,0.393-8.933-3.785-6.476
            					c-16.445,9.669-32.891,19.339-49.336,29.009C47.698,124.293,51.47,130.777,55.648,128.32L55.648,128.32z"/>
            			</g>
            		</g>
            		<g>
            			<g>
            				<path class="quatre" fill="#FFFFFF" d="M0,38.729c0,19.124,0,38.248,0,57.372c0,4.836,7.5,4.836,7.5,0c0-19.124,0-38.248,0-57.372
            					C7.5,33.893,0,33.893,0,38.729L0,38.729z"/>
            			</g>
            		</g>
            	</g>
            	<g>
            		<g>
            			<path class="un" fill="#FFFFFF" d="M99.814,79.04c0,5.403,0,10.806,0,16.208c0,4.836,7.5,4.836,7.5,0c0-5.403,0-10.806,0-16.208
            				C107.314,74.203,99.814,74.203,99.814,79.04L99.814,79.04z"/>
            		</g>
            	</g>
            </g>
        </svg>
        <p id="loading-messages"></p>
    </div>
</div>
<div id="popup">
    <form class="sign-up register" ng-controller="register" ng-submit="create()">
        <a href="#" id="close"><i class="fa fa-times"></i></a>
      <h1 class="sign-up-title">Register</h1>
    
      <?= Core\Session::getFlash() ?>
    
      <div class="divider"></div>
    
      <input type="email" class="sign-up-input" name="email" ng-model="formData.email" placeholder="Email" ng-change="chrono()" autofocus required="">
    
      <input type="password" class="sign-up-input" name="password" ng-model="formData.password" placeholder="Password" required>
    
      <label>
        <input type="checkbox" name="tc" ng-model="formData.tc" required>
        I agree with the terms and conditions.
      </label>
      <div class="notif"></div>
      <input type="submit" value="Register now!" class="sign-up-button">
      <ul class="social_button">
        <li class="button fb"><a href="<?= FbHelper::getFbLink(['email']) ?>">Login with Facebook</a></li>
      </ul>
      <a class="allready">I have already an account</a>
    </form>
    <form class="sign-up login" id="popupLogin" style="border:solid 1px white;">
        <a href="#" id="close"><i class="fa fa-times"></i></a>
        <input type="email" id="emailLoginPopUp" class="sign-up-input" placeholder="What's your mail?" >
        <input type="password" id="passwordLoginPopUp" class="sign-up-input" placeholder="Password">
        <input type="checkbox"> Remember me <br/> <a href="#" class="forgot_pass">Forgot password?</a> <br/>
        <input type="submit" id="submitLogin" value="Log in!" class="sign-up-button">
        <ul class="social_button">
            <li class="button fb"><a href="<?= FbHelper::getFbLink(['email']) ?>">With Facebook</a></li>
        </ul>
    </form>
</div>
<div id="container_create" ng-controller="packCreate">
    <div id="create_event">
        <form method="post"  ng-submit="create()">
            <div id="block_menu">
                <ul>
                    <li id="bar-menu-1" class="activeAfter"><i class="fa fa-calendar-o"></i><span>Event</span></li>
                    <li id="bar-menu-2"><i class="fa fa-home"></i><span>Hosting</span></li>
                    <li id="bar-menu-3"><i class="fa fa-car"></i><span>Transport</span></li>
                    <li id="bar-menu-5"><i class="fa fa-cog"></i><span><span id="options">More</span> Options</span></li>
                    <li id="bar-menu-6"><div id="bouton-create"><button type="submit" id="final-step">Create my pack</button></div></li>
                </ul>
            </div>
            <div id="block_formu">
                <div id="formulaire">
                    <div id="block_formu_parti_1" class="block_formu_parti">
                        <h2>Create an Event</h2>
    
                        <div id="formu_event">
                            <input type="text" class="hidden" ng-model="formData.token" id="inputToken" value="<?php (isset($_SESSION['user']->token) ? $_SESSION['user']->token : ""); ?>"> 
                            <input type="text" class="hidden" ng-model="formData.events_id"> 
                            <input type="text" ng-model="formData.events_name" class="champs" placeholder="Name..." required> 
                            <input type="text" ng-model="formData.events_address" class="champs" placeholder="Location..."> 
                            <input type="number" ng-model="formData.events_price" class="champs" placeholder="Price per person..." required> 
                            <input type="datetime-local" ng-model="formData.events_starttime" class="champs datestart" required> 
                            <input type="datetime-local" ng-model="formData.events_endtime" class="champs datesend" required> 
                            <textarea ng-model="formData.events_description" class="champs" placeholder="Description..." required></textarea>
                            <div class="top-panel" id="uploader">
                                <div id="dropzone" class="dropzone">
                                    <div class="text">
                                        <p>Drop up to 3 images here</p>
                                        <span class="or">or</span>
                                        <a id="browse" href="#">Browse</a>
                                    </div>
                                </div>
                                <div class="details">
                                    <div class="rowcards" id="template">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="block_formu_parti" id="block_formu_parti_2">
                        <h2>Or choose an Event</h2>
    
                        <div id="bar-search">
                            <form id="formu" method="post" action="">
                                <input type="search" class="champs" placeholder="Search an event..." ng-model="search" ng-change="update()">
                            </form>
                        </div>
    
                        <h3 class="title_favorite_event">Your favorite Events</h3>
    
                        <div class="spinner white">
                            <div class="rect1"></div>
                            <div class="rect2"></div>
                            <div class="rect3"></div>
                            <div class="rect4"></div>
                            <div class="rect5"></div>
                        </div>
    
                        <div class="vignettes" ng-repeat="event in data.events track by $index" >
                            <ul>
                                <li ng-repeat="photos in event.events_medias track by $index|limitTo:1" style="background: url({{photos.medias_file}})" ng-click="fillform($event)" data-id="{{event.events_id}}"></li>
                            </ul>
    
                            <div class="cercle" ><img class="check" width="16" src="<?= HTML::link('default/images/check.png') ?>" alt="" ></div>
    
                            <div class="titre_vignettes" ng-click="fillform($event)" data-id="{{event.events_id}}">
                                {{event.events_name}}
                            </div>
                        </div>
                    </div>
    
                    <div class="clear"></div>
                </div>
    
                <div id="formulaire-host">
                    <h2>Choose your hosting</h2>
    
                    <div class="icones-formu">
                        <input type="hidden" ng-model="formData.hosting" value="false">

                        <input type="radio" ng-model="formData.hosting" value="guesthouse">
                        <img src="<?= HTML::link('default/images/maison.png') ?>" alt="">
    
                        <p>Guesthouse</p>
                    </div>
    
                    <div class="icones-formu seconde-icone">
                        <input type="radio" ng-model="formData.hosting" value="simple">

                        <img src="<?= HTML::link('default/images/lit2.png') ?>" alt="">
    
                        <p>Simple</p>
                    </div>
    
                    <div class="icones-formu">
                        <input type="radio" ng-model="formData.hosting" value="confortable">

                        <img src="<?= HTML::link('default/images/lit3.png') ?>" alt="">
    
                        <p>Confortable</p>
                    </div>
    
                    <div class="icones-formu last-icone">
                        <input type="radio" ng-model="formData.hosting" value="luxury">

                        <img src="<?= HTML::link('default/images/lit4.png') ?>" alt="">
    
                        <p>Luxury</p>
                    </div>
    
                    <div class="clear"></div>
    
                    <div class="formu-onglet">
                        <textarea ng-model="formData.hosting_description" class="champs" placeholder="Description..."></textarea>
                        <input ng-model="formData.hosting_price" type="number" class="champs" placeholder="Price per person...">
                    </div>
                </div>
    
                <div id="formulaire-transport">
                    <h2>Choose your transport</h2>
    
                    <div class="icones-formu">
                        <input type="hidden" ng-model="formData.transport" value="false">
                        <input type="radio" ng-model="formData.transport" value="car">
                        <img src="<?= HTML::link('default/images/voiture.png') ?>" alt="">
    
                        <p>Car</p>
                    </div>
    
                    <div class="icones-formu seconde-icone">
                        <input type="radio" ng-model="formData.transport" value="bus">

                        <img src="<?= HTML::link('default/images/bus2.png') ?>" alt="">
    
                        <p>Bus</p>
                    </div>
    
                    <div class="icones-formu">
                        <input type="radio" ng-model="formData.transport" value="train">
                        <img src="<?= HTML::link('default/images/train2.png') ?>" alt="">
    
                        <p>Train</p>
                    </div>
    
                    <div class="icones-formu last-icone">
                        <input type="radio" ng-model="formData.transport" value="train">
                        <img src="<?= HTML::link('default/images/avion.png') ?>" alt="">
    
                        <p>Plane</p>
                    </div>
    
                    <div class="clear"></div>
    
                    <div class="formu-onglet">
                        <textarea ng-model="formData.transport_description" class="champs" placeholder="Description..."></textarea> 
                        <input ng-model="formData.transport_price" type="number" class="champs" placeholder="Price per person...">
                    </div>
                </div>    
                <div id="formulaire-options">
                    <h2>Add more options</h2>
    
                    <div class="formu-onglet">

                            <input type="text" name="option0_name" class="champs" placeholder="Titre...">
                            <textarea name="option0_description" class="champs" placeholder="Description..."></textarea>
                            <input type="number" name="option0_price" class="champs" placeholder="Price per person...">    
    
                            <div class="add_option">
    
                            </div>
    
                            <a href="#" class="other_option">+ Add an option</a>
                    </div>
                </div>
    
                <div id="bouton-next-1" class="bouton-next next-step">
                    Next Step
                </div>
    
                <div id="bouton-next-2" class="bouton-next next-step">
                    Next Step
                </div>
    
                <div id="bouton-next-3" class="bouton-next next-step">
                    Next Step
                </div>
    
                <div id="bouton-next-4" class="bouton-next next-step">
                    Next Step
                </div>
    
                <div id="bouton-next-5" class="bouton-next next-step">
                    <a href="recap_pack.html">Validate</a>
                </div>
            </div>
        </form>

        <div class="clear"></div>
    </div>
</div>


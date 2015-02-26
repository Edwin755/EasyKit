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
                            <input type="text" class="hidden" ng-model="formData.token" id="inputToken" value="<?= $_SESSION['user']->token; ?>"> 
                            <input type="text" class="hidden" ng-model="formData.events_id"> 
                            <input type="text" ng-model="formData.events_name" class="champs" placeholder="Name..."> 
                            <input type="text" ng-model="formData.events_address" class="champs" placeholder="Location..."> 
                            <input type="number" ng-model="formData.events_price" class="champs" placeholder="Price per person..."> 
                            <input type="datetime-local" ng-model="formData.events_starttime" class="champs datestart"> 
                            <input type="datetime-local" ng-model="formData.events_endtime" class="champs datesend"> 
                            <textarea ng-model="formData.events_description" class="champs" placeholder="Description..."></textarea>
                            <div class="top-panel" id="uploader">
                                <div id="dropzone" class="dropzone">
                                    <div class="text">
                                        <p>Drop maximum 3 images here</p>
                                        <span class="or">or</span>
                                        <a id="browse" href="#">Browse</a>
                                    </div>
                                </div>
                                <div class="details">
                                    <div class="rowcards" id="template">
                                        <div class="card" id="{{id}}">
                                            <div class="image">
                                                <ul class="slides">
                                                    <li class="item">
                                                        <div id="blah">
                                                            
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="progress">
                                                    <div class="bar"></div>
                                                </div>
                                            </div>
                                            <div class="informations">
                                                <div class="complement">{{size}}</div>
                                                <div class="options">
                                                    <a class="delete" href=""><span class="fa fa-trash"></span></a>
                                                </div>
                                            </div>
                                        </div>
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


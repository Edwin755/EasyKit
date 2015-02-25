<div id="container_create" ng-controller="packCreate">
    <div id="create_event">
        <form method="post" action="<?= HTML::link('packs/create') ?>">
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
                            <form id="formu1" method="post" action="<?= HTML::link('events/create') ?>">
                                <input type="hidden" name="events_id" ng-model="eventName"> 
                                <input type="text" name="events_name" class="champs" placeholder="Name..." ng-model="eventName"> 
                                <input type="text" name="events_address" class="champs" placeholder="Location..." ng-model="eventLocation"> 
                                <input type="number" name="events_price" class="champs" placeholder="Price per person..." ng-model="eventPrice"> 
                                <input type="datetime-local" name="events_starttime" class="champs datestart" ng-model="eventStartDate"> 
                                <input type="datetime-local" name="events_endtime" class="champs datesend" ng-model="eventEndDate"> 
                                <textarea name="events_description" class="champs" placeholder="Description..." ng-model="eventDesc"></textarea>
                                <div class="droparea"><h2>Add some pictures:</h2><br/>
                                    <img src="<?= HTML::link('default/images/event-1-vignette.jpg') ?>" class="image_drop"/>
                                    <img src="<?= HTML::link('default/images/event-1-vignette.jpg') ?>" class="image_drop"/>
                                    <img src="<?= HTML::link('default/images/event-1-vignette.jpg') ?>" class="image_drop"/>
                                    <ul id="filelist"></ul>
                                    <br />
                                     
                                    <div id="container">
                                        <a id="browse" href="javascript:;">[Browse...]</a>
                                        <a id="start-upload" href="javascript:;">[Start Upload]</a>
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
                        <input type="hidden" name="hosting" value="false">

                        <input type="radio" name="hosting" value="guesthouse">
                        <img src="<?= HTML::link('default/images/maison.png') ?>" alt="">
    
                        <p>Guesthouse</p>
                    </div>
    
                    <div class="icones-formu seconde-icone">
                        <input type="radio" name="hosting" value="simple">

                        <img src="<?= HTML::link('default/images/lit2.png') ?>" alt="">
    
                        <p>Simple</p>
                    </div>
    
                    <div class="icones-formu">
                        <input type="radio" name="hosting" value="confortable">

                        <img src="<?= HTML::link('default/images/lit3.png') ?>" alt="">
    
                        <p>Confortable</p>
                    </div>
    
                    <div class="icones-formu last-icone">
                        <input type="radio" name="hosting" value="luxury">

                        <img src="<?= HTML::link('default/images/lit4.png') ?>" alt="">
    
                        <p>Luxury</p>
                    </div>
    
                    <div class="clear"></div>
    
                    <div class="formu-onglet">
                        <textarea name="hosting_description" class="champs" placeholder="Description..."></textarea>
                        <input name="hosting_price" type="number" class="champs" placeholder="Price per person...">
                    </div>
                </div>
    
                <div id="formulaire-transport">
                    <h2>Choose your transport</h2>
    
                    <div class="icones-formu">
                        <input type="hidden" name="transport" value="false">
                        <input type="radio" name="transport" value="car">
                        <img src="<?= HTML::link('default/images/voiture.png') ?>" alt="">
    
                        <p>Car</p>
                    </div>
    
                    <div class="icones-formu seconde-icone">
                        <input type="radio" name="transport" value="bus">

                        <img src="<?= HTML::link('default/images/bus2.png') ?>" alt="">
    
                        <p>Bus</p>
                    </div>
    
                    <div class="icones-formu">
                        <input type="radio" name="transport" value="train">
                        <img src="<?= HTML::link('default/images/train2.png') ?>" alt="">
    
                        <p>Train</p>
                    </div>
    
                    <div class="icones-formu last-icone">
                        <input type="radio" name="transport" value="train">
                        <img src="<?= HTML::link('default/images/avion.png') ?>" alt="">
    
                        <p>Plane</p>
                    </div>
    
                    <div class="clear"></div>
    
                    <div class="formu-onglet">
                        <textarea name="transport_description" class="champs" placeholder="Description..."></textarea> 
                        <input name="transport_price" type="number" class="champs" placeholder="Price per person...">
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


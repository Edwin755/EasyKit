<div id="container_create" ng-controller="packCreate">
    <div id="create_event">
        <div id="block_menu">
            <ul>
                
                <li id="bar-menu-1" class="activeAfter"><i class="fa fa-calendar-o"></i><span>Event</span></li>
                <li id="bar-menu-2"><i class="fa fa-home"></i><span>Hosting</span></li>
                <li id="bar-menu-3"><i class="fa fa-car"></i><span>Transport</span></li>
                <li id="bar-menu-4"><i class="fa fa-users"></i><span>Contributors</span></li>
                <li id="bar-menu-5"><i class="fa fa-cog"></i><span><span id="options">More</span> Options</span></li>
                <li id="bar-menu-6"><div id="bouton-create"><a id="final-step" href="recap_pack.html">Create my pack</a></div></li>
            </ul>
        </div>

        <div id="block_formu">
            <div id="formulaire">
                <div class="block_formu_parti">
                    <h2>Create an Event</h2>

                    <div id="formu_event">
                        <form id="formu1" method="post" action="traitement.php">
                            <input type="text" class="champs" placeholder="Name..." ng-model="eventName"> 
                            <input type="text" class="champs" placeholder="Location..." ng-model="eventLocation"> 
                            <input type="number" class="champs" placeholder="Price per person..." ng-model="eventPrice"> 
                            <input type="date" class="champs" placeholder="Date..." ng-model="eventDate"> 
                            <textarea name="description" class="champs" placeholder="Description..." ng-model="eventDesc"></textarea>
                        </form>
                    </div>
                </div>

                <div class="block_formu_parti" id="block_formu_parti_2">
                    <h2>Or choose an Event</h2>

                    <div id="bar-search">
                        <form id="formu" method="post" action="traitement.php">
                            <input type="search" class="champs" placeholder="Search an event...">
                        </form>
                    </div>

                    <h3>Favorite Events</h3>

                    <div class="vignettes" ng-repeat="event in data.events track by $index" >
                    <ul>
                        <li ng-repeat="photos in event.events_medias track by $index|limitTo:1" style="background: url({{photos.medias_file}})"></li>
                    </ul>

                        <div class="cercle" ng-click="fillform($event)" data-id="{{event.events_id}}"><img class="check" width="16" src="images/check.png" alt=""></div>

                        <div class="titre_vignettes">
                            {{event.events_name}}
                        </div>
                    </div>
                </div>

                <div class="clear"></div>
            </div>

            <div id="formulaire-host">
                <h2>Choose your hosting</h2>

                <div class="icones-formu">
                    <img src="<?= HTML::link('default/images/maison.png') ?>" alt="">

                    <p>Guesthouse</p>
                </div>

                <div class="icones-formu seconde-icone">
                    <img src="<?= HTML::link('default/images/lit2.png') ?>" alt="">

                    <p>Simple</p>
                </div>

                <div class="icones-formu">
                    <img src="<?= HTML::link('default/images/lit3.png') ?>" alt="">

                    <p>Confortable</p>
                </div>

                <div class="icones-formu last-icone">
                    <img src="<?= HTML::link('default/images/lit4.png') ?>" alt="">

                    <p>Luxury</p>
                </div>

                <div class="clear"></div>

                <div class="formu-onglet">
                    <form id="formu2" method="post" action="traitement.php">
                        <textarea name="description" class="champs" placeholder="Description...">
</textarea> <input type="number" class="champs" placeholder="Price per person...">
                    </form>
                </div>
            </div>

            <div id="formulaire-transport">
                <h2>Choose your transport</h2>

                <div class="icones-formu">
                    <img src="<?= HTML::link('default/images/voiture.png') ?>" alt="">

                    <p>Car</p>
                </div>

                <div class="icones-formu seconde-icone">
                    <img src="<?= HTML::link('default/images/bus2.png') ?>" alt="">

                    <p>Bus</p>
                </div>

                <div class="icones-formu">
                    <img src="<?= HTML::link('default/images/train2.png') ?>" alt="">

                    <p>Train</p>
                </div>

                <div class="icones-formu last-icone">
                    <img src="<?= HTML::link('default/images/avion.png') ?>" alt="">

                    <p>Plane</p>
                </div>

                <div class="clear"></div>

                <div class="formu-onglet">
                    <form id="formu3" method="post" action="traitement.php">
                        <textarea name="description" class="champs" placeholder="Description...">
</textarea> <input type="number" class="champs" placeholder="Price per person...">
                    </form>
                </div>
            </div>

            <div id="formulaire-contributors">
                <h2>You travel...</h2>

                <div class="icones-formu">
                    <img src="<?= HTML::link('default/images/homme.png') ?>" alt="">

                    <p>Alone</p>
                </div>

                <div class="icones-formu seconde-icone">
                    <img src="<?= HTML::link('default/images/couple2.png') ?>" alt="">

                    <p>As a couple</p>
                </div>

                <div class="icones-formu">
                    <img src="<?= HTML::link('default/images/famille.png') ?>" alt="">

                    <p>In family</p>
                </div>

                <div class="icones-formu last-icone">
                    <img src="<?= HTML::link('default/images/groupe2.png') ?>" alt="">

                    <p>In group</p>
                </div>

                <div class="clear"></div>

                <div class="formu-onglet">
                    <form id="formu4" method="post" action="traitement.php">
                        <textarea name="description" class="champs" placeholder="Description...">
</textarea>
                    </form>
                </div>
            </div>

            <div id="formulaire-options">
                <h2>Add more options</h2>

                <div class="formu-onglet">
                    <form id="formu5" method="post" action="traitement.php">
                        <textarea name="description" class="champs" placeholder="Description...">
</textarea>
                    </form>
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

        <div class="clear"></div>
    </div>
</div>


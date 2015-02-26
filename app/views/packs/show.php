<div id="container_pack">

    <img src="" class="video_header" alt="" title=""/>
    <?php var_dump($pack) ?>

    <div id="present_event">

        <h2><?= $pack->packs_name ?></h2>

        <div class="trait"></div>

        <p><?= $pack->packs_description ?></p>

        <div class="gallery_event">
        </div>

        <div class="discuss">

            <h3>Discussions</h3>

            <ul class="list_comment">
                <li class="commented">
                    <img src="<?= HTML::link('default/images/profil5.png'); ?>" alt="profil" title="profil"/>
                    <span class="name">Fred Groad : </span>
                    Great ! I will definitly come ! Did you think about any coming-back option ?</br>
                    <span class="date_post">Yesterday, 10:54 AM</span>
                </li>
                <li class="commented"><img src="<?= HTML::link('default/images/profil2.png'); ?>" alt="profil"
                                           title="profil"/><span class="name">Jamie Kiaal : </span>Hi Fred, we planned
                    to stay in Vancouver after the conferences. If you want get a return flight you’ll have to find it
                    on your own.</br><span class="date_post">Yesterday, 2:54 AM</span></li>
                <li class="commented"><img src="<?= HTML::link('default/images/profil4.png'); ?>" alt="profil"
                                           title="profil"/><span class="name">Carrie Bou : </span>I can't wait!</br>
                    <span class="date_post">Yesterday, 1:54 AM</span></li>
            </ul>

            <div class="new_post">

                <ul>
                    <li class="add_new_post"><img src="profil.png" alt="profil" title="profil"/><textarea
                            class="post_new_comment"> Add your comment ...</textarea> <a href="#"
                                                                                         class="add_post">Post</a></li>

                </ul>

            </div>

        </div>


    </div>

    <div class="trait_vertical"></div>


    <div id="info_pack">

        <div class="gathered">

            <h2> 5555€ </h2>
            <h6> Gathered from <span class="price ">12 contributors</span>
        </div>

        <ul class="detail_pack">
            <li>TED Conference Ticket<span class="price price_detail"> 100€</li>
            <li>Location: Vancouver, Canada</li>
            <li>Date: 24/11/2015
            <Li>
            <li>
                <div class="squaredFour">
                    <input type="checkbox" id="squared" name="check"/>
                    <label for="squared"></label>
                </div>
            </li>
        </ul>

        <ul class="detail_pack">
            <li>Paris - Vancouver (AirFrance)<span class="price price_detail"> 400€</li>
            <li>Transport: Plane</li>
            <li>Date: 24/11/2015
            <Li>
            <li>
                <div class="squaredFour">
                    <input type="checkbox" id="squared2" name="check"/>
                    <label for="squared2"></label>
                </div>
            </li>
        </ul>

        <ul class="detail_pack">
            <li>Oncle Graham<span class="price price_detail"> 200€</li>
            <li>Hosting: Luxury</li>
            <li>Date: 24/11/2015
            <Li>
            <li>
                <div class="squaredFour">
                    <input type="checkbox" id="squared3" name="check"/>
                    <label for="squared3"></label>
                </div>
            </li>
        </ul>

        <ul class="detail_pack">

            <li>Select all options (700€)
                <div class="squaredFour">
                    <input type="checkbox" id="allstep" name="check"/>
                    <label for="allstep"></label>
                </div>
            </li>
        </ul>

        <a href="" class="start">Contribute</a>

        <ul class="contributors">
            <li><img src="<?= HTML::link('default/images/profil.png'); ?>" alt="profil" title="profil"></li>
            <li><img src="<?= HTML::link('default/images/profil2.png'); ?>" alt="profil" title="profil"></li>
            <li><img src="<?= HTML::link('default/images/profil3.png'); ?>" alt="profil" title="profil"></li>
            <li><img src="<?= HTML::link('default/images/profil4.png'); ?>" alt="profil" title="profil"></li>
            <li><img src="<?= HTML::link('default/images/profil.png'); ?>" alt="profil" title="profil"></li>
            <li><img src="<?= HTML::link('default/images/profil5.png'); ?>" alt="profil" title="profil"></li>
            <li><img src="<?= HTML::link('default/images/profil6.png'); ?>" alt="profil" title="profil"></li>
            <li><img src="<?= HTML::link('default/images/profil7.png'); ?>" alt="profil" title="profil"></li>
            <li><a href="#">See more guest</a></li>
        </ul>

    </div>


</div>
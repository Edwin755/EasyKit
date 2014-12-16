<form action="<?= HTML::link('admin1259/users/signin') ?>" method="POST">
    <?php
        if (Core\Session::get('flash') !== false) {
            echo '<div class="alert alert-' . Core\Session::get('flash')['status'] . '">' . Core\Session::get('flash')['message'] . '</div>';
        }

        Core\Session::set('flash', null);
    ?>
    <div class="form-control">
        <label for="username">Nom d'utilisateur</label>
        <input class="input" id="username" name="username" type="text">
    </div>
    <div class="form-control">
        <label for="password">Mot de passe</label>
        <input class="input" id="password" name="password" type="text">
    </div>
    <div class="row">
        <div class="form-control left">
            <input type="hidden" name="remember" value="0">
            <input type="checkbox" class="checkbox" value="1" id="remember" name="remember">
            <label for="remember">Se souvenir de moi</label>
        </div>
        <div class="form-control right">
            <button class="btn btn-primary" type="submit">Se connecter</button>
        </div>
    </div>
</form>
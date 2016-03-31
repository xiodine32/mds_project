<?php
/**
 * Created at: 29/03/16 14:31
 */

/**
 * @var $this \View
 */
if (!isset($viewbag) || !isset($this)) die();
/**@var \Models\ModelEmployee $user */
$user = $viewbag['employee'];
?>

    <div class="top-bar">

        <div class="top-bar-title">

            <a href="<?= $viewbag['root'] ?>main/">
                <strong>Home</strong>
            </a>

        <span class="menu-hamburger show-for-small-only" data-responsive-toggle="responsive-menu"
              data-hide-for="medium">
            <span class="menu-text" data-toggle>Menu</span>
            <span class="menu-icon" data-toggle></span>
        </span>

        </div>

        <div id="responsive-menu">
            <div class="top-bar-left">
                <ul class="menu" data-responsive-menu="drilldown medium-dropdown">
                    <li><a href="#">Monthly Schedule</a></li>
                    <li><a href="#">Projects</a></li>
                    <li><a href="#">Employees</a></li>
                </ul>
            </div>
            <div class="top-bar-right">
                <ul class="menu" data-responsive-menu="drilldown medium-dropdown">
                    <li><span>Welcome, <?= $user->firstName ?></span>&nbsp;</li>
                    <li class="active"><a href="<?= $viewbag['root'] ?>main/logout">Logout</a></li>
                    <!--                    <li class="has-submenu">-->
                    <!--                        <a href="#">Right link dropdown</a>-->
                    <!--                        <ul class="submenu menu vertical" data-submenu>-->
                    <!--                            <li><a href="#">First link in dropdown</a></li>-->
                    <!--                            <li>-->
                    <!--                                <a href="#">Submenu in dropdown</a>-->
                    <!--                                <ul class="menu">-->
                    <!--                                    <li><a href="#">Link in submenu</a></li>-->
                    <!--                                    <li><a href="#">Link in submenu</a></li>-->
                    <!--                                    <li class="active"><a href="#">Active link in submenu</a></li>-->
                    <!--                                </ul>-->
                    <!--                            </li>-->
                    <!--                            <li class="active"><a href="">Active link in dropdown</a></li>-->
                    <!--                        </ul>-->
                    <!--                    </li>-->
                </ul>
            </div>
        </div>
    </div>
<?php $this->continueRun(); ?>
<?php
use Updater\Config\Constant;
?>
<div class="wpwebmaster-header-main-1">
    <div class="container-md container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light ">

            <div class="collapse navbar-collapse" id="navbarTogglerMainHeader">
                <ul class="navbar-nav mt-2 mt-lg-0">
	                <li class="nav-item dropdown m-lg-3 m-1">
		                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdownAvada" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                آوادا
		                </a>
		                <div class="dropdown-menu" aria-labelledby="navbarDropdownAvada">
			                <a class="dropdown-item" href="#">آپدیت قالب</a>
			                <a class="dropdown-item" href="/template/main-pages/add-host-page.php">اضافه کردن هاست</a>
		                </div>
                    </li>
                    <li class="nav-item dropdown m-lg-3 m-1">
                        <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdownAvada" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            بویلر پلیت
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownAvada">
                            <a class="dropdown-item" href="#">پلاگین</a>
                            <a class="dropdown-item" href="#">قالب</a>
                        </div>
                    </li>
                    <li class="nav-item m-lg-3 m-1">
                        <a class="nav-link text-dark" href="#">ایمیل</a>
                    </li>
                </ul>
            </div>
            <a class="navbar-brand" href="#">
                <img src="<?php echo Constant::UPDATER_PUBLIC_IMAGES_URL?>wpwebmaster-logo-300px.png" alt="wpwebmaster logo" loading="lazy">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerMainHeader"
                    aria-controls="navbarTogglerMainHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </nav>
    </div>
</div>

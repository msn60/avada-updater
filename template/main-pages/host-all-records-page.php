<?php

require_once '../main-init.php';

use Updater\Functions\UsableFunctions;
use Updater\Config\Constant;
use Updater\Database\DatabaseObject;
use Updater\Database\DatabaseFunctions;
use Updater\Functions\RequestFunctions;
use Updater\Config\Host;
$request_object = new RequestFunctions();

$database = DatabaseFunctions::connect_to_database(
	Constant::DB_SERVER,
	Constant::DB_USER,
	Constant::DB_PASS,
	Constant::DB_NAME
);
DatabaseObject::set_database( $database );
$page_title = 'نمایش همه هاست ها';
include_once Constant::TEMPLATE_PATH . 'header/head-section.php';
include_once Constant::TEMPLATE_PATH . 'header/header-section.php';
?>
  <hr>
  <section class="mt-2">
    <div class="container  mt-2">
      <div class="row">
        <div class="col-md-12 bg-white  msn-shadow-light rounded-lg p-4 mx-auto ">
	        <div class="table-responsive">
		        <table class="table table-striped table-hover">
			        <thead class="thead-dark">
			        <tr>
				        <th scope="col">#</th>
				        <th scope="col">نام هاست</th>
				        <th scope="col">آدرس هاست</th>
				        <th scope="col">نیاز به چک updraft</th>
				        <th scope="col"></th>
				        <th scope="col"></th>
				        <th scope="col"></th>
			        </tr>
			        </thead>
			        <tbody>
			        <tr>
				        <th scope="row">1</th>
				        <td>Mark</td>
				        <td>Otto</td>
				        <td>@mdo</td>
				        <td>نمایش</td>
				        <td>ویرایش</td>
				        <td>حذف</td>
			        </tr>
			        <tr>
				        <th scope="row">2</th>
				        <td>Jacob</td>
				        <td>Thornton</td>
				        <td>@fat</td>
				        <td>نمایش</td>
				        <td>ویرایش</td>
				        <td>حذف</td>
			        </tr>
			        <tr>
				        <th scope="row">3</th>
				        <td>Larry</td>
				        <td>the Bird</td>
				        <td>@twitter</td>
				        <td>نمایش</td>
				        <td>ویرایش</td>
				        <td>حذف</td>
			        </tr>
			        </tbody>
		        </table>
	        </div>

        </div>
      </div>

    </div>
  </section>

<?php

include_once Constant::TEMPLATE_PATH . 'footer/main-footer.php';

DatabaseFunctions::disconnect_database( $database );
?>
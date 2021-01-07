<?php

require_once '../main-init.php';

use Updater\Functions\UsableFunctions;
use Updater\Config\Constant;
use Updater\Database\DatabaseObject;
use Updater\Database\DatabaseFunctions;
use Updater\Functions\RequestFunctions;
use Updater\Config\Host;
use Updater\ViewHandler\PageRender;
$request_object = new RequestFunctions();

$database = DatabaseFunctions::connect_to_database(
	Constant::DB_SERVER,
	Constant::DB_USER,
	Constant::DB_PASS,
	Constant::DB_NAME
);
DatabaseObject::set_database( $database );
$page_title = 'نمایش همه هاست ها';
PageRender::load_template( 'header.head-section', [$page_title]  );
PageRender::load_template( 'header.header-section' );
$hosts = Host::find_all();
?>
  <hr>
  <section class="my-4">
    <div class="container  mt-2">
      <div class="row">
        <div class="col-md-12 bg-white  msn-shadow-light rounded-lg p-4 mx-auto ">
          <h4 class="text-center my-5">نمایش همه هاست های تعریف شده در سیستم</h4>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="thead-dark">
              <tr>
                <th scope="col">id</th>
                <th scope="col">نام هاست</th>
                <th scope="col">آدرس هاست</th>
                <th scope="col">نیاز به چک updraft</th>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
              </thead>
              <tbody>
							<?php foreach ( $hosts as $host ): ?>
                <tr>
                  <th scope="row"><?php echo $host->id;?></th>
                  <td><?php echo $host->host_name;?></td>
                  <td><?php echo $host->host_path;?></td>
                  <td><?php echo ( true == $host->is_check_updraft) ?  'بله' :  'خیر';?></td>
                  <td>
                    <a href="<?php echo Constant::TEMPLATE_URL . 'main-pages/host-edit-page.php?id=' . htmlspecialchars(urlencode($host->id));?>">ویرایش</a>
                  </td>
                  <td>
                    <a href="<?php echo Constant::TEMPLATE_URL . 'main-pages/host-delete-page.php?id=' . htmlspecialchars(urlencode($host->id));?>">حذف</a>
                  </td>
                </tr>
							<?php endforeach;?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </section>

<?php

PageRender::load_template( 'footer.main-footer' );
DatabaseFunctions::disconnect_database( $database );
?>
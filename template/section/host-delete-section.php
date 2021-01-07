<?php
$host = array_shift( $params );

?>

<hr>
<section class="mt-2">
	<div class="container  mt-2">
    <div class="row">
      <div class="col-md-8 bg-white  msn-shadow-light rounded-lg p-4 mx-auto ">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>توجه کنید ! </strong> شما قصد دارید تا هاست زیر را از دیتابیس حذف کنید
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="form-group">
            <label for="hostName">نام هاست</label>
            <input type="text" class="form-control" id="hostName"
                   value="<?php echo  isset($host->host_name) ?  $host->host_name : '';?>"
                   name="host[host_name]" aria-describedby="emailHelp" readonly disabled>
            <small id="hostNameHelp" class="form-text text-muted">آدرس مورد نیاز برای استفاده در برنامه (ضروری)</small>
          </div>
          <div class="form-group">
            <label for="hostAddress">آدرس هاست</label>
            <input type="text" class="form-control" id="hostAddress"
                   value="<?php echo  isset($host->host_path) ?  $host->host_path : '';?>"
                   name="host[host_path]" readonly disabled>
            <small id="hostAddressHelp" class="form-text text-muted">آدرس نسبی برای هاست (ضروری)</small>
          </div>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="isNeedCheckUpdraft"
                   <?php echo isset($host->is_check_updraft) && $host->is_check_updraft == true  ? 'checked' : ''; ?>
                   name="host[is_check_updraft]" readonly disabled>
            <label class="form-check-label" for="isNeedCheckUpdraft">نیاز به چک کردن Updraft</label>
          </div>
          <?php if ( isset($host->id) && ! empty($host->id)) : ?>
            <div>
              <input type="hidden" name="host[id]" value="<?php echo $host->id;?>">
            </div>
          <?php endif; ?>
          <button type="submit" class="btn btn-warning">پاک کردن هاست</button>
        </form>
      </div>
    </div>

	</div>
</section>
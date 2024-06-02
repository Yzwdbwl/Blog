<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">
          <div class="row">
              <div class=" col-md-12">
                  <div class="panel panel-default">

                      <div id="widget1container" class="panel-body collapse in">
                          <h2>welcome to Admin</h2>


                      </div>
                  </div>
              </div>
          </div>
        <?php echo widget('Admin.Common')->footer(); ?>
            
        </div>
    </div>
<?php echo widget('Admin.Common')->htmlend(); ?>
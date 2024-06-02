<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs('Content'); ?>
        <div class="main-content">
        <div id="sys-list">
          <div class="row">
              <div class="col-md-12">
                <form method="get" action="" class="form-inline">
                  <div class="form-group input-group-sm f-g">
                    <label for="search-keyword"></label>
                    <input type="text" value="<?php if(isset($search['keyword'])) echo $search['keyword']; ?>" name="keyword" id="search-keyword" class="form-control" placeholder="Please enter a keyword" >
                  </div>








                  <div class="form-group btn-group-sm f-g">
                    <input class="btn btn-default" type="submit" value="Search">
                  </div>
                </form>
              </div>
              <div style="margin-bottom:5px; clear:both;"></div>
              <div class="col-md-12" id="ajax-reload">
                  <div class="panel panel-default">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>choose</th>
                            <th width="50%">title</th>
                            <th>side title</th>
                            <th>author</th>
                            <th>time</th>
                            <th>state</th>
                            <th width="70">active</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if( ! empty($list)): ?>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><input autocomplete="off" type="checkbox" name="ids[]" class="ids" value="<?php echo $value['id']; ?>"></td>
                              <td><a target="_blank" href="<?php echo route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['id']]); ?>"><?php echo $value['name']; ?></a></td>
                              <td><?php echo $value['subtitle']; ?></td>
                              <td><?php echo $value['other']; ?></td>
                              <td><?php echo $value['create_at'] ?></td>
                              <td>
                                <?php echo $value['status'] == 1 ? '<i class="fa fa-check" style="color:green;"></i>' : '<i class="fa fa-times" style="color:red;"></i>'; ?>
                              </td>
                              <td>
                                <?php echo widget('Admin.Content')->edit($value); ?>
                                <?php echo widget('Admin.Content')->delete($value); ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                      </table>
                      </div>
                  </div>
              </div>
          </div>
          <?php echo $deleteSelectButton = widget('Admin.Content')->deleteSelect(); ?>
          <?php echo $page; ?>
        </div>
        <?php echo widget('Admin.Common')->footer(); ?>

        </div>
    </div>
    <!-- js css -->
    <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/lib/datepicker/bootstrap-datetimepicker.min.css'); ?>">
    <script src="<?php echo loadStatic('/lib/datepicker/bootstrap-datetimepicker.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo loadStatic('/lib/datepicker/locales/bootstrap-datetimepicker.zh-CN.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript">


      <?php if( ! empty($deleteSelectButton)): ?>
        $('.pl-delete').click(function() {
            var ids = plSelectValue('ids');
            if(ids.length == 0) {
                alertNotic('Please select the article that needs to be deleted first');
                return false;
            }
            confirmNotic('confirm to delete?', function() {
              var url = '<?php echo R('common', 'blog.content.delete'); ?>';
              var params = {id:ids};
              Atag_Ajax_Submit(url, params, 'POST', $('.pl-delete'), 'ajax-reload');
            });
        });
      <?php endif; ?>



    </script>
<?php echo widget('Admin.Common')->htmlend(); ?>

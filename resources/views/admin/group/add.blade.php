<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">

          <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">Fill in user group information</a></li>
          </ul>

          <div class="row">
            <div class="col-md-4">
              <br>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                  <form id="tab" target="hiddenwin" method="post" action="<?php echo $formUrl; ?>">
                      @csrf
                    <div class="form-group input-group-sm">
                      <label>User group name</label>
                      <input type="text" value="<?php if(isset($groupInfo['group_name'])) echo $groupInfo['group_name']; ?>" name="data[group_name]" class="form-control">
                    </div>
                    <div class="form-group input-group-sm">
                      <label>User group level</label>
                      <input type="text" value="<?php if(isset($groupInfo['level'])) echo $groupInfo['level']; ?>" name="data[level]" class="form-control" placeholder="Please enter the number,The higher the number, the lower the level." >
                    </div>
                    <div class="form-group">
                      <label>Remark</label>
                      <textarea name="data[mark]" rows="3" class="form-control"><?php if(isset($groupInfo['mark'])) echo $groupInfo['mark']; ?></textarea>
                    </div>
                    <div class="btn-toolbar list-toolbar">
                      <a class="btn btn-primary btn-sm sys-btn-submit" data-loading="Loading..." ><i class="fa fa-save"></i> <span class="sys-btn-submit-str">Save</span></a>
                    </div>
                    <?php if(isset($id)): ?>
                      <input name="data[id]" type="hidden" value="<?php echo $id;?>" />
                    <?php endif; ?>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <?php echo widget('Admin.Common')->footer(); ?>
        </div>
    </div>
<?php echo widget('Admin.Common')->htmlend(); ?>

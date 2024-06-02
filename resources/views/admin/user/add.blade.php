<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">

          <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">Full in user information</a></li>
          </ul>

          <div class="row">
            <div class="col-md-4">
              <br>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                  <form id="tab" target="hiddenwin" method="post" action="<?php echo $formUrl; ?>">
                      @csrf
                    <div class="form-group input-group-sm">
                      <label>User name</label>
                      <input type="text" <?php if(isset($id)) echo 'disabled'; ?> value="<?php if(isset($userInfo['name'])) echo $userInfo['name']; ?>" name="data[name]" class="form-control">
                      <?php if(isset($id)): ?>
                        <input type="hidden" value="<?php if(isset($userInfo['name'])) echo $userInfo['name']; ?>" name="data[name]" class="form-control">
                      <?php endif; ?>
                    </div>

                    <div class="form-group input-group-sm">
                      <label>Password</label>
                      <input type="password" value="" name="data[password]" class="form-control">
                    </div>


                    <div class="form-group input-group-sm">
                      <label>User group</label>
                      <select name="data[group_id]" id="DropDownTimezone" class="form-control">
                        <?php if(isset($groupList) and is_array($groupList)): ?>
                          <?php foreach($groupList as $key => $value): ?>
                              <option value="<?php echo $value['id'];?>" <?php if(isset($userInfo['group_id']) && $userInfo['group_id'] == $value['id']) echo 'selected'; ?>><?php echo $value['group_name'];?></option>
                          <?php endforeach; ?>
                        <?php endif;?>
                      </select>
                    </div>
                    <div class="btn-toolbar list-toolbar">
                      <a class="btn btn-primary btn-sm sys-btn-submit" data-loading="Saving..." ><i class="fa fa-save"></i> <span class="sys-btn-submit-str">Save</span></a>
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

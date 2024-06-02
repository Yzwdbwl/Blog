<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">

          <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">Fill in function information</a></li>
          </ul>

          <div class="row">
            <div class="col-md-4">
              <br>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                  <form id="tab" target="hiddenwin" method="post" action="<?php echo $formUrl; ?>">

                          @csrf
                    <div class="form-group input-group-sm">
                      <label>Funtion name</label>
                      <input type="text" value="<?php if(isset($permissionInfo['name'])) echo $permissionInfo['name']; ?>" name="data[name]" class="form-control">
                    </div>
                    <div class="form-group input-group-sm">
                      <label>Moudle name</label>
                      <input type="text" value="<?php if(isset($permissionInfo['module'])) echo $permissionInfo['module']; ?>" name="data[module]" class="form-control" placeholder="Usually the name of the subfolder." >
                    </div>
                    <div class="form-group input-group-sm">
                      <label>Class name</label>
                      <input type="text" value="<?php if(isset($permissionInfo['class'])) echo $permissionInfo['class']; ?>" name="data[class]" class="form-control" placeholder="Generally, it is the class name of Controller." >
                    </div>
                    <div class="form-group input-group-sm">
                      <label>Function name</label>
                      <input type="text" value="<?php if(isset($permissionInfo['action'])) echo $permissionInfo['action']; ?>" name="data[action]" class="form-control" placeholder="Generally, it is the function name of Controller." >
                    </div>
                    <div class="form-group input-group-sm">
                      <label>Parent function</label>
                      <select class="form-control" name="data[pid]">
                        <option value="0">Please select parent function</option>
                        <?php echo $select;?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Remark</label>
                      <textarea name="data[mark]" rows="3" class="form-control"><?php if(isset($permissionInfo['mark'])) echo $permissionInfo['mark']; ?></textarea>
                    </div>
                    <div class="form-group input-group-sm">
                      <label>Whether to display as a menu</label>
                      <label class="radio-inline"><input type="radio" id="genderm" <?php if(isset($permissionInfo['display']) && $permissionInfo['display'] == 1) echo 'checked="checked"'; ?> value="1" name="data[display]"> Yes</label>
                      <label class="radio-inline"><input type="radio" id="genderf" <?php if(isset($permissionInfo['display']) && $permissionInfo['display'] == 0) echo 'checked="checked"'; ?> value="0" name="data[display]"> No</label>
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

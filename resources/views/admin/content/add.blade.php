<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">Fill in article information</a></li>
          </ul>

          <div class="row">
            <div class="col-md-8">
              <br>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                  <form id="tab" target="hiddenwin" method="post" action="<?php echo $formUrl; ?>">
                      @csrf
                    <div class="form-group input-group-sm">
                      <label>Title</label>
                      <input type="text" value="<?php if(isset($info['name'])) echo $info['name']; ?>" name="data[name]" class="form-control">
                    </div>

                    <div class="form-group">
                      <label>Subtitle</label>
                      <textarea name="data[subtitle]" rows="3" class="form-control"><?php if(isset($info['subtitle'])) echo $info['subtitle']; ?></textarea>
                    </div>

                    <div class="form-group input-group-sm">
                      <label>Author</label>
                      <input type="text" value="<?php if(isset($info['other'])) echo  $info['other']; ?>" name="data[other]" class="form-control" placeholder="Author">
                    </div>



                    <div class="form-group input-group-sm">
                      <label>Text</label>
                      <script id="container" name="data[content]" type="text/plain"><?php if(isset($info['content'])) echo $info['content']; ?></script>
                    </div>
                      <div class="form-group input-group-sm">
                          <label>Whether to publish</label>
                          <label class="radio-inline"><input type="radio" id="genderm" <?php if(isset($info['status']) && $info['status'] == 1) echo 'checked="checked"'; ?> value="1" name="data[status]"> Yes</label>
                          <label class="radio-inline"><input type="radio" id="genderf" <?php if(isset($info['status']) && $info['status'] == 0) echo 'checked="checked"'; ?> value="0" name="data[status]"> No</label>
                      </div>
                    <div class="btn-toolbar list-toolbar">
                      <a id="save-buttom" class="btn btn-primary btn-sm sys-btn-submit" data-loading="Saving..." ><i class="fa fa-save"></i> <span class="sys-btn-submit-str">Save</span></a>
                    </div>
                    <?php if(isset($id)): ?>
                      <input name="id" type="hidden" value="<?php echo $id;?>" />
                    <?php endif; ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php echo widget('Admin.Common')->footer(); ?>

        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="/lib/chosen/min.css">
    <script src="/lib/chosen/min.js" type="text/javascript"></script>
    <script src="/lib/ueditor/ueditor.config.js" type="text/javascript"></script>
    <script src="/lib/ueditor/ueditor.all.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        var config = {
          '.chosen-select'           : {},
          '.chosen-select-deselect'  : {allow_single_deselect:true},
          '.chosen-select-no-single' : {disable_search_threshold:10},
          '.chosen-select-no-results': {no_results_text:'Could not find it!'},
          '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }
    </script>
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
          autoHeight: false,
          initialFrameHeight: 500,
          autoFloatEnabled: true
        });

        $(document).keydown(function(e){
          // ctrl + s
          if( e.ctrlKey  == true && e.keyCode == 83 ){
            $('#save-buttom').trigger('click');
            return false; //     false        
          }
        });
    </script>
<?php echo widget('Admin.Common')->htmlend(); ?>

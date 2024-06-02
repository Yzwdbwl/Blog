<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">
        <div id="sys-list">
          <div class="row">
              <div class="col-md-12" id="ajax-reload">
                  <div class="panel panel-default">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th width="70">Choose</th>
                            <th>Comment content</th>
                            <th width="80">所属文章</th>
                            <th width="100">评论人</th>
                            <th width="150">评论时间</th>
                            <th width="80">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><input autocomplete="off" type="checkbox" name="ids[]" class="ids" value="<?php echo $value['id']; ?>"></td>
                              <td><?php echo $value['content']; ?></td>
                              <td><a target="_blank" href="<?php echo route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['object_id']]); ?>"><?php echo '查看'; ?></a></td>
                              <td><?php echo $value['nickname'] == '__blog.author__' ? '<span style="color:red;">博主</span>' : $value['nickname']; ?></td>
                              <td>
                                <?php echo date('Y-m-d H:i', $value['time']); ?>
                              </td>
                              <td>
                                <?php $result = widget('Admin.Comment')->reply($value); echo $result['html']; ?>
                                <?php echo widget('Admin.Comment')->delete($value); ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                      </div>
                  </div>
              </div>
          </div>
          <?php echo $deleteSelectButton = widget('Admin.Comment')->deleteSelect(); ?>
          <?php echo $page; ?>
        </div>
        <?php echo widget('Admin.Common')->footer(); ?>
        </div>
    </div>
    <script type="text/javascript">
    <?php if( ! empty($deleteSelectButton)): ?>
      $('.pl-delete').click(function() {
          var ids = plSelectValue('ids');
          if(ids.length == 0) {
              alertNotic('Please select the comment you want to delete first');
              return false;
          }
          confirmNotic('Are you sure delete?', function() {
            var url = '<?php echo R('common', 'blog.comment.delete'); ?>';
            var params = {id:ids};
            Atag_Ajax_Submit(url, params, 'POST', $('.pl-delete'), 'ajax-reload');
          });
      });
    <?php endif; ?>

    <?php if($result['hasPermission']): ?>
    var __d;
    $(document).on('click', '.comment-reply', function() {
        var _id = $(this).attr('data-id');
        __d = dialog({
          title: 'Reply to comment',
          id: 'comment-reply',
          fixed: true,
          width: 500,
          height: 350,
          okValue: 'Yes',
          ok: function() {
            var _this = this;
            _this.title('Loading...');
            $('#article-comment-reply-form').submit();
            setTimeout(function(){
              _this.title('Reply to comment');
            },1000)
            return false;
          },
          onshow: function () {
            loadComment(_id, this);
          },
          cancelValue: 'Cancel',
          cancel: function () {}
        });
        __d.showModal();
    });

    //load 内容到弹窗中
    function loadComment(commentid, dialogObj) {
      var url = '<?php echo R('common', 'blog.comment.reply'); ?>';
      $.get(url, {commentid: commentid}, function(data){
        if( ! dialogObj) dialogObj = __d;
        dialogObj.content(data);
      });
    }
    <?php endif; ?>
    </script>
<?php echo widget('Admin.Common')->htmlend(); ?>
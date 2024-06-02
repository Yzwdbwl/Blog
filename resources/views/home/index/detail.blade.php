<?php $headerObject = new \stdClass(); ?>
<?php $headerObject->description = $info['subtitle']; ?>
<?php echo widget('Home.Common')->header($headerObject); ?>
    <div class="content col-md-9">
        <?php echo widget('Home.Common')->top(); ?>

        <div class="main-content">
          <div>
            <h2><?php echo $info['name']; ?></h2>
          </div>
          <div class="row blog-post">
            <div class="col-sm-9 main-content">

                <div id="blog-posts">
                    <p class="pull-right small">
                        <a href="#detail-comment"><i class="icon-comments"></i>Cheak commons:</a>
                    </p>
                    <p class="text-sm p_h_info">
                        <span class="span_h_info">side title：</span><?php echo $info['subtitle']; ?> &nbsp&nbsp&nbsp
                        <span class="span_h_info">author：</span><?php echo $info['other']; ?> &nbsp&nbsp&nbsp
                        <span class="span_h_info">time：</span><?php echo $info['create_at']; ?>

                    </p>
                    <div class="h-detail-summary"><?php echo $info['subtitle']; ?></div>
                    <div class="main-article-detail">
                        <?php echo $info['content']; ?>
                    </div>
                </div>


            </div>
            <?php echo widget('Home.Common')->right(); ?>
          </div>

        <?php echo widget('Home.Common')->footer(); ?>

        </div>
    </div>
<?php echo widget('Home.Common')->htmlend(); ?>

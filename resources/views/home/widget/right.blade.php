<div class="col-sm-3 sidebar">

    <div class="widget">

        <h3>Tag</h3>
        <p class="widget-body">
            <?php foreach($tagsInfo as $key => $value): ?>
                <a href="<?php echo route('home', ['class' => 'index', 'action' => 'index', 'tag' => $value]); ?>"><span class="large label tag label-info"><?php echo $value; ?></span></a>
            <?php endforeach; ?>
        </p>

    </div>

</div>

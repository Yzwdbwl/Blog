<div class="header">
  <div class="input-group search pull-right hidden-sm hidden-xs">
    <div class="input-group">
      <input type="text" class="form-control input-sm" id="search-keyword" placeholder="Search what you want" value="<?php if(isset($object->keyword)) echo $object->keyword; ?>">
      <span class="input-group-btn">
          <button type="button" class="btn btn-primary btn-sm" id="search"><i class="fa fa-search "></i></button>
      </span>
    </div>
  </div>
  <h1 class="page-title"><a href="/">Wind</a></h1>
  <p>Achieve the dream</p>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#search').on('click', function(){
      var keyword = $('#search-keyword').val();
      window.location.href = '<?php echo route("home", array("class" => "search", "action" => "index")); ?>?keyword='+keyword;
    });

    $('#search-keyword').keyup(function(event){
      if (event.keyCode == 13) {
        $('#search').trigger('click');
      }
    });
  });
</script>

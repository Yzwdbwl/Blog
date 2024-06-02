<?php echo widget('Admin.Common')->header(); ?>

  <style type="text/css">
    body {background: none;}
  </style>

  <!--CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/lib/webuploader/webuploader.css'); ?>">
  <!--JS-->
  <script type="text/javascript" src="<?php echo loadStatic('/lib/webuploader/webuploader.min.js'); ?>"></script>

  <div class="main-content">
    <div id="sys-list" style="padding-left:20px; padding-right:20px;">
      <div class="row">

        <!--dom-->
        <div id="uploader-comtainer">

            <div class="col-tab">

                  <div class="upload-content pad-10 on" id="div_swf_1">
                      <div>
                          <div id="addnew" class="addnew"></div>
                          <div id="filePicker" class="select-upload-file-buttom">Choose a picture</div>
                          <div style="float:left;">
                            <a class="btn btn-primary" id="upload-btn-save" style="font-size: 12px;" >
                              Upload now
                            </a>
                          </div>
                          <div class="clear"></div>
                          <div class="onShow" id="nameTip">Up to <font color="red"> <?php echo (isset($args['nums']) and $args['nums']) ? intval($args['nums']) : 1; ?></font> attachment can be uploaded, and the maximum size of a single file is <font color="red"><?php echo (isset($args['filesize']) and $args['filesize']) ? intval($args['filesize']) : 2;?> MB</font></div>
                          <div class="bk3"></div>

                          <div class="lh24">Support <font style="font-family: Arial, Helvetica, sans-serif"><?php echo $args['alowexts']; ?></font> format</div><span style="display: none"><input type="checkbox" onclick="change_params()" value="1" id="watermark_enable">       </span>
                      </div>
                      <div class="bk10"></div>
                      <fieldset id="swfupload" class="blue pad-10">
                      <legend>List</legend>
                        <div id="fileList" class="uploader-list"></div>
                      </fieldset>
                  </div>
            </div>

        </div>


        <script type="text/javascript">
            let token = document.head.querySelector('meta[name="csrf-token"]').content;
            $(function() {
            var $list = $('#fileList'),
                ratio = window.devicePixelRatio || 1,
                thumbnailWidth = 100 * ratio,
                thumbnailHeight = 100 * ratio,
                // Web Uploader
                uploader;
                // Web Uploader
                uploader = WebUploader.create({
                    auto: false,
                    runtimeOrder: 'html5,flash',
                    fileVal: 'file',
                    fileNumLimit: <?php echo (isset($args['nums']) and $args['nums']) ? intval($args['nums']) : 1; ?>,
                    fileSingleSizeLimit: <?php echo (isset($args['filesize']) and $args['filesize']) ? intval($args['filesize']) : 2;?>*1024*1024,
                    duplicate: true,
                    formData: {args:'<?php echo $parpams['args']; ?>', authkey:'<?php echo $parpams['authkey']; ?>',_token:token},
                    swf: SYS_DOMAIN + '/lib/webuploader/Uploader.swf',
                    server: '<?php echo R('common', 'foundation.upload.process'); ?>',
                    pick: '#filePicker',
                    accept: {
                        title: 'all',
                        extensions: '<?php echo $args['alowexts']; ?>'
                    }
                });

                uploader.on( 'fileQueued', function( file ) {
                    var $li = $(
                            '<div id="' + file.id + '" class="file-item thumbnail" title="' + file.name + '">' +
                                '<img>' +
                                '<div class="' + file.id + '-remove web-upload-remove" title="Delete"><i class="fa fa-times-circle"></i></div>'+
                            '</div>'
                            ),
                        $img = $li.find('img');

                    $list.append( $li );

                    uploader.makeThumb( file, function( error, src ) {
                        var $fileExt = fileExt(file.ext);
                        if ( error ) {
                            $img.attr( 'src', SYS_DOMAIN+'/images/ext/'+ $fileExt+'.png');
                            $img.attr('width', thumbnailWidth).attr('height',thumbnailHeight);
                            return;
                        }

                        $img.attr( 'src', src );
                    }, thumbnailWidth, thumbnailHeight );

                    removeImage(file);

                });

                //Delete picture
                uploader.on('fileDequeued', function (file) {
                    removeImageView(file);
                });

                uploader.on( 'uploadProgress', function( file, percentage ) {
                    var $li = $( '#'+file.id ),
                        $percentP = $li.find('.progress'),
                        $percent = $li.find('.progress span');

                    
                    if ( !$percent.length ) {
                        $percent = $('<p class="progress"><span class="text-show-yes">Loading...</span></p>')
                                .appendTo( $li )
                                .find('span');
                    }
                    $percent.css( 'width', percentage * 100 + '%' );
                    $percentP.css( 'width', percentage * 100 + '%' );
                });

                uploader.on( 'uploadSuccess', function( file, response ) {
                    $( '#'+file.id ).addClass('upload-state-done').append('<input type="hidden" class="upload-reponse" value="'+response.file+'" />');
                    $('.progress .text-show-yes').html('Upload sucessed');
                });

                uploader.on( 'uploadError', function( file ) {
                    var $li = $( '#'+file.id ),
                        $error = $li.find('div.error');

                    if ( !$error.length ) {
                        $error = $('<div class="error"></div>').appendTo( $li );
                    }

                    $error.text('upload failed');
                });

                uploader.on('error', function (code, file) {
                    if (code == 'Q_TYPE_DENIED' || code == 'F_EXCEED_SIZE') {
                        removeImage(file);
                    }
                });

                uploader.on( 'uploadComplete', function( file ) {
                    setTimeout(function(){
                      $( '#'+file.id ).find('.progress').remove();
                    }, 800 );
                });

                function removeImage(file) {
                  $(document).on('click', '.' + file.id + '-remove', function(){
                    uploader.removeFile(file);
                  });
                }

                //Delete picture view
                function removeImageView(file) {
                  var $div = $('#' + file.id);
                  $div.remove();
                }

                
                $('#upload-btn-save').click(function(){
                  uploader.upload();
                });

                function fileExt(fileext) {
                    if(fileext == 'zip' || fileext == 'rar') fileext = 'rar';
                    else if(fileext == 'doc' || fileext == 'docx') fileext = 'doc';
                    else if(fileext == 'xls' || fileext == 'xlsx') fileext = 'xls';
                    else if(fileext == 'ppt' || fileext == 'pptx') fileext = 'ppt';
                    else if (fileext == 'flv' || fileext == 'swf' || fileext == 'rm' || fileext == 'rmvb') fileext = 'flv';
                    else fileext = 'do';
                    return fileext;
                }

            });
        </script>

      </div>
    </div>
  </div>
<?php echo widget('Admin.Common')->htmlend(); ?>

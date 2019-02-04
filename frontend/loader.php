<?php 

function show_html_content(){

    
    $id_image =  get_option( 'media_selector_attachment_id', 0 );

    if($id_image != 0)
    {
      $url =   wp_get_attachment_url($id_image);
    }

    ?>

        <div id="loading">
            <img id="loading-image" src="<?php echo $url ?>" alt="Loading..." />
        </div>

        <style>

            #loading {
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            position: fixed;
            display: none;
            opacity: 0.7;
            background-color: #fff;
            z-index: 99;
            text-align: center;
            }

            #loading-image {
                position:absolute; 
                left:0; right:0;
                top:0; bottom:0;
                margin:auto;
                overflow:auto;
                width: 150px !important;
                height: 150px !important;
            }

        </style>
        
        <script language="javascript" type="text/javascript">

            jQuery(document).on('submit', 'form', function(e){
                e.preventDefault();
                jQuery('#loading').css('display', 'block');
                setTimeout( () => {
                    e.currentTarget.submit();
                }, 3);
            });

            jQuery(window).load(function() {
                jQuery('#loading').hide();
            });
        </script>

    <?php
}

show_html_content();
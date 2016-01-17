<?php
function modern_lite_shortcode($atts)
{
    ob_start();
    ?>
    <?php
    extract(shortcode_atts(
            array(
                'ids' => '1',
            ), $atts)
    );
    $args = array(
        'p' => $atts['ids'],
        'post_type' => array('slider'),
        'post_status' => array('published'),
    );
    $query = new WP_Query($args);
    global $post;
    ?>
    <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
    <?php
    $modern = get_post_meta($post->ID, "idpslider_slide", true);
    $count = count($modern);
    ?>
    <div class="container-fluid">
        <div class="row">
            <section class="section-white">

                <div id="Modern" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php for ($i = 0; $i < $count; $i++) {
                            if ($i == 0) {
                                $class = 'active';
                            }
                            if ($i != 0) {
                                $class = '';
                            }
                            ?>
                            <li class="<?php echo $class; ?>" data-target="#Modern"
                                data-slide-to="<?php echo $i; ?>"></li>
                        <?php } ?>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <?php foreach ($modern as $k => $v) {
                            if ($k == 0) {
                                $clas = 'active';
                            }
                            if ($k != 0) {
                                $clas = '';
                            }
                            $title = $v['title']; //название слайда
                            $image_id = $v['image_id']; // id картинки
                            $image = $v['image']; // url картинки
                            $image_caption = $v['image_caption']; // подпись к картинке "alt"
                            ?>
                            <div id="img-<?php echo $image_id; ?>" class="item <?php echo $clas; ?>">
                                <img src="<?php echo $image; ?>" alt="<?php echo $image_caption; ?>">
                                <div class="carousel-caption">
                                    <h2><?php echo $title; ?></h2>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#Modern" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#Modern" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </section>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php
    wp_reset_postdata();
endwhile; endif;
    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
}

add_shortcode('Modern-lite', 'modern_lite_shortcode');
?>
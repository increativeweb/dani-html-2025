<?php 
$postID = get_query_var( 'postid' ); 
$post_excerpt = get_query_var( 'post_excerpt' );
?>
<article class="post-card" data-post-id="<?php echo $postID; ?>">
    <div class="card-img">
        <?php 
            $categories = get_the_category( $postID );
            if ( ! empty( $categories ) ) {
                echo '<a href="#'. $categories[0]->slug . '" class="post-category">'. esc_html( $categories[0]->name ). '</a>';
            }
        ?>
        <!-- <a href="#" class="post-category">Tech</a> -->
        <img src="<?php echo esc_url( icw_get_post_thumbnail_url( $postID ) ); ?>" alt="<?php echo esc_attr( get_the_title( $postID ) ); ?>">
    </div>
    <div class="card-body">
        <div class="post-meta">
            <span class="post-date"><?php echo get_the_date( 'M d, Y', $postID ); ?> </span><span>|</span><span
                class="post-read-time"><?php echo round(str_word_count(get_the_content($postID)) / 300); ?> min read</span>
        </div>
        <h2 class="card-title"><?php echo esc_html( get_the_title( $postID ) ); ?></h2>
        <?php if($post_excerpt != 'hide') { 
            $excerpt = wp_trim_words(
                get_the_excerpt( $postID ) ?: get_the_content( $postID ),
                get_the_excerpt( $postID ) ? 25 : 20
            );

            if ( ! empty( $excerpt ) ) {
                echo '<div class="card-info">'. $excerpt. '</div>';
            }
        } ?>
    </div>
    <div class="card-action">
        <a href="<?php echo esc_url( get_the_permalink( $postID ) ); ?>">Read More</a>
    </div>
</article>
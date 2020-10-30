<?php
    get_header(); 
    $keyword = get_search_query();
    wpse_get_template_part( 'page-templates/newsflow', null, array('keyword' => $keyword ));
    get_footer(); 
?>
<?php
    $keyword = get_search_query();
    $activeClass = $keyword != '' ? 'active' : '';
?>
<form id="searchbox_<?php echo $type; ?>" action="/search" class="<?php echo $activeClass; ?>" method="get">
    <input class="form-control" name="keyword" type="text" placeholder="Search..." value="<?php echo $keyword; ?>" maxlength="100"/>
    <button class="btn" type="submit">
        <span class="icons search"></span>
    </button>
</form>
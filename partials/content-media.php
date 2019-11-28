<?php
	
	
	$id = get_the_ID();
    $author = get_post_meta( $id, '_media_lib_author', true );
    
    $dld = get_post_meta( $id, '_media_lib_file', true );
    $filename = basename($dld).PHP_EOL;
    
    $dld2 = get_post_meta( $id, '_media_lib_file2', true );
    $filename2 = basename($dld2).PHP_EOL;
    
    $dld3 = get_post_meta( $id, '_media_lib_file3', true );
    $filename3 = basename($dld3).PHP_EOL;
    
    $dld4 = get_post_meta( $id, '_media_lib_file4', true );
    $filename4 = basename($dld4).PHP_EOL;
    
    $filearray = array(
    	$dld => $filename,
        $dld2 => $filename2,
        $dld3 => $filename3,
        $dld4 => $filename4
	);
    
    $location = get_the_terms($id, 'countries');
    $language = get_the_terms($id, 'languages');
    $category = get_the_terms($id, 'category');
    $type_tax = get_the_terms($id, 'types');
    
    if (!empty($author)) : ?>
    <p><b>Author</b>: <?php echo $author;?></p>
    <?php endif;
    
    if (!empty($location)) : ?>
    <p><b>Location</b>: <?php
    foreach($location as $loc) {
        echo $loc->name;
    }?></p>
    <?php endif;
    
    if (!empty($language)):?>
	<p><b>Language</b>: <?php
	foreach($language as $lang) {
		echo $lang->name;
	}?></p>
	<?php endif;
	
	if (!empty($category)):?>
	<p><b>Category</b>: <?php
    foreach($category as $cat) {
		echo $cat->name;
	}?></p>
	<?php endif;
	
	if (!empty($type_tax)):?>
	<p><b>Type</b>: <?php
	foreach($type_tax as $type) {
		echo $type->name;
	}?></p>
	<?php endif; ?>
	
	<p>
	<?php foreach ($filearray as $file => $name) {
		if (!empty($file)) {
        	echo "<a href=\"$file\" class=\"btn btn-default\">$name</a> ";
        }
    }?>
    </p>
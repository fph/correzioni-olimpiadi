<div id='PagePath'>
	<?php
		global $v_PathDescription;
		$first=0;
		foreach($v_PathDescription as $name => $link) {
			if( $first==1 ) { 
	?>
				<strong class='PathSeparator'> < </strong>
	<?php } ?>
			<a class='PathElement' href='<?php echo $link ?>'>
	<?php
			echo $name;
			$first=1;
	?> 
			</a>
	<?php } ?>
</div>

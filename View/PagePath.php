<div id='PagePath'>
	<?php
		global $v_PathDescription;
		$first=0;
		foreach($v_PathDescription as $name => $link) {
			if( $first==1 ) { 
	?>
				<div class='PathSeparator'> < </div>
	<?php } ?>
			<div class='PathElement'> <a href='<?php echo $link ?>'>
	<?php
			echo $name;
			$first=1;
	?> 
			</a></div>
	<?php } ?>
</div>

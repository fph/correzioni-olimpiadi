<head>
  <link href="global.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php
		include "UpperBar.php"
	?>
	<div id="internalBody">
		<?php
			include $_GET["PageName"];
		?>
	</div>
</body>

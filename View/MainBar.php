<?php
	global $MainBarUserId, $MainBarUsername, $v_content;
?>

<header class="text-white" id="MainBar">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark">
                <a class="navbar-brand fs-3 text-truncate" href='<?=($v_content !== 'ParticipationRequest')?'index.php':'ParticipationRequest.php'?>'>
                    Correzioni Olimpiadi
                </a>
				<?php if ($MainBarUserId != -1) { ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link text-white" href='AccountSettings.php'> 
                                    <?=$MainBarUsername?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href='Logout.php'> Logout </a>
                            </li>                        
                    </ul>
                </div>
				<?php } ?>
            </nav>
        </div>
    </header>
<?php

function aireCercle($rayon) {
	return M_PI * $rayon * $rayon;
}

$rayon = 5;
echo "Pour un rayon de ".$rayon.", l'aire est ".aireCercle($rayon);
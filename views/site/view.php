<?php
use yii\helpers\html;
use yii\widgets\ActiveForm;

$this->title = 'Yii2 CRUD Application';
?>
<div class="site-index">

	<h1>View Post</h1>

	<div class="body-content">
=		<ul class="list-group">
		  <li class="list-group-item d-flex justify-content-between align-items-center">
			<?php echo $post->title;?>
			<span class="badge badge-primary badge-pill">14</span>
		  </li>
		  <li class="list-group-item d-flex justify-content-between align-items-center">
			<?php echo $post->description;?>
			<span class="badge badge-primary badge-pill">2</span>
		  </li>
		  <li class="list-group-item d-flex justify-content-between align-items-center">
			<?php echo $post->category;?>
			<span class="badge badge-primary badge-pill">1</span>
		  </li>
		</ul>

		<div class ="row">
			<a href = <?php echo yii::$app->homeUrl;?> class = "btn btn-primary">Go Back</a>
		</div>
    </div>
</div>
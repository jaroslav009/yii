<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(); ?>
<link rel="stylesheet" href="css/post.css">
	<?php $f = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?= $f->field($form, 'title'); ?>
		<?= $f->field($form, 'name'); ?>
		<?= $f->field($form, 'content')->textArea(); ?>
		<?= $f->field($form, 'file')->fileInput(); ?>
		<?= Html::submitButton('submit', ['class' => 'btn btn-lg btn-primary']); ?>
	<?php ActiveForm::end(); ?>
	<?php foreach ($postDB as $post) { ?>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="post">
					<div class="title_post">
						<h1 style="text-align: center;"><?= $post->title ?></h1>
						<p><?= $post->content ?></p>
						<i><b>Author</b> <?= $post->name ?></i>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="picture_post">
					<?php if ($post->picture) {?>
						<img src="photos/<?= $post->picture ?>" alt="<?= $post->title ?>">
					<?php } ?>
					
				</div>
			</div>
		</div>
	</div>
		
	<?php } ?>	

<?php Pjax::end(); ?>
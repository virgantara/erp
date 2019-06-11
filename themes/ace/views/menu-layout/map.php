<?php
/* @var $this MenuLayoutRbacController */
/* @var $model MenuLayoutRbac */

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\ActiveForm;

$this->title = 'Role Menu Mapping';
$this->params['breadcrumbs'][] = ['label' => 'Menu Layout', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<style type="text/css">
	/* RADIOS & CHECKBOXES STYLES */
/* SOURCE: https://gist.github.com/dciccale/1367918 */
/* No more blue blur border */
input {
  outline: none;
}

/* base styles */
input[type="checkbox"] {
    height: 20px;
    width: 20px;
    vertical-align: middle;
    margin: 0 0.4em 0.4em 0;
    background: rgba(255, 255, 255, 1);
    border: 1px solid #AAAAAA;
    -webkit-appearance: none;
}

/* border radius for radio*/


/* border radius for checkbox */
input[type="checkbox"] {
    border-radius: 2px;
}

/* hover state */
input[type="checkbox"]:not(:disabled):hover {
    border: 1px solid rgba(58, 197, 201, 1);
}

/* active state */
input[type="checkbox"]:active:not(:disabled) {
    border: 1px solid rgba(58, 197, 201, 1);
}

/* input checked border color */

input[type="checkbox"]:checked {
    border: 1px solid rgba(58, 197, 201, 1);
}

input[type="checkbox"]:checked:not(:disabled) {
    background: rgba(58, 197, 201, 1);
}


/* checkbox checked */
input[type="checkbox"]:checked:before {
    font-weight: bold;
    color: white;
    content: '\2713';
    margin-left: 2px;
    font-size: 14px;
}
/*
table thead tr{
    display:block;
}


table  tbody{
  display:block;
  height:600px;
  overflow:auto;
}
*/
</style>
<h1>Role Mapping</h1>
 <?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <i class="icon fa fa-check"></i><?= Yii::$app->session->getFlash('success') ?>
         
    </div>
<?php endif; ?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
	<div class="col-xs-12">

		<table class="table table-striped">
			<thead>
			<tr>
				<th >Menu</th>
				<?php 
				foreach($listRole as $role)
				{
					echo '<th style="text-align:center">'.$role->name.'<br><input type="checkbox" class="role" data-item="'.$role->name.'"></th>';
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?php 
			$i =0;
			$j = 1;
			$k = 0;
			foreach($listMenu as $menu)
			{


			?>
			<tr>
				<td><?php
				$m = '';
				if(!empty($menu->parent0)){
					
					echo ' - - - ';

					if(!empty($menu->parent0->parent0)){
						$k++;
						echo ' - - - ';
						
						echo $menu->parent0->parent0->nama.' > ';
					}	
					else
					{
						$j++;
						$k=0;
					}

					echo $menu->parent0->nama.' > ';
				}

				else{
					$j=1;
					$i++;
					;
				}

				echo ' '.$menu->nama;



				?>
					
				</td>
				<?php 
				foreach($listRole as $role)
				{

					$checked = $values[$menu->id][$role->name] == 1 ? 'checked' : '';

					echo '<td width="100px" style="text-align:center"><label for="ch_'.$menu->id.'_'.$role->name.'"><input type="checkbox" '.$checked.' class="role_'.$role->name.'" name="ch_'.$menu->id.'_'.$role->name.'" id="ch_'.$menu->id.'_'.$role->name.'"> </label></td>';
				}
				?>
			</tr>
			<?php 
			}
			?>
		</tbody>
		</table>		
	</div>
</div>
	<div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
        	<input type="hidden" value="1" name="flag"/>
		<?= Html::submitButton('Update Role', ['class' => 'btn btn-success']) ?>
	  </div>
      </div>
            
    <?php ActiveForm::end(); ?>
<?php
$script = "
$(document).ready(function(){
	$('.role').change(function(){

		var value = this.checked;
		var val = $(this).attr('data-item');
		$('.role_'+val).each(function(){
			$(this).prop('checked',value);
		});
	});
});


";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);


?>
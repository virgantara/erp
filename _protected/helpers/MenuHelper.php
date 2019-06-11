<?php
namespace app\helpers;

use Yii;

use app\models\MenuLayout;

/**
 * Css helper class.
 */
class MenuHelper
{

	public static function getMenuItems()
	{
		$userRole = Yii::$app->user->identity->access_role;
		$menuItems = [];

		$listMenu = MenuLayout::find()->where(['level'=>1])->orderBy(['urutan'=>SORT_ASC])->all();

		foreach($listMenu as $m1)
		{

			$privileges = [];
	       	foreach($m1->menuLayoutRbacs as $role)
			{
				$privileges[] = Yii::$app->user->can($role->role_name);
			}

			$tmp = [
				'label' => '<i class="menu-icon '.$m1->icon.'"></i><span class="menu-text"> '.$m1->nama.' </span>', 
		        'url' => [$m1->link],
		        'visible' => in_array($userRole, $privileges)
			];

			if(count($m1->menuLayouts) > 0)
			{
				$tmp = [
					'label' => '<i class="menu-icon '.$m1->icon.'"></i><span class="menu-text"> '.$m1->nama.' </span><i class="caret"></i>',
		            'url' => '#',
		            'visible' => in_array($userRole, $privileges),
		            'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
		            'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
		        ];	
			}

			foreach($m1->getSubmenus() as $m2)
			{
				$privileges = [];
		       	foreach($m2->menuLayoutRbacs as $role)
				{
					$privileges[] = Yii::$app->user->can($role->role_name);
				}

				$subtmp = [
					'label' => '<i class="menu-icon '.$m2->icon.'"></i><span class="menu-text"> '.$m2->nama.' </span>',  
			        'url' => [$m2->link],
			        'visible' => in_array($userRole, $privileges)
				];

				if(count($m2->menuLayouts) > 0)
				{
					$subtmp = [
						'label' => '<i class="menu-icon '.$m2->icon.'"></i><span class="menu-text"> '.$m2->nama.' </span><i class="caret"></i>',
			            'url' => '#',
			            'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
			            'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
			            'visible' => in_array($userRole, $privileges)
			        ];
				}

				foreach($m2->getSubmenus() as $m3)
				{
					$privileges = [];
			       	foreach($m3->menuLayoutRbacs as $role)
					{
						$privileges[] = Yii::$app->user->can($role->role_name);
					}

					$ssm = [
						'label' => '<i class="menu-icon '.$m3->icon.'"></i><span class="menu-text"> '.$m3->nama.' </span>',  
			        	'url' => [$m3->link],
			        	'visible' => in_array($userRole, $privileges)
					];

					$subtmp['items'][] = $ssm;
				}

				$tmp['items'][] = $subtmp;
			}


			$menuItems[] = $tmp;


		}

		return $menuItems;		
	}

   
}
<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_menu_layout".
 *
 * @property int $id
 * @property string $nama
 * @property string $icon
 * @property string $link
 * @property int $parent
 * @property int $level
 * @property int $urutan
 * @property string $created_at
 * @property string $updated_at
 *
 * @property MenuLayout $parent0
 * @property MenuLayout[] $menuLayouts
 * @property MenuLayoutRbac[] $menuLayoutRbacs
 */
class MenuLayout extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_menu_layout';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'link'], 'required'],
            [['parent', 'level', 'urutan'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama', 'link'], 'string', 'max' => 255],
            [['icon'], 'string', 'max' => 100],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => MenuLayout::className(), 'targetAttribute' => ['parent' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'icon' => 'Icon',
            'link' => 'Link',
            'parent' => 'Parent',
            'level' => 'Level',
            'urutan' => 'Urutan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getSubmenus()
    {
        $menu = MenuLayout::find()->where(['parent'=>$this->id])->orderBy(['urutan'=> SORT_ASC])->all();
        return $menu;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(MenuLayout::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuLayouts()
    {
        return $this->hasMany(MenuLayout::className(), ['parent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuLayoutRbacs()
    {
        return $this->hasMany(MenuLayoutRbac::className(), ['menu_id' => 'id']);
    }
}

<?php

namespace app\models;

use Yii;

use \app\rbac\models\AuthItem;
/**
 * This is the model class for table "erp_menu_layout_rbac".
 *
 * @property int $id
 * @property string $role_name
 * @property int $menu_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AuthItem $roleName
 * @property MenuLayout $menu
 */
class MenuLayoutRbac extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_menu_layout_rbac';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_name', 'menu_id'], 'required'],
            [['menu_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['role_name'], 'string', 'max' => 64],
            [['role_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['role_name' => 'name']],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuLayout::className(), 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'menu_id' => 'Menu ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'role_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(MenuLayout::className(), ['id' => 'menu_id']);
    }
}

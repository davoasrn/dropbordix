<?php

/**
 * This is the model class for table "lib_category".
 *
 * The followings are the available columns in table 'lib_types':
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Goods[] $goods
 */
class LibCategory extends CActiveRecord
{
    
        public $countAndName;
        protected $_children;
        const CAR = 1;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lib_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('parent_id', 'safe'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, parent_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'announcements' => array(self::HAS_MANY, 'Announcement', 'category_id'),
			'parent' => array(self::BELONGS_TO,'LibCategory','parent_id'),
                        'childs' =>array(self::HAS_MANY,'LibCategory',array('parent_id' => 'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Identification number',
			'name' => 'Type name',
			'parent_id' => 'Parent',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LibTypes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function afterFind(){
		parent::afterFind();
                $this->_children = trim($this->id.','.$this->getChildrenString($this->id),',');
                if($this->parent_id == 0){
                        //$parentId = trim($this->id.','.$this->getChildrenString($this->id),',');
                        $countName = Announcement::model()->count('category_id in ('.$this->_children.')');
                        $this->countAndName = $this->name.'('.$countName.')';
                }
                
	}
        
        public function getChildren($parent, $level=0) { 
                $criteria = new CDbCriteria;
                $criteria->condition='parent_id=:id';
                $criteria->params=array(':id'=>$parent);
                //$model = $this->findAll($criteria);
                $model = self::model()->findAll($criteria);
                foreach ($model as $key) {
                    echo str_repeat(' — ', $level) . $key->name . "<br />";
//                    $this->getChildren($key->id, $level+1);
                    self::getChildren($key->id, $level+1);
                }
            }
        public function getChildrenString($parent) { 
                $criteria = new CDbCriteria;
                $criteria->condition='parent_id=:id';
                $criteria->params=array(':id'=>$parent);
                $model = self::model()->findAll($criteria);
                $storage = '';
                foreach ($model as $key) {
                    $storage .= $key->id . ","; 
                    $storage .= self::getChildrenString($key->id);
                }
                return $storage;
            }
        
//        public function get_key($arr, $id)
//        {
//            foreach ($arr as $key => $val) {
//                if ($val['id'] === $id) {
//                    return $key;
//                }
//            }
//            return null;
//        }
//
//        public function get_parent($arr, $id)
//        {
//            $key = get_key($arr, $id);
//            if ($arr[$key]['parent'] == 0)
//            {
//                return $id;
//            }
//            else 
//            {
//                return get_parent($arr, $arr[$key]['parent']);
//            }
//        }
//        
//        
//        
//
//        public function getChildren(){
//                if(null === $this->_children){
//                        $this->_children = self::model()->findAll('parent_id='.$this->id);
//                        var_dump($this->_children,$this->id);die;
//                }
//                return $this->_children;
//        }
//        // to get father
//        public function getFather(){
//
//                if($this->parent_id!=0)  // isnt root?
//                {
//
//                        $model = LibCategory::model()->findByPk($this->parent_id);
//                        return $model;
//                }
//                return null;
//        }
//        // to play
//        // scope to get root categories
//        public function whereRoot(){
//                $this->getDbCriteria()->addCondition('parent_id=0');
//
//                return $this;
//        }
//        protected function loopChildren($models, $side='', $id='-1'){
//                $items = array();
//                foreach($models as $model){
//                        if($id == $model->id) continue;
//                        $items[] = array('id'=> $model->id,'name'=> $side.$model->name);
//                        if($model->children){
//                                $items= CMap::mergeArray($items,$this->loopChildren($model->children,$side.'--', $id));
//                        }
//                }
//                return $items;
//        }
//        // building an array to be used with a dropdown list
//        public function getTreeListArray($id='-1'){
//                $models = self::model()->whereRoot()->findAll();
//
//                $items = array();
//                if($models){
//                        $items = $this->loopChildren($models, '', $id);
//                }
//
//                return $items;
//        }
}
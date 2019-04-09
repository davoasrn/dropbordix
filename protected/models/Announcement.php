<?php

/**
 * This is the model class for table "announcement".
 *
 * The followings are the available columns in table 'announcement':
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property integer $status
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property integer $user_id
 * @property string $add_date
 * @property string $price
 * @property string $bid
 * @property string $site_url
 * @property string $video_url
 * @property integer $commentsCount
 * @property integer $video_type
 * @property integer $view_count
 *
 * The followings are the available model relations:
 * @property AutoDetail[] $autoDetails
 * @property Files[] $files
 * @property LibTypes $type
 */
class Announcement extends CActiveRecord
{
    
        public $category_saved, $check, $video, $video_hidden_name;

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'announcement';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, category_id, price', 'required', 'on' =>'create'),
			array('name, price, category_id', 'required', 'on' =>'notLogined'),
			array('category_id, status, view_count, user_id', 'numerical', 'integerOnly'=>true),
			array('price, video_type', 'numerical'),
			//array('bid', 'checkBid'),
			array('name', 'length', 'max'=>255),
			array('price, bid', 'length', 'max'=>10),
			array('description, site_url, video_url, video, video_type', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, category_id, view_count, status, video_type, description, site_url, video_url, start_date, end_date, user_id, add_date, price, bid', 'safe', 'on'=>'search'),
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
			'autoDetails' => array(self::HAS_ONE, 'AutoDetail', 'announcement_id'),
			'files' => array(self::HAS_MANY, 'Files', 'announcement_id',
                            'condition' => 'type != :type ',
                            'params' => array(
                                ':type' => 1
                            )
                        ),
			'file' => array(self::HAS_ONE, 'Files', 'announcement_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'category' => array(self::BELONGS_TO, 'LibCategory', 'category_id'),
			'libStatus' => array(self::BELONGS_TO, 'LibAnnouncementStatus', 'status'),
			'announcementPaidVideo' => array(self::HAS_ONE, 'AnnouncementPaid', 'announcement_id',
                            'condition' => 'type_id = :type and status = :status',
                            'params' => array(
                                ':type' => LibPaidServices::video,
                                ':status' => 1
                            )
                        ),
			'announcementPaidSite' => array(self::HAS_ONE, 'AnnouncementPaid', 'announcement_id',
                            'condition' => 'type_id = :type and status = :status',
                            'params' => array(
                                ':type' => LibPaidServices::website_url,
                                ':status' => 1
                            )
                        ),
                        'savedAnn' => array(self::HAS_MANY, 'SavedAnnouncements','announcement_id'),
                        'payments' => array(self::HAS_MANY, 'Payments','announcement_id'),
                        'comments' => array(self::HAS_MANY, 'Comments','announcement_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Identification number',
			'name' => 'Announcement name',
			'category_id' => 'Type',
			'status' => 'Status-in what process is user category',
			'description' => 'long description',
			'start_date' => 'Start to sale',
			'end_date' => 'Sale end date',
			'user_id' => 'User who added this announcement',
			'add_date' => 'Adding date',
			'price' => 'Vraagprijs:',
			'bid' => 'Bieden',
			'site_url' => 'Plaats een website url bij uw advertentie(�3,75):',
			'video_url' => 'Plaats een video bij uw advertentie(�5,75):',
		);
	}
        
//        public function checkBid($attribute){
//            if($this->check == 0 && empty($this->$attribute)){
//                $error = 'Bieden cannot be blank.';
//                $this->addError($attribute, $error);
//            }
//        }
	
	public function getCommentsCount(){
		return Comments::model()->countByAttributes(array('announcement_id' => $this->id));;
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('bid',$this->bid,true);
		$criteria->compare('site_url',$this->site_url,true);
		$criteria->compare('video_url',$this->video_url,true);
		$criteria->compare('video_type',$this->video_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    protected function beforeSave()
    {
            if(parent::beforeSave())
            {
                if($this->isNewRecord)
                {
                    $this->add_date = date('Y-m-d H:m:i');
                    if(empty($this->user_id))
                        $this->user_id = Yii::app()->user->getId();
                }
		$this->change_date = date('Y-m-d H:m:i');
                return true;
            }
            else
                return false;
    }
    
    public function weather($zipcode)
    {

                //$zipcode = 'NLXX0012';

            $result = file_get_contents('http://weather.yahooapis.com/forecastrss?p=' . $zipcode . '&u=f');
            $xml = simplexml_load_string($result);

            //echo htmlspecialchars($result, ENT_QUOTES, 'UTF-8');

            $xml->registerXPathNamespace('yweather', 'http://xml.weather.yahoo.com/ns/rss/1.0');
            $location = $xml->channel->xpath('yweather:location');

            if(!empty($location)){
                foreach($xml->channel->item as $item){
                    $current = $item->xpath('yweather:condition');
                    $forecast = $item->xpath('yweather:forecast');
                    $current = $current[0];
                   echo $current['temp'];
                    //$output = <<<END


           // END;
                }
            }
    }

    public function afterFind(){
        if(isset($this->category_id) && !empty($this->category_id)){
            $category = LibCategory::model()->findByPk($this->category_id);//7
            $this->category_saved = $category->id;
            $this->category_id = $category->id;
            $parent = $category->id;
            while(isset($category->parent_id) && !empty($category->parent_id)){
                //$this->category_saved = $this->category_saved.",".$category->parent_id;
                $category = LibCategory::model()->findByPk($category->parent_id);
                $this->category_id = $category->id;
                $this->category_saved = $this->category_saved."-".$category->id.",".$parent;
                $parent = $category->id;
            }
        }
    }

}

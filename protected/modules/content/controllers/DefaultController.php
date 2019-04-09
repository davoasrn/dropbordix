<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
            
            
            
            $post=new Content;
$post->page_title='sample post';
$post->content='content for the sample post';
$post->meta_title="asasd";
$post->meta_description="asd";
$post->meta_keywords="asd";
$post->save();
		$this->render('index');
	}
        
        
        
public  function actionShow($page_id){
    $post=Content::model()->find('id=:id', array(':id'=>$page_id));
    
    
    
    
  if($post== null ){
      
   exit("That page does not exist");   
      
  }
  else{
  
    
   $this->render('view',array(
        'title'=>$post->page_title,
       'content'=>$post->content,
       
    ));
   
  }
}
}
SanitizationBehavior
====================

SanitizationBehavior(HTMLPurifier) for cakephp to protected from xss or any other malicious content  


HtmlPurifier

So let’s use HtmlPurifier, it’s a filtering PHP library which “purifies” your html, it even deals with malformed tags and follows the specifications ! It’s THE massive weapon ! You can do a whitelist of the acceptable tags and even decide which attributes of these tags are allowed. Well I discovered it few days ago, so I’m no expert but we’ll get down to some configuration.


Implimentation 

Step : 1

 First, we need the latest copy of htmlpurifier class you can downloade it from http://htmlpurifier.org/ and import it to vendor folder. 


Step : 2
Then create a behavior in app/Model/Behavior, under the name of SanitizationBehavior.php, and it should look like this.

/*  code  */

<?php
//get htmlpurifier => http://htmlpurifier.org/
App::import('Vendor', null, array
            (
                'file' => 'htmlpurifier'.DS.'library'.DS.'HTMLPurifier.auto.php'
             ));
     
class SanitizationBehavior extends ModelBehavior
{
    function setup(Model $model, $settings = array())
    {
        //field is the field we purify by default it is called content
        $fields = (isset($settings['fields']))?$settings['fields']: array_keys($this->Model->schema());
        //$this->settings[$model->alias] = array('field' => $field);
        $this->fields = $fields;
            //set its configuration
            $config = HTMLPurifier_Config::createDefault();
            $config->set('Core.Encoding', 'UTF-8'); // replace with your encoding
			$config->set('HTML.Doctype', 'XHTML 1.0 Transitional'); // replace with your doctype	
		//cleaning
            $this->purifier = new HTMLPurifier($config);  
      
    }
    
    	public function cleanup(Model $model) {
		
		if (isset($this->fields)) {
			unset($this->fields);
		}
		if (isset($this->purifier)) {
			unset($this->purifier);
		}
	
		
	}

    function afterFind(Model $model, $results, $primary = false) {
			
		foreach($results as $key => $val){
if(!$key)
break;
		if(in_array($this->fields , $val[$model->alias])){
			$results[$key][$model->alias][$field]= $this->purifier->purify($val[$model->alias][$field]);
		}
	}
		return $results;

}
    /*
        cleaning before saving
    */
    function beforeSave(Model $model)
    {
        //convenient to get the name of the field to clean
        foreach($this->fields as $field){
        //check if we are working on the field
        if(isset($model->data[$model->alias][$field]))
        {
            $model->data[$model->alias][$field] = $this->purifier->purify($model->data[$model->alias][$field]);
        }
}
        return true;
    }
    

          
}








/* End of line */

Step :3

   Fix the code in model where you need
example   
public $actsAs = array('Sanitization' => array('fields' => array('content','web_url')));

data[model_name]['content']  as content
del_name]['web_url']  as web_url
  (OR)
public $actsAs = array('Sanitization' => array('fields' => array()));

its will filter all the fieds in the model.


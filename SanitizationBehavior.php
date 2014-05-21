<?
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

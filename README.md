SanitizationBehavior
====================

SanitizationBehavior(HTMLPurifier) for cakephp to protected from xss or any other malicious content  


HtmlPurifier

So let’s use HtmlPurifier, it’s a filtering PHP library which “purifies” your html, it even deals with malformed tags and follows the specifications ! It’s THE massive weapon ! You can do a whitelist of the acceptable tags and even decide which attributes of these tags are allowed. Well I discovered it few days ago, so I’m no expert but we’ll get down to some configuration.


Implimentation 

Step : 1

 First, we need the latest copy of htmlpurifier class you can downloade it from http://htmlpurifier.org/ and import it to vendor folder. 


Step : 2
Downloade SanitizationBehavior and place it in app/Model/Behavior


Step :3

   Fix the code in model where you need
example   
public $actsAs = array('Sanitization' => array('fields' => array('content','web_url')));

data[model_name]['content']  as content
del_name]['web_url']  as web_url

  (OR)
  
public $actsAs = array('Sanitization' => array('fields' => array()));

its will filter all the fieds in the model.


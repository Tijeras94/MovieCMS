<?php
namespace MovieCMS;

class Container
{
	private $classes =array();
	function get($name)
	{  
		if (array_key_exists($name , $this->classes))
			return $this->classes[$name]();	

		$prod_class = new \ReflectionClass( $name );

		try{
			$method = $prod_class->getMethod( "__construct" );
			$args = array();

			foreach ( $method->getParameters() as $param ) {
					if($param->getClass() != null){
						$classname = $param->getClass()->name; 
						$args[] =  $this->get( $classname ); 
					}else
					{
						$args[] = $param->getDefaultValue();
						
					}
			}
			$this->classes[$name] = $prod_class->newInstanceArgs($args);
			return $this->classes[$name];

		}catch(\ReflectionException $e)
		{

		}
 
 		$this->classes[$name] = $prod_class->newInstance();
		return $this->classes[$name];
		
	}

	function addDefinitions($def)
	{
		$this->classes = $def;
	}

}
?>
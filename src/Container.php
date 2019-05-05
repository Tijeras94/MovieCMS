<?php
namespace MovieCMS;

class Container
{
	private $classes =array();

	function get($name, $args = array())
	{  
		if (array_key_exists($name , $this->classes))
			return $this->classes[$name]();	

		$prod_class = new \ReflectionClass( $name );

		try{
			$method = $prod_class->getMethod( "__construct" );
			$args = $this->resolveArgs($method, $args);
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

	function callm($c, $method, $args = array())
    {
        $r = new \ReflectionMethod($c, $method);
        $r->invokeArgs($c, $this->resolveArgs($r, $args));
    }

	function callf($callback, $args = array())
    {
        $r = new \ReflectionFunction($callback);
        $r->invokeArgs($this->resolveArgs($r, $args));
    }

    function resolveArgs($r , $a)
    {
        $args = array();

        foreach ( $r->getParameters() as $param ) {
            if($param->getClass() != null){
                $classname = $param->getClass()->name;
                $args[] =  $this->get( $classname );
            }else
            {
                if($param->isDefaultValueAvailable())
                    $args[] = $param->getDefaultValue();
                else
                    $args[] = array_shift($a);
            }
        }

        return $args;
    }

}
?>
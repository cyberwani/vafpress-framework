<?php

class VP_Control_Field_RadioButton extends VP_Control_FieldMulti
{

	public function __construct()
	{
		parent::__construct();
		$this->_value = array();
	}

	public static function withArray($arr = array())
	{
		$instance = new self();
		$instance->_basic_make($arr);
		$instance->add_container_extra_classes('vp-checked-field');
		
		// Turn default array to single value
		$instance->set_default(VP_Util_Array::first($instance->get_default()));
		
		return $instance;
	}

	public function render($is_compact = false)
	{
		$this->_setup_data();
		$this->add_data('is_compact', $is_compact);
		return VP_View::instance()->load('control/radiobutton', $this->get_data());
	}

}

/**
 * EOF
 */
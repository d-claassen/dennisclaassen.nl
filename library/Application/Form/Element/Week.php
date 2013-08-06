<?php
class Application_Form_Element_Week extends Application_Form_Element_Text
{
    public function isValid( $value, $context = null )
    {
        if ($this->isAutoloadValidators())
        {
            //@todo: base week numbers on Zend_Locale
            $this->addValidator('Between', false, array('min' => 1, 'max' => 52));
        }
        
        return parent::isValid( $value, $context );
    }
}
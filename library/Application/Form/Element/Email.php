<?php
class Application_Form_Element_Email extends Application_Form_Element_Text
{
    public function isValid( $value, $context = null )
    {
        if ($this->isAutoloadValidators())
        {
            $this->addValidator('EmailAddress');
        }
        
        return parent::isValid( $value, $context );
    }

}
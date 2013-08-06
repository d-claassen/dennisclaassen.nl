<?php
class Application_Form_Element_Number extends Application_Form_Element_Text
{
    public function isValid( $value, $context = null )
    {
        if ($this->isAutoloadFilters())
        {
            $this->addFilter('Digits');
        }

        if ($this->isAutoloadValidators())
        {
            $this->addValidator('Digits');
            $validatorOpts = array_filter(array(
                'min' => $this->getAttrib('min'),
                'max' => $this->getAttrib('max'),
            ));
            $validator = null;
            if (2 === count($validatorOpts))
            {
                $validator = 'Between';
            }
            else if (isset($validatorOpts['min']))
            {
                $validator = 'GreaterThan';
            }
            else if (isset($validatorOpts['max']))
            {
                $validator = 'LessThan';
            }
            if (null !== $validator)
            {
                $this->addValidator($validator, false, $validatorOpts);
            }
        }
        
        return parent::isValid(  $value, $context );
    }
}
